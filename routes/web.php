<?php
//use App\Object;
//Web
//
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */
//Actual Views
//Home Page
//asdasdsa/
Route::post('contacts', 'UserController@retriveContact');

//DEVELOPERS ROUTES STARTS /////////////////////////////////////////////////////////////
//Language APIS
Route::get('/dev', function () {
	return view('test.home');
});

Route::get('/search', function () {
	return view('test.searchpage', compact('q'));
});

Route::get('help/privacy/preset', function () {
	return view('help.privacyhelp');
});

Route::get('help/circle', function () {
	return view('help.circlehelp');
});

Route::get('help/recorder', function () {
	return view('help.recorderhelp');
});

Route::get('help/voicecommand', function () {
	return view('help.voicecommandhelp');
});

Route::post('object/hide', 'ObjController@hide');

Route::post('dev/all_langs', 'LanguageController@collect');
Route::post('dev/all_msgs', 'StaticMessageController@collect');
Route::post('dev/new_word', 'StaticMessageController@addNewWord');
Route::post('dev/translate', 'StaticMessageController@boundTranslation');
Route::post('dev/translate/force', 'StaticMessageController@forceTranslation');
Route::post('dev/delete/allmems', 'DevController@removeAllFriends');

//Resetting the app
Route::post('dev/trunc/knocks', 'DevController@resetKnocks');
Route::post('dev/trunc/users', 'DevController@resetKnocks');
Route::post('dev/db/reinstall', 'DevController@reinstall');
Route::post('dev/db/chck/members', 'DevController@watchMembershipDublications');

//Add Random Users
Route::post('dev/db/add/users', 'DevController@addUsersPatch');
Route::post('dev/db/entry/users', 'DevController@addRandomEntry');
Route::post('dev/db/add/groups', 'DevController@createRandomGroups');
Route::post('dev/db/add/circles', 'DevController@createRandomCircles');
Route::post('dev/db/add/knocks', 'DevController@createRandomKnocks');
Route::post('dev/db/add/comment', 'DevController@createRandomSocial');
Route::post('dev/db/add/reaction', 'DevController@createRandomReactions');

Route::post('dev/test', function () {return 'done';});

//DEVELOPERS ROUTES ENDS /////////////////////////////////////////////////////////////

//Presets
Route::post('user/preset/check', 'SavedPresetsController@check');

Route::post('user/preset/save', 'SavedPresetsController@save');

Route::post('user/preset/delete', 'SavedPresetsController@delete');

Route::post('user/preset/fav', 'SavedPresetsController@setAsDefault');

Route::post('user/preset/get', 'SavedPresetsController@get');

Route::post('user/preset/default', 'UserController@getDefaultPreset');

//Check if the user exists
Route::post('user/check', 'UserController@check');

Route::post('email/check', 'UserController@mailCheck');

Route::post('registeration', 'UserController@register');

Route::post('get_notification', 'BallonController@getUserNotification');

Route::post('ballons/batch', 'BallonController@getAllUserNotification');

Route::post('ballons/fr/batch', 'BallonController@getAllUserNotificationFr');

Route::post('update_notifications', 'BallonController@setToPoped');

Route::post('ballon/seen', 'BallonController@setToSeen');

Route::post('user/info', 'UserController@getInfo');

Route::post('user/info/lazy', 'UserController@getInfoLazy');

Route::post('user/update/name', 'UserController@updateName');

Route::post('user/update/displayname', 'UserController@updateDisplayName');

Route::post('user/posts', 'UserController@retrivePeopleKnocks');

Route::post('user/posts/older', 'UserController@retriveOlderPeopleKnocks');

Route::post('user/posts/newer', 'UserController@retriveNewerPeopleKnocks');

Route::post('user/profile/posts', 'UserController@retriveUserKnocks');

Route::post('user/profile/posts/older', 'UserController@retriveOlderUserKnocks');

Route::post('user/profile/posts/newer', 'UserController@retriveNewerUserKnocks');

Route::post('group/posts', 'GroupController@retriveGroupKnocks');

