<?php

namespace App\Http\Controllers;

use App\Ballon;
use App\User;
use App\Candy_session;
use App\User_request;
use Illuminate\Http\Request;

class UserRequestController extends Controller {
	public function sendGroup(Request $request) {
		$request->validate([
			'users' => 'required',
			'circles' => 'required',
		]);
		$request->users = json_decode($request->users);
		foreach ($request->users as $user) {
			if (User::find($user) != null) {
				$req = new User_request();
				$req->initialize($user, $request->circles);
			}
			return 'done';
		}

	}
	public function sendOne(Request $request) {
		$request->validate([
			'to' => 'required',
		]);
		//Validate if exist
		if ($request->to == auth()->user()->id) {
			return 'invalid';
		}

		$user = User::find($request->to);
		if (!$user) {
			return 'invalid';
		}

		//Validate if already friends
		if (auth()->user()->isFriend($user)) {
			return 'invalid';
		}

		//Initialize and send
		$req = new User_request();
		$req->initialize(auth()->user()->id, $user->id);
		$ballon = new Ballon();
		$ballon->friendRequestBalloon(auth()->user()->id, $request->to, $req->id);

		if(auth()->user()->isKid()){
			$candy_session = new Candy_session();

			$candy_session->initialize(auth()->user()->id,$request->to,'pairFriend',$request->to,null,null);
		}
		return 'done';

	}
	public function cancelOne(Request $request) {
		$request->validate([
			'to' => 'required',
		]);
		//Validate if exist
		if ($request->to == auth()->user()->id) {
			return 'invalid';
		}

		$user = User::find($request->to);
		if (!$user) {
			return 'invalid';
		}

		//Validate if already friends
		if (auth()->user()->isFriend($user)) {
			return 'invalid';
		}

		//Initialize and send
		$req = auth()->user()->userSentRequests()->where('reciver_id', '=', $request->to)->get();
		if ($req->count() == 0) {
			return 'invalid';
		} else {
			foreach ($req as $r) {
				$r->response = 'canceled';
				$r->update();
			}
		}
		$b = new Ballon();
		$b->initialize(json_encode(array(
			'user' => $request->to,
			'category' => 'hidden',
			'index' => array(
				'category' => 'friend_request_canceled',
				'sender_id' => auth()->user()->id,
			),
		)));
		return 'done';

	}
	public function ignoreOne(Request $request) {
		$request->validate([
			'to' => 'required',
		]);
		//Validate if exist
		if ($request->to == auth()->user()->id) {
			return 'invalid';
		}

		$user = User::find($request->to);
		if (!$user) {
			return 'invalid';
		}

		//Validate if already friends
		if (auth()->user()->isFriend($user)) {
			return 'invalid';
		}

		//Initialize and send
		$req = auth()->user()->userRecivedRequests()->where('sender_id', '=', $request->to)->get();
		if ($req->count() == 0) {
			return 'invalid';
		} else {
			foreach ($req as $r) {
				$r->response = 'ignored';
				$r->update();
			}
		}
		$b = new Ballon();
		$b->initialize(json_encode(array(
			'user' => $request->to,
			'category' => 'hidden',
			'index' => array(
				'category' => 'friend_request_ignored',
				'sender_id' => auth()->user()->id,
			),
		)));
		return 'done';

	}

	public function accept(Request $request) {
		$request->validate([
			'target' => 'required',

		]);

		//Validate if the target exists;
		$target = User::find($request->target);
		if ($target == null) {
			return 'invalid';
		}

		//Validate if they already friends
		if (auth()->user()->isFriend($request->target)) {
			return 'invalid';
		}

		//Validate if has a friend request
		$fr = auth()->user()->hasFriendRequestObject($request->target);
		if (!$fr) {
			return 'invalid';
		}

		//pair as friends

		auth()->user()->pairAsFriend($target);

		if(auth()->user()->isKid())
		{
			$candy_session = new Candy_session();

			$candy_session->initialize(auth()->user()->id,$request->target,'pairFriend',$request->target,null,null);

		}

		//Connect the acceptance circles

		$target->createCirclesMembership($request->circles);

		//Create acceptance balloon

		$ballon = new Ballon();
		$ballon->friendRequestAccepted(auth()->user()->id, $request->target);

		//update the request as accepted

		$fr->response = 'accepted';
		$fr->update();

		return 'done';
	}

	public function sendGroupRequest(Request $request) {

		$newRequest = new User_request();
		$newRequest->initializeForGroups(
			auth()->user()->id,
			$request->reciver_id
		);
		return 'done';
	}

	public function getGroupWaitResponse(Request $request) {
		$res = User_request::where('sender_id', '=', auth()->user()->id)->where('reciver_id', '=', $request->group_id)->get();
		return $res;
	}
	public function getGroupResponse(Request $request) {
		$res = User_request::where('parent_type', '=', 'Group')->where('reciver_id', '=', $request->group_id)->get();
		return $res;
	}
	public function declineRequestForGroup(Request $request) {
		$upd = User_request::where('sender_id', '=', $request->user)->where('reciver_id', '=', $request->group)->where('response', '=', 'waiting')->get()->first();
		$upd->response = 'declined';
		$upd->update();
	}
	public function checkGroupResponse(Request $request) {
		$check = User_request::where('sender_id', '=', auth()->user()->id)
			->where('reciver_id', '=', $request->group_id)
			->where('response', '=', 'waiting')->get();
		if (count($check) > 0) {
			return 'true';
		} else {
			return 'false';
		}

	}
}
