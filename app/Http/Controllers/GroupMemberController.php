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
             ->where('user_id','=',auth()->user()->id)->get();
             if(count($ingroup) > 0){
             	return 'true';
             }
             else{
             	 return 'false';
             }

    }

    public function joinPublicGroup(Request $request){
    	$newUser = new Group_member;
    	$newUser->initialize(
    		$user_id = auth()->user()->id,
    		$group_id = $request->group,
    		$position = 'Member'
    	);
    	
    	$group = Group::where('id','=', $request->group);
    	$group->increaseMembers();
$newUser->save();
    	return 'done';
    }
}
