<?php
//user Controller

namespace App\Http\Controllers;

use App\Comment;
use App\Envelope;
use App\Group;
use App\Group_member;
use App\Knock;
use App\Mail\AccountBlocked;
use App\Mail\VerifyAccount;
use App\obj;
use App\Reply;
use App\Saved_presets;
use App\User;
use App\User_log;
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
			$c = $user->first();
			if ($c->api_token_attemps >= 3 && $c->api_token_type == 'blocked') {
				return 'blocked';
			}
			$pass = $c->password;
			if (Hash::check($request->pw, $pass)) {
				auth()->login($user->first());
				$log = new User_log();
				$log->addUserLog(auth()->user()->id, 'Login', $request->ip(), $request->method());
				auth()->user()->api_token_attemps = 0;
				auth()->user()->api_token = null;
				auth()->user()->api_token_type = null;
				auth()->user()->update();
				return 'done';
			} else {
				$c->api_token_attemps += 1;
				if ($c->api_token_attemps == 3) {
					$c->api_token_type = 'blocked';
					$c->temp_password = $c->generateRandomString(rand(15, 25));
					$c->api_token = csrf_token();
					$c->api_token_date = now();
					$c->api_token_access_attemps = 0;
				}
				$c->update();
				\Mail::to($c)->send(new AccountBlocked($c));
				return $c->api_token_attemps < 3 ? 'fail' : 'blocked';
			}

		} else {
			return 'failed';
		}

	}

	public function goHome(Request $request) {
		$log = new User_log();
		$log->autoLog($request->url(), $request->ip(), $request->method());
		if (Auth::check()) {
			if (auth()->user()->verified) {
				return view('user.home');
			}

			return view('user.verify');
			//     if(auth()->user()->age() > 13)
			//   return view('guest.survey');
			// else return view('guest.candy_survey');
		} else {
			return view('guest.signup');
		}

	}

	public function offerVerify(Request $request) {
		if (auth()->check()) {
			if (auth()->user()->verified) {
				return redirect()->action('UserController@goHome');
			} else {
				auth()->user()->api_token = null;
				auth()->user()->api_token_date = null;
				auth()->user()->update();
				return view('user.verify');
			}
		} else {
			return redirect()->action('UserController@goHome');
		}

	}

	public function offerVerifyExpired(Request $request) {
		if (auth()->check()) {
			if (auth()->user()->verified) {
				return redirect()->action('UserController@goHome');
			} else {
				auth()->user()->api_token = null;
				auth()->user()->api_token_date = null;
				auth()->user()->update();
				return view('user.verifyexpired');
			}
		} else {
			return redirect()->action('UserController@goHome');
		}

	}

	public function requestVerify(Request $request) {
		if (auth()->check()) {
			if (auth()->user()->verified) {
				return 'verified';
			}
			auth()->user()->api_token = csrf_token();
			auth()->user()->api_token_date = now();
			auth()->user()->update();
			\Mail::to(auth()->user())->send(new VerifyAccount(auth()->user()));
			return 'done';

		} else {
			return 'unauth';
		}

	}

	public function attempVerify(Request $request, $token) {
		if (auth()->check()) {
			if (auth()->user()->verified) {
				return redirect()->action('UserController@goHome');
			}
			if ($token == auth()->user()->api_token) {
				auth()->user()->api_token = null;
				auth()->user()->api_token_date = null;
				auth()->user()->verified = 1;
				auth()->user()->update();
				return redirect()->action('UserController@goHome');
			}

			return redirect()->action('UserController@offerVerifyExpired');

		} else {
			return redirect()->action('UserController@goHome');
		}

	}

	public function attempUnblock(Request $request, $user, $token) {
		if (!auth()->check()) {
			$tuser = User::find($user);
			if ($tuser == null) {
				return redirect()->action('UserController@lost');
			}
			if ($tuser->api_token_type != 'blocked' || $tuser->api_token_attemps != 3) {
				return redirect()->action('UserController@goHome');
			}

			if ($token == $tuser->api_token) {
				$tuser->api_token = null;
				$tuser->api_token_date = null;
				$tuser->api_token_type = null;
				$tuser->api_token_attemps = null;
				$tuser->update();
				return redirect()->action('UserController@goHome');
			}

			return redirect()->action('UserController@goHome');

		} else {
			return redirect()->action('UserController@goHome');
		}

	}

	public function attempUnblockTempPassword(Request $request, $user, $token) {
		if (!auth()->check()) {
			$tuser = User::find($user);
			if ($tuser == null) {
				return redirect()->action('UserController@lost');
			}
			if ($tuser->api_token_type != 'blocked' || $tuser->api_token_attemps != 3) {
				return redirect()->action('UserController@goHome');
			}

			if ($token == $tuser->api_token) {
				$tuser->api_token = null;
				$tuser->api_token_date = null;
				$tuser->api_token_type = null;
				$tuser->api_token_attemps = null;
				$tuser->password = bcrypt($tuser->temp_password);
				$tuser->temp_password = null;
				$tuser->update();
				return redirect()->action('UserController@goHome');
			}

			return redirect()->action('UserController@goHome');

		} else {
			return redirect()->action('UserController@goHome');
		}

	}

	public function lost() {
		return view('guest.lost');
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

	public function getSuggestions(Request $request) {
		return auth()->user()->getSuggestionsAvoid($request->c);
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

	public function searchForUsersByNames(Request $request) {
		$q = $request->q;
		if (strlen($q) == 0) {
			return [];
		}
		$names = [];
		$users = User::where('first_name', 'like', '%' . $q . '%')
			->orwhere('last_name', 'like', '%' . $q . '%')
			->orwhere('middle_name', 'like', '%' . $q . '%')
			->orwhere('nickname', 'like', '%' . $q . '%')->get();
		foreach ($users as $user) {
			if (auth()->check()) {
				if (auth()->user()->hasNoBlocks($user->id)) {
					array_push($names, $user->fullName());
				}

			} else {
				array_push($names, $user->fullName());
			}
		}
		return $names;
	}
	public function globalUserSearch(Request $request) {
		$user = new User();
		$users = $user->soundsLikeID($request->q);
		$temp = [];
		for ($i = 0; $i < count($users); $i++) {
			if (auth()->user()->hasNoBlocks($users[$i])) {
				array_push($temp, $users[$i]);
			}
		}
		return $temp;
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
		if (auth()->check() && !$user->first()->hasNoBlocks(auth()->user()->id)) {
			return view('guest.lost');
		}
		$c = $user->get()->first();
		return view('user.profile', ['user' => $c]);
	}
	public function routeToProfileById(Request $request, $user) {
		$user = User::find($user);
		if ($user == null) {
			return view('guest.lost');
		}
		if (auth()->check() && !$user->hasNoBlocks(auth()->user()->id)) {
			return view('guest.lost');
		}
		$c = $user;
		return view('user.profile', ['user' => $c]);
	}

	public function updateUserfirstName(Request $request) {
		$user = User::find(auth()->user()->id);
		$user->first_name = $request->first_name;
		$user->update();
		return 'done';
	}

	public function updateUsermiddleName(Request $request) {
		$user = User::find(auth()->user()->id);
		$user->middle_name = $request->middle_name;
		$user->update();
		return 'done';
	}
	public function updateUserlastName(Request $request) {
		$user = User::find(auth()->user()->id);
		$user->last_name = $request->last_name;
		$user->update();
		return 'done';
	}

	public function updateUsernickName(Request $request) {
		$user = User::find(auth()->user()->id);
		$user->nickname = $request->nickname;
		$user->update();
		return 'done';
	}

	public function updateUserbirthdate(Request $request) {
		$user = User::find(auth()->user()->id);
		$user->birthdate = $request->birthdate;
		$user->update();
		return 'done';
	}

	public function updateUserorientation(Request $request) {
		$user = User::find(auth()->user()->id);
		$user->orientation = $request->orientation;
		$user->update();
		return 'done';
	}

	public function updateUserreligon(Request $request) {
		$user = User::find(auth()->user()->id);
		$user->religon = $request->religon;
		$user->update();
		return 'done';
	}

	public function updateUsermaritalstatus(Request $request) {
		$user = User::find(auth()->user()->id);
		$user->marital_status = $request->marital_status;
		$user->update();
		return 'done';
	}

	public function updateUserbio(Request $request) {
		$user = User::find(auth()->user()->id);
		$user->bio = $request->bio;
		$user->update();
		return 'done';
	}

	public function updateUserphone(Request $request) {
		$user = User::find(auth()->user()->id);
		$user->phone = $request->phone;
		$user->update();
		return 'done';
	}

	public function updateUsergender(Request $request) {
		$user = User::find(auth()->user()->id);
		$user->gender = $request->gender;
		$user->update();
		return 'done';
	}

	public function deleteUsermiddleName(Request $request) {
		$user = User::find(auth()->user()->id);
		$user->middle_name = null;
		$user->update();
		return 'done';
	}

	public function deleteUsernickName(Request $request) {
		$user = User::find(auth()->user()->id);
		$user->nickname = null;
		$user->update();
		return 'done';
	}

	public function deleteUserorientation(Request $request) {
		$user = User::find(auth()->user()->id);
		$user->orientation = null;
		$user->update();
		return 'done';
	}

	public function deleteUserreligon(Request $request) {
		$user = User::find(auth()->user()->id);
		$user->religon = null;
		$user->update();
		return 'done';
	}

	public function deleteUsermaritalstatus(Request $request) {
		$user = User::find(auth()->user()->id);
		$user->marital_status = null;
		$user->update();
		return 'done';
	}

	public function deleteUserbio(Request $request) {
		$user = User::find(auth()->user()->id);
		$user->bio = null;
		$user->update();
		return 'done';
	}

	public function deleteUserphone(Request $request) {
		$user = User::find(auth()->user()->id);
		$user->phone = null;
		$user->update();
		return 'done';
	}

	public function hasAddresses(Request $request) {
		return array('has_address' => auth()->user()->addresses()->exists());
	}
	public function updateSettings(Request $request) {
		$users = User::all();
		foreach ($users as $user) {
			$cog = json_decode($user->configuration);
			$privacyUserSet = $cog->privacy_user_set;
			$privacyCircleSet = $cog->privacy_circle_set;
			$circle = $user->mainCircle();
			$privacyCircleSet->phone = array(["circle" => $circle->id, "preset" => "valid"], ["circle" => -1, "preset" => "valid"]);

			$privacyUserSet->phone = array();

			$cog->privacy_user_set = $privacyUserSet;
			$cog->privacy_circle_set = $privacyCircleSet;
			$user->configuration = json_encode($cog);
			$user->update();

		}
		return 'done';
	}

	public function updateName(Request $req) {
		$req->validate(['first_name' => 'required', 'last_name' => 'required']);
		auth()->user()->first_name = $req->first_name;
		auth()->user()->last_name = $req->last_name;
		auth()->user()->middle_name = $req->middle_name;
		auth()->user()->nickname = $req->nickname;
		auth()->user()->full_name = auth()->user()->fullName();
		auth()->user()->update();
		return 'done';
	}

	public function updatePassword(Request $req) {
		$req->validate(['password' => 'required']);
		auth()->user()->password = bcrypt($req->password);
		auth()->user()->update();
		return 'done';
	}

	public function updateDisplayName(Request $req) {
		$req->validate(['display_name' => 'required']);
		$cog = auth()->user()->cog();
		$cog->display_name = $req->display_name;
		auth()->user()->configuration = json_encode($cog);
		auth()->user()->update();
		return 'done';
	}

	public function updatePrivacy(Request $req) {
		$req->validate(['key' => 'required', 'circle_privacy' => 'required']);
		$cog = auth()->user()->cog();

		$pcs = $cog->privacy_circle_set;
		$pus = $cog->privacy_user_set;
		$key = $req->key;
		$pcs->$key = $req->circle_privacy;
		$pus->$key = $req->user_privacy;

		$cog->privacy_circle_set = $pcs;
		$cog->privacy_user_set = $pus;

		auth()->user()->configuration = json_encode($cog);
		auth()->user()->update();
		return 'done';
	}

	public function deleteAttr(Request $req) {
		$req->validate(['key' => 'required']);
		$key = $req->key;
		auth()->user()->$key = null;
		auth()->user()->update();
		return 'done';
	}

	public function updateAttr(Request $req) {
		$req->validate(['key' => 'required']);
		$key = $req->key;
		auth()->user()->$key = $req->value;
		auth()->user()->update();
		return 'done';
	}

	public function getDeviceInfo(Request $request) {
		$request->validate(['device' => 'required']);
		return auth()->user()->deviceInfo($request->device);
	}

	public function getUserDevices(Request $request) {
		return auth()->user()->devices();
	}

	//Blocked Accounts and forgoted passwords

	public function guiedBlockedAccount(Request $request) {

	}

	public function forgotMyPasswordAsk(Request $request) {
		if (auth()->check()) {
			return 'auth';
		}

		$request->validate(['email' => 'required']);
		$user = User::where('email', '=', $request->email)->get();
		if (!$user->exists()) {
			return 'not_exist';
		} else {
			$user = $user->first();
			if ($user->isBlockedAccount()) {
				return 'blocked';
			} else {

			}
		}
	}

}
