<?php

namespace App\Http\Controllers;

use App\Ballon;
use App\obj;
use App\Reaction;
use App\User;
use Illuminate\Http\Request;

class ReactionController extends Controller {

	public function insert_reaction(Request $request) {

		$res = Reaction::where('object_id', '=', $request->object_id)
			->where('user_id', '=', auth()->user()->id)->get();

		if ($res->count() != 0) {
			$reaction = $res->first();

			$reaction->type = $request->type;

			$reaction->update();
			return 'swapped';

		} else {
			$reaction = new Reaction();

			$reaction->object_id = $request->object_id;
			$reaction->type = $request->type;
			$reaction->parent_type = $request->parent_type;
			$reaction->parent_id = $request->parent_id;
			$reaction->user_id = auth()->user()->id;

			$reaction->save();
			$obj = obj::find($request->object_id);

			$ballon = new Ballon();
			$ballon->userReaction(auth()->user()->id, $obj->user_id, $request->type, $obj->id, $obj->type, $obj->getMyChild()->id, $obj);

			return 'done';
		}

	}

	public function checkinit_reaction(Request $request) {
		$res = Reaction::where('object_id', '=', $request->object_id)
			->where('user_id', '=', auth()->user()->id)->get();

		if ($res->count() != 0) {
			return $res->first()->type;
		} else {
			return 'null';
		}
	}

	public function delete_reaction(Request $request) {

		$reaction = Reaction::where('object_id', '=', $request->object_id)
			->where('user_id', '=', auth()->user()->id)->first();
		$reaction->delete();
		return 'done';

	}

	public function getstats_reaction(Request $request) {
		$sad_users = array();
		$reaction_sad = Reaction::where('object_id', '=', $request->object_id)
			->where('type', '=', 'sad')->get();
		foreach ($reaction_sad as $sadUsers) {
			array_push($sad_users, $sadUsers->user_id);
		}
		$sad_count = $reaction_sad->count();

		$angry_users = array();
		$reaction_angry = Reaction::where('object_id', '=', $request->object_id)
			->where('type', '=', 'angry')->get();
		foreach ($reaction_angry as $angryUsers) {

			array_push($angry_users, $angryUsers->user_id);
		}
		$angry_count = $reaction_angry->count();

		$laugh_users = array();
		$reaction_laugh = Reaction::where('object_id', '=', $request->object_id)
			->where('type', '=', 'laugh')->get();
		foreach ($reaction_laugh as $laughUsers) {
			array_push($laugh_users, $laughUsers->user_id);
		}
		$laugh_count = $reaction_laugh->count();

		$like_users = array();
		$reaction_like = Reaction::where('object_id', '=', $request->object_id)
			->where('type', '=', 'like')->get();
		foreach ($reaction_like as $likeUsers) {
			array_push($like_users, $likeUsers->user_id);
		}
		$like_count = $reaction_like->count();

		$dislike_users = array();
		$reaction_dislike = Reaction::where('object_id', '=', $request->object_id)
			->where('type', '=', 'dislike')->get();
		foreach ($reaction_dislike as $dislikeUsers) {
			array_push($dislike_users, $dislikeUsers->user_id);
		}
		$dislike_count = $reaction_dislike->count();

		$finger_users = array();
		$reaction_finger = Reaction::where('object_id', '=', $request->object_id)
			->where('type', '=', 'finger')->get();
		foreach ($reaction_finger as $fingerUsers) {
			array_push($finger_users, $fingerUsers->user_id);
		}
		$finger_count = $reaction_finger->count();

		$love_users = array();
		$reaction_love = Reaction::where('object_id', '=', $request->object_id)
			->where('type', '=', 'love')->get();
		foreach ($reaction_love as $loveUsers) {
			array_push($love_users, $loveUsers->user_id);
		}
		$love_count = $reaction_love->count();

		$poker_users = array();
		$reaction_poker = Reaction::where('object_id', '=', $request->object_id)
			->where('type', '=', 'poker')->get();
		foreach ($reaction_poker as $pokerUsers) {
			array_push($poker_users, $pokerUsers->user_id);
		}
		$poker_count = $reaction_poker->count();

		$reactions = json_encode(array(
			'sad' => $sad_count,
			'sadusers' => $sad_users,
			'angry' => $angry_count,
			'angryusers' => $angry_users,
			'laugh' => $laugh_count,
			'laughusers' => $laugh_users,
			'like' => $like_count,
			'likeusers' => $like_users,
			'dislike' => $dislike_count,
			'dislikeusers' => $dislike_users,
			'poker' => $poker_count,
			'pokerusers' => $poker_users,
			'love' => $love_count,
			'loveusers' => $love_users,
			'finger' => $finger_count,
			'fingerusers' => $finger_users,
		));

		return $reactions;
	}

}