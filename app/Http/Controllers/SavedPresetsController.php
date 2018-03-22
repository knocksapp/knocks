<?php

namespace App\Http\Controllers;

use App\Saved_presets;
use Illuminate\Http\Request;

class SavedPresetsController extends Controller {
	public function check(Request $req) {
		return Saved_presets::where('name', '=', $req->q)->where('user_id', '=', auth()->user()->id)->exists() ? 'invaliud' : 'valid';
	}
	public function save(Request $req) {
		if (Saved_presets::where('name', '=', $req->name)->where('user_id', '=', auth()->user()->id)->exists()) {
			return 'invalid';
		}
		$preset = new Saved_presets();
		$preset->name = $req->name;
		$preset->preset = json_encode($req->object);
		$preset->user_id = auth()->user()->id;
		$preset->save();
		return 'done';
	}
	public function get(Request $req) {
		return Saved_presets::where('user_id', '=', auth()->user()->id)->orderBy('name')->get();
	}
}
