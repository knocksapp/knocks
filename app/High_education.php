<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class High_education extends Model {
	public function user() {
		return $this->belongsTo('App\User', 'user_id');
	}
	public function object() {
		return $this->belongsTo('App\obj', 'object_id');
	}

	public function initialize($study_at, $study_what, $study_since, $study_to, $grade) {
		$object = new obj();
		$object->initialize('high_education');
		$this->study_at = $study_at;
		$this->study_what = $study_what;
		$this->study_since = $study_since;
		$this->study_to = $study_to;
		$this->grade = $grade;
		$this->object_id = $object->id;
		$this->user_id = auth()->user()->id;
		$this->save();

	}
	public function init($study_at, $study_what, $study_since, $study_to, $grade, $user) {
		$object = new obj();
		$object->initialize('high_education');
		$this->study_at = $study_at;
		$this->study_what = $study_what;
		$this->study_since = $study_since;
		$this->study_to = $study_to;
		$this->grade = $grade;
		$this->object_id = $object->id;
		$this->user_id = $user;
		$this->save();

	}

}
