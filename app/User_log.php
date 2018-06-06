<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Agent\Agent;

class User_log extends Model {

	public function autoLog($url, $ip, $method) {
		if ($method == 'GET') {
			if (auth()->check()) {
				$this->addUserLog(auth()->user()->id, $url, $ip, $method);
			} else {
				$this->addAnanymousLog($url, $ip, $method);
			}
		}
	}
	public function addUserLog($user, $url, $ip, $method) {
		$agent = new Agent();
		$this->user_id = $user;
		$this->index = json_encode(array());
		$this->os = $agent->platform();
		$this->os_version = $agent->version($agent->platform());
		$this->browser = $agent->browser();
		$this->browser_version = $agent->version($agent->browser());
		$this->device = $agent->device();
		$this->url = $url;
		$this->ip = $ip;
		$this->method = $method;
		$this->save();
	}
	public function addAnanymousLog($url, $ip, $method) {
		$agent = new Agent();
		$this->index = json_encode(array());
		$this->os = $agent->platform();
		$this->os_version = $agent->version($agent->platform());
		$this->browser = $agent->browser();
		$this->browser_version = $agent->version($agent->browser());
		$this->device = $agent->device();
		$this->url = $url;
		$this->ip = $ip;
		$this->method = $method;
		$this->save();
	}
}
