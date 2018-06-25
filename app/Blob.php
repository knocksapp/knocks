<?php

namespace App;

use App\obj;
use Illuminate\Database\Eloquent\Model;

class Blob extends Model {
	//

	public function object() {
		return $this->belongsTo('App\obj', 'object_id');
	}

	public function parent_object() {
		return $this->belongsTo('App\obj', 'parent_object');
	}

	public function imageBlob($object) {
		$parent_object = new obj();
		$parent_object->initialize('blob');
		$object = json_decode($object);
		$this->type = "image";
		$this->extension = $object->extension;
		$this->object_id = $parent_object->id;
		$this->album = $object->album;
		$this->user_id = auth()->user()->id;

		$this->index = json_encode(array(
			'blob' => $object->blob,
			'quote' => $object->quote,
			'name' => $object->name,
		));
		$this->save();
		return true;

	}

	public function fileBlob($object) {
		$parent_object = new obj();
		$parent_object->initialize('blob');
		$object = json_decode($object);
		$this->type = "File";
		$this->extension = $object->extension;
		$this->object_id = $parent_object->id;
		$this->album = $object->album;
		$this->user_id = auth()->user()->id;

		$this->index = json_encode(array(
			'blob' => $object->blob,
			'name' => $object->name,
		));
		$this->save();
		return true;

	}

	public function avatarBlob($object) {
		$parent_object = new obj();
		$parent_object->initialize('blob');
		$object = json_decode($object);
		$this->type = "avatar";
		$this->extension = $object->extension;
		$this->object_id = $parent_object->id;
		$this->album = 'Profile Pictures';
		$this->user_id = auth()->user()->id;
		if ($object->compressed != null) {
			$this->index = json_encode(array(
				'blob' => $object->blob,
				'compressed' => $object->compressed,
			));
		} else {
			$this->index = json_encode(array(
				'blob' => $object->blob,
				'compressed' => $object->blob,
			));
		}
		$this->save();
		return true;

	}

	public function coverBlob($object) {
		$parent_object = new obj();
		$parent_object->initialize('blob');
		$object = json_decode($object);
		$this->type = "cover";
		$this->extension = $object->extension;
		$this->object_id = $parent_object->id;
		$this->album = 'Profile Pictures';
		$this->user_id = auth()->user()->id;

		if ($object->compressed != null) {
			$this->index = json_encode(array(
				'blob' => $object->blob,
				'compressed' => $object->compressed,
			));
		} else {
			$this->index = json_encode(array(
				'blob' => $object->blob,
				'compressed' => $object->blob,
			));
		}

		$this->save();
		return true;

	}

	public function recordBlob($object) {
		$parent_object = new obj();
		$parent_object->initialize('blob');
		$object = json_decode($object);
		$this->type = "record";
		$this->extension = 'audio/webm';
		$this->album = 'User Records';
		$this->object_id = $parent_object->id;
		$this->user_id = auth()->user()->id;
		$this->index = json_encode(array(
			'blob' => $object->blob,
			'duration' => $object->duration,
			'text_content' => $object->text_content,
		));
		$this->save();
		return $this->id;

	}
	public function assignParent($object) {
		$this->parent_object = $object;
		$this->update();
		return;
	}
	public function index() {
		return json_decode($this->index);
	}
	public function mongoToken() {
		return $this->index()->mongo_token;
	}
	public function blobQuote() {
		return $this->index()->quote;
	}
	public function blobDuration() {
		return $this->index()->duration;
	}
	public function vnBlob() {
		return base64_decode(str_replace('data:audio/webm; codecs=opus;base64,', '', $this->index()->blob));
	}
	public function retriveImgBlob() {
		return base64_decode($this->index()->blob);
	}
	public function retriveImgCompressed() {
		return base64_decode($this->index()->compressed);
	}

}
