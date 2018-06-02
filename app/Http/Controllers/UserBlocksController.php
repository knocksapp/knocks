<?php

namespace App\Http\Controllers;

use App\Ballon;
use App\Circle_member;
use App\User;
use App\user_blocks;
use Illuminate\Http\Request;

class UserBlocksController extends Controller {
	public function blockUser(Request $request) {
		$authMembers = Circle_member::where('owner_id', '=', auth()->user()->id)->where('user_id', '=', $request->blocked_user_id);
		if ($authMembers->exists()) {
			foreach ($authMembers->get() as $member) {
				$member->delete();
			}}
		$user = user_blocks::where('user_id', '=', auth()->user()->id)->where('blocked_user_id', '=', $request->blocked_user_id);
		if ($user->exists()) {
			return 'invalid';
		}

		$blockuser = new user_blocks();
		$blockuser->initialize(

			$request->blocked_user_id
		);
		$b = new Ballon();
		$b->initialize(json_encode(array(
			'user' => $request->blocked_user_id,
			'category' => 'hidden',
			'index' => array(
				'category' => 'user_block',
				'sender_id' => auth()->user()->id,
			),
		)));
		return 'done';
	}

	public function unblockUser(Request $request) {
		user_blocks::where('blocked_user_id', '=', $request->blocked_user_id)->delete();
		return 'done';
	}

	public function isBlocked(Request $request) {
		$mem = user_blocks::where('user_id', '=', auth()->user()->id)->where('blocked_user_id', '=', $request->blocked_user_id);
		$user = User::find($request->blocked_user_id);
		$res = $user->retriveForUserLazy(auth()->user()->id);
		$res['blocked'] = $mem->exists();
		return $res;
	}

	public function retriveBlockedUser(Request $request) {
		$all = user_blocks::
			where('user_id', '=', auth()->user()->id)->get()->pluck('blocked_user_id');
		return $all;
	}
}
