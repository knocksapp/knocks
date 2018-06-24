<?php

namespace App;
use App\User;
use Illuminate\Database\Eloquent\Model;

class candy_blobs extends Model
{
    //
    public function sender() {
  		return $this->belongsTo('App\User', 'req_id');
  	}
  	public function reciever() {
      if('req_id' == 'parent_id')
  		return $this->belongsTo('App\User', 'kid_id');
      else {
        return $this->belongsTo('App\User', 'parent_id');
      }
  	}
  
    public function initialize($parent_id, $kid_id , $req_id) {
  		$this->parent_id = $parent_id;
  		$this->kid_id = $kid_id;
      $this->req_id = $req_id;
  		$this->status = 'waiting';
  		$this->save();
  	}
}
