<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Group;
use App\Group_member;
class GroupController extends Controller
{
    public function createGroup(Request $request){
            $newGroup = new Group();
            $newGroup->initialize(
            $request->name,
            $request->category,
            $request->thumbnail,
            $request->preset
            );
            $ownerShip = new Group_member();
            $postion = 'Owner';
            $member = 'Member';
            $ownerShip->initialize(
            auth()->user()->id,
            $newGroup->id,
            $postion
            );
            $allmembers = array_merge($request->circle_members,$request->normal_members);
            for($i=0; $i < count($allmembers); $i++)
            {
            $memberShip = new Group_member();
            $memberShip->initialize(
            $allmembers[$i],
            $newGroup->id,
            $member
            );
        }
        return 'done';
    }
}
