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

	public function getCollectionChunk($collection, $chuncks, $index) {
		$arr = collect($collection)->chunk($chuncks)->toArray();
		return count($arr) <= $index ? [] : $arr[$index];
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

	public function isValidForKids($text) {
		$arr = [
			'fuck',
			'ass',
			'pussy',
			'asshole',
			'motherfucker',
			'shit',
			'fucking',
			'a**',
			'f**',
			'a******',
		];
		$text = explode(" ", strtolower($text));
		return !$this->isMatchedArrays($arr, $text);
	}

	public function isMatchedArrays($one, $two) {
		for ($c = 0; $c < count($one); $c++) {
			if (in_array($one[$c], $two)) {
				return true;
			}
		}
		return false;
	}
}
