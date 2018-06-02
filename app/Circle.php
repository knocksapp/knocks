<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Circle extends Model {
	public function users() {
		return $this->belongsTo('App\User', 'user_id');
	}

	public function privacySetCircles() {
		return $this->hasMany('App\Privacy_set_circle', 'circle_id');
	}

	public function circleMembers() {
		return $this->hasMany('App\Circle_member', 'circle_id');
	}

	//Is Member in some circle

	public function isMember($user) {
		return $this->circleMembers()->where('user_id', '=', $user)->count() == 0 ? false : true;
	}

	//Circles methods

	public function initialize($name, $thumbnail) {
		$this->circle_name = $name;
		$this->thumbnail = $thumbnail;
		$this->user_id = auth()->user()->id;
		$this->save();
	}

	public function init($name, $thumbnail, $user) {
		$this->circle_name = $name;
		$this->thumbnail = $thumbnail;
		$this->user_id = $user;
		$this->save();
	}

	public function retriveCircle() {
		$resultObject = array(
			"icon" => $this->thumbnail,
			"name" => $this->circle_name,
			"id" => $this->id,
		);
		$members = $this->circleMembers()->pluck('user_id');
		$resultObject['members'] = $members;
		return $resultObject;
	}
}
