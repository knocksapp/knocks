@extends('layouts.user')
@section('content')
<?php
$currentUser = auth()->check() ? auth()->user() : array('id' => -1);
?>
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
<knocksuser v-model = "profileModel" class = "knocks_hidden" :user = "{{$user->id}}"></knocksuser>
<transition    name="custom-classes-transition" enter-active-class="animated tada" leave-active-class="animated bounceOutRight">
  <h3 v-if = "!loggedIn" class = "center knocks_text_dark">See you again, Bye!</h3>
</transition>
<transition    name="custom-classes-transition" enter-active-class="animated zoomIn" leave-active-class="animated zoomOut">
  <div class = " " style = "padding : 0.2rem" v-if = "loggedIn" id = "knocks_homepage_lower_area">
    <div class = "row knocks_house_keeper" style = "padding : 3px;">
      <div class = "row knocks_house_keeper">
        @if($user->id == $currentUser['id'])
        <el-tooltip  placement="bottom" effect="light">
        <span slot = "content">
          <span class = "knocks-settings5 "></span>
          <static_message msg=  "Your Profile Settings."></static_message>
        </span>
        <a class = "knocks_text_pink" href = "{{asset('user/settings')}}" style="position: absolute; margin-top : 10px !important; margin-left : 10px; " v-if = "lowerTrigger != 'cover_uploader'" >
          <span class = "knocks-settings5 knocks_text_md knocks_blured_bg knocks_tinny_border_radius white-text" style="padding : 5px !important"></span></a>
          </el-tooltip>
          <el-tooltip  placement="bottom" effect="light">
          <span slot = "content">
            <span class = "knocks-settings5 "></span>
            <static_message msg=  "Your Profile Settings."></static_message>
          </span>
          <el-dropdown style="position: absolute; margin-top : 5px !important; margin-left : 42px; ">
          <el-button class = " knocks_text_md knocks_blured_bg knocks_tinny_border_radius white-text knocks_borderless knocks_xs_padding" >
          <i class="el-icon-arrow-down el-icon--right"></i>
          </el-button>
          <el-dropdown-menu slot="dropdown">
          <el-dropdown-item>
            <a class = "knocks_text_pink" href = "{{asset('user/settings?t=general')}}">
              <span class = "knocks_icon_border knocksapp-disguise"></span>
              <static_message msg="General"></static_message>
            </a>
          </el-dropdown-item>
          <el-dropdown-item>
            <a class = "knocks_text_pink" href = "{{asset('user/settings?t=myPeople')}}">
              <span class = "knocks_icon_border knocks-planet"></span>
              <static_message msg="My People"></static_message>
            </a>
          </el-dropdown-item>
          <el-dropdown-item>
            <a class = "knocks_text_pink" href = "{{asset('user/settings?t=myCircles')}}">
              <span class = "knocks_icon_border knocks-atom2"></span>
              <static_message msg="My Circles"></static_message>
            </a>
          </el-dropdown-item>
          <el-dropdown-item>
            <a class = "knocks_text_pink" href = "{{asset('user/settings?t=myGroups')}}">
              <span class = "knocks_icon_border knocks-group-1"></span>
              <static_message msg="My Groups"></static_message>
            </a>
          </el-dropdown-item>
          <el-dropdown-item>
            <a class = "knocks_text_pink" href = "{{asset('user/settings?t=privacy')}}">
              <span class = "knocks_icon_border knocksapp-lock2"></span>
              <static_message msg="Privacy"></static_message>
            </a>
          </el-dropdown-item>
          <el-dropdown-item>
            <a class = "knocks_text_pink" href = "{{asset('user/settings?t=blocking')}}">
              <span class = "knocks_icon_border knocks-eye-blocked"></span>
              <static_message msg="Blocking"></static_message>
            </a>
          </el-dropdown-item>
          </el-dropdown-menu>
          </el-dropdown>
          </el-tooltip>
          <el-tooltip  placement="bottom" effect="light" v-if = "lowerTrigger != 'cover_uploader'">
          <span slot = "content">
            <span class = "knocksapp-edit  "></span>
            <static_message msg=  "Change Your Cover Photo."></static_message>
          </span>
          <a @click = "setCoverTrigger(true)" style="position: absolute; margin-top : 10px !important; margin-left : 80px; "  v-if = "lowerTrigger != 'cover_uploader'" >
            <span class = "knocksapp-edit knocks_text_md knocks_blured_bg knocks_tinny_border_radius white-text" style="padding : 5px !important"></span></a>
            </el-tooltip>
            <knocksimageviewer gid ="profile_image_viewer"
            :sources = "{{ $user->coverPictures() }}"
            v-if = "profileModel != null"
            unquoted
            :scope = "['cover_picture_handler']"
            :object_id = "{{$user->profilePictureBlob()['object_id']}}"
            :user_id = "{{$currentUser['id']}}"
            :owner_object = "profileModel"
            entrance = "custom"
            :knock_id =  "{{$user->profilePictureBlob()['object_id']}}"
            :owner_id = "{{$user->id}}">
            <knocksimg src = "{{asset('media/cover/'.$user->id)}}" slot = "entrance" class = "knocks_full_cover_photo z-depth-1 knocks_user_cover_scope" v-if = "lowerTrigger != 'cover_uploader'"></knocksimg>
            </knocksimageviewer>
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
            @if($user->id != $currentUser['id'])
            <knocksimageviewer gid ="profile_image_viewer"
            :sources = "{{ $user->coverPictures() }}"
            v-if = "profileModel != null"
            unquoted
            :scope = "['cover_picture_handler']"
            :object_id = "{{$user->profilePictureBlob()['object_id']}}"
            :user_id = "{{$currentUser['id']}}"
            :owner_object = "profileModel"
            entrance = "custom"
            :knock_id =  "{{$user->profilePictureBlob()['object_id']}}"
            :owner_id = "{{$user->id}}">
            <knocksimg src = "{{asset('media/cover/'.$user->id)}}" slot = "entrance" class = "knocks_full_cover_photo z-depth-1 " v-if = "lowerTrigger != 'cover_uploader'"></knocksimg>
            </knocksimageviewer>
            @endif
          </div>
          <div class = "knocks_profile_avatar_frame knocks_house_keeper">
            <a class = "">
              @if($user->id == $currentUser['id'])
              <div >
                <knocksimageviewer gid ="profile_image_viewer"
                :sources = "{{ $user->profilePictures() }}"
                v-if = "profileModel != null"
                unquoted
                :scope = "['profile_picture_handler']"
                :object_id = "{{$user->profilePictureBlob()['object_id']}}"
                :user_id = "{{$currentUser['id']}}"
                :owner_object = "profileModel"
                entrance = "custom"
                :knock_id =  "{{$user->profilePictureBlob()['object_id']}}"
                :owner_id = "{{$user->id}}">
                <knocksimg slot = "entrance" class = "knocks_profile_avatar z-depth-1 knocks_user_profile_scope" src = "{{asset('media/avatar/'.$user->id)}}"></knocksimg>
                </knocksimageviewer>
                <span class = "knocksapp-edit knocks_profile_update_anchor" @click = "setProfileTrigger" v-if = "lowerTrigger != 'profile_uploader'"></span>
              </div>
              @endif
              @if($user->id != $currentUser['id'])
              <knocksimageviewer gid ="profile_image_viewer"
              :sources = "{{ $user->profilePictures() }}"
              v-if = "profileModel != null"
              unquoted
              :scope = "['profile_picture_handler']"
              :object_id = "{{$user->profilePictureBlob()['object_id']}}"
              :user_id = "{{$currentUser['id']}}"
              :owner_object = "profileModel"
              entrance = "custom"
              :knock_id =  "{{$user->profilePictureBlob()['object_id']}}"
              :owner_id = "{{$user->id}}">
              <knocksimg slot = "entrance" class = "knocks_profile_avatar z-depth-1 knocks_user_profile_scope" src = "{{asset('media/avatar/'.$user->id)}}"></knocksimg>
              </knocksimageviewer>
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
          @if($user->id == $currentUser['id'])
          <div class = "row">
            <h4 class="ui horizontal divider header transparent">
            <span class="knocks-centralized-structure"></span>
            <static_message msg = "My People"></static_message>
            </h4>
            <knockscirclechip :circle = "{{$user->mainCircle()->id}}" as_list></knockscirclechip>
          </div>
          <div class="row"> <h4 class="ui horizontal divider header transparent">
            <span class="knocks-atom2"></span>
            <static_message msg = "My Circles"></static_message>
            </h4>
            <knockscollapse icon = 'knocks-atom2' title = "Show" active_title = "hide" dual_title
            regular_class = "blue-grey-text text-darken-3 knocks_text_ms"
            toggler_container = " grey lighten-4 row knocks_gray_hover knocks_margin_keeper knocks_gray_border knocks_fair_padding">
            <div slot = "content" class = "blue-grey lighten-5 knocks_house_keeper">
              <knocksusercircles></knocksusercircles>
            </div>
            </knockscollapse>
          </div>
          @endif
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
          @if($user->id != $currentUser['id'])
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
            @if(auth()->check())
            <knock
            :scope= "['knock_at_profile']"
            :error_at="[]"
            submit_at = "post/create"
            :recorder_upload_data = "{ user : {{$currentUser['id']}} , index : {}}"
            :player_show_options = "false"
            :post_at = "{{ $user->id }}"
            @if($user->id == $currentUser['id'])
            parent_type = "self"
            @endif
            @if($user->id != $currentUser['id'])
            parent_type = "user"
            @endif
            success_at = "done"
            success_msg = "Done."
            gid = "knockknock"></knock>
            @endif
          </div>
          <knocksknockinjector
          :current_user = "{{$currentUser['id']}}"
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