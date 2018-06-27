@extends('layouts.user')
@section('headers')
<meta property="fb:app_id" content="1796023703741381" />
    <meta property="og:type"   content="website" />
    <meta property="og:url"    content="{{Request::url()}}" />
    <meta property="og:title"  content="KnocksApp, Knock by {{ App\User::find($knock->user_id)->first_name }}" />
    <meta property="og:image"  content="https://knocksapp.com/media/avatar/{{$knock->user_id}}" />
    <meta property="og:description" content="{{$knock->discription()}}">
    <meta property="og:site_name" content="Knocks, Inc.">
@endsection
@section('content')


<title>Knocks</title>
  <transition    name="custom-classes-transition" enter-active-class="animated tada" leave-active-class="animated bounceOutRight">
   <h3 v-if = "!loggedIn" class = "center knocks_text_dark">See you again, Bye!</h3>
  </transition>
  <transition    name="custom-classes-transition" enter-active-class="animated zoomIn" leave-active-class="animated zoomOut">
    <div class = " " style = "padding : 0.2rem" v-if = "loggedIn">


  <div class = "row " style = "padding : 3px;">

    <div class = "col l8 s12 white" style="" id = "knocks_main_injectort">




  <div class = "">

  <knock
   :scope= "['knock']"
   :error_at="[]"
   submit_at = "post/create"
   :recorder_upload_data = "{ user : '7esam' , index : {}}"
   :player_show_options = "false"
   :post_at = "{{ auth()->user()->id }}"
   parent_type = "self"
   success_at = "done"
   success_msg = "yess"
   gid = "knockknock"></knock>
  </div>









{{--   <knockscircleseditor></knockscircleseditor> --}}
   <div id = "knocks_homepage_lower_area">

  <transition name="custom-classes-transition" enter-active-class="animated zoomIn" leave-active-class="animated zoomOut">
   <div v-if = "lowerTrigger == 'cover_uploader'">
    <h5 class = "knocks_text_dark">
        <span class = "knocks-atom2 knocks_icon_border"></span>
        <static_message msg = "Add cover photo"></static_message>
    </h5>

    <a @click ="clearLowerTrigger()">
          <span class = "knocks-close red-text right knocks_text_md "></span>
    </a>
     <knockscoveruploader
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
    </knockscoveruploader>
   </div>
  </transition>

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



   <transition name="custom-classes-transition" enter-active-class="animated zoomIn" leave-active-class="zoomOut">
   <div v-if = "lowerTrigger == 'profile_uploader'">
    <h5 class = "knocks_text_dark">
        <span class = "knocks-pencil9 knocks_icon_border"></span>
        <static_message msg = "Update Your Profile Picture"></static_message>
    </h5>

    <a @click ="clearLowerTrigger()">
          <span class = "knocks-close red-text right knocks_text_md "></span>
    </a>
    <knocksfileupload
    gid = "file"
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
    upload_at = "media/avatar/upload">
    </knocksfileupload>
   </div>
  </transition>
</div>

   <knocksknock  :knock = "{{$knock->id}}" gid="knock_on_scope"
   :current_user = "{{auth()->user()->id}}" replier_message = "Leave a comment" ></knocksknock>


   </div>

   <div class = "col l4 show-on-large hide-on-med-and-down"
    style="padding: 1rem; margin-top: -3%;
    margin-bottom: -3%;
    min-height:-webkit-fill-available;" >
     <div class = "row ">Right</div>
   </div>

  </div>

  </div>
  </transition>



@endsection