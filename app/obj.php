<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class obj extends Model {
	public function user() {
		return $this->belongsTo('App\User', 'user_id');
	}

	//Object childs

	public function blobs() {
		return $this->hasOne('App\Blob', 'object_id');
	}

	public function childBlobs() {
		return $this->hasOne('App\Blob', 'parent_object');
	}

	public function knocks() {
		return $this->hasOne('App\Knock', 'object_id');
	}

	public function comments() {
		return $this->hasOne('App\Comment', 'object_id');
	}

	public function replies() {
		return $this->hasOne('App\Reply', 'object_id');
	}

	public function reactions() {
		return $this->hasOne('App\Reaction', 'object_id');
	}

	public function privacySetUsers() {
		return $this->hasOne('App\Privacy_set_user', 'object_id');
	}

	public function privacySetCircles() {
		return $this->hasOne('App\Privacy_set_circle', 'object_id');
	}

	public function educations() {
		return $this->hasOne('App\Education', 'object_id');
	}

	public function highEducations() {
		return $this->hasOne('App\High_education', 'object_id');
	}

	public function careers() {
		return $this->hasOne('App\Career', 'object_id');
	}

	public function sports() {
		return $this->hasOne('App\Sport', 'object_id');
	}

	public function hobbies() {
		return $this->hasOne('App\Hobby', 'object_id');
	}

	public function publicFigures() {
		return $this->hasOne('App\Public_figure', 'object_id');
	}

	public function userRequests() {
		return $this->hasOne('App\User_request', 'object_id');
	}

	public function envelops() {
		return $this->hasOne('App\Envelope', 'object_id');
	}

	public function candySessions() {
		return $this->hasOne('App\Candy_session', 'object_id');
	}

	public function talentObjects() {
		return $this->hasOne('App\talent_object', 'object_id');
	}

	public function ballons() {
		return $this->hasOne('App\Ballon', 'object_id');
	}
	public function blobQoute() {

	}
	public function getMyChild() {
		if ($this->type == 'knock') {
			return Knock::where('object_id', '=', $this->id)->first();
		}
		if ($this->type == 'comment') {
			return Comment::where('object_id', '=', $this->id)->first();
		}
		if ($this->type == 'reply') {
			return Reply::where('object_id', '=', $this->id)->first();
		}
		if ($this->type == 'blob') {
			return Blob::where('object_id', '=', $this->id)->first();
		}

	}
	public function addFollower($user) {
		$index = $this->knockIndex();
		if (!isset($index->followers)) {
			$index->followers = array($this->user_id => true);
		}

		$followers = $index->followers;
		$followers->$user = true;
		$this->index = json_encode($index);
		$this->update();
	}
	public function knockIndex() {
		return json_decode($this->index);
	}

	//Object methods

	public function initialize($type) {
		$this->type = $type;
		$this->has_media = 0;
		$this->user_id = auth()->user()->id;
		$this->index = json_encode(array("public_preset" => auth()->user()->publicPreset(), "followers" => array(auth()->user()->id => true)));
		$this->save();
	}

	public function isAvailable($requestMaker) {
		if (!User::find($requestMaker)) {
			return false;
		}

		//$this = Object::find($this_id);

		$object_owner = $this->user_id;

		if ($object_owner == $requestMaker) {
			return true;
		}

		$preset_id_privacy_user = $this->privacySetUsers()->where('user_id', '=', $requestMaker)->first();

		if (!($preset_id_privacy_user == null)) {
			$preset_id = $preset_id_privacy_user->preset_id;

			//getting the name of privacy_preset for the far_user
			$preset = $this->privacySetUsers()->where('user_id', '=', $requestMaker)->first()->preset()->first();
			$preset_name = $preset->name;
			// return $preset_name;

			//gettint the conditions for the user in privacy_user_set
			if ($preset_name == 'invalidForAll') {
				return false;
			} else if ($preset_name == 'invalid') {
				return false;
			} elseif ($preset_name == 'valid') {
				return true;
			}

		} else //look in the circles
		{
			$invalid = 0;
			$valid = 0;
			//getting the circles for mysqli_change_user
			$circles = Circle::where('user_id', '=', $object_owner)->get();
			$circles_hasFar_member = array();
			foreach ($circles as $c) {

				$c_id = $c->id;
				//checking if the far user is a member of selected circles or not
				if (User::find($requestMaker)->isMemberIn($c_id, $requestMaker)) {
					array_push($circles_hasFar_member, $c_id);

				}
			}

			//now i have the circles where the far user is a member of ,i will look for the
			//privacy circle preset for each circles

			if (count($circles_hasFar_member) != 0) {
				for ($c = 0; $c < count($circles_hasFar_member); $c++) {

					$privacy_c_set = Privacy_set_circle::where('circle_id', '=', $circles_hasFar_member[$c])->first();

					$privacy_c_set_id = $privacy_c_set->preset_id;
					$preset = $privacy_c_set->preset()->where('id', '=', $privacy_c_set_id)->first();
					$preset_name = $preset->name;
					//return $preset_name;
					//now i have preset name for each circle

					if ($preset_name == 'invalidForAll') {
						return false;
					} else if ($preset_name == 'invalid') {
						$invalid = 1;
					} else if ($preset_name == 'valid') {
						$valid = 1;
					}

				}

				if ($valid == 1 && $invalid == 1) {
					return true;
				} else if ($valid == 1 && $invalid == 0) {
					return true;
				} else if ($valid == 0 && $invalid == 1) {
					return true;
				} else if ($valid == 0 && $invalid == 0) {

					// return"go for object indexing";

					//go fo public indexing in object
					$Preset_pup = json_decode($this->index)->public_preset;
					if ($Preset_pup == 'invalidForAll') {
						return false;
					} else if ($Preset_pup == 'invalid') {
						return false;
					} elseif ($Preset_pup == 'valid') {
						return true;
					}

				}

			} else // he is neither in privacy_set_user nor privacy_circle_set
			{
				$Preset_pup = json_decode($this->index)->public_preset;
				if ($Preset_pup == 'invalidForAll') {
					return false;
				} else if ($Preset_pup == 'invalid') {
					return false;
				} elseif ($Preset_pup == 'valid') {
					return true;
				}

			}

		}

	}

}
