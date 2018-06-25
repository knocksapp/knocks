@extends('layouts.user')
@section('content')
<title>Knocks | Home</title>
<knockswatchmywindow v-model = "watchMyWindow" ></knockswatchmywindow>
<transition    name="custom-classes-transition" enter-active-class="animated tada" leave-active-class="animated bounceOutRight">
  <h3 v-if = "!loggedIn" class = "center knocks_text_dark">See you again, Bye!</h3>
</transition>
<transition    name="custom-classes-transition" enter-active-class="animated zoomIn" leave-active-class="animated zoomOut">
  <div class = " " style = "padding : 0.2rem" v-if = "loggedIn">
    <div class = "row " style = "padding : 3px;">
      <div class = "col grey lighten-5" style="" id = "knocks_main_injectort" :class = "[{'col s12':watchMyWindow.width < 1200} , {'col l8':watchMyWindow.width >= 1200}]">
        <div class = "">
          <knock :scope= "['knock']" :error_at="[]" submit_at = "post/create" :recorder_upload_data = "{ user : {{auth()->user()->id}} , index : {}}" :player_show_options = "false" :post_at = "{{ auth()->user()->id }}" parent_type = "self" success_at = "done" success_msg = "Done." gid = "knockknock"></knock>
        </div>
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
              <knockscroppie gid = "knocks_cover_picture_uploader" success_at = "done" success_msg = "Updated Your cover picture succecfully!" :upload_data = "{ }" :error_at = "[]" callback_event = "update" :callback_payloads = "{}" ref = "ss" :special_submit = "true" :scope = "['cover_picture_handler']" upload_at = "media/cover/upload" :aspect_ratio = "78/205" ></knockscroppie>
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
              <knockscroppie gid = "knocks_profile_picture_uploader" success_at = "done" success_msg = "Updated Your profile picture succecfully!" :upload_data = "{ }" :error_at = "[]" callback_event = "update" :callback_payloads = "{}" ref = "ss" :special_submit = "true" :scope = "['profile_picture_handler']" upload_at = "media/avatar/upload" ></knockscroppie>
            </div>
          </transition>

          <knockstips></knockstips>

        </div>
        <br/>
        <knocksusersuggestions class ="" ></knocksusersuggestions>
          <div class="white knocks_fair_bounds knocks_ocean_blue_border knocks_tinny_border_radius hide-on-large-only">
