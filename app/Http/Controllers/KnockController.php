<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Knock;
use App\obj;
use App\Reply;
use App\User;
use App\Candy_session;
use Illuminate\Http\Request;

class KnockController extends Controller {
	public function create(Request $request) {
		$knock = new Knock();

		$knock->initialize(json_encode($request->submit_object));
		
		return 'done';
	}
	public function delete(Request $request) {

		$request->validate([
			'knock' => 'required',
		]);
		$knock = Knock::find($request->knock);
		if (!$knock->canEdit(auth()->user()->id)) {
			return 'invalid';
		}
		$knock->deleteKnock();
		return 'done';
	}
	public function retrive(Request $request) {

		$request->validate([
			'knock' => 'required',
		]);

		$knock = Knock::find($request->knock);
		return $knock->view(auth()->check() ? auth()->user()->id : -1);
	}

	public function retriveOlder(Request $request) {

		$request->validate([
			'knock' => 'required',
		]);

		$knock = Knock::find($request->knock);
		return $knock->view();
	}

	public function getComments(Request $request) {
		$request->validate([
			'knock' => 'required',
		]);
		if ($request->max == null) {
			if (Knock::find($request->knock)->comments()) {
				$array = array();
				$comments = Knock::find($request->knock)->comments()->where('type', '=', 'knock')->get();
				foreach ($comments as $comment) {
					$object = obj::find($comment->object_id);
					if ($object->isAvailable(auth()->check() ? auth()->user()->id : -1)) {
						array_push($array, $comment->id);
					}

				}
				return $array;
			} else {
				return array();
			}

		} else {
			if (Knock::find($request->knock)->comments()->where('id', '>', $request->max)) {
				return Knock::find($request->knock)->comments()->where('id', '>', $request->max)->get()->pluck('id');
			} else {
				return array();
			}

		}
	}

	public function tickSeen(Request $request) {
		$request->validate([
			'knock' => 'required',
		]);
		$knock = Knock::find($request->knock)->watchSeen(auth()->user()->id);
		return $knock ? 'done' : 'failed';

	}

	public function viewKnock(Request $request, $knock) {
		$k = Knock::find($knock);
		if ($k != null) {
			return view('user.knock', ['knock' => $k]);
		} else {
			return view('guest.lost');
		}

	}

	public function knockMasterData(Request $request) {
		$k = Knock::find($request->id);
		if ($k) {
			return array(
				'id' => $k->id,
				'user' => $k->user_id,
			);
		}
	}

	public function viewComment(Request $request, $comment) {
		$c = Comment::find($comment);
		if ($c == null) {
			return view('guest.lost');
		}

		if ($c) {
			$k = Knock::find($c->post_id);
		} else {
			return view('guest.lost');
		}
		if ($k && $c && $k->comments()->where('id', '=', $c->id)->exists()) {
			return view('user.comment',
				['knock' => $k,
					'comment' => $c,
					'owner' => User::find($k->user_id), 'commenter' => User::find($c->user_id)]);
		}

	}

	public function viewReply(Request $request, $reply) {
		$comment = Reply::find($reply);
		if ($comment == null) {
			return view('guest.lost');
		}

		$c = Comment::find($comment->parent_id);
		if ($c) {
			$k = Knock::find($c->post_id);
		} else {
			return view('guest.lost');
		}
		if ($k && $c && $k->comments()->where('id', '=', $c->id)->exists()) {
			return view('user.reply',
				['knock' => $k,
					'reply' => $comment,
					'comment' => $c,
					'owner' => User::find($k->user_id), 'commenter' => User::find($comment->user_id)]);
		}

	}

	public function viewKnockWithComment(Request $request, $knock, $comment) {
		$k = Knock::find($knock);
		$c = Comment::find($comment);
		if ($k && $c && $k->comments()->where('id', '=', $c->id)->exists()) {
			return view('user.comment',
				['knock' => $k,
					'comment' => $c,
					'owner' => User::find($k->user_id), 'commenter' => User::find($c->user_id)]);
		}

	}

}
