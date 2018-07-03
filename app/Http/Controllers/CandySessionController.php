<?php

namespace App\Http\Controllers;

use App\candy_blobs;
use App\Candy_session;
use App\User;
use Illuminate\Http\Request;

class CandySessionController extends Controller {
	//
	public function retriveAllLogs(Request $request) {
		return Candy_session::get()->pluck('id');
	}

	public function retriveLog(Request $request) {
		$log = Candy_session::where('id', '=', $request->id)->get();
		return $log;

	}

	public function retriveMyKids(Request $request) {
		if (!auth()->user()->isKid()) {
			return candy_blobs::where('parent_id', '=', auth()->user()->id)->get()->pluck('kid_id');
		}

	}

	public function retrieveMyKidsLogs(Request $request) {
		if (!auth()->user()->isKid()) {
			$log = Candy_session::where('kid_id', '=', $request->kid_id)->orderBy('id', 'desc')->get()->pluck('id');
			if (count($log) > 0) {
				return $log;
			}
		}

	}

}
