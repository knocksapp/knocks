<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Group;
use App\Group_member;
use App\User_request;
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
            for($i=0; $i < count($allmembers); $i++){
            {
            $memberShip = new Group_member();
            $memberShip->initialize(
            $allmembers[$i],
            $newGroup->id,
            $member
            );

            $newGroup->increaseMembers();



        }
        }

        return 'done';
    }

    public function joinPublicGroup(Request $request){
      $checkUser = Group_member::where('user_id','=',$request->user)
      ->where('group_id','=',$request->group)->get();
      if(count($checkUser) > 0){
        return 'fail';
      }else{
        $newUser = new Group_member;
      $newUser->initialize(
        $user_id = $request->user,
        $group_id = $request->group,
        $position = 'Member'
      );

      if($request->state == 'request'){
        $upd = User_request::where('sender_id','=',$request->user)->where('reciver_id','=',$request->group)->
        where('response','=','waiting')->get()->first();
        $upd->response = 'accepted';
        $upd->update();
      }
      
      $group = Group::find($request->group);
      $group->increaseMembers();
        $newUser->save();
      return 'done';
      }
    	
    }

    public function joinClosedGroup(Request $request){
       $checkUser = Group_member::where('user_id','=',$request->user)
      ->where('group_id','=',$request->group)->get();
      if(count($checkUser) > 0){
        return 'false';
      }else{
         $checkOwner = Group_member::where('user_id','=',$auth->user()->id)->where('group_id','=',$request->group)->get();
      if(count($checkOwner) > 0){
         $newUser = new Group_member;
      $newUser->initialize(
        $user_id = $request->user,
        $group_id = $request->group,
        $position = 'Member'
      );
      
      $group = Group::find($request->group);
      $group->increaseMembers();
        $newUser->save();
      return 'done';
    }else{
      return 'false';
    }
     }
    }

    public function addMemberPublicGroup(Request $request){
       $checkUser = Group_member::where('user_id','=',$request->user)
      ->where('group_id','=',$request->group)->get();
      if(count($checkUser) > 0){
        return 'failed';
      }else{
      $ingroup = Group_member::where('group_id','=',$request->group)->where('user_id','=',auth()->user()->id)->where('position','=','Owner')->get();
      if(count($ingroup) > 0){
        $newUser = new Group_member;
      $newUser->initialize(
        $user_id = $request->user,
        $group_id = $request->group,
        $position = 'Member'
      );
      $group = Group::find($request->group);
      $group->increaseMembers();
        $newUser->save();
      return 'done';
      }
      return 'failed';
    }
    }



    public function getGroups(Request $request){
            $allgroups = $request->groups;
            $res;
            $var;
            $result = [];
            for($i = 0; $i < count($allgroups); $i++)
            {
                 $var = Group::where('id','=',$allgroups[$i])->get()->first();
                $res = array('name' => $var->name, 'group_id' => $var->id);
                array_push($result ,$res);
            }

            return $result;
    }

     public function getGroupName(Request $request){
                 $result = Group::where('id','=',$request->group)->get()->first();
                  return $result;
    }

      public function routeToGroup(Request $request){
      $c = Group::find($request->group_id);
      return view('groups.group', ['group' => $c]);
    }
    public function routeToGroupPictures(Request $request){
      $c = Group::find($request->group_id);
      return view('groups.group_pictures', ['group' => $c]);
    }
    public function routeToGroupFiles(Request $request){
      $c = Group::find($request->group_id);
      return view('groups.group_files', ['group' => $c]);
    }
    public function routeToGroupVoices(Request $request){
      $c = Group::find($request->group_id);
      return view('groups.group_voices', ['group' => $c]);
    }
    public function routeToGroupVideos(Request $request){
      $c = Group::find($request->group_id);
      return view('groups.group_videos', ['group' => $c]);
    }
       public function routeToGroupSettings(Request $request){
      $c = Group::find($request->group_id);
      return view('groups.groups_settings', ['group' => $c]);
    }
    public function retriveGroupKnocks(Request $request){
      $group = Group::find($request->user);
      if($group)
      return $group->getGroupKnocks(json_encode($request->limits));
    }

    public function retriveOlderGroupKnocks(Request $request){
       $group = Group::find($request->user);
      if($group)
      return $group->getGroupKnocksRegularMin($request->min);
    }

    public function retriveNewerGroupKnocks(Request $request){
      $group = Group::find($request->user);
      if($group)
      return $group->getGroupKnocksRegularMax($request->max);
    }

   public function retriveGroupForJoin(Request $request){
              $group = Group::find($request->group);
              return $group;
   }

   public function getPictures(Request $request){
           $res = Group::find($request->group_id)->photos();
          return $res;
   }
    public function getFiles(Request $request){
           $res = Group::find($request->group_id)->files();
          return $res;
   }
    public function getVoices(Request $request){
           $res = Group::find($request->group_id)->voices();
          return $res;
   }
    public function getVideos(Request $request){
           $res = Group::find($request->group_id)->videos();
          return $res;
   }
   public function updateGroupInfo(Request $request){
      $group = Group::find($request->group_id);
      if(count($group) > 0){
        $group->name = $request->group_name;
        $group->category = $request->group_category;
        $group->update();
        return 'done';
      }else return 'not found';
    }
    public function updateGroupPrivacy(Request $request){
      $group = Group::find($request->group_id);
      if(count($group) > 0){
        $group->preset = $request->preset;
        $group->update();
        return 'done';
      }else return 'not found';
    }
    public function deleteGroup(Request $request){
          $del = Group::find($request->group_id)->delete();
          return 'done';
    }
}
