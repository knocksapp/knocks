<?php

namespace App;

use App\Blob;
use App\hashtags;
use App\ignore_object;
use App\obj;
use App\User;
use App\User_hashtags;
use App\User_keywords;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Knock extends Model {
	public function users() {
		return $this->belongsTo('App\User', 'user_id');
	}
	public function object() {
		return $this->belongsTo('App\obj', 'object_id');
	}

	public function addFollower($user) {
		$index = $this->knockIndex();
		$followers = $index->followers;
		$followers->$user = true;
		$this->index = json_encode($index);
		$this->update();
	}

	public function canEdit($user) {
		if ($this->user_id == $user) {
			return true;
		}
		if ($this->at == $user && ($this->type == 'self' || $this->type == 'user')) {
			return true;
		}
		return false;
	}

	public function deleteKnock() {
		if ($this->hasPictures()) {
			foreach ($this->pictures() as $blob) {
				Blob::find($blob)->delete();
			}
		}
		if ($this->hasFiles()) {
			foreach ($this->files() as $blob) {
				Blob::find($blob)->delete();
			}
		}
		if ($this->hasVoices()) {
			Blob::find($this->knockIndex()->voices_specifications)->delete();
		}
		$object = obj::find($this->object_id);
		$this->delete();
		$object->delete();
	}

	//Knocks childs

	public function isIgnored($user) {
		return ignore_object::where('object_id', '=', $this->object_id)->where('user_id', '=', $user)->exists();
	}

	public function comments() {
		return $this->hasMany('App\Comment', 'post_id');
	}

	public function reactions() {
		return $this->hasMany('App\Reaction', 'parent_id');
	}

	public function hasPictures() {
		return $this->knockIndex()->has_pictures;
	}
	public function hasFiles() {
		return $this->knockIndex()->has_files;
	}
	public function hasVoices() {
		return $this->knockIndex()->has_voices;
	}
	public function hasVideos() {
		return $this->knockIndex()->has_videos;
	}

	public function pictures() {
		return $this->knockIndex()->images_specifications;
	}

	public function files() {
		return $this->knockIndex()->files_specifications;
	}
	public function voices() {
		return array('blob' => $this->knockIndex()->voices_specifications, 'user' => $this->user_id);
	}
	public function videos() {
		return $this->knockIndex()->videos_specifications;
	}

	//Knocks methods

	// public function initialize($body , $at , $type){
	//   $object = new obj();
	//   $object->initialize('post');
	//   $this->body = $body ;
	//   $this->at = $at ;
	//   $this->type = $type ;
	//   $this->object_id = $object->id;
	//   $this->user_id = auth()->user()->id;
	//   $this->save();
	// }

	public function initialize($object) {
		$parent_object = new obj();
		$parent_object->initialize('knock');
		$object = json_decode($object);
		$parent_object->keywords = $object->text;
		$parent_object->quick_preset = $object->privacy_setting->tip;
		$parent_object->update();
		$this->body = $object->body;
		$this->at = $object->at;
		$this->type = $object->type;
		$this->object_id = $parent_object->id;
		$this->text_content = $object->text;
		$this->quick_preset = $object->privacy_setting->tip;
		//$object->$user_privacy ;
		//Images specifications reactions
		//images_quotes
		$images_reactions = array();
		$images_comments = array();
		if (isset($object->images_specifications) && count($object->images_specifications) > 0) {
			for ($i = 0; $i < count($object->images_specifications); $i++) {
				Blob::find((int) $object->images_specifications[$i])->assignParent($parent_object->id);
				//Create an image blob
				// $blob = new Blob();
				// $blob->imageBlob(json_encode(array(
				//   'extension' => 'image' ,
				//   'parent_obj' => $parent_object->id ,
				//   'parent_type' => 'knock' ,
				//   'album' => 'timeline' ,
				//   'quote' => $object->images_quotes[$i] ,
				//   'mongo_token' => $object->images_specifications[$i]
				// )));
				// $images_reactions[$object->images_specifications[$i]] = array();
			}
			//  for($i = 0 ; $i < count($object->images_specifications); $i++){
			//   $images_comments[$object->images_specifications[$i]] = array();
			// }
		}
		if ($object->has_voices) {
			$blob = Blob::find($object->voices_specifications);
			$blob->assignParent($parent_object->id);
		}

		if (isset($object->files_specifications) && count($object->files_specifications) > 0) {
			for ($i = 0; $i < count($object->files_specifications); $i++) {
				Blob::find((int) $object->files_specifications[$i])->assignParent($parent_object->id);
			}

		}

		$this->index = json_encode(array(
			'typing' => array(),
			'edited' => false,
			'has_pictures' => $object->has_pictures,
			'images_specifications' => $object->images_specifications,
			'has_videos' => $object->has_videos,
			'videos_specifications' => $object->videos_specifications,
			'has_voices' => $object->has_voices,
			'voices_specifications' => $object->voices_specifications,
			'has_files' => $object->has_files,
			'files_specifications' => $object->files_specifications,
			'seen' => array(auth()->user()->id => substr(json_decode(json_encode(Carbon::now()))->date, 0, 19)),
			'followers' => array(auth()->user()->id => true),
			'feelings' => $object->feelings,
			'check_in' => $object->check_in,
			'tags' => $object->tags,
			'images_reactions' => $images_reactions,
			'images_comments' => $images_comments,
			'hashtags' => $object->hashtags,
			'kvc' => $object->kvc_knock,

		));
		// $this->UserShowPost($object->user_privacy,$this->object_id);
		// $this->CircleShowPost($object->user_privacy,$this->object_id);
		if ($object->privacy_setting->tip == 'custom' || $object->privacy_setting->tip == 'userpresets') {
			$user_ps_object = $object->privacy_setting->user_privacy;
			foreach ($user_ps_object as $ob) {
				$user_privacy = new Privacy_set_user();
				$user_privacy->user_id = $ob->user_id;
				$user_privacy->preset_id = $ob->preset_id;
				$user_privacy->object_id = $parent_object->id;
				$user_privacy->save();
			}

			$circle_ps_object = $object->privacy_setting->circle_privacy;
			foreach ($circle_ps_object as $ob) {
				$circle_privacy = new Privacy_set_circle();
				$circle_privacy->circle_id = $ob->circle_id;
				$circle_privacy->preset_id = $ob->preset_id;
				$circle_privacy->object_id = $parent_object->id;
				$circle_privacy->save();
			}
		}
		$keywords = User_keywords::where('user_id', '=', auth()->user()->id);
		if ($keywords->count() == 0) {
			$kw = new User_keywords();
			$kw->keywords = $object->text;
			$kw->user_id = auth()->user()->id;
			$kw->save();
		} else {
			$kw = $keywords->get()->first();
			$kw->keywords .= ' ' . $object->text;
			$kw->update();
		}
		$this->user_id = auth()->user()->id;
		$this->save();
		//hashtags
		for ($h = 0; $h < count($object->hashtags); $h++) {
			$ht = new hashtags();
			$ht->createOrUpdate($object->hashtags[$h]);
			$uht = new User_hashtags();
			$uht->hashtag = $object->hashtags[$h];
			$uht->object_id = $this->object_id;
			$uht->parent_type = 'knock';
			$uht->parent_id = $this->id;
			$uht->user_id = auth()->user()->id;
			$uht->save();
		}
	}
	public function knockIndex() {
		return json_decode($this->index);
	}
	public function typing($user) {
		$index = $this->knockIndex();
		$typing = $index->typing;
		// if(!isset($typing->$user)) $typing[$user] = substr(json_decode(json_encode(Carbon::now()))->date,0,19);
		// else $typing->$user = substr(json_decode(json_encode(Carbon::now()))->date,0,19);
		// $typing->$user = substr(json_decode(json_encode(Carbon::now()))->date,0,19);
		$index->typing = $typing;
		$this->index = json_encode($index);
		$this->update();
		return true;
	}
	public function runningTypings($user) {
		$typing = $this->knockIndex()->typing;
		$counter = count((array) $typing);
		$last_date = null;
		foreach ($typing as $typer => $type) {
			if ($user != $typer) {
				$last_date = $type;
			}
		}
		return $last_date == null ? 'f' :
		array('last_typing' => $last_date, 'now' => substr(json_decode(json_encode(Carbon::now()))->date, 0, 19));
	}

	public function watchSeen($user) {
		if (!obj::find($this->object_id)->isAvailable($user)) {
			return false;
		}

		$index = $this->knockIndex();
		$seen = $index->seen;
		if (isset($seen->$user)) {
			return true;
		} else {
			$seen->$user = substr(json_decode(json_encode(Carbon::now()))->date, 0, 19);
			$index->seen = $seen;
			$this->index = json_encode($index);
			$this->update();
			return true;
		}
	}

	public function hasSeen($user) {
		$index = $this->knockIndex();
		$seen = $index->seen;
		return isset($seen->$user) ? true : false;
	}

}