Route::post('group/posts/older', 'GroupController@retriveOlderGroupKnocks');

Route::post('group/posts/newer', 'GroupController@retriveNewerGroupKnocks');

Route::post('user/search', 'UserController@searchForFriends');

Route::post('user/search/global', 'UserController@globalUserSearch');

Route::post('userlogin', 'UserController@userlogin');

Route::post('retrive_circle', 'CircleController@retrive');

Route::post('get_circles', 'UserController@getUserCircles');

Route::post('user/device/info', 'UserController@getDeviceInfo');

Route::post('user/devices/get', 'UserController@getUserDevices');

Route::post('circle/search', 'CircleController@search');

Route::post('circle/check', 'CircleController@check');

Route::post('circle/delete', 'CircleController@deleteCircle');

Route::post('/create_group', 'GroupController@createGroup');

Route::post('/get_group_members', 'GroupMemberController@getGroupMembers');

Route::post('/check_member_position', 'GroupMemberController@checkOwner');

Route::post('/check_member_position_admin', 'GroupMemberController@checkAdmin');

Route::post('get_group_request', 'UserRequestController@getGroupWaitResponse');

Route::post('check_group_user_request', 'UserRequestController@checkGroupResponse');

Route::post('send_group_request', 'UserRequestController@sendGroupRequest');

Route::post('/decline_request_group', 'UserRequestController@declineRequestForGroup');

Route::post('/remove_member', 'GroupMemberController@removeMember');

Route::post('/delete_group', 'GroupController@deleteGroup');

Route::post('/get_group_pictures', 'GroupController@getPictures');

Route::post('/get_group_files', 'GroupController@getFiles');

Route::post('/get_group_voices', 'GroupController@getVoices');

Route::post('/get_group_videos', 'GroupController@getVideos');

Route::post('get_circle_members', 'CircleMemberController@groupPushMembers');

Route::post('get_all_circles', 'UserController@getUserAllCircles');

Route::post('get_user_groups', 'UserController@retriveUserGroups');

Route::post('get_group_name', 'GroupController@getGroups');

Route::post('get_groupname', 'GroupController@getGroupName');

Route::post('get_group_for_join', 'GroupController@retriveGroupForJoin');

//Career

Route::post('career', 'CareerController@createCareer');

Route::post('career/get', 'CareerController@retriveCareer');

Route::post('career/update', 'CareerController@updateCareer');

Route::post('career/delete', 'CareerController@deleteCareer');

//Education

Route::post('education', 'EducationController@createEducation');

Route::post('education/get', 'EducationController@retriveEducation');

Route::post('education/update', 'EducationController@updateEducation');

Route::post('education/delete', 'EducationController@deleteEducation');

//High Education

Route::post('high_education', 'HighEducationController@createHighEducation');

Route::post('high_education/get', 'HighEducationController@retriveHighEducation');

Route::post('high_education/update', 'HighEducationController@updateHighEducation');

Route::post('high_education/delete', 'HighEducationController@deleteHighEducation');

//Hobby

Route::post('hobby', 'HobbyController@createHobby');

Route::post('hobby/get', 'HobbyController@retriveHobby');

Route::post('hobby/update', 'HobbyController@updateHobby');

Route::post('hobby/delete', 'HobbyController@deleteHobby');

Route::post('hobby/all', 'HobbyController@hobbies');

//Sport

Route::post('sport', 'SportController@createSport');

Route::post('sport/get', 'SportController@retriveSport');

Route::post('sport/update', 'SportController@updateSport');

Route::post('sport/delete', 'SportController@deleteSport');

Route::post('sport/all', 'SportController@sports');

Route::post('check_user_ingroup', 'GroupMemberController@checkUserInGroup');

Route::post('join_public_group', 'GroupController@joinPublicGroup');

Route::post('add_member_public_group', 'GroupController@addMemberPublicGroup');

Route::post('get_group_members_positions', 'GroupMemberController@getMembersPosition');

Route::post('set_member_admin', 'GroupMemberController@setMembersToAdmin');

