<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAddresses extends Model
{

    public function user(){
      return $this->belongsTo('App\User' , 'user_id');
    }
    public function object(){
      return $this->belongsTo('App\obj' , 'object_id');
    }

    public function initialize($address1,$address2,$address3,$city,$state,$country,$postal_code){
        $object = new obj();
        $object->initialize('user_addresses');
        $this->address1 = $address1;
        $this->address2 = $address2;
        $this->address3 = $address3;
        $this->city = $city;
        $this->state = $state;
        $this->country = $country;
        $this->postal_code = $postal_code;
        $this->object_id = $object->id;
        $this->user_id = auth()->user()->id;
        $this->save();
     }
}
