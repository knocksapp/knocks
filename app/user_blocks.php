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

  public function initialize($bloacked_user_id) {
    $this->bloacked_user_id = $bloacked_user_id
    $this->user_id = auth()->user()->id;
    $this->index = json_encode(array(
      "blocked_user_count" => 1,

    ));
    $this->save();
  }
  public function index() {
		return json_decode($this->index);
	}
  public function increaseBlockedUser() {
		$index = $this->index();

		$index->blocked_user_count++;
		$this->index = json_encode($index);
		$this->update();
	}
  public function decreaseBlockedUser() {
		$index = $this->index();

		$index->blocked_user_count--;
		$this->index = json_encode($index);
		$this->update();
	}

}
