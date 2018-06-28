<?php

namespace App;

use App\Comment;
use App\Knock;
use App\obj;
use App\Saved_presets;
use App\User_keywords;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model {
	public function users() {
		return $this->belongsTo('App\User', 'user_id');
	}
	public function object() {
		return $this->belongsTo('App\obj', 'object_id');
	}
	public function knock() {
		return $this->belongsTo('App\Knock', 'post_id');
	}
	public function reply() {
		return $this->belongsTo('App\Reply', 'comment_id');
	}

	//Reply childs

	public function replies() {
		return $this->hasMany('App\Reply', 'parent_id');
	}

	public function replyReplies() {
		return Reply::where('parent_type', '=', 'reply')->where('parent_id', '=', $this->id);
	}

	public function reactions() {
		return $this->hasMany('App\Reaction', 'parent_id');
	}

	public function discription() {
		$ind = $this->knockIndex();
		if ($ind->has_voices) {
			return 'Voice note';
		}
		if ($this->text_content != null && count($this->text_content) > 0) {
			return $this->text_content;
		}
		if ($ind->has_files) {
			return count($ind->files_specifications) . ' File/s';
		}
		if ($ind->has_pictures) {
			return count($ind->images_specifications) . ' Image/s';
		}
		return 'KnocksApp, INC';
	}
	public function knockIndex() {
		return json_decode($this->index);
	}
	public function initialize($object) {
		$parent_object = new obj();
		$parent_object->initialize('reply');
		$object = json_decode($object);
		$parent_object->keywords = $object->text;
		$parent_object->quick_preset = $object->privacy_setting->tip;
		$parent_object->update();
		$this->body = $object->body;
		$this->at = $object->at;
		$this->text_content = $object->text;
		$this->type = $object->type;
		$this->parent_type = $object->type;
		$this->object_id = $parent_object->id;
		$this->parent_id = $object->post_id;
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

		if ($object->privacy_setting->tip == 'custom' || $object->privacy_setting->tip == 'userpresets' || $object->privacy_setting->tip == 'choosedefault') {
			$user_ps_object = $circle_ps_object = array();
			//Default
			if ($object->privacy_setting->tip == 'choosedefault') {
				$dps = auth()->user()->defaultPreset();
				if ($dps != null) {
					$udf = Saved_presets::find($dps);
					if ($udf != null) {
						$constraints = $udf->constraints();
						if ($constraints != null) {
							$user_ps_object = $constraints->user_privacy;
							$circle_ps_object = $constraints->circle_privacy;
						}
					}
				}
			} else {
				$user_ps_object = $object->privacy_setting->user_privacy;
				$circle_ps_object = $object->privacy_setting->circle_privacy;
			}
			//Customs

			foreach ($user_ps_object as $ob) {
				$user_privacy = new Privacy_set_user();
				$user_privacy->user_id = $ob->user_id;
				$user_privacy->preset_id = $ob->preset_id;
				$user_privacy->object_id = $parent_object->id;
				$user_privacy->save();
			}
			foreach ($circle_ps_object as $ob) {
				if ($ob->circle_id == -1) {
					$parent_object->updatePublicPresetNum($ob->preset_id);
				} else {
					$circle_privacy = new Privacy_set_circle();
					$circle_privacy->circle_id = $ob->circle_id;
					$circle_privacy->preset_id = $ob->preset_id;
					$circle_privacy->object_id = $parent_object->id;
					$circle_privacy->save();
				}
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
		$pknock = Comment::find($object->post_id);
		if ($pknock != null) {
			$kobj = obj::find($pknock->object_id);
			if ($kobj != null) {
				if ($kobj->type == 'comment') {
					$pknock->addFollower(auth()->user()->id);
					$pkfollowers = $pknock->knockIndex()->followers;
					foreach ($pkfollowers as $flwr => $state) {
						if ($state && $flwr != auth()->user()->id) {
							$bal = new Ballon();
							$bal->userReply(auth()->user()->id, $flwr, Knock::find($pknock->post_id)->id, $pknock->id, $this->id, $pknock->object_id);
						}
					}
				}
			}
		}
	}

}
