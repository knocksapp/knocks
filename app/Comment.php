<?php

namespace App;

use App\Ballon;
use App\Knock;
use App\obj;
use App\Reply;
use App\User;
use App\User_keywords;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model {
	public function users() {
		return $this->belongsTo('App\User', 'user_id');
	}
	public function object() {
		return $this->belongsTo('App\obj', 'object_id');
	}
	public function knock() {
		return $this->belongsTo('App\Knock', 'post_id');
	}

	//comment childs

	public function replies() {
		return $this->hasMany('App\Reply', 'comment_id');
	}

	public function reactions() {
		return $this->hasMany('App\Reaction', 'parent_id');
	}

	public function commentReplies() {
		return Reply::where('parent_type', '=', 'comment')->where('parent_id', '=', $this->id);
	}

	//Comment methods
	public function addFollower($user) {
		$index = $this->knockIndex();
		$followers = $index->followers;
		$followers->$user = true;
		$this->index = json_encode($index);
		$this->update();
	}

	public function knockIndex() {
		return json_decode($this->index);
	}

	public function initialize($object) {
		$parent_object = new obj();
		$parent_object->initialize('comment');
		$object = json_decode($object);
		$parent_object->keywords = $object->text;
		$parent_object->quick_preset = $object->privacy_setting->tip;
		$parent_object->update();
		$this->body = $object->body;
		$this->at = $object->at;
		$this->type = $object->type;
		$this->object_id = $parent_object->id;
		$this->post_id = $object->post_id;
		$this->text_content = $object->text;
		$this->quick_preset = $object->privacy_setting->tip;

		//Add follower
		$pknock = Knock::find($object->post_id);
		if ($pknock != null) {
			$kobj = obj::find($pknock->object_id);
			if ($kobj != null) {
				if ($kobj->type == 'knock') {
					$pknock->addFollower(auth()->user()->id);
				}
			}
		}
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
				//   'parent_object' => $parent_object->id ,
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

		//user wights
		if ($this->type == 'knock') {
			$pknock = Knock::find($object->post_id);
			$owner = $pknock->user_id;
			if (auth()->user()->isFriend($owner)) {
				auth()->user()->updateFrindshipWeight($owner, 3);
			}
			$ownerob = User::find($owner);
			$ownerob->weight += 3;
			$ownerob->update();
		}
		//Add follower
		if ($this->type == 'knock') {
			$pknock = Knock::find($object->post_id);
			if ($pknock != null) {
				$kobj = obj::find($pknock->object_id);
				if ($kobj != null) {
					if ($kobj->type == 'knock') {
						$pknock->addFollower(auth()->user()->id);
						$pkfollowers = $pknock->knockIndex()->followers;
						foreach ($pkfollowers as $flwr => $state) {
							if ($state && $flwr != auth()->user()->id) {
								$bal = new Ballon();
								$bal->userComment(auth()->user()->id, $flwr, $pknock->id, $this->id, $pknock->object_id, $this->type);
							}
						}
					}
				}
			}
		} elseif ($this->type == 'timelinephoto') {

		}
	}

}
