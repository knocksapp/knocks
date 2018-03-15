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
      {{ ucfirst(auth()->user()->first_name)}} {{ucfirst(auth()->user()->last_name)}}
    </span></a>
  </div></li>
  <div id = "sidebar_search">
    <div class = "row" >
      <div class = "row" id = "sidebar_search_group_holder">
        {{--     <knocksinput
        placeholder="search"
        gid = "sidebar_search_box"
        icon_class = "teal-text lighten-3"
        knocksclass="knocks_teal_input" icon = "knocks-search12" ></knocksinput> --}}
        <form action = "{{asset('search')}}" method="get" id = "knocks_sidebar_search_form">

        <el-input
        class = "knocks_tinny_top_padding knocks_side_padding"
        name = "q"
        placeholder="Search"
        @focus = "searchFocus()"
        @blur = "searchBlur()"
        @input = "sidebarRunSearch()"
        id="sidebar_search_box"
        v-model="sidebarSearch" class="input-with-select">
        <knocksvoicerecognition v-model = "sidebarSearchRecognition" :lang = "sideBarSearchLanguage" @recognition = "runVoiceSearch($event)" @leave="sidebarFocus()" slot = "prepend"></knocksvoicerecognition>
        <el-button native-type ="submit" slot="append" icon=" knocks_icon knocks-search2"></el-button>
        </el-input>
        <input type = "hidden" name = "t" :value = "sidebarSearchTaps"/>
      </form>

        <div style = "display : none" id = "sidebar_search_results">
          <div class = "row knocks_side_padding knocks_tinny_top_padding">

            <el-button id ="sidebar_search_back" type="info" icon=" knocks_icon knocks-chevron-left2" class = ""></el-button>
            <div class = "right">
                          <el-select v-model="sideBarSearchLanguage" slot="prepend"  style = "width :110px !important">
            <el-option label = "English" value = "en"></el-option>
            <el-option label = "العربيه" value = "ar-sa"></el-option>
            </el-select>
            <span class = "knocks-globe9 blue-text knocks_text_md"></span>
            </div>
            <transition enter-active-class = "animated bounceInLeft" leave-active-class = "animated bounceOutRight">
            <div v-if = "sidebarSearchRecognition.loading" class = "animated bounceInLeft">
              <span class = "blue-text knocks-spinner13 knocks_spinner"></span>
              <static_message msg = "Processing your voice.." classes = "blue-text"></static_message>
            </div>
          </transition>
            <transition enter-active-class = "animated bounceInLeft" leave-active-class = "animated bounceOutUp">
              <div v-if = "sidebarSearchRecognition.speaking" class = "">
                <a class = "btn btn-floating pulse red">
              <span class = "knocks-assistive-listening-systems white-text "></span>
            </a>
              <static_message msg = "Listening.." classes = "red-text"></static_message>
            </div>
            </transition>

          </div>
          <transition enter-active-class = "animated zoomIn" leave-active-class = "animated zoomOut">
            <div class = "row knocks_house_keeper" v-if = "sidebarSearchResult != null">
              <el-tabs  class = "" v-model = "sidebarSearchTaps">
              <el-tab-pane name = "users">
              <span slot="label">
                <el-tooltip class="item" effect="dark" placement="top">
                <span slot = "content">
                  <i class="knocks_icon knocks-user-outline"></i> <static_message msg = "Results from Knocks users"></static_message>
                </span>
                <span>
                  <i class="knocks_icon knocks-user-outline"></i>
                  <span class="uk-badge " v-if = "sidebarSearchResult != null">
                    <span class = "knocks_text_xs">@{{plusNumber(sidebarSearchResult.users.length)}}</span></span>
                  </span>
                  </el-tooltip>
                </span>
                                 <center v-if = "sidebarSearchResult == null ||  sidebarSearchResult.users.length == 0">
                  <span class = "knocks-alert-circle knocks_text_ms"></span>
                  <static_message msg = "No users matches your search." classes = "knocks_fair_bounds knocks_text_ms"></static_message>
                  </center>
                <transition   enter-active-class = "animated slideInUp" leave-active-class = "animated slideOutLeft">
                  <div>
                      <div class = "row"  v-for = "(user,index) in sidebarSearchResult.users" :key = "index" v-if="inSidebarUserRange(index)" >
                        <knocksuser as_result :user ="user" show_accept_shortcut ></knocksuser>
                      </div>

                    <div  v-if="sidebarSearchResult != null && sidebarSearchResult.users.length > 3">
                    <a v-if = "sidebarSearchResult != null && showSidebarUserKey < sidebarSearchResult.users.length"
                       @click = "submitSearch()"
                       class = " knocks_side_padding knocks_text_anchor knocks_pointer" >
                      <span class = "knocks-user-outline"></span> See More
                    </a>
                    </div></div>

                </transition>
                </el-tab-pane>
                <el-tab-pane name = "knock">
                <span slot="label">
                  <el-tooltip class="item" effect="dark" placement="top">
                  <span slot = "content">
                    <i class="knocks_icon knocks-newspaper5"></i> <static_message msg = "Results from people's knocks"></static_message>
                  </span>
                  <span>
                    <i class="knocks_icon knocks-newspaper5"></i>
                    <span class="uk-badge knocks_xs_padding" v-if = "sidebarSearchResult != null">
                      <span class = "knocks_text_xs">@{{plusNumber(sidebarSearchResult.knock.length)}}</span></span>
                    </span>
                    </el-tooltip>
                  </span>
                                   <center v-if = "sidebarSearchResult == null ||  sidebarSearchResult.knock.length == 0">
                  <span class = "knocks-alert-circle knocks_text_ms"></span>
                  <static_message msg = "No Knocks matches your search." classes = "knocks_fair_bounds knocks_text_ms"></static_message>
                  </center>
                  <transition enter-active-class = "animated slideInUp" leave-active-class = "animated slideOutLeft">
                    <div>
                        <div class = "row"  v-for = "(knock , index) in sidebarSearchResult.knock" :key = "index" v-if="inSidebarKnockRange(index)" >

                          <knocksknock  :knock = "knock" :gid="'knock_side_search_result_'+index" as_shortcut
                          :current_user = "{{auth()->user()->id}}" replier_message = "Leave a comment" ></knocksknock>
                        </div>

                      <div  v-if="sidebarSearchResult != null && sidebarSearchResult.knock.length > 3">
                      <a v-if = "sidebarSearchResult != null && showSidebarKnockKey < sidebarSearchResult.knock.length"
                      @click = "submitSearch()"
                         class = " knocks_side_padding knocks_text_anchor knocks_pointer" >
                        <span class = "knocks-newspaper5 "></span> See More
                      </a>
                      </div></div>
                  </transition>
                  </el-tab-pane>
                  <el-tab-pane name = "groups">
                  <span slot="label">
                    <el-tooltip class="item" effect="dark" placement="top">
                    <span slot = "content">
                      <i class="knocks_icon knocks-group2"></i> <static_message msg = "Results from people's groups"></static_message>
                    </span>
                    <span>
                      <i class="knocks_icon knocks-group2"></i>
                      <span class="uk-badge knocks_xs_padding" v-if = "sidebarSearchResult != null">
                        <span class = "knocks_text_xs">@{{plusNumber(sidebarSearchResult.groups.length)}}</span>
                      </span>
                    </span>
                    </el-tooltip>
                  </span>
                  <center v-if = "sidebarSearchResult == null ||  sidebarSearchResult.groups.length == 0">
                  <span class = "knocks-alert-circle knocks_text_ms"></span>
                  <static_message msg = "No Groups matches your search." classes = "knocks_fair_bounds knocks_text_ms"></static_message>
                  </center>
                  <transition enter-active-class = "animated slideInUp" leave-active-class = "animated slideOutLeft">
                    <div>
                        <div class = "row" v-for = "(groups , index) in sidebarSearchResult.groups" :key = "index" v-if="inSidebarGroupRange(index)" >

                      <knocksgroupshortcut as_result :group_id ="groups"></knocksgroupshortcut>

                        </div>

                      <div  v-if="sidebarSearchResult != null && sidebarSearchResult.groups.length > 3">
                      <a v-if = "sidebarSearchResult != null && showSidebarGroupKey < sidebarSearchResult.groups.length"
                      @click = "submitSearch()"

                         class = " knocks_side_padding knocks_text_anchor knocks_pointer" >
                        <span class = "knocks-group2 center"></span> See More
                      </a>
                      </div></div>
                  </transition>
                  </el-tab-pane>
                  </el-tabs>
                </div>
              </transition>
            </div>
          {{-- </transition> --}}
        </div>
      </div>
    </div>
    <div id = "sidebar_contents" :class = "{'animated slideOutUp' : sidebarSearchFocus}">
    <div class = "row">
      <ul id = "knocks_sidebar_list" class = "l10 push-l1 s10 push-l1">
         <el-menu default-active="2" class="el-menu-vertical-demo" >
      <el-submenu index="1">
        <template slot="title">
          <i class="el-icon-location"></i>
<i class="knocks-group2 knocks_text_dark"></i>
          <span> My Groups</span>

        </template>
        <el-menu-item-group>

            <knocksgroupslist></knocksgroupslist>

        </el-menu-item-group>
        <el-menu-item-group title="Group Two">
          <el-menu-item index="1-3">item three</el-menu-item>
        </el-menu-item-group>
        <el-submenu index="1-4">
          <template slot="title">item four</template>
          <el-menu-item index="1-4-1">item one</el-menu-item>
        </el-submenu>
      </el-submenu>
      <el-menu-item index="2">
        <i class="el-icon-menu"></i>
        <span>Navigator Two</span>
      </el-menu-item>
      <el-menu-item index="3">
        <i class="el-icon-setting"></i>
        <span>Navigator Three</span>
      </el-menu-item>
    </el-menu>

      </ul>
    </div>
  </div>
  </ul>
