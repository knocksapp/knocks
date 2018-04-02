<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class hashtags extends Model {
	public function createOrUpdate($q) {
		$hash = hashtags::where('hashtag', '=', $q);
		if ($hash->exists()) {
			$c = $hash->first();
			$c->count++;
			$c->update();
		} else {
			$this->hashtag = $q;
			$this->count = 1;
			$this->save();
		}
	}
}
