<?php

namespace App\Http\Controllers;

use App\Group;
use App\Group_member;
use Illuminate\Http\Request;

class GroupMemberController extends Controller {
	public function getGroupMembers(Request $request) {
		// $all = Group_member::where('group_id','=',$request->group_id)->where()->get();
		// return $all;
		$groupmembers = \DB::table('search_queries')
			->join('group_members', 'search_queries.query_id', '=', 'group_members.user_id')
			->select('group_members.*')
			->where('group_members.group_id', '=', $request->group_id)
			->where('search_queries.query_type', '=', 'user')
			->where('search_queries.keywords', 'LIKE', '%' . $request->q . '%')
			->get();
		return $groupmembers;
	}
	public function checkUserInGroup(Request $request) {
		$ingroup = Group_member::where('group_id', '=', $request->group)
			->where('user_id', '=', $request->user)->get();
		if (count($ingroup) > 0) {
			return 'in';
		} else {
			return 'out';
		}

	}

	public function checkOwner(Request $request) {
		$mem = Group_member::where('group_id', '=', $request->group_id)
			->where('user_id', '=', $request->mem_id)
			->where('position', '=', 'Owner')->get();

		if (count($mem) > 0) {
			return 'true';
		} else {
			return 'false';
		}

	}
	public function checkAdmin(Request $request) {
		$mems = Group_member::where('group_id', '=', $request->group_id)
			->where('user_id', '=', $request->mem_id)
			->where('position', '=', 'Admin')->get();

		if (count($mems) > 0) {
			return 'true';
		} else {
			return 'false';
		}

	}

	public function removeMember(Request $request) {
		$group = Group::find($request->group_id);
		if (Group_member::where('group_id', '=', $request->group_id)->where('user_id', '=', auth()->user()->id)->get()->first()->isAdmin()) {
			if (Group_member::where('group_id', '=', $request->group_id)->where('user_id', '=', $request->mem_id)->get()->first()->isAdmin()) {
				if (count(Group_member::where('group_id', '=', $request->group_id)->where('position', '=', 'Owner')->get()) < 2) {
					return 'faild';
				} else {
					$mem = Group_member::where('group_id', '=', $request->group_id)->where('user_id', '=', $request->mem_id)->delete();
					$group->decreaseMembers();
					return 'done';
				}
			} else {
				$mem = Group_member::where('group_id', '=', $request->group_id)->where('user_id', '=', $request->mem_id)->delete();
				$group->decreaseMembers();
				return 'done';
			}

		} else {
			$mem = Group_member::where('group_id', '=', $request->group_id)->where('user_id', '=', $request->mem_id)->delete();
			$group->decreaseMembers();
			return 'done';
		}
	}
	public function getMembersPosition(Request $request) {
		$mem = Group_member::where('group_id', '=', $request->group_id)->where('user_id', '=', $request->user_id)->get();
		return $mem;
	}
	public function setMembersToAdmin(Request $request) {
		$upd = Group_member::where('group_id', '=', $request->group_id)->where('user_id', '=', $request->user_id)->where('position', '=', 'Member')->get()->first();
		$upd->position = 'Admin';
		$upd->update();
		return 'done';
	}
	public function setAdminToMember(Request $request) {
		$upd = Group_member::where('group_id', '=', $request->group_id)->where('user_id', '=', $request->user_id)->where('position', '=', 'Admin')->get()->first();
		$upd->position = 'Member';
		$upd->update();
		return 'done';
	}
	public function setToOwner(Request $request) {
		$upd = Group_member::where('group_id', '=', $request->group_id)->where('user_id', '=', $request->user_id)->get()->first();
		$upd->position = 'Owner';
		$upd->update();
		return 'done';
	}

}
