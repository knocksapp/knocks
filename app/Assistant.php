<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Assistant extends Model {
	public function objectKeys($object) {
		$arr = [];
		foreach ($object as $key => $value) {
			array_push($arr, $key);
		}
		return $arr;
	}

	public function objectRollback($object) {
		return json_decode(json_encode($object));
	}

	public function isSupportedBrowser() {
		$agent = new \Jenssegers\Agent\Agent();
		$browser = $agent->browser();
		$browser_version = $agent->version($agent->browser());
		$unsupportedBrowsers = [
			'IE',
		];
		$unsupportedBrowsersVersions = array(
			'IE' => 8,
		);
		if (in_array($browser, $unsupportedBrowsers)) {
			if ($browser_version <= $unsupportedBrowsersVersions[$browser]) {
				return false;
			}
		}
		return true;
	}
}
