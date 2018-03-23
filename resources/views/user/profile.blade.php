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
        @if($user->id == auth()->user()->id)
        <img src = "{{asset('media/cover/'.$user->id)}}" class = "knocks_full_cover_photo knocks_user_cover_scope" v-if = "lowerTrigger != 'cover_uploader'"/>
        <transition name="custom-classes-transition" enter-active-class="animated zoomIn" leave-active-class="animated zoomOut">
          <div v-if = "lowerTrigger == 'cover_uploader'">
            <h5 class = "knocks_text_dark">
            <span class = "knocks-atom2 knocks_icon_border"></span>
            <static_message msg = "Add cover photo"></static_message>
            </h5>
            <a @click ="clearLowerTrigger()">
              <span class = "knocks-close red-text right knocks_text_md "></span>
            </a>
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
            :scope = "['cover_picture_handler']"
            upload_at = "media/cover/upload"
            :aspect_ratio = "78/205"
            ></knockscroppie>
            <h4 class="ui horizontal divider header transparent">
            <i class="knocks-newspaper5"></i>
            <static_message msg = "Edit your cover photo." ></static_message>
            </h4>
          </div>
        </transition>
        @endif
        @if($user->id != auth()->user()->id)
        <img src = "{{asset('media/cover/'.$user->id)}}" class = "knocks_full_cover_photo "/>
        @endif
      </div>
      <div class = "knocks_profile_avatar_frame knocks_house_keeper">
        <a class = "">
          @if($user->id == auth()->user()->id)
          <img class = "knocks_profile_avatar z-depth-1 knocks_user_profile_scope" src = "{{asset('media/avatar/'.$user->id)}}"/>
          @endif
          @if($user->id != auth()->user()->id)
          <img class = "knocks_profile_avatar z-depth-1 " src = "{{asset('media/avatar/'.$user->id)}}"/>
          @endif
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
        <div v-if = "lowerTrigger == 'circle_adder'">
          <h5 class = "knocks_text_dark">
          <span class = "knocks-atom2 knocks_icon_border"></span>
          <static_message msg = "Add Circle"></static_message>
          </h5>
          <a @click ="clearLowerTrigger()">
            <span class = "knocks-close red-text right knocks_text_md "></span>
          </a>
          <knocksaddcircle gid = "circle_adder"></knocksaddcircle>
        </div>
      </transition>
      @if($user->id != auth()->user()->id)
      <transition name="custom-classes-transition" enter-active-class="animated zoomIn" leave-active-class="animated zoomOut">
        <div v-if = "lowerTrigger == 'cover_uploader'">
          <h5 class = "knocks_text_dark">
          <span class = "knocks-atom2 knocks_icon_border"></span>
          <static_message msg = "Add cover photo"></static_message>
          </h5>
          <a @click ="clearLowerTrigger()">
            <span class = "knocks-close red-text right knocks_text_md "></span>
          </a>
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
          :scope = "['cover_picture_handler']"
          upload_at = "media/cover/upload"
          :aspect_ratio = "78/205"
          ></knockscroppie>
        </div>
      </transition>
      @endif
      <transition name="custom-classes-transition" enter-active-class="animated zoomIn" leave-active-class="zoomOut">
        <div v-if = "lowerTrigger == 'profile_uploader'" class = "row">
          <h5 class = "knocks_text_dark">
          <span class = "knocks-pencil9 knocks_icon_border"></span>
          <static_message msg = "Update Your Profile Picture"></static_message>
          </h5>
          <a @click ="clearLowerTrigger()">
            <span class = "knocks-close red-text right knocks_text_md "></span>
          </a>
          <div class = "col s12 l6">
            <knockscroppie
            gid = "knocks_profile_picture_uploader"
            success_at = "done"
            success_msg = "Updated Your profile picture succecfully!"
            :upload_data = "{ }"
            :error_at = "[]"
            callback_event = "update"
            :callback_payloads = "{}"
            ref = "ss"
            :special_submit = "true"
            :scope = "['profile_picture_handler']"
            upload_at = "media/avatar/upload"
            ></knockscroppie>
          </div>
        </div>
      </transition>
      <div class = "row">

          <knock
           :scope= "['knock_at_profile']"
           :error_at="[]"
           submit_at = "post/create"
           :recorder_upload_data = "{ user : {{auth()->user()->id}} , index : {}}"
           :player_show_options = "false"
           :post_at = "{{ $user->id }}"
            @if($user->id == auth()->user()->id)
           parent_type = "self"
           @endif
           @if($user->id != auth()->user()->id)
           parent_type = "user"
           @endif
           success_at = "done"
           success_msg = "Done."
           gid = "knockknock"></knock>

      </div>
      <knocksknockinjector
      :current_user = "{{auth()->user()->id}}"
      as_atimeline
      show_appendex
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