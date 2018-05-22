<?php

namespace App\Http\Controllers;

use App\Ballon;
use App\Blob;
use App\Circle_member;
use App\Comment;
use App\Knock;
use App\Language;
use App\obj;
use App\Privacy_preset;
use App\Reaction;
use App\Reply;
use App\User;
use Illuminate\Http\Request;

class DevController extends Controller {
	public function resetKnocks(Request $request) {
		//Delet Ballons & their Objects
		Ballon::truncate();
		//Delete Reactions & their Objects
		Reaction::truncate();
		//Delete Replies & their Objects
		$reply = Reply::all();
		foreach ($reply as $rep) {
			$rep->delete();
		}

		//Delete Comments & their Objects
		$comment = Comment::all();
		foreach ($comment as $rep) {
			$rep->delete();
		}

		//Delete Blobs & their Objects
		Blob::truncate();
		//Delete Knocks & their Objects
		$knock = Knock::all();
		foreach ($knock as $rep) {
			$rep->delete();
		}

		return 'done';

	}

	public function resetUsers(Request $request) {
		//Delet Ballons & their Objects
		Ballon::truncate();
		//Delete Reactions & their Objects
		Reaction::truncate();
		//Delete Replies & their Objects
		$reply = Reply::all();
		foreach ($reply as $rep) {
			$rep->delete();
		}

		//Delete Comments & their Objects
		$comment = Comment::all();
		foreach ($comment as $rep) {
			$rep->delete();
		}

		//Delete Blobs & their Objects
		Blob::truncate();
		//Delete Knocks & their Objects
		$knock = Knock::all();
		foreach ($knock as $rep) {
			$rep->delete();
		}

		$object = obj::all();
		foreach ($object as $rep) {
			$rep->delete();
		}

		$user = User::all();
		foreach ($user as $rep) {
			$rep->delete();
		}

		return 'done';

	}

	public function reinstall(Request $request) {
		$v = new Privacy_preset();
		$v->name = 'valid';
		$v->save();

		$v = new Privacy_preset();
		$v->name = 'invalid';
		$v->save();

		$v = new Privacy_preset();
		$v->name = 'invalid_for_all';
		$v->save();

		$v = new Language();
		$v->name = 'en';
		$v->alignment = 'left';
		$v->font_family = 'titillium';
		$v->display_name = 'English';
		$v->save();

		$v = new Language();
		$v->name = 'ar-sa';
		$v->alignment = 'right';
		$v->font_family = 'cairo';
		$v->display_name = 'لاعربيه';
		$v->save();

		return 'done';
	}

	public function removeAllFriends(Request $request) {
		$mems = Circle_member::all();
		foreach ($mems as $mem) {
			$mem->delete();
		}

		return 'done';
	}

	public function addUsersPatch(Request $request) {
		$usersCount = User::all()->count();
		for ($i = 0; $i < 100; $i++) {
			$user = new User();
			$user->initialaize(
				json_encode(array(
					'first_name' => "Knocks " . $user->generateRandomString(3),
					'last_name' => "User " . $user->generateRandomString(3),
					'username' => "knockstestuser" . ($i + $usersCount),
					'gender' => "male",
					'middle_name' => "Test " . $user->generateRandomString(3),
					'nickname' => "Knocks Random User " . $user->generateRandomString(5),
					'birthdate' => "2017-01-01",
					'email' => "test" . ($i + $usersCount) . "@knocks.com",
					'password' => "testtest12",
					'language' => "en",
				))
			);
		}
		$all = User::all();
		$count = $all->count();
		foreach ($all as $one) {
			for ($j = 0; $j < 30; $j++) {
				$c = User::find(rand(0, $count));
				if ($c != null) {
					$one->pairAsFriend($c);
				}

			}
		}
		return "done";
	}
}

?>
