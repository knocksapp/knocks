<?php

namespace App\Http\Controllers;
use App\UserAddress;
use Illuminate\Http\Request;

class UserAddressController extends Controller {
	//
	public function getStates(Request $request) {
		$request->validate(['country' => 'required']);
		$states = UserAddress::where('country', '=', $request->country)
			->where('state', '!=', null)->get()
			->groupBy('state');
		$arr = [];
		foreach ($states as $key => $value) {
			array_push($arr, $key);
		}
		return $arr;
	}

	public function getRegions(Request $request) {
		$request->validate(['country' => 'required', 'state' => 'required']);
		$regions = UserAddress::where('country', '=', $request->country)
			->where('region', '!=', null)
			->where('state', '!=', null)
			->where('state', '=', $request->state)->get()->groupBy('region');

		$arr = [];
		foreach ($regions as $key => $value) {
			array_push($arr, $key);
		}
		return $arr;
	}

	public function create(Request $request) {
		$request->validate(['object' => 'required']);
		$temp = json_decode(json_encode($request->object));
		$prev = UserAddress::where('user_id', '=', auth()->user()->id)
			->where('region', '=', $temp->region)
			->where('country', '=', $temp->country)
			->where('state', '=', $temp->state);
		if ($prev->exists()) {
			return 'invalid';
		}
		$address = new UserAddress();
		$address->init(json_encode($request->object));
		return $address->id;
	}

	public function deleteAddresses(Request $request) {
		UserAddress::where('id', '=', $request->addresses_id)->delete();
		return 'done';
	}

}