Route::post('set_admin_member', 'GroupMemberController@setAdminToMember');

Route::post('set_to_owner', 'GroupMemberController@setToOwner');

Route::post('post/create', 'KnockController@create');

Route::get('usersupdatesettings', 'UserController@updateSettings');

Route::post('post/seen', 'KnockController@tickSeen');

Route::post('post/comments', 'KnockController@getComments');

Route::post('comment/create', 'CommentController@create');

Route::post('comment/replies', 'CommentController@getReplies');

Route::post('reply/replies', 'ReplyController@getReplies');

Route::post('blob/qoute', 'BlobController@quote');

Route::post('reply/create', 'ReplyController@create');

//Addresses

Route::post('address/state/get', 'UserAddressController@getStates');

Route::post('address/region/get', 'UserAddressController@getRegions');

Route::post('address/create', 'UserAddressController@create');

Route::post('address/delete', 'UserAddressController@deleteAddresses');

//MultiMedia
Route::post('blob/record', 'BlobController@createRecord');

Route::post('media/record/meta', 'BlobController@retriveRecordMeta');

Route::post('media/file/meta', 'BlobController@retriveFileMeta');

Route::post('media/image/upload', 'BlobController@uploadImage');

Route::post('media/file/upload', 'BlobController@uploadFile');

Route::post('media/avatar/upload', 'BlobController@uploadAvatar');

Route::post('get_group_user_request', 'UserRequestController@getGroupResponse');

Route::post('group_edit_info', 'GroupController@updateGroupInfo');

Route::post('group_edit_preset', 'GroupController@updateGroupPrivacy');

Route::post('media/group/upload', 'BlobController@uploadGroupPicture');

Route::post('media/cover/upload', 'BlobController@uploadCover');

Route::post('media/image/states', 'BlobController@imageStates');

Route::post('media/image/comments', 'BlobController@imageComments');

Route::get('media/record/retrive/{id}', 'BlobController@retriveRecord');

Route::get('media/image/retrive/{id}', 'BlobController@retriveImage');

Route::get('media/file/retrive/{id}', 'BlobController@retriveFile');

Route::get('media/avatar/{id}', 'BlobController@retriveAvatar');

Route::get('media/group/picture/{id}', 'BlobController@retriveGroupPicture');

Route::get('media/group/picture/compressed/{id}', 'BlobController@retriveGroupCompressed');

Route::get('media/avatar/compressed/{id}', 'BlobController@retriveAvatarCompressed');

Route::get('media/cover/{id}', 'BlobController@retriveCover');

Route::get('media/cover/compressed/{id}', 'BlobController@retriveCoverCompressed');

Route::get('media/avatar/ref/compressed/{id}', 'BlobController@retriveAvatarCompressed');

Route::post('search/main', 'UserController@mainSearch');

Route::post('search/main/names', 'UserController@searchForUsersByNames');

//userupdate

Route::post('user/updatefirstname', 'UserController@updateUserfirstName');

Route::post('user/updatemiddlename', 'UserController@updateUsermiddleName');

Route::post('user/updatelastname', 'UserController@updateUserlastName');

Route::post('user/updatenickname', 'UserController@updateUsernickName');

Route::post('user/updatebirthdate', 'UserController@updateUserbirthdate');

Route::post('user/updateorientation', 'UserController@updateUserorientation');

Route::post('user/updatereligon', 'UserController@updateUserreligon');

Route::post('user/updatemaritalstatus', 'UserController@updateUsermaritalstatus');

Route::post('user/updatebio', 'UserController@updateUserbio');

Route::post('user/updatephone', 'UserController@updateUserphone');

Route::post('user/updategender', 'UserController@updateUsergender');

Route::post('user/attr/ps/update', 'UserController@updatePrivacy');

Route::post('user/attr/delete', 'UserController@deleteAttr');

Route::post('user/attr/update', 'UserController@updateAttr');

Route::post('user/ask/first/address', 'UserController@hasAddresses');

Route::post('hashtag/lazy', 'HashtagsController@lazy');

