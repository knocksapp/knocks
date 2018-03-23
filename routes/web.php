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

// Route::get('userinfo' , function(){
//   return App\User::find(21)->retriveForUser(20);
// });

// Route::get('registeration' , function(){
//   return view('guest.signup');
// });
// Route::get('rec' , function(){
//   return view('rec');
// });

//DEVELOPERS ROUTES STARTS /////////////////////////////////////////////////////////////
//Language APIS
Route::get('/dev', function () {
	return view('test.home');
});

Route::get('/search', function () {
	return view('test.searchpage', compact('q'));
});

Route::post('object/hide', 'ObjController@hide');

Route::post('dev/all_langs', 'LanguageController@collect');
Route::post('dev/all_msgs', 'StaticMessageController@collect');
Route::post('dev/new_word', 'StaticMessageController@addNewWord');
Route::post('dev/translate', 'StaticMessageController@boundTranslation');
Route::post('dev/translate/force', 'StaticMessageController@forceTranslation');

//Resetting the app
Route::post('dev/trunc/knocks', 'DevController@resetKnocks');
Route::post('dev/trunc/users', 'DevController@resetKnocks');
Route::post('dev/db/reinstall', 'DevController@reinstall');

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

Route::post('update_notifications', 'BallonController@setToPoped');

Route::post('user/info', 'UserController@getInfo');

Route::post('user/info/lazy', 'UserController@getInfoLazy');

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

Route::post('userlogin', 'UserController@userlogin');

Route::post('retrive_circle', 'CircleController@retrive');

Route::post('get_circles', 'UserController@getUserCircles');

Route::post('/create_group', 'GroupController@createGroup');

Route::post('/get_group_members', 'GroupMemberController@getGroupMembers');

Route::post('/check_member_position', 'GroupMemberController@checkOwner');

Route::post('/remove_member', 'GroupMemberController@removeMember');

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

//Sport

Route::post('sport', 'SportController@createSport');

Route::post('sport/get', 'SportController@retriveSport');

Route::post('sport/update', 'SportController@updateSport');

Route::post('sport/delete', 'SportController@deleteSport');

Route::post('check_user_ingroup', 'GroupMemberController@checkUserInGroup');

Route::post('join_public_group', 'GroupController@joinPublicGroup');

Route::post('add_member_public_group', 'GroupController@addMemberPublicGroup');

Route::post('post/create', 'KnockController@create');

Route::post('post/seen', 'KnockController@tickSeen');

Route::post('post/comments', 'KnockController@getComments');

Route::post('comment/create', 'CommentController@create');

Route::post('comment/replies', 'CommentController@getReplies');

Route::post('reply/replies', 'ReplyController@getReplies');

Route::post('blob/qoute', 'BlobController@quote');

Route::post('reply/create', 'ReplyController@create');

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

	Route::get('signup', function () {
		return view('guest.signup');
	});

	Route::get('signin', function () {auth()->logout();return view('guest.signup');});

});

Route::group(['middleware' => 'auth'], function () {
	Route::group(['middleware' => 'lastseen'], function () {
		Route::get('faq/survey', function () {
			if (auth()->user()->age() > 13) {
				return view('guest.survey');
			} else {
				return view('guest.candy_survey');
			}

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

		Route::get('group/{group_id}', 'GroupController@routeToGroup');

		Route::get('group/{group_id}/pictures', 'GroupController@routeToGroupPictures');

		Route::get('group/{group_id}/files', 'GroupController@routeToGroupFiles');

		Route::get('group/{group_id}/voices', 'GroupController@routeToGroupVoices');

		Route::get('group/{group_id}/videos', 'GroupController@routeToGroupVideos');

		Route::get('group/{group_id}/settings', 'GroupController@routeToGroupSettings');

		Route::get('/knock/{knock}', 'KnockController@viewKnock');

		Route::get('/cmnt/{comment}', 'KnockController@viewComment');

		Route::get('/knock/{knock}/{comment}', 'KnockController@viewKnockWithComment');

		Route::post('getstats_reaction/reaction', 'ReactionController@getstats_reaction');

		Route::post('insert_reaction/reaction', 'ReactionController@insert_reaction');

		Route::post('delete_reaction/reaction', 'ReactionController@delete_reaction');

		Route::post('checkinit_reaction/reaction', 'ReactionController@checkinit_reaction');

		Route::get('/user/logout', function () {auth()->user()->turnOffChat(); auth()->logout();return view('guest.signup');});

		//APIS routes

		Route::post('get/circles', 'UserController@userCircles');

		Route::post('create/circles', 'CircleController@create');

		//Friendship requests

		Route::post('get/request', 'UserController@activeRequests');

		Route::post('send/request', 'UserRequestController@sendGroup');

		Route::post('accept/request', 'CircleMemberController@acceptGroup');

		Route::post('request/one', 'UserRequestController@sendOne');

		Route::post('request/cancel', 'UserRequestController@cancelOne');

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

//Route::get('/home', 'HomeController@index')->name('home');

Route::post('qis', function () {
	//$x = App\Language::all()->pluck('name');
	//foreach($x as $y) $y['s'] = null;
	$x = 'invalid';
	return $x;
});
