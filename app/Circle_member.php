<?php

namespace App;

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
		$this->circle_id = $circle;
		$this->user_id = $user;
		$this->owner_id = $owner;
		$this->save();
	}
}
