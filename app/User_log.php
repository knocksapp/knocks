<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Agent\Agent;
class User_log extends Model
{
  public function autoLog($url , $ip , $method){
    if(auth()->check()){
      $this->addUserLog(auth()->user()->id , $url , $ip , $method);
    }else{
      $this->addAnanymousLog($url , $ip , $method );
    }
  }
  public function addUserLog($user , $url , $ip , $method ){
    $agent = new Agent();
  	$this->user_id = $user;
  		$this->index = json_encode(array(
  		'platform'=> $agent->platform() , 
      'platform_version' => $agent->version($agent->platform()) , 
  		'browser'=> $agent->browser() , 
      'browser_version' => $agent->version($agent->browser()) ,
  		'device'=> $agent->device() , 
  		'url' => $url ,
      'ip' => $ip,
      'method' => $method , 
  	));
  	$this->save();
  }
  public function addAnanymousLog($url , $ip , $method ){
  	$agent = new Agent();
  	$this->index = json_encode(array(
  		'platform'=> $agent->platform() , 
      'platform_version' => $agent->version($agent->platform()) , 
  		'browser'=> $agent->browser() , 
      'browser_version' => $agent->version($agent->browser()) ,
  		'device'=> $agent->device() , 
  		'url' => $url ,
      'ip' => $ip,
      'method' => $method , 
  	));
  	$this->save();
  }   
}
