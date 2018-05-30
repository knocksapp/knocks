<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class user_blocks extends Model
{
  public function user(){
    return $this->belongsTo('App\User' , 'user_id');
  }

  public function blocked(){
    return $this->belongsTo('App\user_blocks' , 'user_id');
  }

  public function initialize($blocked_user_id) {
    $this->blocked_user_id = $blocked_user_id;
    $this->user_id = auth()->user()->id;

    $this->save();
  }
  public function index() {
		return json_decode($this->index);
	}

}
