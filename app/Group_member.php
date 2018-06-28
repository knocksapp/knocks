<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Group;
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
		$user = User::find($user_id);
		if($user->isKid())
	 {
		 $candy_session = new Candy_session();
		 $candy_session->initialize($user->id,$this->group_id,'group',$this->group_id,null,null);

	}
}
	public function isAdmin() {
		return $this->position == 'Owner' || $this->position == 'Admin' ? true : false;
	}
}
