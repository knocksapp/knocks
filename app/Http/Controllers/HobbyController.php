<?php

namespace App\Http\Controllers;

use App\Hobby;
use App\obj;
use App\User;
use Illuminate\Http\Request;

class HobbyController extends Controller {
	public function createHobby(Request $request) {

		$newHobby = new Hobby();
		$newHobby->initialize(
			$request->name
		);
		return $newHobby->id;

	}

	public function retriveHobby(Request $request) {
		$user = User::find($request->user);
		if (!$user) {
			return 'invalid';
		}

		$edus = $user->hobbies()->get();
		$array = [];
		foreach ($edus as $edu) {
			if (obj::find($edu->object_id)->isAvailable(auth()->user()->id)) {
				array_push($array, $edu);
			}

		}
		return $array;
	}

	public function updateHobby(Request $request) {
		$hobby = Hobby::where('id', '=', $request->hobby_id)->update([
			'name' => $request->name,
		]);
		return 'done';
	}

	public function deleteHobby(Request $request) {
		Hobby::where('id', '=', $request->about_id)->delete();
		return 'done';
	}

	public function hobbies(Request $req) {
		$regions = Hobby::where('name', '!=', null)->get()->groupBy('name');
		$arr = [];
		foreach ($regions as $key => $value) {
			array_push($arr, $key);
		}
		return $arr;
	}
}
