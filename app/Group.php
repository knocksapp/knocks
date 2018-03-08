<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Knock;
use App\obj;

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

     public function getGroupKnocks($limits){

      $limits = json_decode($limits);
      if($limits->max == null && $limits->min == null){
           $knocks = array();
          $current =  Knock::where('type','=','group')->where('at','=',$this->id)->where('at' , '=' , $this->id)->get()->pluck('id');
        foreach($current as $c ) array_push($knocks, $c);

          if(count($knocks) == 0) return array ('knocks' => [] , 'last_index' => null);
          rsort($knocks);
          $collection = collect($knocks);
          return array ('knocks' => $collection->chunk(3)->toArray()[0] , 'last_index' => null);
      }elseif($limits->max != null ){
       $knocks = array();
          $current =  Knock::where('type','=','group')->where('id' , '>' , $limits->max)->where('at','=',$this->id)->get()->pluck('id');
        foreach($current as $c ) array_push($knocks, $c);
          if(count($knocks) < 3 && $limits->min){
            $current =  $this->knocks()->where(['type','=','group'],['id' , '<' , $limits->min])->get()->pluck('id');
           foreach($current as $c ) array_push($knocks, $c);

          }
          rsort($knocks);
          if(count($knocks) == 0) return array ('knocks' => [] , 'last_index' => null);
          $collection = collect($knocks);
          if($limits->last_index == null && count($collection)  == 0)
          return array ( 'knocks' => [] , 'last_index' => null);
          if($limits->last_index == null && count($collection) > 0)
          return array ( 'knocks' => $collection->chunk(3)->toArray()[0] , 'last_index' => 0 );
          elseif($limits->last_index == count($collection)->chunk(3) - 1){
            return array ( 'knocks' => [] , 'last_index' => count($collection)->chunk(3) - 1 );
          }else{
            return array( 'knocks' => $collection->chunk(3)->toArray()[$last_index] , 'last_index' => $last_index+1 );
          }
      }

    }

    public function getGroupKnocksRegular(){
          $knocks = array();
          $current =  Knock::where('type','=','group')->get()->pluck('id');
        foreach($current as $c ) array_push($knocks, $c);
          if(count($knocks) == 0) return array ('knocks' => [] , 'last_index' => null);
          rsort($knocks);
          $collection = collect($knocks);
          return array ('knocks' => $collection->chunk(3)->toArray()[0] , 'last_index' => null);
    }

    public function getGroupKnocksRegularMin($min){
        if($min == null) return array ('knocks' => array(), 'last_index' => null);

        $knocks = array();
        $current =  Knock::where('type','=','group')->where('at','=',$this->id)->where('id' , '<' , $min)->get()->pluck('id');

        foreach($current as $c ) array_push($knocks, $c);

          if(count($knocks) == 0) return array ('knocks' => [] , 'last_index' => null);
          rsort($knocks);
          $collection = collect($knocks);
          return array ('knocks' => $collection->chunk(3)->toArray()[0] , 'last_index' => null);
    }

    public function getGroupKnocksRegularMax($max){
        if($max == null) return $this->getGroupKnocksRegular();
          $current =  Knock::where('type','=','group')->where('at','=',$this->id)->where('id' , '>' , $max)->get()->pluck('id');
          $knocks = array();
        //$current =  $this->knocks()->get()->pluck('id');
        foreach($current as $c ) array_push($knocks, $c);

          if(count($knocks) == 0) return array ('knocks' => [] , 'last_index' => null);
          asort($knocks);
          $collection = collect($knocks);
          return array ('knocks' => $collection->chunk(3)->toArray()[0] , 'last_index' => null);
    }
}
