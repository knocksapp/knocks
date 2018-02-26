<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Knock;
use App\obj;
use App\Comment;
use Carbon\Carbon;
use App\User;

class KnockController extends Controller
{
    public function create(Request $request){
    	$knock = new Knock();

    	$knock->initialize(json_encode($request->submit_object));
    	return 'done';
    }
    public function retrive(Request $request){

      $request->validate([
        'knock' =>'required'
      ]);

      $knock = Knock::find($request->knock);
      $reqObject = obj::find($knock->object_id);
      if($reqObject->isAvailable(auth()->user()->id)){
        if($reqObject->user_id == auth()->user()->id){
          $resultObject = $knock;
          $resultObject['sdate'] = new Carbon();
          //$resultObject['comments'] = $knock->comments()->pluck('id');
          $exeptions = $reqObject->privacySetUsers();
          if($exeptions->count() == 0) $exeptions = false; else $exeptions = true;

          $resultObject['exceptions'] = $exeptions;

          return $resultObject;
        }
        else {
          $resultObject = $knock;
          $resultObject['sdate'] = new Carbon();
          //$resultObject['comments'] = $knock->comments()->pluck('id');
          $resultObject['exceptions'] = false;
          return $resultObject;
        }
   }else{
        return 'invalid';
      }

    }

    public function retriveOlder(Request $request){

      $request->validate([
        'knock' =>'required'
      ]);

      $knock = Knock::find($request->knock);
      $reqObject = obj::find($knock->object_id);
      if($reqObject->isAvailable(auth()->user()->id)){
        if($reqObject->user_id == auth()->user()->id){
          $resultObject = $knock;

          //$resultObject['comments'] = $knock->comments()->pluck('id');
          $exeptions = $reqObject->privacySetUsers();
          if($exeptions->count() == 0) $exeptions = false; else $exeptions = true;

          $resultObject['exceptions'] = $exeptions;

          return $resultObject;
        }
        else {
          $resultObject = $knock;
          $resultObject['seens'] = $knock->hasSeen(auth()->user()->id);
          //$resultObject['comments'] = $knock->comments()->pluck('id');
          $resultObject['exceptions'] = false;

          return $resultObject;
        }
   }else{
        return 'invalid';
      }

    }

    public function getComments(Request $request){
      $request->validate([
        'knock' => 'required' ,
      ]);
      if($request->max == null){
        if(Knock::find($request->knock)->comments()){
          $array = array();
          $comments =  Knock::find($request->knock)->comments()->get();
          foreach($comments as $comment){
            $object = obj::find($comment->object_id);
            if($object->isAvailable(auth()->user()->id)) array_push($array, $comment->id);
          }
          return $array;
        }
        else return array();
      }else{
        if(Knock::find($request->knock)->comments()->where('id' , '>' , $request->max))
          return Knock::find($request->knock)->comments()->where('id' , '>' , $request->max)->get()->pluck('id');
        else return array();
      }
    }

    public function tickSeen(Request $request){
      $request->validate([
        'knock' => 'required' ,
      ]);
      $knock = Knock::find($request->knock)->watchSeen(auth()->user()->id);
      return $knock ? 'done' : 'failed';


    }

    public function viewKnock(Request $request , $knock){
      $k = Knock::find($knock);
      if($knock)
         return view('user.knock', ['knock' => $k]);
    }

    public function knockMasterData(Request $request){
      $k = Knock::find($request->id);
      if($k){
        return array(
          'id' => $k->id , 
          'user' => $k->user_id , 
        );
      }
    }

    public function viewComment(Request $request,  $comment ){
      $c = Comment::find($comment);
      if($c){
        $k = Knock::find($c->post_id);
      }else{
        return 'invalid';
      }
      if($k && $c && $k->comments()->where('id' , '=' , $c->id)->exists())
         return view('user.comment',
          ['knock' => $k ,
           'comment' => $c ,
            'owner' => User::find($k->user_id) , 'commenter' => User::find($c->user_id)]);
    }

    public function viewKnockWithComment(Request $request, $knock , $comment ){
      $k = Knock::find($knock);
      $c = Comment::find($comment);
      if($k && $c && $k->comments()->where('id' , '=' , $c->id)->exists())
         return view('user.comment',
          ['knock' => $k ,
           'comment' => $c ,
            'owner' => User::find($k->user_id) , 'commenter' => User::find($c->user_id)]);
    }

}
