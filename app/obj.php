<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class obj extends Model
{
  public function user(){
    return $this->belongsTo('App\User' , 'user_id');
  }

  public function index(){ return $this->index != null ? json_decode($this->index) : false ; }

  //Object childs

  public function blobs(){
    return $this->hasOne('App\Blob' , 'object_id');
  }

  public function childBlobs(){
    return $this->hasOne('App\Blob' , 'parent_object');
  }

  public function knocks(){
    return $this->hasOne('App\Knock' , 'object_id');
  }

  public function comments(){
    return $this->hasOne('App\Comment' , 'object_id');
  }

  public function replies(){
    return $this->hasOne('App\Reply' , 'object_id');
  }

  public function reactions(){
    return $this->hasOne('App\Reaction' , 'object_id');
  }

  public function privacySetUsers(){
    return $this->hasOne('App\Privacy_set_user' , 'object_id');
  }

  public function privacySetCircles(){
    return $this->hasOne('App\Privacy_set_circle' , 'object_id');
  }

  public function educations(){
    return $this->hasOne('App\Education' , 'object_id');
  }

  public function highEducations(){
    return $this->hasOne('App\High_education' , 'object_id');
  }

  public function careers(){
    return $this->hasOne('App\Career' , 'object_id');
  }

  public function sports(){
    return $this->hasOne('App\Sport' , 'object_id');
  }

  public function hobbies(){
    return $this->hasOne('App\Hobby' , 'object_id');
  }

  public function publicFigures(){
    return $this->hasOne('App\Public_figure' , 'object_id');
  }

  public function userRequests(){
    return $this->hasOne('App\User_request' , 'object_id');
  }

  public function envelops(){
    return $this->hasOne('App\Envelope' , 'object_id');
  }

  public function candySessions(){
    return $this->hasOne('App\Candy_session' , 'object_id');
  }

  public function talentObjects(){
    return $this->hasOne('App\talent_object' , 'object_id');
  }

  public function ballons(){
    return $this->hasOne('App\Ballon' , 'object_id');
  }
  public function blobQoute(){

  }

  //Object methods

  public function initialize($type){
    $this->type = $type ;
    $this->has_media = 0;
    $this->user_id = auth()->user()->id;
    $this->index = json_encode(array("public_preset" => auth()->user()->publicPreset()));
    $this->save();
  }

  public function isAvailable ($requestMaker) {
    $maker = User::find($requestMaker);
    $owner = User::find($this->user_id);
    //Check if they are the same 
    if($owner->id == $requestMaker) return true ;
    //Check the users exceptions
    $exceptions = $this->privacySetUsers()->where('user_id' , '=' , $requestMaker);
    if($exceptions->exists()){
      return $exceptions->first()->preset_id == 'valid' ?  true : false ;
    }
    //Check if they are friends
    if($owner->isFriend($maker->id)){
      $circlesets = $this->privacySetCircles()->get();
      //invalid for all case
      $p3 = $circlesets->where('preset_id' , '=' , 3);
      foreach($p3 as $p)
        if(Circle::find($p->circle_id)->isMember($requestMaker)) return false;
      //valid case
      $p1 = $circlesets->where('preset_id' , '=' , 1);
      foreach($p1 as $p)
        if(Circle::find($p->circle_id)->isMember($requestMaker)) return true;
      //invalid case
      $p2 = $circlesets->where('preset_id' , '=' , 2);
      foreach($p2 as $p)
        if(Circle::find($p->circle_id)->isMember($requestMaker)) return false;
      return $this->index()->public_preset == 'valid' ? true : false ;
    }else{
      //Check the public preset if they are not friends
      return $this->index()->public_preset == 'valid' ? true : false ;
    }
 }

}
