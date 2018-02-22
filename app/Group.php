<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
  public function groupMembers(){
    return $this->hasMany('App\Group_member' , 'group_id');
  }
    public function initialize($name ,$category, $thumbnail,$preset){
      $this->name = $name ;
      $this->category = $category;
      $this->thumbnail = $thumbnail;
      $this->preset = $preset;
      $this->save();
    }
}
