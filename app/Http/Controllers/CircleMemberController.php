<?php

namespace App\Http\Controllers;

use App\Ballon;
use App\Circle;
use App\Circle_member;
use App\User;
use App\User_request;
use Illuminate\Http\Request;

class CircleMemberController extends Controller {
	public function acceptGroup(Request $request) {
		//validate the http
		$request->validate([
			'circles_confirm' => 'required',
			'req_id' => 'required',
		]);
		//validate the request circles
		if (Circle::find($request->req_id)) {
			return 'invalid';
		} else {
			$knocks_request = User_request::find($request->req_id);
		}

		if (!auth()->user()->hasRecievedRequest($request->req_id)) {
			return 'invalid';
		}

		//return $knocks_request;

		$reqeust_circles = json_decode($knocks_request->circles);
		$sender = User::find($knocks_request->sender_id);

		//Validating Senders Circles

		foreach ($reqeust_circles as $rc) {
			if (!$sender->hasCircleById($rc)) {
				return 'invalid';
			}

		}

		//Validating Confirm Circles

		$confirm_circles = json_decode($request->circles_confirm);

		foreach ($confirm_circles as $rc) {
			if (!auth()->user()->hasCircleById($rc)) {
				return 'invalid';
			}

		}

		//push as a circle members for the specified and for @all@

		//Adding Circle members for the sender

		$member = new Circle_member();
		$member->initialize($sender->id, $sender->getCircleId('@all@'));

		foreach ($reqeust_circles as $rc) {
			$member = new Circle_member();
			$member->initialize($sender->id, $rc);
		}

		//Adding Circle members for the reciever

		$member = new Circle_member();
		$member->initialize(auth()->user()->id, $sender->getCircleId('@all@'));

		foreach ($confirm_circles as $rc) {
			$member = new Circle_member();
			$member->initialize(auth()->user()->id, $rc);
		}

		$knocks_request->response = 'accepted';
		$knocks_request->update();

		return 'done';

	}
	public function groupPushMembers(Request $request) {
		$members = Circle::find($request->circle_id)->circleMembers()->get()->pluck('user_id');

		return $members;
	}
	public function unpairFriends(Request $request) {
		$authMembers = Circle_member::where('owner_id', '=', auth()->user()->id)->where('user_id', '=', $request->user);
		if ($authMembers->exists()) {
			foreach ($authMembers->get() as $member) {
				$member->delete();
			}
		}

		$reqMembers = Circle_member::where('owner_id', '=', $request->user)->where('user_id', '=', auth()->user()->id);
		if ($reqMembers->exists()) {
			foreach ($reqMembers->get() as $member) {
				$member->delete();
			}
		}

		$b = new Ballon();
		$b->initialize(json_encode(array(
			'user' => $request->user,
			'category' => 'hidden',
			'index' => array(
				'category' => 'friendship_unpair',
				'sender_id' => auth()->user()->id,
			),
		)));

		return 'done';
	}
	public function addMember(Request $req) {
		$req->validate([
			'circle' => 'required',
			'user' => 'required',
		]);
		$circle = Circle::find($req->circle);
		if ($circle == null) {
			return 'invalid';
		}
		if ($circle->user_id != auth()->user()->id) {
			return 'invalid';
		}
		$membership = Circle_member::where('user_id', '=', $req->user)
			->where('circle_id', '=', $req->circle);
		if ($membership->exists()) {
			return 'exists';
		}
		$mem = new Circle_member();
		$mem->initialize($req->user, $req->circle, auth()->user()->id);
		return 'done';
	}

	public function removeMember(Request $req) {
		$req->validate([
			'circle' => 'required',
			'user' => 'required',
		]);
		$circle = Circle::find($req->circle);
		if ($circle == null) {
			return 'invalid';
		}
		if ($circle->user_id != auth()->user()->id) {
			return 'invalid';
		}
		$membership = Circle_member::where('user_id', '=', $req->user)
			->where('circle_id', '=', $req->circle);
		if (!$membership->exists()) {
			return 'exists';
		}
		$membership->first()->delete();

		return 'done';
	}
}
