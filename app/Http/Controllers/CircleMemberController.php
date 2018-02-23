<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\User_request;
use App\Circle_member;
use App\Circle;
class CircleMemberController extends Controller
{
    public function acceptGroup(Request $request){
      //validate the http
      $request->validate([
        'circles_confirm' => 'required' ,
        'req_id' => 'required' ,
      ]);
      //validate the request circles
      if(Circle::find($request->req_id))
      return 'invalid';
      else $knocks_request = User_request::find($request->req_id);

      if(!auth()->user()->hasRecievedRequest($request->req_id)){
        return 'invalid';
      }

      //return $knocks_request;

      $reqeust_circles = json_decode($knocks_request->circles);
      $sender = User::find($knocks_request->sender_id);


      //Validating Senders Circles

      foreach($reqeust_circles as $rc){
        if( ! $sender->hasCircleById($rc) )
        return 'invalid';
      }

      //Validating Confirm Circles

      $confirm_circles = json_decode($request->circles_confirm);

      foreach($confirm_circles as $rc){
        if( ! auth()->user()->hasCircleById($rc) )
        return 'invalid';
      }


      //push as a circle members for the specified and for @all@

      //Adding Circle members for the sender

      $member = new Circle_member();
      $member->initialize( $sender->id , $sender->getCircleId('@all@') );

      foreach($reqeust_circles as $rc){
         $member = new Circle_member();
         $member->initialize($sender->id, $rc);
      }

      //Adding Circle members for the reciever

       $member = new Circle_member();
      $member->initialize( auth()->user()->id , $sender->getCircleId('@all@') );

      foreach($confirm_circles as $rc){
         $member = new Circle_member();
         $member->initialize(auth()->user()->id, $rc);
      }

      $knocks_request->response = 'accepted';
      $knocks_request->update();

      return 'done';

    }
    public function groupPushMembers(Request $request){
               $members = Circle::find($request->circle_id)->circleMembers()->get()->pluck('user_id');

               return $members;
    }
}
