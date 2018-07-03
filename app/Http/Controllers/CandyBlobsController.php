<?php

namespace App\Http\Controllers;

use App\Ballon;
use App\candy_blobs;
use App\User;
use Illuminate\Http\Request;

class CandyBlobsController extends Controller {
	//
	public function retrieveCandyStatus(Request $request) {
		if (auth()->user()->isKid()) {
			$status = candy_blobs::where('kid_id', '=', auth()->user()->id)->where('status', '=', 'accepted')->get()->pluck('parent_id');
		} else {
			$status = candy_blobs::where('parent_id', '=', auth()->user()->id)->where('status', '=', 'accepted')->get()->pluck('kid_id');
		}
		return $status;
	}

	public function findCandyRecord(Request $request) {
		if (auth()->user()->isKid()) {
			$status = candy_blobs::where('kid_id', '=', auth()->user()->id)->where('status', '=', 'accepted')->get()->pluck('id');
		} else {
			$status = candy_blobs::where('parent_id', '=', auth()->user()->id)->where('status', '=', 'accepted')->get()->pluck('id');
		}
		return $status;
	}

	public function sendOne(Request $request) {
		$request->validate([
			'to' => 'required',
		]);

		$primev = candy_blobs::where('parent_id', '=', auth()->user()->id)->orwhere('kid_id', '=', auth()->user()->id)->get();
		if ($primev->count() > 10) {
			return 'toomuch';
		}
		$check = candy_blobs::where('parent_id', '=', auth()->user()->id)->where('kid_id', '=', $request->to)->get();
		$check1 = candy_blobs::where('kid_id', '=', auth()->user()->id)->where('parent_id', '=', $request->to)->get();
		if (count($check) > 0 || count($check1) > 0) {
			return 'requested';
		}
		//Validate if exist
		$userr = User::find($request->to);
		if ($userr->isKid() && auth()->user()->isKid() || !($userr->isKid()) && !(auth()->user()->isKid())) {
			return 'age proplem';
		}
		if ($request->to == auth()->user()->id) {
			return 'invalid';
		}

		$user = User::find($request->to);
		if (!$user) {
			return 'user not exist';
		}

		if (auth()->user()->isBondedCandy($user)) {
			return 'already';
		}
		//Validate if already friends
		if (auth()->user()->isFriend($request->to)) {

			//Initialize and send

			$req = new candy_blobs();
			if (auth()->user()->isKid()) {
				$req->initialize($user->id, auth()->user()->id, auth()->user()->id);
			} else {
				$req->initialize(auth()->user()->id, $user->id, auth()->user()->id);
			}
			$ballon = new Ballon();
			if (auth()->user()->isKid()) {
				$ballon->candyRequestBalloon(auth()->user()->id, $request->to, $req->id, 'kid');
			} else {
				$ballon->candyRequestBalloon(auth()->user()->id, $request->to, $req->id, 'parent');
			}
			return 'done';
		} else {
			return 'invalid';
		}
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

		if (auth()->user()->isBondedCandy($user)) {
			return 'invalid';
		}
		//Validate if already friends
		if (auth()->user()->isFriend($user)) {

			//Initialize and send
			if ('req_id' == 'parent_id') {
				$req = auth()->user()->candyUserSentRequests()->where('parent_id', '=', $request->to)->get();
			} else {
				$req = auth()->user()->candyUserSentRequests()->where('kid_id', '=', $request->to)->get();
			}
			if ($req->count() == 0) {
				return 'invalid';
			} else {
				foreach ($req as $r) {
					$r->status = 'canceled';
					$r->update();
				}
			}
			$b = new Ballon();
			if ('req_id' == 'parent_id') {
				$b->initialize(json_encode(array(
					'user' => $request->to,
					'category' => 'hidden',
					'index' => array(
						'category' => 'parent_request_canceled',
						'req_id' => auth()->user()->id,
					),
				)));
			} else {
				$b->initialize(json_encode(array(
					'user' => $request->to,
					'category' => 'hidden',
					'index' => array(
						'category' => 'kid_request_canceled',
						'req_id' => auth()->user()->id,
					),
				)));
			}
			return 'done';
		} else {
			return 'is not friends';
		}
	}

	public function ignoreOne(Request $request) {
		candy_blobs::where('id', '=', $request->id)->first()->delete();
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

		if (auth()->user()->isBondedCandy($request->target)) {
			return 'invalid';
		}

		//Validate if they already friends
		if (auth()->user()->isFriend($request->target)) {

			//Validate if has a friend request
			// $fr = auth()->user()->hasCandyRequestObject($request->target);
			// if (!$fr) {
			// 	return 'invalid';
			// }

			//pair as friends

			// auth()->user()->bondCandy($target);

			//Connect the acceptance circles

			//		$target->createCirclesMembership($request->circles);

			//Create acceptance balloon

			if (auth()->user()->isKid()) {

				$req = candy_blobs::where('parent_id', '=', $request->target)->update(['status' => 'accepted']);
			} else {
				$req = candy_blobs::where('kid_id', '=', $request->target)->update(['status' => 'accepted']);
			}

			$ballon = new Ballon();
			if ('req_id' == 'parent_id') {
				$ballon->candyRequestAccepted(auth()->user()->id, $request->target, 'parent');
			} else {
				$ballon->candyRequestAccepted(auth()->user()->id, $request->target, 'kid');
			}

			//update the request as accepted

			return 'done';
		} else {
			return 'invalid';
		}
	}
	public function retrieveCandyRequest(Request $request) {
		if (auth()->user()->isKid()) {
			return $candy_request = candy_blobs::where('kid_id', '=', auth()->user()->id)->where('status', '=', 'waiting')->get();
		} else {
			return $candy_request = candy_blobs::where('parent_id', '=', auth()->user()->id)->where('status', '=', 'waiting')->get();
		}
	}
}
