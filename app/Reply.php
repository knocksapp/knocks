<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Object ;
use App\Knock;
use App\Comment ;


class Reply extends Model
{
  public function users() {
    return $this->belongsTo('App\User','user_id');
  }
  public function object() {
    return $this->belongsTo('App\obj','object_id');
  }
  public function knock() {
    return $this->belongsTo('App\Knock','post_id');
  }
  public function reply() {
    return $this->belongsTo('App\Reply','comment_id');
  }

  //Reply childs

  public function replies(){
    return $this->hasMany('App\Reply' , 'parent_id');
  }

  public function replyReplies(){
    return Reply::where('parent_type',  '=' , 'reply')->where('parent_id' , '=' , $this->id);
  }

  public function reactions(){
    return $this->hasMany('App\Reaction' , 'parent_id');
  }
     public function initialize($object){
      $parent_object = new obj();
      $parent_object->initialize('reply');
      $object = json_decode($object);
      $parent_object->keywords = $object->text;
      $parent_object->update();
      $this->body = $object->body ;
      $this->at = $object->at ;
      $this->text_content = $object->text;
      $this->type = $object->type ;
      $this->parent_type = $object->type ;
      $this->object_id = $parent_object->id;
      $this->parent_id = $object->post_id ;


      $images_reactions = array();
      $images_comments = array();
      if( isset($object->images_specifications) && count($object->images_specifications) > 0){
         for($i = 0 ; $i < count($object->images_specifications); $i++){
          Blob::find((int) $object->images_specifications[$i])->assignParent($parent_object->id);

        }
  
      }
      if($object->has_voices){
        $blob = Blob::find($object->voices_specifications);
        $blob->assignParent($parent_object->id);
      }

      if( isset($object->files_specifications) && count($object->files_specifications) > 0){
         for($i = 0 ; $i < count($object->files_specifications); $i++){
          Blob::find((int) $object->files_specifications[$i])->assignParent($parent_object->id);
        }

      }


      $this->index = json_encode(array(
        'typing' => array() ,
        'edited' => false ,
        'has_pictures' => $object->has_pictures,
        'images_specifications' => $object->images_specifications,
        'has_videos'=> $object->has_videos,
        'videos_specifications' => $object->videos_specifications,
        'has_voices'=> $object->has_voices,
        'voices_specifications' => $object->voices_specifications,
        'has_files'=> $object->has_files,
        'files_specifications' => $object->files_specifications,
        'seen' => array( auth()->user()->id  => substr(json_decode(json_encode(Carbon::now()))->date,0,19) ),
        'followers' => array(auth()->user()->id => true) ,
        'feelings' => $object->feelings,
        'check_in' => $object->check_in,
        'tags' => $object->tags,
        'images_reactions' => $images_reactions ,
        'images_comments' => $images_comments

      ));


      $user_ps_object = $object->user_privacy;
      foreach ($user_ps_object as $ob)
      {
        $user_privacy = new Privacy_set_user();
        $user_privacy->user_id = $ob->user_id ;
        $user_privacy->preset_id = $ob->preset_id ;
        $user_privacy->object_id = $parent_object->id ;
        $user_privacy->save();
      }

      $circle_ps_object = $object->circle_privacy;
      foreach ($circle_ps_object as $ob)
      {
        $circle_privacy = new Privacy_set_circle();
        $circle_privacy->circle_id = $ob->circle_id ;
        $circle_privacy->preset_id = $ob->preset_id ;
        $circle_privacy->object_id = $parent_object->id ;
        $circle_privacy->save();
      }


      $this->user_id = auth()->user()->id;
      $this->save();
    }
}
