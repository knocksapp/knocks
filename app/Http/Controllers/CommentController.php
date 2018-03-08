<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\obj;
use App\Comment;
use App\Reply;

class CommentController extends Controller
{
    public function create(Request $request){
      if(!isset($request->submit_object) || $request->submit_object == null) return 'invalid';
      $comment = new Comment();
      $comment->initialize(json_encode($request->submit_object));
      return 'done';
    }
    public function retrive(Request $request){
    $request->validate([
      'comment'=>'required'
    ]);

    $comment = Comment::find($request->comment);
    if(obj::find($comment->object_id)->isAvailable(auth()->user()->id))
    //if($comment->user_id != auth()->user()->id)return 'invalid';
      return $comment;
      else return 'invalid';

  }
    public function getComments(Request $request){
      $request->validate([
        'knock' => 'required' ,
      ]);
      if($request->max == null){
        if(Knock::find($request->knock)->comments())
          return Knock::find($request->knock)->comments()->get()->pluck('id');
        else return array();
      }else{
        if(Knock::find($request->knock)->comments()->where('id' , '>' , $request->max))
          return Knock::find($request->knock)->comments()->where('id' , '>' , $request->max)->get()->pluck('id');
        else return array();
      }
    }


     public function getReplies(Request $request){
      $request->validate([
        'knock' => 'required' ,
      ]);
      if($request->max == null){
        if(Comment::find($request->knock)->commentReplies()){
          $array = array();
          $comments =  Comment::find($request->knock)->commentReplies()->get();
          if($comments->count() > 0)
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

}
