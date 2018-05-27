<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserBlocksController extends Controller
{
  public function blockUser(Request $request) {

    $user = UserBlocksController::where('user_id' , '=' ,auth()->user()->id);
      if(!$user->exists()) return 'invalid';
    $user->initialaize(

        auth()->user()->id => $request->user_id,
        'blocked_user_id' => $request->blocked_user_id,

    json_encode(array($request->index))
    );
    return 'done';
  }

  public function retriveBlockedUser(Request $request){
      $user = UserBlocksController::find($request->user);
     if(!$user) return 'invalid' ;
     $blocks = $user->user_blocks()->get();
     $array = [];
     foreach($blocks as $block){
        array_push($array, $block);
     }
     return $array ;
  }
  // public function retriveUserAddresses(Request $request){
  //
  //   $alls = UserAddresses::where('user_id','=',$request->user_id)->get();
  //   return $alls->first();
  //
  // }
}
