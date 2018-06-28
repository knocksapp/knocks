<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\UserAddresses;
use App\Obj;

class UserAddressesController extends Controller
{
  public function updateUserAddressone(Request $request) {
    $user = UserAddresses::where('user_id' , '=' ,auth()->user()->id);
    if(!$user->exists()) return 'invalid';
    $user = $user->first();

    if($user->object_id == null)
    $user->object_id = $request->object_id;

    $user->address1 = $request->address1;
    $user->update();
    return 'done';

  }

  public function updateUserAddresstwo(Request $request) {
    $user = UserAddresses::where('user_id' , '=' ,auth()->user()->id);
    if(!$user->exists()) return 'invalid';
    $user = $user->first();

    if($user->object_id == null)
    $user->object_id = $request->object_id;

    $user->address2 = $request->address2;
    $user->update();
    return 'done';

  }

  public function deleteUserAddresstwo(Request $request) {
    $user = UserAddresses::where('user_id' , '=' ,auth()->user()->id);
    $user = $user->first();
    $user->address2 = null;
    $user->update();
    return 'done';
  }

  public function updateUserAddressthree(Request $request) {
    $user = UserAddresses::where('user_id' , '=' ,auth()->user()->id);
    if(!$user->exists()) return 'invalid';
    $user = $user->first();

    if($user->object_id == null)
    $user->object_id = $request->object_id;

    $user->address3 = $request->address3;
    $user->update();
    return 'done';

  }

  public function deleteUserAddressthree(Request $request) {
    $user = UserAddresses::where('user_id' , '=' ,auth()->user()->id);
    $user = $user->first();
    $user->address3 = null;
    $user->update();
    return 'done';
  }

  public function updateUserCity(Request $request) {
    $user = UserAddresses::where('user_id' , '=' ,auth()->user()->id);
    if(!$user->exists()) return 'invalid';
    $user = $user->first();

    if($user->object_id == null)
    $user->object_id = $request->object_id;

    $user->city = $request->city;
    $user->update();
    return 'done';

  }

  public function deleteUserCity(Request $request) {
    $user = UserAddresses::where('user_id' , '=' ,auth()->user()->id);
    $user = $user->first();
    $user->city = null;
    $user->update();
    return 'done';
  }

  // public function retriveUserAddresses(Request $request) {
  //   $userr = User::find($request->userr);
  //   if(!$userr) return 'invalid' ;
	// 	$users = UserAddresses::all();
	// 	$result = array();
	// 	foreach ($users as $user) {
	// 		array_push($result, array(
	// 			"address1" => $user->address1,
	// 			"address2" => $user->address2,
	// 			"address3" => $user->address3,
  //       "city" => $user->city,
  //       "state" => $user->state,
  //       "country" => $user->country,
  //       "postal_code" => $user->postal_code,
  //
  //       			));
	// 	}
	// 	return json_encode($result);
	// }

  public function retriveUserAddresses(Request $request){
    // $user = UserAddresses::where('user_id' , '=' ,auth()->user()->id);
    // if(!$user->exists()) return 'invalid';
    // $user = $user->first();
    $alls = UserAddresses::where('user_id','=',$request->user_id)->get();
    return $alls->first();
    // $array = [];
    // foreach($alls as $all){
    //  if(obj::find($all->object_id)->isAvailable(auth()->user()->id))
    //    array_push($array, $all);
    // }
    // return $array ;
  }
  


}