<knockscollapse icon = "knocks-map7" regular_class = "blue-grey-text text-darken-3 knocks_text_ms" toggler_container = " grey lighten-4 row knocks_gray_hover knocks_margin_keeper knocks_gray_border knocks_fair_padding" title = "Add an address" icon = "knocks-maps" @if(auth()->check() && !auth()->user()->addresses()->exists()) toggle_on_mount @endif ><div slot = "content" > <knocksquickaddress tiny main_container = "white knocks_gray_border row knocks_fair_bounds"></knocksquickaddress></div> </knockscollapse>
            <knockscollapse icon = "knocks-graduate" regular_class = "blue-grey-text text-darken-3 knocks_text_ms" toggler_container = " grey lighten-4 row knocks_gray_hover knocks_margin_keeper knocks_gray_border knocks_fair_padding" title = "Add a career" icon = "knocks-suitcase3" @if(auth()->check() && !auth()->user()->enteryStatus()['career']) toggle_on_mount @endif ><div slot = "content" > <knocksusercareers tiny></knocksusercareers></div> </knockscollapse>
            <knockscollapse icon = "knocks-home7" regular_class = "blue-grey-text text-darken-3 knocks_text_ms" toggler_container = " grey lighten-4 row knocks_gray_hover knocks_margin_keeper knocks_gray_border knocks_fair_padding" title = "Add an Education" icon = "knocks-maps" @if(auth()->check() && !auth()->user()->enteryStatus()['education']) toggle_on_mount @endif ><div slot = "content" > <knocksusereducation tiny></knocksusereducation></div> </knockscollapse>
            <knockscollapse icon = "knocks-graduate" regular_class = "blue-grey-text text-darken-3 knocks_text_ms" toggler_container = " grey lighten-4 row knocks_gray_hover knocks_margin_keeper knocks_gray_border knocks_fair_padding" title = "Add High Education" icon = "knocks-maps" @if(auth()->check() && !auth()->user()->enteryStatus()['high_education']) toggle_on_mount @endif ><div slot = "content" > <knocksuserhigheducation tiny></knocksuserhigheducation></div> </knockscollapse>
           <knockscollapse icon = "knocks-puzzle" regular_class = "blue-grey-text text-darken-3 knocks_text_ms" toggler_container = " grey lighten-4 row knocks_gray_hover knocks_margin_keeper knocks_gray_border knocks_fair_padding" title = "Add a hobby" icon = "knocks-maps" @if(auth()->check() && !auth()->user()->enteryStatus()['hobby']) toggle_on_mount @endif ><div slot = "content" > <knocksuserhobby tiny></knocksuserhobby></div> </knockscollapse>
            <knockscollapse icon = "knocks-graduate" regular_class = "blue-grey-text text-darken-3 knocks_text_ms" toggler_container = " grey lighten-4 row knocks_gray_hover knocks_margin_keeper knocks_gray_border knocks_fair_padding" title = "Add a sport" icon = "knocks-checkered-flag2" @if(auth()->check() && !auth()->user()->enteryStatus()['sport']) toggle_on_mount @endif ><div slot = "content" > <knocksusersport tiny></knocksusersport></div> </knockscollapse>
          </div>
        <knocksknockinjector :current_user = "{{auth()->user()->id}}" show_appendex></knocksknockinjector>
      </div>
      <div class = "col l4" v-if = "watchMyWindow.width >= 1200"
        style=" margin-top: -3.4%;
        margin-bottom: -3%;
        padding: 0.4rem;
        min-height:-webkit-fill-available;" >
        <div class = "row ">
          <br/>
          <div class="white knocks_fair_bounds knocks_ocean_blue_border knocks_tinny_border_radius">
            <knockscollapse icon = "knocks-map7" regular_class = "blue-grey-text text-darken-3 knocks_text_ms" toggler_container = " grey lighten-4 row knocks_gray_hover knocks_margin_keeper knocks_gray_border knocks_fair_padding" title = "Add an address" icon = "knocks-maps" @if(auth()->check() && !auth()->user()->addresses()->exists()) toggle_on_mount @endif ><div slot = "content" > <knocksquickaddress tiny main_container = "white knocks_gray_border row knocks_fair_bounds"></knocksquickaddress></div> </knockscollapse>
            <knockscollapse regular_class = "blue-grey-text text-darken-3 knocks_text_ms" toggler_container = " grey lighten-4 row knocks_gray_hover knocks_margin_keeper knocks_gray_border knocks_fair_padding" title = "Add a career" icon = "knocks-suitcase3" @if(auth()->check() && !auth()->user()->enteryStatus()['career']) toggle_on_mount @endif ><div slot = "content" > <knocksusercareers tiny></knocksusercareers></div> </knockscollapse>
            <knockscollapse icon = "knocks-home7" regular_class = "blue-grey-text text-darken-3 knocks_text_ms" toggler_container = " grey lighten-4 row knocks_gray_hover knocks_margin_keeper knocks_gray_border knocks_fair_padding" title = "Add an Education" icon = "knocks-maps" @if(auth()->check() && !auth()->user()->enteryStatus()['education']) toggle_on_mount @endif ><div slot = "content" > <knocksusereducation tiny></knocksusereducation></div> </knockscollapse>
            <knockscollapse icon = "knocks-graduate" regular_class = "blue-grey-text text-darken-3 knocks_text_ms" toggler_container = " grey lighten-4 row knocks_gray_hover knocks_margin_keeper knocks_gray_border knocks_fair_padding" title = "Add High Education" icon = "knocks-maps" @if(auth()->check() && !auth()->user()->enteryStatus()['high_education']) toggle_on_mount @endif ><div slot = "content" > <knocksuserhigheducation tiny></knocksuserhigheducation></div> </knockscollapse>
            <knockscollapse icon = "knocks-puzzle" regular_class = "blue-grey-text text-darken-3 knocks_text_ms" toggler_container = " grey lighten-4 row knocks_gray_hover knocks_margin_keeper knocks_gray_border knocks_fair_padding" title = "Add a hobby" icon = "knocks-maps" @if(auth()->check() && !auth()->user()->enteryStatus()['hobby']) toggle_on_mount @endif ><div slot = "content" > <knocksuserhobby tiny></knocksuserhobby></div> </knockscollapse>
            <knockscollapse icon = "knocks-graduate" regular_class = "blue-grey-text text-darken-3 knocks_text_ms" toggler_container = " grey lighten-4 row knocks_gray_hover knocks_margin_keeper knocks_gray_border knocks_fair_padding" title = "Add a sport" icon = "knocks-checkered-flag2" @if(auth()->check() && !auth()->user()->enteryStatus()['sport']) toggle_on_mount @endif ><div slot = "content" > <knocksusersport tiny></knocksusersport></div> </knockscollapse>
          </div>
        </div>
      </div>
    </div>
  </div>
</transition>
@endsection