//user delete

Route::post('usermiddlename/delete', 'UserController@deleteUsermiddleName');

Route::post('usernickname/delete', 'UserController@deleteUsernickName');

Route::post('userorientation/delete', 'UserController@deleteUserorientation');

Route::post('userreligon/delete', 'UserController@deleteUserreligon');

Route::post('usermaritalstatus/delete', 'UserController@updateUsermaritalstatus');

Route::post('userbio/delete', 'UserController@deleteUserbio');

Route::post('userphone/delete', 'UserController@deleteUserphone');

//user block

Route::post('userblock/addblockeduser', 'UserBlocksController@blockUser');

Route::post('userblock/retriveblockeduser', 'UserBlocksController@retriveBlockedUser');

Route::post('userblock/isblockeduser', 'UserBlocksController@isBlocked');

//unblock user

Route::post('userblock/unblockuser', 'UserBlocksController@unblockUser');

// Route::get('add_notification' , function(){
//   $not = new App\Ballon();
//   $not->initialize( json_encode(
//     array(
//     "index" => array(
//       "title_image" => 'url' ,
//       "title_value" => 'Knocks_user',
//       "category" => 'post' ,
//       "has_picture" => true ,
//       "callback_url" => 'somewhere'  ,
//       "replyable" => true ,
//     ) ,
//     "parent" => 1 ,
//     "user" => 1 ,
//     "content" => 'Hai this is a content'
//   )
//   ));
//   return 'done';
// });

Route::post('tttt', function () {
	$arr = [];
	$arr[0]['value'] = 1;
	$arr[0]['label'] = 'one';
	$arr[1]['value'] = 2;
	$arr[1]['label'] = 'two';
	$arr[2]['value'] = 3;
	$arr[2]['label'] = 'three';
	$arr[3]['value'] = 4;
	$arr[3]['label'] = 'four';
	$arr[4]['value'] = 5;
	$arr[4]['label'] = 'five';
	return json_encode($arr);
});

// Route::get('homeu' , function(){
//   return view('user.home');
// });

Route::get('/', 'UserController@goHome');
Route::get('/home', 'UserController@goHome');

//Developers routes

//Language APIS
Route::get('/dev', function () {
	return view('test.home');
});

Route::get('faq/survey/analysis', function () {
	return view('guest.survey_analysis');
});

Route::post('answers/patch', 'AnswerController@patch');

/*
Using the next APIs for development, they includes:
Creating a language API,
Creating a static message,
Creating a translation a static message,
Getter for all of:
English word id,
Any Language word id,
Word getter by the default user language,

 **The apis are responsive and handling many common errors which makes it easier to develop.

 **Every API is followed by a discription that shows the required params for each one.

 **You need to use an API REST application such as (Advanced REST Client or Postman)
to use the APIs easily.
 */

Route::post('langs', 'LanguageController@create');
/*Creat a language
Params:
language : eg -> english (required)
font : eg -> monospace (optional) , (defaulted by : sans-seric)
alignment : eg -> right (optional) , (defaulted by : left)

OnSuccess  : x language has been added to languages.

 */
Route::post('smsg', 'StaticMessageController@create');
/*Creat a static message
Params:
language : eg -> english (required)
body : eg -> hello world (required)

OnSuccess  : the message has been saved , id tooken is 'id'

 */
Route::post('translate', 'StaticMessageController@translate');
/*Creat a static message
You need to specify the id for the message that you want to translate
Params:
language : eg -> english (required)
body : eg -> hello world (required)
id : eg -> 1 (required)

OnSuccess  : the message `x` has been translated to `lang`
onDublication : the message has already translated to `x`

 */
Route::post('idof', 'StaticMessageController@idOf');
//Get the id of some message in english
//Params :
// q : eg -> hello world (required)
Route::post('glob', 'StaticMessageController@idOfGlob');
//Get the id of some message in any language
//Params :
// q : eg -> hello world (required)
// language : eg -> english (required)
Route::post('gettrans', 'StaticMessageController@getTranslation');
//Get the word in the authorized user language by id
//params : id : eg 1

