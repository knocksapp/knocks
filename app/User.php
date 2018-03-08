<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Circle;
use App\Language;
use App\Knock;
use App\Blob;
use DB;
use App\Quotation;
use App\user_blocks;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    //User childs

    public function comments()
    {
        return $this->hasMany('App\Comment', 'user_id');
    }
    public function answer()
    {
        return $this->hasOne('App\Answer', 'user_id');
    }

    public function knocks()
    {
        return $this->hasMany('App\Knock', 'user_id');
    }

    public function replies()
    {
        return $this->hasMany('App\Reply', 'user_id');
    }

    public function reactions()
    {
        return $this->hasMany('App\Reaction', 'user_id');
    }

    public function privacySet()
    {
        return $this->hasMany('App\Privacy_set_user', 'user_id');
    }

    public function circleMember()
    {
        return $this->belongsTo('App\Circle_member', 'user_id');
    }

    //Check if some user is a member in some owner circle

    public function isMemberIn($circleToCheck , $userToCheck){
         $circle = Circle::find($circleToCheck);
         if($circle == null) return false;
         if($circle->user_id == $this->id){
            $circleMembers = $circle->circleMembers()->where('user_id' , '=' , $userToCheck)->get();
            if($circleMembers->count() != 0){
                return true;
            }else return false;
         } else return false;
    }

    public function updateLastSeen(){
        $this->last_seen = now();
        $this->status = 'online';
        $this->update();
        return true;
    }

    public function turnOffChat(){
        $this->last_seen = now();
        $this->status = 'offline';
        $this->update();
        return true;
    }

    public function jamCircles()
    {
        return $this->hasMany('App\Jam_circle', 'user_id');
    }

    public function groupMembers()
    {
        return $this->hasMany('App\Group_member', 'user_id');
    }

    public function stageMembers()
    {
        return $this->hasMany('App\Stage_member', 'user_id');
    }

    public function circles()
    {
        return $this->hasMany('App\Circle', 'user_id');
    }

    public function objects()
    {
        return $this->hasMany('App\obj', 'user_id');
    }

    public function educations()
    {
        return $this->hasMany('App\Education', 'user_id');
    }

    public function highEducations()
    {
        return $this->hasMany('App\High_education', 'user_id');
    }

    public function careers()
    {
        return $this->hasMany('App\Career', 'user_id');
    }

    public function sports()
    {
        return $this->hasMany('App\Sport', 'user_id');
    }

    public function hobbies()
    {
        return $this->hasMany('App\Hobby', 'user_id');
    }

    public function publicFigures()
    {
        return $this->hasMany('App\Public_figure', 'user_id');
    }

    public function userSentRequests()
    {
        return $this->hasMany('App\User_request', 'sender_id');
    }

    public function userRecivedRequests()
    {
        return $this->hasMany('App\User_request', 'reciver_id');
    }

    public function sentEnvelopes()
    {
        return $this->hasMany('App\Envelope', 'sender_id');
    }

    public function recivedEnvelops()
    {
        return $this->hasMany('App\Envelope', 'reciver_id');
    }

    public function candySessionsParents()
    {
        return $this->hasMany('App\Candy_session', 'parent_id');
    }

    public function candySessionKids()
    {
        return $this->hasMany('App\Candy_session', 'kid_id');
    }

    public function ballons()
    {
        return $this->hasMany('App\Ballon', 'user_id');
    }

    public function talentObjects()
    {
        return $this->hasMany('App\Talent_object', 'user_id');
    }

    public function ignoredObjects()
    {
        return $this->hasMany('App\ignored_object', 'user_id');
    }

    public function savedObjects()
    {
        return $this->hasMany('App\saved_object', 'user_id');
    }

    public function cog(){
        return json_decode($this->configuration);
    }




    //User methods

    public function initialaize($object)
    {
        $object = json_decode($object);

        if (isset($object->middle_name)) {
            if ($object->middle_name != null || !empty($object->middle_name)) {
                $this->middle_name = $object->middle_name;
            }
        }

        if (isset($object->nickname)) {
            if ($object->nickname != null || !empty($object->nickname)) {
                $this->nickname = $object->nickname;
            }
        }

        $this->first_name = $object->first_name;

        $this->last_name = $object->last_name;

        $this->birthdate = $object->birthdate;

        $this->gender = $object->gender;

        $this->username = $object->username;

        $this->email = $object->email;

        $this->password = bcrypt($object->password);
        if(isset($object->nickname)){
            $displayName = ['nickname'];
        }else{
            $displayName = ['first_name'];
            if(isset($object->middle_name))
                array_push($displayName, 'middle_name');
            array_push($displayName, 'last_name');
        }

        $this->configuration = json_encode(array(
            'language' => $object->language ,
            'display_name' => $displayName ,
            'objects_public_preset' => 'valid' ,
            'sessions_count' => 0 ,
            'devices' => array() ,
            'privacy_user_set' => array(
                                        "birthdate" => array () ,
                                        "email" => array () ,
                                        "gender" => array () ,
                                        "orientation" => array () ,
                                        "religon" => array () ,
                                        "marital_status" => array () ,
                                        "bio" => array () ,
                                        ) ,

         ));

        $this->ballons_configuration = json_encode(array());

        $this->save();

        auth()->login($this);

        $circle = new Circle();
        $circle->initialize('All', json_encode(
            [ array("class" => "planet" , "label" => "health" , "category" => "knocks") ]
        ));



        $cog = ($this->configuration);
        $cog = json_decode($cog);
        $privacyCircleSet = array(
            "birthdate" => array ( ["circle" => $circle->id , "preset" => "valid"] , ["circle" => -1 , "preset" => "valid"] ) ,
            "email" => array ( ["circle" => $circle->id , "preset" => "valid" ], ["circle" => -1 , "preset" => "valid"]) ,
            "gender" => array ( ["circle" => $circle->id , "preset" => "valid"], ["circle" => -1 , "preset" => "valid"] ) ,
            "orientation" => array ( ["circle" => $circle->id , "preset" => "valid"], ["circle" => -1 , "preset" => "valid"]) ,
            "religon" => array ([ "circle" => $circle->id , "preset" => "valid"], ["circle" => -1 , "preset" => "valid"]) ,
            "marital_status" => array ( ["circle" => $circle->id , "preset" => "valid"], ["circle" => -1 , "preset" => "valid"]) ,
            "bio" => array ( ["circle" => $circle->id , "preset" => "valid"], ["circle" => -1 , "preset" => "valid"]) ,
        );
        $cog->privacy_circle_set = $privacyCircleSet;
        $cog->main_circle = $circle->id;
        $cog->default_privacy_sets = array(
            'privacy_user_set' => array() ,
            'privacy_circle_set' => array( array(  'circle_id'=> $circle->id , 'preset_id' => 1 ))
        );
        $this->configuration = json_encode($cog);
        $this->update();
    }

    //Update upload Token
    public function updateToken($token){
        $this->upload_tooken = $token;
        $this->update();
    }

    public function blobObject(){
        return Blob::find($this->profile_picture)->object_id;
    }
    public function retriveForUserLazy( $requester ){
        return array(
            'first_name' => $this->first_name , 
            'last_name' => $this->last_name , 
            'middle_name' => $this->middle_name , 
            'user_name' => $this->username , 
            'display_name' => $this->cog()->display_name
        );
    }
    public function retriveForUser( $requester ){
        //Get the configuration
        $cog = json_decode($this->configuration);
        $privacyUserSet = $cog->privacy_user_set;
        $privacyCircleSet = $cog->privacy_circle_set;
        $resultObject = array (
            "id" => $this->id,
            "first_name" => $this->first_name ,
            "last_name" => $this->last_name ,
            "middle_name" => $this->middle_name ,
            "nickname" => $this->nickname ,
            "username" => $this->username ,
            "gender" => $this->gender ,
            "display_name" => $cog->display_name
        );
        //Declaring the user propirties
        $userProperties = array(
            "birthdate" => null,
            "marital_status" => null ,
            "orientation"  => null ,
            "email" => null ,
            "religon" => null ,
            "gender" => null ,
            "bio" => null ,
        );
        $userExeptions = array(
            "birthdate" => false ,
            "marital_status" => false ,
            "orientation" => false ,
            "email" => false ,
            "religon" => false ,
            "bio" => false ,
            "gender" => false ,
        );
        /*
        We are having three types of presets
        Valid : switches on the property and make it returnable.
        Invalid : Switches off the property, but could be overrided.
        InvalidForAll : switches off the property and can't be overrided.
        */
         foreach($userProperties as $prop => $value){
                foreach($privacyUserSet->$prop as $pus){
                    if($pus->user == $requester){
                        $userExeptions[$prop] = true;
                        if($pus->preset == 'valid')
                            $resultObject[$prop] = $this->$prop;
                        elseif($pus->preset == 'invalid')
                            $resultObject[$prop] = 'INVALID';
                    }
            }
         }
         //Search in the circles
           foreach($userProperties as $prop => $value){
            if(!$userExeptions[$prop]){
                // array_push($nonExepted, $prop); //OPT TEST
                foreach($privacyCircleSet->$prop as $pus){
                    if($pus->circle != -1){
                            if(Circle::find($pus->circle)->isMember($requester)){
                                // array_push($checkedcircles, $pus->circle); //OPT TEST
                            if(isset($resultObject[$prop]) && $resultObject[$prop] == 'INVALIDFORALL'){
                                // array_push($nonoverrided, $prop); //OPT TEST
                                $resultObject[$prop] = 'INVALIDFORALL';
                            }else{
                                // array_push($overrided, $prop);
                                if($pus->preset == 'valid')
                                    $resultObject[$prop] = $this->$prop;
                                elseif($pus->preset == 'invalid'){
                                    if(!(isset($resultObject[$prop]) && $resultObject[$prop] == 'valid' ))
                                        $resultObject[$prop] = 'INVALID';
                                }elseif($pus->preset == 'invalid_for_all')
                                    $resultObject[$prop] = 'INVALIDFORALL';
                                }
                            }
                        }else{
                            if(!(isset($resultObject[$prop]))){
                                // array_push($public, $prop); //OPT TEST
                                if($pus->preset == 'valid'){
                                    $resultObject[$prop] = $this->$prop;
                                }else $resultObject[$prop] = 'INVALID';
                            }
                        }
                    }
            }
         }
         //Check the public restrictions
         //Handling the final output
         foreach($resultObject as $prop => $value){
            if($value == 'INVALID' || $value == 'INVALIDFORALL')
                $resultObject[$prop] = null;
         }
         $resultObject['profile_index'] = $this->currentProfilePicture();
         $isFriend = $this->isFriend($requester);
         $resultObject['is_friend'] = $isFriend;
         if($isFriend || $requester == $this->id){
            $resultObject['requested'] =false;
            $resultObject['requester'] =false;
            $resultObject['last_seen'] = $this->last_seen;
            $resultObject['status'] = $this->status;
         } else {
            $resultObject['requested'] = $this->hasFriendRequest($requester);
            $resultObject['requester'] = $this->hasSentRequest($requester);
        }
        //Return the result
        return $resultObject;
    }

    public function hasSentRequest($target){
        return $this->userSentRequests()->where('reciver_id' , '=' , $target)->where('response' , '=' , 'waiting')->exists();
    }

    public function hasFriendRequest($from){
        return $this->userRecivedRequests()->where('sender_id' , '=' , $from)->where('response' , '=' , 'waiting')->exists();
    }

     public function hasFriendRequestObject($from){
        $req =  $this->userRecivedRequests()->where('sender_id' , '=' , $from)->where('response' , '=' , 'waiting');
        if(!$req->exists()) return false ;
        else return $req->first();
    }

    public function defaultPresets(){
        return json_encode(json_decode($this->configuration)->default_privacy_sets);
    }

    public function isFriend($user){
        return $this->mainCircle()->circleMembers()->where('user_id' , '=' , $user)->count() == 0 ? false : true;
    }

    //User circle methods

    public function mainCircle(){
        return Circle::find(json_decode($this->configuration)->main_circle);
    }

    public function getCircleId($name){
        return $this->circles()->where('circle_name', '=', $name)->first()->id;
    }

    public function hasCircle($circle){
        if ($this->circles()->where('circle_name', '=', $circle)->count() == 0) {
            return false ;
        } else {
            return true;
        }
    }

    public function hasCircleById($circle)
    {
        if ($this->circles()->where('id', '=', $circle)->count() == 0) {
            return false ;
        } else {
            return true;
        }
    }

    //User Request methods

    public function hasRecievedRequest($id)
    {
        if ($this->userRecivedRequests()->where('id', '=', $id)->count() == 0) {
            return false ;
        } else {
            return true;
        }
    }

    //User Attribures

    public function has_career($works_at, $works_since)
    {
        if (($this->careers()->where('works_at', '=', $works_at))&&
        ($this->careers()->where('works_since', '=', $works_since))->count()==0) {
            return false;
        } else {
            return true;
        }
    }

    public function has_hobby($name, $url)
    {
        if (($this->hobbies()->where('name', '=', $name))&&
        ($this->hobbies()->where('url', '=', $url))) {
            return false;
        } else {
            return true;
        }
    }

    public function has_public_figure($name, $url)
    {
        if (($this->publicFigures()->where('name', '=', $name))&&
        ($this->publicFigures()->where('url', '=', $url))) {
            return false;
        } else {
            return true;
        }
    }

    public function hasEducation($uniname, $study_since)
    {
        if (($this->educations()->where('study_at', '=', $uniname)->count() == 0)&&($this->educations()->where('study_since', '=', $study_since)->count() == 0)) {
            return false ;
        } else {
            return true;
        }
    }
    public function hasHighEducation($uniname, $study_since)
    {
        if (($this->highEducations()->where('study_at', '=', $uniname)->count() == 0)&&($this->educations()->where('study_since', '=', $study_since)->count() == 0)) {
            return false ;
        } else {
            return true;
        }
    }
    public function hasSport($sportname, $url)
    {
        if (($this->sports()->where('name', '=', $sportname)->count() == 0)&&($this->educations()->where('url', '=', $url)->count() == 0)) {
            return false ;
        } else {
            return true;
        }
    }


    //Language getter
    public function userLanguage(){
      if(!auth()->check()) return 'en';
      return json_decode($this->configuration)->language;
    }
    public function userLanguageFont(){
      return Language::where('name' , '=' , $this->userLanguage())->get()->first()->font_family;
    }
    public function userLanguageAlignment(){
      return Language::where('name' , '=' , $this->userLanguage())->get()->first()->alignment;
    }
    public function profilePicture(){

        return ($this->profile_picture);
    }
    public function nextProfilePicture(){
        if($this->profile_picture == null){ return '';

            //$this->profile_picture = json_encode(array('current' => -1 , 'index' => -1));
            $this->update();
        }
        $profilePictureObject =  json_decode($this->profile_picture);

        return $profilePictureObject->index + 1;
    }
    public function currentProfilePicture(){
        return $this->profile_picture;
    }
    public function publicPreset(){
        return json_decode($this->configuration)->objects_public_preset;
    }


    public function getPeopleKnocks($limits){

      $limits = json_decode($limits);
      if($limits->max == null && $limits->min == null){
          $friends = $this->mainCircle()->circleMembers()->get();
          $knocks = array();
          $current =  knock::where('user_id' , '=' ,auth()->user()->id)->get()->pluck('id');
        foreach($current as $c ) array_push($knocks, $c);
          foreach($friends as $friend){
            $current =  knock::where('user_id' , '=' ,$friend->user_id)->get();
            foreach($current as $c ) {
                $ob = obj::find($c->object_id);
                if($ob->isAvailable($this->id))
                array_push($knocks, $c->id);
            }
          }
          if(count($knocks) == 0) return array ('knocks' => [] , 'last_index' => null);
          rsort($knocks);
          $collection = collect($knocks);
          return array ('knocks' => $collection->chunk(3)->toArray()[0] , 'last_index' => null);
      }elseif($limits->max != null ){
        $friends = $this->mainCircle()->circleMembers()->get();
        $knocks = array();
        $current =  knock::where('user_id' , '=' ,auth()->user()->id)->where('id' , '>' , $limits->max)->get()->pluck('id');
        foreach($current as $c ) array_push($knocks, $c);
          foreach($friends as $friend){
            $current =  knock::where('user_id' , '=' ,$friend->user_id)->
            where('id' , '>' , $limits->max)->get()->pluck('id');
              foreach($current as $c ) {
                $ob = obj::find($c->object_id);
                if($ob->isAvailable($this->id))
                array_push($knocks, $c->id);
            }
          }
          if(count($knocks) < 3 && $limits->min){
            $current =  knock::where('user_id' , '=' ,auth()->user()->id)->where('id' , '<' , $limits->min)->get()->pluck('id');
           foreach($current as $c ) array_push($knocks, $c);
          foreach($friends as $friend){
            $current =  knock::where('user_id' , '=' ,$friend->user_id)->
            where('id' , '<' , $limits->min)->get()->pluck('id');
                          foreach($current as $c ) {
                $ob = obj::find($c->object_id);
                if($ob->isAvailable($this->id))
                array_push($knocks, $c->id);
            }
          }
          }
          rsort($knocks);
          if(count($knocks) == 0) return array ('knocks' => [] , 'last_index' => null);
          $collection = collect($knocks);
          if($limits->last_index == null && count($collection)  == 0)
          return array ( 'knocks' => [] , 'last_index' => null);
          if($limits->last_index == null && count($collection) > 0)
          return array ( 'knocks' => $collection->chunk(3)->toArray()[0] , 'last_index' => 0 );
          elseif($limits->last_index == count($collection)->chunk(3) - 1){
            return array ( 'knocks' => [] , 'last_index' => count($collection)->chunk(3) - 1 );
          }else{
            return array( 'knocks' => $collection->chunk(3)->toArray()[$last_index] , 'last_index' => $last_index+1 );
          }
      }

    }

    public function getPeopleKnocksRegular(){
          $friends = $this->mainCircle()->circleMembers()->get();
          $knocks = array();
          $current =  knock::where('user_id' , '=' ,$this->id)->get()->pluck('id');
        foreach($current as $c ) array_push($knocks, $c);
          foreach($friends as $friend){
            $current =  knock::where('user_id' , '=' ,$friend->user_id)->get()->pluck('id');
            foreach($current as $c ) array_push($knocks, $c);
          }
          if(count($knocks) == 0) return array ('knocks' => [] , 'last_index' => null);
          rsort($knocks);
          $collection = collect($knocks);
          return array ('knocks' => $collection->chunk(3)->toArray()[0] , 'last_index' => null);
    }

    public function getPeopleKnocksRegularMin($min){
        if($min == null) return array ('knocks' => array(), 'last_index' => null);
          $friends = $this->mainCircle()->circleMembers()->get();
          $knocks = array();
          $current =  knock::where('user_id' , '=' , $this->id)
          ->where('id' , '<' , $min)
          ->get()->pluck('id');
        foreach($current as $c ) array_push($knocks, $c);
          foreach($friends as $friend){
            $current =  knock::where('user_id' , '=' ,$friend->user_id)
            ->where('id' , '<' , $min)
            ->get();
            foreach($current as $c ) {
                $ob = obj::find($c->object_id);
                if($ob->isAvailable($this->id))
                array_push($knocks, $c->id);
            }
          }
          if(count($knocks) == 0) return array ('knocks' => [] , 'last_index' => null);
          rsort($knocks);
          $collection = collect($knocks);
          return array ('knocks' => $collection->chunk(3)->toArray()[0] , 'last_index' => null);
    }

    public function getPeopleKnocksRegularMax($max){
        if($max == null) return $this->getPeopleKnocksRegular();
          $friends = $this->mainCircle()->circleMembers()->get();
          $knocks = array();
          $current =  knock::where('user_id' , '=' ,$this->id)
          ->where('id' , '>' , $max)
          ->get()->pluck('id');
        foreach($current as $c ) array_push($knocks, $c);
          foreach($friends as $friend){
            $current =  knock::where('user_id' , '=' ,$friend->user_id)
            ->where('id' , '>' , $max)
            ->get();
            foreach($current as $c ) {
                $ob = obj::find($c->object_id);
                if($ob->isAvailable($this->id))
                array_push($knocks, $c->id);
            }
          }
          if(count($knocks) == 0) return array ('knocks' => [] , 'last_index' => null);
          asort($knocks);
          $collection = collect($knocks);
          return array ('knocks' => $collection->chunk(3)->toArray()[0] , 'last_index' => null);
    }



    public function getUserKnocks($limits){

      $limits = json_decode($limits);
      if($limits->max == null && $limits->min == null){
           $knocks = array();
          $current =  $this->knocks()->get()->pluck('id');
        foreach($current as $c ) array_push($knocks, $c);

          if(count($knocks) == 0) return array ('knocks' => [] , 'last_index' => null);
          rsort($knocks);
          $collection = collect($knocks);
          return array ('knocks' => $collection->chunk(3)->toArray()[0] , 'last_index' => null);
      }elseif($limits->max != null ){
       $knocks = array();
          $current =  $this->knocks()->where('id' , '>' , $limits->max)->get()->pluck('id');
        foreach($current as $c ) array_push($knocks, $c);
          if(count($knocks) < 3 && $limits->min){
            $current =  $this->knocks()->where('id' , '<' , $limits->min)->get()->pluck('id');
           foreach($current as $c ) array_push($knocks, $c);

          }
          rsort($knocks);
          if(count($knocks) == 0) return array ('knocks' => [] , 'last_index' => null);
          $collection = collect($knocks);
          if($limits->last_index == null && count($collection)  == 0)
          return array ( 'knocks' => [] , 'last_index' => null);
          if($limits->last_index == null && count($collection) > 0)
          return array ( 'knocks' => $collection->chunk(3)->toArray()[0] , 'last_index' => 0 );
          elseif($limits->last_index == count($collection)->chunk(3) - 1){
            return array ( 'knocks' => [] , 'last_index' => count($collection)->chunk(3) - 1 );
          }else{
            return array( 'knocks' => $collection->chunk(3)->toArray()[$last_index] , 'last_index' => $last_index+1 );
          }
      }

    }

   public function age(){
    $year = (int) substr($this->birthdate , 0 , 4);
    $current = (int) date('Y');
    return $current - $year;

   }

    public function getUserKnocksRegular(){
          $knocks = array();
          $current =  $this->knocks()->get()->pluck('id');
        foreach($current as $c ) array_push($knocks, $c);
          if(count($knocks) == 0) return array ('knocks' => [] , 'last_index' => null);
          rsort($knocks);
          $collection = collect($knocks);
          return array ('knocks' => $collection->chunk(3)->toArray()[0] , 'last_index' => null);
    }

    public function getUserKnocksRegularMin($min){
        if($min == null) return array ('knocks' => array(), 'last_index' => null);

        $knocks = array();
        $current =  $this->knocks()->where('id' , '<' , $min)->get()->pluck('id');

        foreach($current as $c ) array_push($knocks, $c);

          if(count($knocks) == 0) return array ('knocks' => [] , 'last_index' => null);
          rsort($knocks);
          $collection = collect($knocks);
          return array ('knocks' => $collection->chunk(3)->toArray()[0] , 'last_index' => null);
    }

    public function getUserKnocksRegularMax($max){
        if($max == null) return $this->getUserKnocksRegular();
          $current =  $this->knocks() ->where('id' , '>' , $max)->get()->pluck('id');
          $knocks = array();
        //$current =  $this->knocks()->get()->pluck('id');
        foreach($current as $c ) array_push($knocks, $c);

          if(count($knocks) == 0) return array ('knocks' => [] , 'last_index' => null);
          asort($knocks);
          $collection = collect($knocks);
          return array ('knocks' => $collection->chunk(3)->toArray()[0] , 'last_index' => null);
    }


    public function soundsLike($q){
        return  DB::select( DB::raw("SELECT * FROM users 
          WHERE first_name sounds like '$q'
          or last_name sounds like '$q'
          or middle_name sounds like '$q'
          or nickname sounds like '$q'
          or username sounds like '$q'
          "
        ) 
       );
    }
   public function soundsLikeID($q){
        return  collect(DB::select( DB::raw("SELECT id FROM users 
          WHERE first_name sounds like '%$q%'
          or last_name sounds like '%$q%'
          or middle_name sounds like '%$q%'
          or nickname sounds like '%$q%'
          or username sounds like '%$q%'
          or first_name like '%$q%'
          or last_name like '%$q%'
          or middle_name like '%$q%'
          or nickname like '%$q%'
          or username like '%$q%'
          "
        ) 
       ))->pluck('id');
    }

       public function FriendsSoundsLikeID($q){
        $mainCircle = $this->mainCircle()->id;
        return  collect(DB::select( DB::raw("SELECT * FROM users 
         INNER JOIN circle_members ON users.id=circle_members.user_id
          WHERE circle_members.circle_id = '$mainCircle'
          AND ( users.first_name sounds like '%$q%'
          or users.last_name sounds like '%$q%'
          or users.middle_name sounds like '%$q%'
          or users.nickname sounds like '%$q%'
          or users.username sounds like '%$q%'
          or users.first_name like '%$q%'
          or users.last_name like '%$q%'
          or users.middle_name like '%$q%'
          or users.nickname like '%$q%'
          or users.username like '%$q%' )
          "
        ) 
       ))->pluck('user_id');
    }

    public function friendsObjects(){
        $mainCircle = $this->mainCircle()->id;
        return  collect(DB::select( DB::raw("SELECT * FROM users 
         INNER JOIN circle_members ON users.id=circle_members.user_id
          WHERE circle_members.circle_id = '$mainCircle'"
        ) 
       ));
    }

      public function friendsToChat(){
        $mainCircle = $this->mainCircle()->id;
        return  collect(DB::select( DB::raw("SELECT users.id , users.last_seen , users.status FROM users 
         INNER JOIN circle_members ON users.id=circle_members.user_id
          WHERE circle_members.circle_id = '$mainCircle'
          ORDER BY users.last_seen DESC
          "
        ) 
       ));
    }

    public function isMatched($q){
        $arr = [];
        array_push($arr, $this->first_name);
        array_push($arr, $this->last_name);
        array_push($arr, $this->middle_name);
        array_push($arr, $this->username);
        array_push($arr, $this->nickname);
        array_push($arr, join(" ",$arr));

        for($i = 0; $i < count($arr) ; $i++){       
          similar_text($arr[$i], $q ,$percent);
          if($percent > 50 || strpos($arr[$i], $q))
            return true;
        }
        return false ;
    }










    public function pairAsFriend($friend){
        $current = new Circle_member();
        $current->initialize( $this->id , $friend->mainCircle()->id );
        $other = new Circle_member();
        $other->initialize( $friend->id , $this->mainCircle()->id );
    }
    public function createCirclesMembership($circles){
        //$circles = json_encode($circles);
        for($cir = 0; $cir < count($circles); $cir++){
            $current = Circle::find($circles[$cir]);
            if($current != null && !$current->isMember($this->id) ){
               $mem = new Circle_member();
               $mem->initialize( $this->id , $circles[$cir] );
            }
        }
    }
}
