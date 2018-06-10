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
		$hashtags = User_hashtags::where('hashtag', '=', $this->hashtag)->where('id', '<', $min)->orderBy('id', 'desc')->get();
		$lastIndex = count($hashtags) - 1;
		$arr = array('knocks' => [], 'last_index' => null);
		$i = 0;
		while (count($arr['knocks']) < 3 && $i <= $hashtags->count() - 1) {
			if ($lastIndex > $i) {
				$c = Knock::find($hashtags[$i]->parent_id);
				if ($c) {
					$view = $c->view(auth()->check() ? auth()->user()->id : -1);
					if ($view != 'invalid') {
						array_push($arr['knocks'], $c->id);
					}

				}

			}
			$i++;
		}
		return $arr;
	}

	public function retriveNewerKnocks($max) {
		$hashtags = User_hashtags::where('hashtag', '=', $this->hashtag)->where('id', '>', $max)->orderBy('id', 'desc')->get();
		$lastIndex = count($hashtags) - 1;
		$arr = array('knocks' => [], 'last_index' => null);
		$i = 0;
		while (count($arr['knocks']) < 3 && $i <= $hashtags->count() - 1) {
			if ($lastIndex > $i) {
				$c = Knock::find($hashtags[$i]->parent_id);
				if ($c) {
					$view = $c->view(auth()->check() ? auth()->user()->id : -1);
					if ($view != 'invalid') {
						array_push($arr['knocks'], $c->id);
					}

				}

			}
			$i++;
		}
		return $arr;
	}

	public function retriveKnocks() {
		$hashtags = User_hashtags::where('hashtag', '=', $this->hashtag)->orderBy('id', 'desc')->get();
		$lastIndex = count($hashtags) - 1;
		$arr = array('knocks' => [], 'last_index' => null);
		$i = 0;
		while (count($arr['knocks']) < 3 && $i <= $hashtags->count() - 1) {
			if ($lastIndex > $i) {
				$c = Knock::find($hashtags[$i]->parent_id);
				if ($c) {
					$view = $c->view(auth()->check() ? auth()->user()->id : -1);
					if ($view != 'invalid') {
						array_push($arr['knocks'], $c->id);
					}

				}

			}
			$i++;
		}
		return $arr;
	}
}
