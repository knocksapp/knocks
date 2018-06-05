<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Assistant extends Model {
	public function objectKeys($object) {
		$arr = [];
		foreach ($object as $key => $value) {
			array_push($arr, $key);
		}
		return $arr;
	}
}