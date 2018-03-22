<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User_request extends Model
{
  public function sender(){
    return $this->belongsTo('App\User' , 'sender_id');
  }
  public function reciever(){
    return $this->belongsTo('App\User' , 'reciver_id');
  }


public function initialize($sender_id , $receiver_id)
{
   $this->reciver_id = $receiver_id;
    $this->circles = json_encode(array());
    $this->sender_id = $sender_id;
    $this->response = 'waiting';
    $this->save();
}

public function initializeForGroups($sender_id , $receiver_id)
{
    $this->reciver_id = $receiver_id;
    $this->sender_id = $sender_id;
    $this->response = 'waiting';
    $this->parent_type = 'Group';
    $this->save();
}

}
