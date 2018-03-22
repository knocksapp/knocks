<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User_request;
use App\User;
use App\Ballon;

class UserRequestController extends Controller
{
    public function sendGroup(Request $request){
      $request->validate([
        'users'=> 'required',
        'circles' => 'required'
      ]);
      $request->users = json_decode( $request->users);
      foreach($request->users as $user){
        if(User::find($user) != null){
          $req = new User_request();
          $req->initialize($user, $request->circles);
        }
        return 'done';
      }

    }
    public function sendOne(Request $request){
      $request->validate([
        'to' => 'required'
      ]);
      //Validate if exist
      if($request->to == auth()->user()->id) return 'invalid';
      $user = User::find($request->to);
      if(!$user) return 'invalid';
      //Validate if already friends
      if(auth()->user()->isFriend($user)) return 'invalid';
      //Initialize and send
      $req = new User_request();
      $req->initialize(auth()->user()->id , $user->id);
      $ballon = new Ballon();
      $ballon->friendRequestBalloon(auth()->user()->id , $request->to, $req->id);
      return 'done';

    }
      public function cancelOne(Request $request){
      $request->validate([
        'to' => 'required'
      ]);
      //Validate if exist
      if($request->to == auth()->user()->id) return 'invalid';
      $user = User::find($request->to);
      if(!$user) return 'invalid';
      //Validate if already friends
      if(auth()->user()->isFriend($user)) return 'invalid';
      //Initialize and send
      $req = auth()->user()->userSentRequests()->where('reciver_id' , '=' , $request->to)->get();
      if($req->count() == 0) return 'invalid';
      else{
        foreach($req as $r){
          $r->response = 'canceled';
          $r->update();
        }
      }
      return 'done';

    }

     public function accept(Request $request){
      $request->validate([
        'target' => 'required' , 
        
      ]);

     //Validate if the target exists;
     $target = User::find($request->target);
     if($target == null) return 'invalid'; 

     //Validate if they already friends 
     if(auth()->user()->isFriend($request->target)) return 'invalid';

     //Validate if has a friend request
     $fr = auth()->user()->hasFriendRequestObject($request->target);
     if(!$fr) return 'invalid';

     //pair as friends

     auth()->user()->pairAsFriend($target);

     //Connect the acceptance circles

     $target->createCirclesMembership($request->circles);

     //Create acceptance balloon

     $ballon = new Ballon();
     $ballon->friendRequestAccepted($request->target , $request->target);

     //update the request as accepted

     $fr->response = 'accepted' ;
     $fr->update();

     return 'done';
    }

    public function sendGroupRequest(Request $request){

              $newRequest = new User_request();
              $newRequest->initializeForGroups(
              auth()->user()->id,
              $request->reciver_id
              );
              return 'done';
    }

    public function getGroupWaitResponse(Request $request){
                 $res = User_request::where('sender_id','=',auth()->user()->id)->where('reciver_id','=',$request->group_id)->get();
                 return $res;
    }
    public function getGroupResponse(Request $request){
                 $res = User_request::where('parent_type','=','Group')->where('reciver_id','=',$request->group_id)->get();
                 return $res;
    }

}
 