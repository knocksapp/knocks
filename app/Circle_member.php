<?php

namespace App;

use App\Circle;
use Illuminate\Database\Eloquent\Model;

class Circle_member extends Model {
	//

	public function user() {
		return $this->hasMany('App\User', 'user_id');
	}

	public function circle() {
		return $this->belongsTo('App\Circle', 'circle_id');
	}

	//Circle Members Methods

	public function initialize($user, $circle, $owner) {
		$c = Circle::find($circle);
		if (!$c) {
			return;
		}
		if (Circle_member::where('circle_id', '=', $circle)->where('user_id', '=', $user)->exists()) {
			return;
		}
		$this->circle_id = $circle;
		$this->user_id = $user;
		$this->owner_id = $owner;
		$this->save();
	}
}
