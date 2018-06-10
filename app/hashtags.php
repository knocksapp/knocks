<?php

namespace App;

use App\Knock;
use App\User_hashtags;
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

	public function retriveOlderKnocks($min) {
		$hashtags = User_hashtags::where('hashtag', '=', $this->hashtag)->where('parent_id', '<', $min)->orderBy('parent_id', 'desc')->get();
		$lastIndex = $hashtags->count() - 1;
		$arr = array('knocks' => [], 'last_index' => null);
		$i = 0;
		while (count($arr['knocks']) < 3 && $i <= $lastIndex) {
				$c = Knock::find($hashtags[$i]->parent_id);
				if ($c) {
					$view = $c->view(auth()->check() ? auth()->user()->id : -1);
					if ($view != 'invalid') {
						array_push($arr['knocks'], $c->id);
					}

				}
			$i++;
		}
		return $arr;
	}

	public function retriveNewerKnocks($max) {
		$hashtags = User_hashtags::where('hashtag', '=', $this->hashtag)->where('parent_id', '>', $max)->orderBy('parent_id', 'desc')->get();
		$lastIndex = $hashtags->count() - 1;
		$arr = array('knocks' => [], 'last_index' => null);
		$i = 0;
		while (count($arr['knocks']) < 3 && $i <= $lastIndex) {
				$c = Knock::find($hashtags[$i]->parent_id);
				if ($c) {
					$view = $c->view(auth()->check() ? auth()->user()->id : -1);
					if ($view != 'invalid') {
						array_push($arr['knocks'], $c->id);
					}

				}
			$i++;
		}
		return $arr;
	}

	public function retriveKnocks() {
		$hashtags = User_hashtags::where('hashtag', '=', $this->hashtag)->orderBy('parent_id', 'desc')->get();
		$lastIndex = $hashtags->count() - 1;
		$arr = array('knocks' => [], 'last_index' => null);
		$i = 0;
		while (count($arr['knocks']) < 3 && $i <= $lastIndex) {
				$c = Knock::find($hashtags[$i]->parent_id);
				if ($c) {
					$view = $c->view(auth()->check() ? auth()->user()->id : -1);
					if ($view != 'invalid') {
						array_push($arr['knocks'], $c->id);
					}

				}
			$i++;
		}
		return $arr;
	}
}