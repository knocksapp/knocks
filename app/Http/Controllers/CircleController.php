<?php

namespace App\Http\Controllers;

use App\Circle;
use App\Circle_member;
use App\User;
use Illuminate\Http\Request;

class CircleController extends Controller {
	public function create(Request $request) {
		$request->validate([
			'name' => 'required',

		]);
		if (auth()->user()->hasCircle($request->name)) {
			return 'already_exists';
		}

		$circle = new Circle();
		$circle->initialize($request->name, json_encode($request->icon));
		return $circle->id;
	}
	public function view(Request $request) {
		$circle = Circle::find($request->id);
		if (isset($circle) && $circle != null && $circle->count() == 0) {
			return 'not_exist';
		}

		$circle['members'] = Circle_member::where('circle_id', '=', $circle->id)->get();
		// foreach($circle['members'] as $mem){
		//   $mem['data'] = User::find($mem->user_id);
		// }
		return $circle;

	}
	public function retrive(Request $request) {

		$request->validate([
			'circle' => 'required',
		]);

		$circle = Circle::find($request->circle);
		if ($circle->user_id != auth()->user()->id) {
			return 'invalid';
		} else {
			return $circle->retriveCircle();
		}

	}

	public function search(Request $request) {
		return Circle::where('user_id', '=', auth()->user()->id)->where('circle_name', 'like', "%$request->q%")->orderBy('circle_name')->get()->pluck('id');
	}

	public function check(Request $request) {
		return Circle::where('user_id', '=', auth()->user()->id)->where('circle_name', '=', $request->q)->exists() ? 'invalid' : 'valid';
	}

	public function deleteCircle(Request $request) {
		$request->validate(['circle' => 'required']);
		$circle = Circle::find($request->circle);
		if ($circle == null) {
			return 'invalid';
		}
		if ($circle->user_id != auth()->user()->id) {
			return 'invalid';
		}
		if ($circle->id == auth()->user()->mainCircle()->id) {
			return 'main';
		}
		$circle->delete();
		return 'done';

	}

	public function update(Request $request) {
		$request->validate([
			'name' => 'required',
			'circle' => 'required',
		]);
		$circle = Circle::find($request->circle);
		if ($circle == null) {
			return 'invalid';
		}

		if ($circle->user_id != auth()->user()->id) {
			return 'invalid';
		}

		$circle->circle_name = $request->name;
		$circle->update();

		return 'done';

	}

}
