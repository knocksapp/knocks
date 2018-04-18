<?php

namespace App;

use App\obj;
use Illuminate\Database\Eloquent\Model;

class Ballon extends Model {
	public function user() {
		return $this->belongsTo('App\User', 'user_id');

	}
	public function object() {
		return $this->belongsTo('App\obj', 'object_id');
	}
	public function initialize($object) {
		$parentObject = new obj();
		$parentObject->initialize('balloon');
		$object = json_decode($object);
		$this->poped = 0;
		$this->seen = 0;
		if (isset($object->parent)) {
			$this->parent_id = $object->parent;
		}

		$this->user_id = $object->user;
		if (isset($object->parent)) {
			$this->content = $object->content;
		}
		$this->category = $object->category;
		$this->index = json_encode($object->index);
		$this->object_id = $parentObject->id;

		$this->save();
	}

	public function friendRequestBalloon($sender, $reciever, $request) {
		$this->initialize(json_encode(array(
			'user' => $reciever,
			'category' => 'friend_request',
			'index' => array(
				'category' => 'friend_request',
				'sender_id' => $sender,
				'request' => $request,
			),
		)));
	}

	public function friendRequestAccepted($sender, $reciever) {
		$this->initialize(json_encode(array(
			'user' => $reciever,
			'category' => 'friend_request_accepted',
			'index' => array(
				'category' => 'friend_request_accepted',
				'sender_id' => $sender,
			),
		)));
	}

	public function userComment($sender, $reciever, $knock, $comment) {
		$this->initialize(json_encode(array(
			'user' => $reciever,
			'category' => 'comment',
			'index' => array(
				'category' => 'comment',
				'sender_id' => $sender,
				'knock' => $knock,
				'comment' => $comment,
			),
		)));
	}
}

//TOBE EDITED
function sendNotification($ballon_type, $not,
	$object, $reference_url,
	$is_replyable, $sender_name,
	$has_picture, $image_url, $content) {
	switch ($ballon_type) {
	case 'post':
		$not->initialize(json_encode(
			array(
				"index" => array(
					"title_image" => $image_url,
					"title_value" => $sender_name,
					"category" => 'post',
					"has_picture" => $has_picture,
					"callback_url" => $reference_url,
					"replyable" => $is_replyable,
				),
				"parent" => $object,
				"user" => auth()->user()->id,
				"content" => $content,
			)
		));
		break;

	case 'comment':
		$not->initialize(json_encode(
			array(
				"index" => array(
					"title_image" => $image_url,
					"title_value" => $sender_name,
					"category" => 'comment',
					"has_picture" => $has_picture,
					"callback_url" => $reference_url,
					"replyable" => $is_replyable,
				),
				"parent" => $object,
				"user" => auth()->user()->id,
				"content" => $content,
			)
		));
		break;

	case 'replyable':
		$not->initialize(json_encode(
			array(
				"index" => array(
					"title_image" => $image_url,
					"title_value" => $sender_name,
					"category" => 'replyable',
					"has_picture" => $has_picture,
					"callback_url" => $reference_url,
					"replyable" => $is_replyable,
				),
				"parent" => $object,
				"user" => auth()->user()->id,
				"content" => $content,
			)
		));
		break;

	case 'reaction':
		$not->initialize(json_encode(
			array(
				"index" => array(
					"title_image" => $image_url,
					"title_value" => $sender_name,
					"category" => 'reaction',
					"has_picture" => $has_picture,
					"callback_url" => $reference_url,
					"replyable" => $is_replyable,
				),
				"parent" => $object,
				"user" => auth()->user()->id,
				"content" => $content,
			)
		));
		break;

	case 'knocks':
		$not->initialize(json_encode(
			array(
				"index" => array(
					"title_image" => $image_url,
					"title_value" => $sender_name,
					"category" => 'reaction',
					"has_picture" => $has_picture,
					"callback_url" => $reference_url,
					"replyable" => $is_replyable,
				),
				"parent" => $object,
				"user" => auth()->user()->id,
				"content" => $content,
			)
		));
		break;

	default:

		break;
	}

}
