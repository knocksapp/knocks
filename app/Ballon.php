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
		if (isset($object->content)) {
			$this->content = $object->content;
		}
		$this->category = $object->category;
		$this->index = json_encode($object->index);
		$this->object_id = $parentObject->id;

		$this->save();
	}
	public function index() {
		return json_decode($this->index);
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

	public function userComment($sender, $reciever, $knock, $comment, $parent, $object_type) {
		$same = Ballon::where('user_id', '=', $reciever)->where('parent_id', '=', $parent)->where('poped', '=', 0)->where('category', '=', 'comment');
		if ($same->exists()) {
			$ballon = $same->first();
			$ind = $ballon->index();
			$commenters = $ind->commenters;
			if (!in_array($sender, $commenters)) {
				array_push($commenters, $sender);
				$ind->commenters = $commenters;
			}
			$comments = $ind->comments;
			array_push($comments, $comment);
			$ind->comments = $comments;
			$ind->$comment = $comment;
			$ind->sender_id = $sender;
			$ballon->index = json_encode($ind);
			$ballon->update();
		} else {
			$this->initialize(json_encode(array(
				'user' => $reciever,
				'category' => 'comment',
				'parent' => $parent,
				'index' => array(
					'category' => 'comment',
					'sender_id' => $sender,
					'knock' => $knock,
					'comment' => $comment,
					'comments' => [$comment],
					'commenters' => [$sender],
					'object_type' => $object_type,
				),
			)));
		}
	}

	public function userReply($sender, $reciever, $knock, $comment, $reply, $parent) {
		$same = Ballon::where('user_id', '=', $reciever)->where('parent_id', '=', $parent)->where('poped', '=', 0)->where('category', '=', 'reply');
		if ($same->exists()) {
			$ballon = $same->first();
			$ind = $ballon->index();
			$commenters = $ind->repliers;
			if (!in_array($sender, $commenters)) {
				array_push($commenters, $sender);
				$ind->commenters = $commenters;
			}
			$comments = $ind->replies;
			array_push($comments, $comment);
			$ind->comments = $comments;
			$ind->$comment = $comment;
			$ind->sender_id = $sender;
			$ballon->index = json_encode($ind);
			$ballon->update();
		} else {
			$this->initialize(json_encode(array(
				'user' => $reciever,
				'category' => 'reply',
				'parent' => $parent,
				'index' => array(
					'category' => 'reply',
					'sender_id' => $sender,
					'knock' => $knock,
					'comment' => $comment,
					'reply' => $reply,
					'replies' => [$reply],
					'repliers' => [$sender],
				),
			)));
		}
	}

	public function userReaction($sender, $reciever, $reaction, $object, $object_type, $child, $parent) {
		$same = Ballon::where('user_id', '=', $reciever)->where('parent_id', '=', $parent)->where('poped', '=', 0)->where('category', '=', 'reaction');
		if ($same->exists()) {
			$ballon = $same->first();
			$ind = $ballon->index();
			$commenters = $ind->reactors;
			if (!in_array($sender, $commenters)) {
				array_push($commenters, $sender);
				$ind->commenters = $commenters;
			}
			$ind->sender_id = $sender;
			$ballon->index = json_encode($ind);
			$ballon->update();
		} else {
			$this->initialize(json_encode(array(
				'user' => $reciever,
				'category' => 'reaction',
				'parent' => $parent,
				'index' => array(
					'category' => 'reaction',
					'reaction' => $reaction,
					'sender_id' => $sender,
					'object_id' => $object,
					'object_type' => $object_type,
					'child' => $child,
					'reactors' => [$sender],
				),
			)));
		}
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
