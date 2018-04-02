<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Group;
use App\Group_member;

class GroupMemberController extends Controller
{
    public function getGroupMembers(Request $request){
    	$all = Group_member::where('group_id','=',$request->group_id)->get();
    	return $all;
    }
     public function checkUserInGroup(Request $request){
             $ingroup = Group_member::where('group_id','=',$request->group)
             ->where('user_id','=',$request->user)->get();
             if(count($ingroup) > 0){
             	return 'in';
             }
             else{
             	 return 'out';
             }

    }

     public function checkOwner(Request $request){
        $mem = Group_member::where('group_id','=',$request->group_id)
        ->where('user_id','=', $request->mem_id)
        ->where('position','=','Owner')->get();

        if(count($mem) > 0)
            return 'true';
        else
            return 'false';
    }
    public function checkAdmin(Request $request){
        $mems = Group_member::where('group_id','=',$request->group_id)
        ->where('user_id','=', $request->mem_id)
        ->where('position','=','Admin')->get();

        if(count($mems) > 0)
            return 'true';
        else
            return 'false';
    }

    public function removeMember(Request $request){
        $group = Group::find($request->group_id);
        if(Group_member::where('group_id' , '=' , $request->group_id)->where('user_id' , '=' , auth()->user()->id)->get()->first()->isAdmin()){
        $mem = Group_member::where('group_id','=',$request->group_id)->where('user_id','=',$request->mem_id)->delete();
        $group->decreaseMembers();
        return 'done';
        }
        else 
        {
            return 'invalid';
        }
    }
    public function getMembersPosition(Request $request){
        $mem = Group_member::where('group_id','=',$request->group_id)->where('user_id','=',$request->user_id)->get();
        return $mem;
    }
    public function setMembersToAdmin(Request $request){
        $upd = Group_member::where('group_id','=',$request->group_id)->where('user_id','=',$request->user_id)->where('position','=','Member')->get()->first();
                $upd->position = 'Admin';
                $upd->update();
                return 'done';
    }
    public function setAdminToMember(Request $request){
        $upd = Group_member::where('group_id','=',$request->group_id)->where('user_id','=',$request->user_id)->where('position','=','Admin')->get()->first();
                $upd->position = 'Member';
                $upd->update();
                return 'done';
    }
    
}