Route::post('gtrans', 'StaticMessageController@getTranslationByWord');
//Get the word in the authorized user language by id
//params : id : eg 1

//Testing routes
// Route::get('new_user' , function(){
//   //
//   $user = new App\User();
//   $user->initialaize(json_encode(array(
//     'first_name'=> 'Knocks' ,
//     'last_name'=> 'User' ,
//     'nickname' => 'Moussa' ,
//     'birthdate' => '1995-06-15' ,
//     'username' => 'user2' ,
//     'email' => 'mamr2@mail.com' ,
//     'password' => 'secret' ,
//     'gender' => 'male' ,
//     'language' => 'english'
//   )));
//   //auth()->login($user);
//   return 'success!';
// });
// Route::get('ulang' , 'UserController@authUsersLanguage');
// Route::get('circle' , function(){
//   $user = auth()->user();
//   return $user->getCircleId('@all@');
// });

Route::post('allusers', 'UserController@getAllUsers');
//Test Routes

// Route::get('msg/{word}' , function($word){
//   $msg = new App\MessageBus();
//   $msg->defineDefault($word);
//   return 'saved';
// });
// Route::get('trns/{id}/{lang}/{word}' , function($id , $lang , $word){
//   $msg = App\MessageBus::find($id);
//   $msg->addTranslation($word, $lang);
//   return 'saved';
// });
// Route::get('reg' , function(){
//   return view('user.register');
// });

Route::group(['middleware' => 'guest'], function () {

	Route::get('user/blocked/unblock/{user}/{token}', 'UserController@attempUnblock');
	Route::get('user/blocked/temp/{user}/{token}', 'UserController@attempUnblockTempPassword');

	Route::get('signup', function () {
		return view('guest.signup');
	});

	Route::get('signin', function () {auth()->logout();return view('guest.signup');});

	Route::get('user/account/blocked', 'UserController@guiedBlockedAccount');

});

