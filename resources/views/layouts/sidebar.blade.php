<ul id = "knocks_sidebar" class = "side-nav fixed knocks_house_keeper grey lighten-5" >
  <div class="force-overflow"></div>
  <li id = "sidebar_head"><div class="user-view ">
    <div class="background">
      <img :src="coverPhoto()" class = "knocks_user_cover_scope">
    </div>
    <a >
      <el-dropdown class = "right" trigger="click">
      <span class="el-dropdown-link knocks_blured_bg  btn btn-floating knocks_super_tiny_floating_btn knocks_text_light">
        <span class="knocks-chevron-down2"></span>
      </span>
      <el-dropdown-menu slot="dropdown" sty>
      <el-dropdown-item>
      <div @click = "setProfileTrigger(true)">
        <span class = "knocks-pencil9 knocks_icon_border"></span>
        <static_message msg = "Update Your Profile Picture"></static_message>
      </div>
      </el-dropdown-item>
      <el-dropdown-item>
      <div @click = "setCoverTrigger(true)">
        <span class = "knocks-photo knocks_icon_border"></span>
        <static_message msg = "Update Your Cover Picture"></static_message>
      </div>
      </el-dropdown-item>
      <el-dropdown-item>
      <div @click = "setCircleAdderTrigger(true)">
        <span class = "knocks-atom2 knocks_icon_border"></span>
        <static_message msg = "Add Circle"></static_message>
      </div>
      </el-dropdown-item>

       <el-dropdown-item>
         <div @click = "goToSettings()">
        <span class = "knocks-cog knocks_icon_border"></span>
        <static_message msg = "Settings"></static_message>
      </div>
      </el-dropdown-item>



      <el-dropdown-item>
      <div @click = "logout()">
        <span class = "knocks-log-out knocks_icon_border"></span>
        <static_message msg = "Logout"></static_message>
      </div>
      </el-dropdown-item>
      </el-dropdown-menu>
      </el-dropdown>
      {{--  <knocksimgframeless  fill_from="pp/blob" :specifications="{ id : {{auth()->user()->id}} , index : {{auth()->user()-()}} }"
      :show_container = "false" :scope = "['profile_picture_handler']"
      class=" " classes="circle" return_on_null = "{{asset('snaps/avatar.jpg')}}" >
      </knocksimgframeless> --}}
      <img :src="pp()" class = "circle knocks_user_profile_scope" alt = "{{auth()->user()->username.' Profile Picture'}}"/>
    </a>
    <a href="{{asset(auth()->user()->username)}}"><span class="white-text name">
      @if(auth()->user()->nickname != null)
      {{auth()->user()->nickname}}
      @endif
      @if(auth()->user()->nickname == null)
      {{auth()->user()->first_name}}
      @endif
    </span></a>
  </div></li>
  <div id = "sidebar_search">
    <div class = "row" >
             @include('layouts.sidesearch')
            </div>
          </div>
          <div id = "sidebar_contents" :class = "{'animated slideOutUp' : sidebarSearchFocus}">
            <div class = "row">
              <ul id = "knocks_sidebar_list" class = "l10 push-l1 s10 push-l1" style="margin-bottom: 100px">
                <knockscollapse icon = 'knocks-team' title = "My Groups"
                regular_class = "blue-grey-text text-darken-3 knocks_text_ms"
                toggler_container = " grey lighten-4 row knocks_gray_hover knocks_margin_keeper knocks_gray_border knocks_fair_padding">
                  <div slot = "content" class = "blue-grey lighten-5 knocks_house_keeper">
                  <knocksgroupslist></knocksgroupslist>
                  <a @click = "toggleGroupCreator(true)" class = "fluid ui button knocks_no_border_radius">
                <i class="knocks-plus7 "></i>
                <static_message msg = "Create a group"></static_message>
                  </a>
                </div>
                </knockscollapse>
                <knockscollapse icon = 'knocks-atom2' title = "My Circles"
                regular_class = "blue-grey-text text-darken-3 knocks_text_ms"
                toggler_container = " grey lighten-4 row knocks_gray_hover knocks_margin_keeper knocks_gray_border knocks_fair_padding">
                  <div slot = "content" class = "blue-grey lighten-5 knocks_house_keeper">
                   <knocksusercircles></knocksusercircles>
                </div>
                </knockscollapse>
                <knockstrendslist></knockstrendslist>

              </ul>
            </div>
          </div>

        </ul>

        <!-- sidebar -->