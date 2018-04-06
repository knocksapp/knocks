<?php
//user Controller

namespace App\Http\Controllers;

use App\Comment;
use App\Envelope;
use App\Group;
use App\Group_member;
use App\Knock;
use App\obj;
use App\Reply;
use App\Saved_presets;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller {
	public function userCircles() {
		return auth()->user()->circles()->where('circle_name', '!=', '@all@')->get();
	}
	public function getAllUsers() {
		return User::all();
	}
	public function activeRequests() {
		$req = auth()->user()->userRecivedRequests()->where('response', '=', 'waiting')->get();
		if ($req->count() == 0) {
			return 'empty';
		}

		foreach ($req as $r) {
			$r['first_name'] = User::find($r->sender_id)->first_name;
			$r['last_name'] = User::find($r->sender_id)->last_name;
		}
		return $req;
	}

	public function userlogin(Request $request) {
		$user = User::where('email', '=', $request->q)
			->orwhere('username', '=', $request->q)
			->orwhere('phone', '=', $request->q)->get();
		if ($user->count() > 0) {
			$pass = $user->first()->password;
			if (Hash::check($request->pw, $pass)) {
				auth()->login($user->first());
				return 'done';
			} else {
				return 'failed';
			}

		} else {
			return 'failed';
		}

	}

	public function goHome(Request $request) {
		if (Auth::check()) {
			return view('user.home');
			//     if(auth()->user()->age() > 13)
			//   return view('guest.survey');
			// else return view('guest.candy_survey');
		} else {
			return view('guest.signup');
		}

	}

	//Authorised user's language
	public function authUsersLanguage() {
		if (auth()->check()) {
			return auth()->user()->userLanguage();
		}
		return 'en';
	}

	public function retrivePeopleKnocks(Request $request) {
		return auth()->user()->getPeopleKnocks(json_encode($request->limits));
	}

	public function retriveOlderPeopleKnocks(Request $request) {
		return auth()->user()->getPeopleKnocksRegularMin($request->min);
	}

	public function retriveNewerPeopleKnocks(Request $request) {
		return auth()->user()->getPeopleKnocksRegularMax($request->max);
	}

	public function retriveUserKnocks(Request $request) {
		$user = User::find($request->user);
		if ($user) {
			return $user->getUserKnocks(json_encode($request->limits));
		}

	}

	public function retriveOlderUserKnocks(Request $request) {
		$user = User::find($request->user);
		if ($user) {
			return $user->getUserKnocksRegularMin($request->min);
		}

	}

	public function getUserAllCircles(Request $request) {
		return auth()->user()->circles()->get();
	}

	public function retriveNewerUserKnocks(Request $request) {
		$user = User::find($request->user);
		if ($user) {
			return $user->getUserKnocksRegularMax($request->max);
		}

	}
	public function getDefaultPreset(Request $request) {
		$d = auth()->user()->defaultPreset();
		if ($d != null) {
			$star = Saved_presets::find($d);
			return array('outcome' => $d, 'name' => $star->name);
		}
		return array('outcome' => null, 'name' => null);
	}

	public function retriveUserGroups(Request $request) {
		$groups = Group_member::where('user_id', '=', auth()->user()->id)
			->join('groups', 'groups.id', '=', 'group_members.group_id')
			->where('groups.name', 'like', '%' . $request->q . '%')
			->get()->pluck('group_id');
		return $groups;
	}

	//Check if the user exists
	public function check(Request $request) {
		if ($request->q == null || empty($request->q) || !isset($request->q)) {
			return 'not_exist';
		}

		$user = User::where('username', '=', $request->q)->get();
		if ($user->count() == 0) {
			return 'not_exist';
		}

		return 'exist';
	}

	public function mailCheck(Request $request) {
		if ($request->q == null || empty($request->q) || !isset($request->q)) {
			return 'not_exist';
		}

		$user = User::where('email', '=', $request->q)->get();
		if ($user->count() == 0) {
			return 'not_exist';
		}

		return 'exist';
	}
	public function register(Request $request) {
		$user = new User();
		$user->initialaize(
			json_encode(array(
				'first_name' => $request->first_name,
				'last_name' => $request->last_name,
				'username' => $request->username,
				'gender' => $request->gender,
				'middle_name' => $request->middle_name,
				'nickname' => $request->nickname,
				'birthdate' => $request->birthdate,
				'email' => $request->email,
				'password' => $request->password,
				'language' => $request->language,

			))
		);
		return 'done';
	}
	public function initChat(Request $request) {
		return Envelope::where('sender_id', '=', auth()->user()->id)
			->orwhere('reciever_id', '=', auth()->user()->id)
			->orwhere('reciever_id', '=', $request->q)
			->orwhere('sender_id', '=', $request->q)->orderBy('id', 'DESC')->get()->chunk(7);
	}
	public function getInfo(Request $request) {
		$user = User::find($request->q);
		return $user != null ? $user->retriveForUser(auth()->user()->id) : 'invalid';
	}

	public function getInfoLazy(Request $request) {
		$user = User::find($request->q);
		return $user != null ? $user->retriveForUserLazy(auth()->user()->id) : 'invalid';
	}

	public function getUserCircles(Request $request) {
		return auth()->user()->circles()->get()->pluck('id');
	}

	public function retriveContact(Request $request) {
		$users = User::all();
		$result = array();
		foreach ($users as $user) {
			array_push($result, array(
				"name" => $user->first_name,
				"email" => $user->email,
				"phone" => $user->phone,
				"favorite" => true,
			));
		}
		return json_encode($result);
	}
	public function updateProfileIndex(Request $request) {
		$userIndex = json_decode(auth()->user()->profile_picture);
		$userIndex->index = $userIndex->index + 1;
		$userIndex->current = $userIndex->index;
		auth()->user()->profile_picture = json_encode($userIndex);
		auth()->user()->update();
		return 'done';
	}
	//SEEARCH FOR FRIENDS --stable

	public function searchForFriends(Request $request) {

		//Update typing
		if (isset($request->parent_type) && isset($request->parent_id)) {
			if ($request->parent_type == 'knock') {
				Knock::find($request->parent_id)->typing(auth()->user()->id);
			}
		}
		//Search for friends

		// $circle = auth()->user()->mainCircle();
		// $suggestions =  $circle->circleMembers()->join('users' , 'users.id' , '=' , 'circle_members.user_id')
		// ->where('users.first_name' , 'sounds like' , $request->q)
		// ->orwhere('users.last_name' , 'sounds like', $request->q)
		// ->orwhere('users.middle_name' , 'sounds like' , $request->q)
		// ->orwhere('users.nickname' , 'sounds like', $request->q)
		// ->orwhere('users.username' , 'sounds like' , $request->q)
		// ->pluck('users.id');
		$suggestions = auth()->user()->FriendsSoundsLikeID($request->q);

		$result = [];
		if (auth()->user()->isMatched($request->q)) {
			array_push($result, auth()->user()->id);
		}

		for ($i = 0; $i < count($suggestions); $i++) {
			$flag = true;
			for ($j = 0; $j < count($result); $j++) {
				if ($suggestions[$i] == $result[$j]) {
					$flag = false;
				}

			}
			if ($flag) {
				array_push($result, $suggestions[$i]);
			}

		}
		return $result;

	}
	public function mainSearch(Request $request) {
		$result = array();
		$result['users'] = auth()->user()->soundsLikeID($request->q);
		$result['reply'] = array();
		$result['comment'] = array();
		$result['knock'] = array();
		$result['groups'] = Group::where('name', 'like', '%' . $request->q . '%')->get()->pluck('id');

		// $obs = obj::
		// where('keywords' , 'like' , "%$request->q%  ")
		// ->get();

		//  $obs = collect(DB::select( DB::raw("SELECT id FROM objs
		//    WHERE keywords sounds like '$request->q'
		//    or keywords like '%$request->q%'
		//    "
		//  )
		// ));
		$objs = obj::where('type', '=', 'knock')
			->orwhere('type', '=', 'comment')
			->orwhere('type', '=', 'reply')
			->get();
		foreach ($objs as $ob) {

			if ($ob->isAvailable(auth()->user()->id)) {
				similar_text($ob->keywords, $request->q, $percent);

				if ($percent > 50 || strpos($ob->keywords, $request->q)) {
					if ($ob->type == 'knock') {
						$res = Knock::where('object_id', '=', $ob->id);
						if ($res->count() > 0) {
							array_push($result[$ob->type], $res->first()->id);
						}

					} elseif ($ob->type == 'comment') {
						$res = Comment::where('object_id', '=', $ob->id);
						if ($res->count() > 0) {
							array_push($result[$ob->type], $res->first()->id);
						}

					} elseif ($ob->type == 'reply') {
						$res = Reply::where('object_id', '=', $ob->id);
						if ($res->count() > 0) {
							array_push($result[$ob->type], $res->first()->id);
						}

					}
				}

			}

		}

		return $result;

	}

	public function friendsToChat(Request $request) {
		return auth()->user()->friendsToChat();
	}

	public function routeToProfile(Request $request, $user) {
		$user = User::where('username', '=', $user);
		if (!$user->exists()) {
			return view('guest.lost');
		}
		$c = $user->get()->first();
		return view('user.profile', ['user' => $c]);
	}

	public function updateUserfirstName(Request $request){
  $user = User::find(auth()->user()->id);
	$user->first_name = $request->first_name;
	$user->update();
return 'done';
}

public function updateUsermiddleName(Request $request){
$user = User::find(auth()->user()->id);
$user->middle_name = $request->middle_name;
$user->update();
return 'done';
}
public function updateUserlastName(Request $request){
$user = User::find(auth()->user()->id);
$user->last_name = $request->last_name;
$user->update();
return 'done';
}

public function updateUsernickName(Request $request){
$user = User::find(auth()->user()->id);
$user->nickname = $request->nickname;
$user->update();
return 'done';
}


public function updateUserbirthdate(Request $request){
$user = User::find(auth()->user()->id);
$user->birthdate = $request->birthdate;
$user->update();
return 'done';
}

public function updateUserorientation(Request $request){
	$user = User::find(auth()->user()->id);
	$user->orientation = $request->orientation;
	$user->update();
	return 'done';
}

public function updateUserreligon(Request $request){
	$user = User::find(auth()->user()->id);
	$user->religon = $request->religon;
	$user->update();
	return 'done';
}

public function updateUsermaritalstatus(Request $request){
	$user = User::find(auth()->user()->id);
	$user->marital_status = $request->marital_status;
	$user->update();
	return 'done';
}

public function updateUserbio(Request $request){
	$user = User::find(auth()->user()->id);
	$user->bio = $request->bio;
	$user->update();
	return 'done';
}

public function updateUserphone(Request $request){
	$user = User::find(auth()->user()->id);
	$user->phone = $request->phone;
	$user->update();
	return 'done';
}

public function updateUsergender(Request $request){
	$user = User::find(auth()->user()->id);
	$user->gender = $request->gender;
	$user->update();
	return 'done';
}

public function deleteUsermiddleName(Request $request){
	$user = User::find(auth()->user()->id);
	$user->middle_name = null;
	$user->update();
	return 'done';
}

public function deleteUsernickName(Request $request){
	$user = User::find(auth()->user()->id);
	$user->nickname = null;
	$user->update();
	return 'done';
}

public function deleteUserorientation(Request $request){
	$user = User::find(auth()->user()->id);
	$user->orientation = null;
	$user->update();
	return 'done';
}

public function deleteUserreligon(Request $request){
	$user = User::find(auth()->user()->id);
	$user->religon = null;
	$user->update();
	return 'done';
}

public function deleteUsermaritalstatus(Request $request){
	$user = User::find(auth()->user()->id);
	$user->marital_status = null;
	$user->update();
	return 'done';
}

public function deleteUserbio(Request $request){
	$user = User::find(auth()->user()->id);
	$user->bio = null;
	$user->update();
	return 'done';
}

public function deleteUserphone(Request $request){
	$user = User::find(auth()->user()->id);
	$user->phone = null;
	$user->update();
	return 'done';
}


}