Route::group(['middleware' => 'auth'], function () {
	Route::group(['middleware' => 'isverified'], function () {
		Route::group(['middleware' => 'lastseen'], function () {
			Route::get('faq/survey', function () {
				if (auth()->user()->age() > 13) {
					return view('guest.survey');
				} else {
					return view('guest.candy_survey');
				}

			});
			Route::get('/user/settings', function () {
				return view('user.userinfoedit');
			});

			Route::post('user/answers', 'AnswerController@userAnswers');

			Route::post('survey/submit', 'AnswerController@create');

			Route::post('user/updatepp', 'UserController@updateProfileIndex');

			Route::post('retrive_comment', 'CommentController@retrive');

			Route::post('retrive_reply', 'ReplyController@retrive');

			Route::post('retrive_knock', 'KnockController@retrive');

			Route::post('retrive_knock', 'KnockController@retrive');

			Route::post('knock/delete', 'KnockController@delete');

			Route::get('/{user}', 'UserController@routeToProfile');

			Route::get('user/profile/{user}', 'UserController@routeToProfileById');

			Route::get('group/{group_id}', 'GroupController@routeToGroup');

			Route::get('group/{group_id}/pictures', 'GroupController@routeToGroupPictures');

			Route::get('group/{group_id}/files', 'GroupController@routeToGroupFiles');

			Route::get('group/{group_id}/voices', 'GroupController@routeToGroupVoices');

			Route::get('group/{group_id}/videos', 'GroupController@routeToGroupVideos');

			Route::get('group/{group_id}/settings', 'GroupController@routeToGroupSettings');

			Route::get('/knock/{knock}', 'KnockController@viewKnock');

			Route::get('/cmnt/{comment}', 'KnockController@viewComment');

			Route::get('/rply/{reply}', 'KnockController@viewReply');

			Route::get('/knock/{knock}/{comment}', 'KnockController@viewKnockWithComment');

			Route::post('getstats_reaction/reaction', 'ReactionController@getstats_reaction');

			Route::post('insert_reaction/reaction', 'ReactionController@insert_reaction');

			Route::post('delete_reaction/reaction', 'ReactionController@delete_reaction');

			Route::post('checkinit_reaction/reaction', 'ReactionController@checkinit_reaction');

			//APIS routes

			Route::post('get/circles', 'UserController@userCircles');

			Route::post('create/circles', 'CircleController@create');

			Route::post('update/circles', 'CircleController@update');

			//Friendship requests

			Route::post('get/request', 'UserController@activeRequests');

			Route::post('user/suggestions', 'UserController@getSuggestions');

			Route::post('send/request', 'UserRequestController@sendGroup');

			Route::post('accept/request', 'CircleMemberController@acceptGroup');

			Route::post('circle/member/add', 'CircleMemberController@addMember');

			Route::post('circle/member/remove', 'CircleMemberController@removeMember');

			Route::post('circle/friend/unpair', 'CircleMemberController@unpairFriends');

			Route::post('request/one', 'UserRequestController@sendOne');

			Route::post('request/cancel', 'UserRequestController@cancelOne');

			Route::post('request/ignore', 'UserRequestController@ignoreOne');

			Route::post('request/accept', 'UserRequestController@accept');

			Route::post('view/circle', 'CircleController@view');

			Route::post('user/friendstochat', 'UserController@friendsToChat');

			Route::post('chat/init', 'UserController@initChat');

			// Route::get('cir' , function(){
			//   $c = auth()->user()->circles()->get();
			//    $arr = array();
			//   foreach($c as $cm){

			//     array_push($arr , $cm->circle_name);
			//     array_push($arr , $cm->CircleMembers()->get());
			//     $cmm = $cm->CircleMembers()->get();
			//     foreach($cmm as $cmi){
			//         array_push( $arr , $cmi->user()->get()->pluck('first_name') );
			//     }
			//   }
			//   return json_encode($arr);
			// });
		});
	});
	Route::get('user/offer/verify', 'UserController@offerVerify');
	Route::get('user/offer/verify/expired', 'UserController@offerVerifyExpired');
	Route::get('user/verify/try/{token}', 'UserController@attempVerify');
	Route::post('user/verify/request', 'UserController@requestVerify');
	Route::get('/user/logout', function () {auth()->user()->turnOffChat(); auth()->logout();return view('guest.signup');});
	Route::post('user/passwords/forgot/ask', 'UserController@forgotMyPasswordAsk');
});
// Route::get('test' , function(){
//   return view('test');
// });

// Route::get('currentcsrf/{user}/{tooken}' , function($user ,$tooken ){
//   $userObject =  App\User::where( 'id' , '=' , $user)->get();
//   if($userObject->count() == 0) return 'not_found'.$user;
//   else $userObject = $userObject[0];
//   if($userObject->upload_tooken == $tooken) return 'valid'; else return 'invalid';
// })->middleware('cors');

// Route::get('validobj/{user}/{object}' , function($user ,$object ){

//  return App\Object::find($object)->isAvailable($user) ? 'valid' : 'invalid';
// })->middleware('cors');

// Auth::routes();

// Authentication Routes...
Route::group(['middleware' => 'lastseen'], function () {
	Route::get('user/login', 'Auth\LoginController@showLoginForm')->name('login');
	Route::post('user/login', 'Auth\LoginController@login');
	Route::post('user/logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
	Route::get('user/register', 'Auth\RegisterController@showRegistrationForm')->name('register');
	Route::post('user/register', 'Auth\RegisterController@register');

// Password Reset Routes...
	Route::get('user/password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm');
	Route::post('user/password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
	Route::get('user/password/reset/{token}', 'Auth\ResetPasswordController@showResetForm');
	Route::post('user/password/reset', 'Auth\ResetPasswordController@reset');

});

//Route::get('/home', 'HomeController@index')->name('home');

Route::post('qis', function () {
	//$x = App\Language::all()->pluck('name');
	//foreach($x as $y) $y['s'] = null;
	$x = 'invalid';
	return $x;
});

Route::get('app/lost', 'UserController@lost');
