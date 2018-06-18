<div class = "row" id = "sidebar_search_group_holder">
        {{--     <knocksinput
        placeholder="search"
        gid = "sidebar_search_box"
        icon_class = "teal-text lighten-3"
        knocksclass="knocks_teal_input" icon = "knocks-search12" ></knocksinput> --}}
        <form action = "{{asset('app/search')}}" method="get" id = "knocks_sidebar_search_form">
          <knockselinput
          class = "knocks_tinny_top_padding knocks_side_padding"
          name = "q"
          placeholder="Search"
          has_slot
          inner_placeholder
          autocomplete
          autocomplete_from = "search/main/sc"
          @control = "sidebarSearchControllers = $event"
          @autocomplete = "searchTypingResults = $event"
          @focus = "sidebarFocus()"
          @blur = "searchBlur()"
          @input = "searchTypingMode = true"
          id="sidebar_search_box"
          v-model="sidebarSearch" class="input-with-select">
          <knocksvoicerecognition v-model = "sidebarSearchRecognition" :lang = "sideBarSearchLanguage" @recognition = "runVoiceSearch($event)" @leave="sidebarFocus()" slot = "labelside"></knocksvoicerecognition>
          <el-button native-type ="submit" slot="aside" icon=" knocks_icon knocks-search2"></el-button>
          </knockselinput>
          <input type = "hidden" name = "t" :value = "sidebarSearchTaps"/>
        </form>
        <div style = "display : none" id = "sidebar_search_results">
          <div class = "row knocks_side_padding knocks_tinny_top_padding">
            <el-button  circle id ="sidebar_search_back" type="danger" icon=" knocks_icon knocks-chevron-left2" class = ""></el-button>
            <div class = "right">
              <el-select v-model="sideBarSearchLanguage" slot="prepend"  style = "width :110px !important">
              <el-option label = "English" value = "en"></el-option>
              <el-option label = "العربيه" value = "ar-sa"></el-option>
              </el-select>
              <span class = "knocks-globe9 blue-text knocks_text_md"></span>
            </div>
            <transition enter-active-class = "animated bounceInLeft" leave-active-class = "animated bounceOutRight">
              <div v-if = "sidebarSearchRecognition.loading" class = "animated bounceInLeft">
                <div class="ui active inline loader"></div>
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
            <transition enter-active-class = "animated bounceInLeft" leave-active-class = "animated bounceOutUp">
              <div v-if = "sidebarSeachLoading" class = "">
                <a class = "btn btn-floating pulse  cyan lighten-5">
                  <div class="ui active tiny inline loader"></div>
                </a>
                <static_message msg = "Loading.." classes = "red-text"></static_message>
              </div>
            </transition>
          </div>
          <transition enter-active-class = "animated zoomIn" leave-active-class = "animated zoomOut">
            <div class = "row knocks_xs_padding" v-if = "searchTypingResults.length != 0 && searchTypingMode">
              <ul class = "uk-list uk-list-divider" >
                <li v-for = "query in searchTypingResults" @click = "updateSearchQuery(query.c)" class = "knocks_gray_hover">
                  <span :class = "[
                  {'knocks-newspaper5' : query.t == 'knock'},
                  {'knocks-user-outline' : query.t == 'user'},
                  {'knocks-group2' : query.t == 'group'}]"></span>
                  <knockstextlenhandler :body = "query.c" :len = "20"></knockstextlenhandler>
                  <span class = "knocks-arrow-up-left2 right knocks_text_ms knocks_mp_top_margin animated slideInLeft" ></span>
                </li>
              </ul>
            </div>
          </transition>
          <transition enter-active-class = "animated zoomIn" leave-active-class = "animated zoomOut">
            <div class = "row knocks_house_keeper" v-if = "sidebarSearchResult != null && !searchTypingMode">
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
                          <knocksknock  :knock = "knock" :gid="'knock_side_search_result_'+index" as_shortcut no_reactor
                          :current_user = "{{auth()->check() ? auth()->user()->id : -1}}" replier_message = "Leave a comment" ></knocksknock>
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
                          <i class="knocks_icon knocks-team"></i> <static_message msg = "Results from people's groups"></static_message>
                        </span>
                        <span>
                          <i class="knocks_icon knocks-team"></i>
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