<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group_member extends Model {
	//

	public function user() {
		return $this->belongsTo('App\User', 'user_id');
	}

	public function group() {
		return $this->belongsTo('App\Group', 'group_id');
	}

	public function initialize($user_id, $group_id, $position) {
		$g = Group::find($group_id);
		if (!$g) {
			return;
		}
		if ($g->groupMembers()->where('user_id', '=', $user_id)->exists()) {
			return;
		}
		$this->user_id = $user_id;
		$this->group_id = $group_id;
		$this->position = $position;
		$this->save();
	}
	public function isAdmin() {
		return $this->position == 'Owner' || $this->position == 'Admin' ? true : false;
	}
}
