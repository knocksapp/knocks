<?php

namespace App;

use App\candy_blobs;
use App\User;
use App\Group_member;
use App\Group;
use Illuminate\Database\Eloquent\Model;

class Candy_session extends Model
{
    public function user()
    {
        return $this->belongsTo('App/User','kid_id');

    }
    public function parentUser()
    {
        return $this->belongsTo('App/User','parent_id');

    }
  public function object ()
    {
        return $this->belongsTo('App/obj','object_id');
    }

    // public function initializeR($kid_id, $object_id, $type, $type_id ) {
    //   $parents = candy_blobs::where('kid_id','=',auth()->user()->id)
    //   ->where('status','=','accepted')->get()->pluck('parent_id');
    //   foreach ($parents as $parent)
    //   {
    //   $s = new Candy_session();
    //   $s->parent_id = $parent;
    //   $s->object_id = $object_id;
    //   $s->kid_id = $kid_id;
    //   $s->log = json_encode(array(
    //     'type' => $type,
    //     'type_id' => $type_id,
    //   ));
    //   $s->save();
    // }
    // return 'done1';
    // }

    public function initialize($kid_id, $object_id, $type, $type_id,$commentid , $knockid) {
      $parents = candy_blobs::where('kid_id','=',$kid_id)
      ->where('status','=','accepted')->get()->pluck('parent_id');
      foreach ($parents as $parent)
      {
      $s = new Candy_session();
      $s->parent_id = $parent;
      $s->object_id = $object_id;
      $s->kid_id = $kid_id;
      $s->log = json_encode(array(
        'type' => $type,
        'type_id' => $type_id,
        'commentid' => $commentid,
        'knockid' => $knockid,

      ));
      $s->save();
    }
    return 'done1';
    }
}
