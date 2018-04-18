<?php

namespace App\Http\Controllers;

use App\Ballon;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BallonController extends Controller {
	public function getUserNotification(Request $request) {
		$ballons = Ballon::where('user_id', '=', auth()->user()->id)
			->where('poped', '=', 0)
			->get();
		return $ballons;
	}
	public function getAllUserNotification(Request $request) {
		$ballons = array();
		if ($request->min != null) {
			$ballons = Ballon::where('user_id', '=', auth()->user()->id)
				->where('id', '>', $request->min)
				->where('category', '!=', 'friend_request')
				->where('category', '!=', 'friend_request_accept')
				->where('category', '!=', null)
				->orderBy('id', 'desc')
				->get();
			if ($ballons->count() > 0) {
				$ballons = $ballons->chunk(5)[0];
			} else {
				$ballons = [];
			}

		} else {
			$ballons = Ballon::where('user_id', '=', auth()->user()->id)
				->orderBy('id', 'desc')
				->get();
			if ($ballons->count() > 0) {
				$ballons = $ballons->chunk(5)[0];
			} else {
				$ballons = [];
			}

		}

		return $ballons;
	}
	public function getAllUserNotificationFr(Request $request) {
		$ballons = array();
		if ($request->min != null) {
			$ballons = Ballon::where('user_id', '=', auth()->user()->id)
				->where('id', '>', $request->min)
				->where(function ($q) {
					$q->where('category', '=', 'friend_request')
						->orWhere('category', '=', 'friend_request_accept');
				})
				->orderBy('id', 'desc')
				->get();
			if ($ballons->count() > 0) {
				$ballons = $ballons->chunk(5)[0];
			} else {
				$ballons = [];
			}

		} else {
			$ballons = Ballon::where('user_id', '=', auth()->user()->id)
				->orderBy('id', 'desc')
				->get();
			if ($ballons->count() > 0) {
				$ballons = $ballons->chunk(5)[0];
			} else {
				$ballons = [];
			}

		}

		return $ballons;
	}
	public function setToPoped(Request $request) {
		$obj = $request->obj;
		for ($i = 0; $i < count($obj); $i++) {
			$current = Ballon::find($obj[$i]);
			if ($current != null) {
				$current->poped = 1;
				$current->update();
			}

		}
		return new Carbon();
	}

	public function setToseen(Request $request) {
		$current = Ballon::find($request->ballon);
		if ($current != null) {
			if ($current->user_id == auth()->user()->id) {
				$current->seen = 1;
				$current->update();
				return 'done';
			}
		} else {
			return 'invalid';
		}

	}

}
