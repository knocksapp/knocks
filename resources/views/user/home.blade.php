@extends('layouts.user')
@section('content')
<title>Knocks</title>
  <transition    name="custom-classes-transition" enter-active-class="animated tada" leave-active-class="animated bounceOutRight">
   <h3 v-if = "!loggedIn" class = "center knocks_text_dark">See you again, Bye!</h3>
  </transition>
  <transition    name="custom-classes-transition" enter-active-class="animated zoomIn" leave-active-class="animated zoomOut">
    <div class = " " style = "padding : 0.2rem" v-if = "loggedIn">


  <div class = "row " style = "padding : 3px;">

    <div class = "col l8 s12  grey lighten-5" style="" id = "knocks_main_injectort">
    
      WELCOME GIT


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
   success_msg = "Done."
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
  </transition>
</div>
  
<knocksknockinjector :current_user = "{{auth()->user()->id}}"></knocksknockinjector>


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