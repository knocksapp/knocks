@extends('layouts.user')
@section('content')
<title>
   {{$user->first_name}}
      @if($user->middle_name != null)
      {{' '.$user->middle_name}}
      @endif
      {{' '.$user->last_name}}
      @if($user->nickname != null)
      {{' ('.$user->nickname.')'}}
      @endif
</title>
  <transition    name="custom-classes-transition" enter-active-class="animated tada" leave-active-class="animated bounceOutRight">
   <h3 v-if = "!loggedIn" class = "center knocks_text_dark">See you again, Bye!</h3>
  </transition>
  <transition    name="custom-classes-transition" enter-active-class="animated zoomIn" leave-active-class="animated zoomOut">
    <div class = " " style = "padding : 0.2rem" v-if = "loggedIn">


  <div class = "row knocks_house_keeper" style = "padding : 3px;">
    <div class = "row knocks_house_keeper">
      <img src = "{{asset('media/cover/'.$user->id)}}" class = "knocks_full_cover_photo knocks_user_cover_scope"/>
    </div>
    <div class = "knocks_profile_avatar_frame knocks_house_keeper">
      <a class = "">
        <img class = "knocks_profile_avatar z-depth-1 knocks_user_profile_scope" src = "{{asset('media/avatar/'.$user->id)}}"/>
      </a>
    </div>
    <div class = " knocks_profile_name">
      <h4 class = "  knocks_text_dark">
      {{$user->first_name}}
      @if($user->middle_name != null)
      {{' '.$user->middle_name}}
      @endif
      {{' '.$user->last_name}}
      @if($user->nickname != null)
      {{' ('.$user->nickname.')'}}
      @endif
    </h4>
    </div>
  </div>

  <div class = "row knocks_house_keeper white knocks_standard_border_radius" style="border : 1px solid #cfd8dc">
     <knocksuserabout :user = "{{$user->id}}"></knocksuserabout>
    <h4 class="ui horizontal divider header transparent">
  <i class="knocks-newspaper5"></i>
  <static_message msg = "** 's Knocks" replaceable :replacements = "[{target : '**' , body : '{{$user->first_name}}' }]"></static_message>
</h4>


  <transition name="custom-classes-transition" enter-active-class="animated zoomIn" leave-active-class="animated zoomOut">
   <div v-if = "lowerTrigger == 'cover_uploader'">
    <h5 class = "knocks_text_dark">
        <span class = "knocks-atom2 knocks_icon_border"></span>
        <static_message msg = "Add cover photo"></static_message>
    </h5>

    <a @click ="clearLowerTrigger()">
          <span class = "knocks-close red-text right knocks_text_md "></span>    
    </a>
{{--      <knockscoveruploader
    gid = "coveru"
    :valid_ex="['image/png' , 'image/jpeg']"
    :crop = "true"
    v-model = "fileup"
    success_at = "done"
    success_msg = "done !"
    :upload_data = "{ }"
    :error_at = "[]"
    callback_event = "update"
    :callback_payloads = "{}"
    ref = "ss"
    :special_submit = "true"
    :scope = "['profile_picture_handler']"
    upload_at = "media/cover/upload">
    </knockscoveruploader> --}}

        <knockscroppie
    gid = "knocks_cover_picture_uploader"
    success_at = "done"
    success_msg = "Updated Your cover picture succecfully!"
    :upload_data = "{ }"
    :error_at = "[]"
    callback_event = "update"
    :callback_payloads = "{}"
    ref = "ss"
    :special_submit = "true"
    :scope = "['profile_picture_handler']"
    upload_at = "media/cover/upload"
    :aspect_ratio = "78/205"
></knockscroppie>
   </div>
  </transition>
    <knocksknockinjector 
    :current_user = "{{auth()->user()->id}}"
    as_atimeline
    newer_retrive = "user/profile/posts/newer"
    older_retrive = "user/profile/posts/older"
    basic_retrive = "user/profile/posts"
     :requsted = "{{$user->id}}">
      
    </knocksknockinjector>
  </div>

  </div>
  </div>
    
  </div>
  </transition>
  @endsection