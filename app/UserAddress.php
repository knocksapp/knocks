<?php

namespace App;
use App\obj;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model {
	public function user() {
		return $this->belongsTo('App\User', 'user_id');
	}
	public function init($object) {
		$parentObject = new obj();
		$parentObject->initialize('address');
		$object = json_decode($object);
		$this->object_id = $parentObject->id;
		$this->user_id = isset($object->user) ? $object->user : auth()->user()->id;
		$this->country = $object->country;
		$this->region = $object->region;
		$this->state = $object->state;
		if (isset($object->zipcode)) {
			$this->zipcode = $object->zipcode;
		}
		$this->index = json_encode($object->index);
		$this->save();
	}
}
