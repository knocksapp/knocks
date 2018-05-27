<template>
<div>
  <!-- Lazy Retriver Begins ========================================================================-->
  <knocksretriver
  :xdata = "{ q : user }"
  v-model=  "lazyRetriver"
  v-if = "lazy_user"
  @success="saveLazySource($event.response)"
  url = "user/info/lazy"></knocksretriver>
  <!-- Lazy Retriver Ends =============================================================================-->
  <!-- Regular Retriver Begins ========================================================================-->
  <knocksretriver
  :xdata = "{ q : user }"
  v-model=  "regularRetriver"
  v-if = "!lazy_user"
  prevent_on_mount
  :scope = "['regular_user_retriver' , 'user_retriver_'+user]"
  @success="initialize($event.response)"
  url = "user/info"></knocksretriver>
  <!-- Regular Retriver Ends ============================================================================-->
  <div v-if = "regularRetriver != null || lazyRetriver != null" >
    <knocksloaderbar class = "col s12 animated fadeIn" v-if = "regularRetriver.loading"></knocksloaderbar>
    <knocksloaderbar class = "col s10 animated fadeIn" v-if = "regularRetriver.loading"></knocksloaderbar>
    <!-- Popover Begins =================================================================================-->
    <el-popover
    v-if = "!hide_popover && userObject != null"
    ref="userpopover"
    width = "400"
    placement="top-start"
    @show = "updateBalloonsTimer()"
    @hide="runBalloonsTimer()"
    popper-class = "knocks_house_keeper"
    trigger="hover">
    <div class = "row knocks_house_keeper">
      <div class = "col s4 knocks_house_keeper">
        <knocksimg :src = "asset('media/avatar/compressed/'+user)" :classes = "[{'knocks_user_profile_scope' : thatsMe}]"></knocksimg>
      </div>
      <div class = "col s8 knocks_house_keeper">
        <div class = "row knocks_text_dark">
          <div class = "col s12">
            <span  :href = "userUrl"  v-if="userObject"  > {{ displayName }}</span>
          </div>
          <div class = "col s12">
            <a  :href = "userUrl" v-if="userObject != null && show_username"> {{'@'+userObject.username}} </a>
          </div>
        </div>
        <div class = "row knocks_text_dark">
          <div class = "col s12" style="margin-top : -10px;">
            <span class = "knocks-user4"></span>
            <span v-if ="userObject.first_name != null && userObject.first_name != undefined" >{{userObject.first_name}} </span>
            <span v-if ="userObject.middle_name != null && userObject.middle_name != undefined" >{{userObject.middle_name}} </span>
            <span v-if ="userObject.last_name != null && userObject.last != undefined" >{{userObject.last_name}} </span>
          </div>
          <div class = "col s12" v-if ="userObject.gender != null && userObject.gender != undefined && userObject.gender.toLowerCase() == 'male'" >
            <span class = "knocks-male2"></span><span><static_message msg = "Male"></static_message></span>
          </div>
          <div class = "col s12" v-if ="userObject.gender != null && userObject.gender != undefined && userObject.gender.toLowerCase() == 'female'" >
            <span class = "knocks-female2"></span><span><static_message msg = "Female"></static_message></span>
          </div>
          <div class = "col s12" v-if ="userObject.birthdate != null && userObject.birthdate != undefined" >
            <span class = "knocks-birthday-cake"></span> <span> {{ birthDate(userObject.birthdate) }}</span>
          </div>
          <div class = "col s12" v-if ="userObject.email != null && userObject.email != undefined" >
            <span class = "knocks-email3"></span> <span> {{ userObject.email }}</span>
          </div>
        </div>
        <div class = "col s12">
          <div class = "col s12 knocks_house_keeper">
            <center>
            <knocksuseractions
            
            style = "margin-top : 3px;"
            :user = "user"
            extended
            :start_as ="userObject" :extras="{hover_id : 'user_report_'+user}"></knocksuseractions></center>
          </div>
        </div>
      </div>
    </div>
    </el-popover>
    <!-- Popover Ends =======================================================================================-->
    <!-- Default Presentation Begins ========================================================================-->
    <div v-if = "onDefaultView && userObject != null" :class = "[main_container]">
      <div v-if = "!hide_popover">
        <knocksimg  v-popover:userpopover
        :src = "asset('media/avatar/compressed/'+user)" :classes = "[knocks_avatar_classes, {'knocks_user_profile_scope' : thatsMe}]" v-if = "!hide_image">
        </knocksimg>
        <div :class = "name_container_class" class="" v-if ="!hide_text_info">
          <a :class = "name_class" :href = "userUrl" v-popover:userpopover v-if="userObject && !hide_name"> {{ displayName }}</a>
          <slot name = "append_to_display_name"></slot>
          <br/>
          <a :class = "username_class" v-popover:userpopover :href = "userUrl" v-if="userObject != null && show_username" style = "display:block"> {{'@'+userObject.username}} </a>
        </div>
      </div>
      <div v-else>
        <knocksimg :src = "asset('media/avatar/compressed/'+user)" :classes = "[knocks_avatar_classes, {'knocks_user_profile_scope' : thatsMe}]" v-if = "!hide_image">
        </knocksimg>
        <div :class = "name_container_class" class="" v-if ="!hide_text_info">
          <a :class = "name_class" :href = "userUrl"  v-if="userObject && !hide_name"> {{ displayName }}</a><slot name = "append_to_display_name"></slot><br/>
          <a :class = "username_class" :href = "userUrl" v-if="userObject != null && show_username" style = "display:block"> {{'@'+userObject.username}} </a>
        </div>
      </div>
    </div>
    <!--Default Presentation Ends ========================================================================-->
    <!--Chips Presentation Begins ========================================================================-->
    <div class="chip" :class="main_container" contenteditable="false" v-if="as_chip">
      <knocksimg :src = "asset('media/avatar/compressed/'+user)" :classes = "{'knocks_user_profile_scope' : thatsMe}" ></knocksimg>
      <span :class = "name_class" :href = "userUrl"  v-if="userObject && !hide_text_info"  >
        <el-tooltip :content = "displayName" placement="bottom-start">
        <span> {{handledDisplayName}} </span>
        </el-tooltip>
      </span>
      <slot name = "append"></slot>
    </div>
    <!--Chips Presentation Ends ========================================================================-->
    <!--Card Presentation Begins ========================================================================-->
    <div class="ui special cards" v-if = "as_card" v-loading = "regularRetriver.loading" element-loading-spinner="el-icon-loading"
      element-loading-background="rgba(0, 0, 0, 0.8)">
      <div class="card">
        <div class="blurring dimmable image">
          <div class="ui inverted dimmer">
            <div class="content" v-if = "userObject != null">
              <div class="center">
                <knocksuseractions
                style = "margin-top : 3px;"
                :user = "user"
                @add = "$emit('add')"
                class = "knocks_house_keeper"
                extended
                :start_as ="userObject" :extras="{hover_id : 'user_report_'+user}"></knocksuseractions>
              </div>
            </div>
          </div>
          <knocksimg
          @clicked = "tinnyHeight = !tinnyHeight"
          :class = "{ 'knocks_avatar_card_tinny_height' : tinnyHeight}"
          v-if = "userObject != null" :src = "asset('media/avatar/compressed/'+user)" :classes = "{'knocks_user_profile_scope' : thatsMe}" ></knocksimg>
        </div>
        <div class="content" v-if = "userObject != null">
          <a :class = "[name_class , 'header']" :href = "userUrl"  v-if="userObject && !hide_name">
            <el-tooltip :content = "displayName" placement="bottom-start">
            <span> {{handledDisplayName}} </span>
            </el-tooltip>
            
          </a><slot name = "append_to_display_name"></slot>
          <a :class = "[username_class , 'header']" :href = "userUrl" v-if="userObject != null && show_username" style = "display:block"> {{'@'+userObject.username}} </a>
          <p v-if = "!thatsMe && userObject != null && userObject.common_people !== undefined && userObject.common_people.length > 0">
            <small>{{userObject.common_people.length}} <static_message msg = "Common People"></static_message></small>
          </p>
          <div class="meta">
            <knockscollapse title = "More" icon = "knocks-circle5" regular_class = "grey-text" toggler_container = "knocks_house_keeper transparent row">
            <div slot = "content">
              <hr class="uk-divider-icon">
              <div class = "col s12" >
                <span class = "knocks-user4"></span>
                <span v-if ="userObject.first_name != null && userObject.first_name != undefined" >{{userObject.first_name}} </span>
                <span v-if ="userObject.middle_name != null && userObject.middle_name != undefined" >{{userObject.middle_name}} </span>
                <span v-if ="userObject.last_name != null && userObject.last != undefined" >{{userObject.last_name}} </span>
              </div>
              <knocksaddressviewer class = "col s12"
              :address = "address"
              v-for = "(address,index) in userObject.addresses"
              :key = "index"
              v-if = "userObject.addresses">
              </knocksaddressviewer>
              <div class = "col s12" v-if ="userObject.gender != null && userObject.gender != undefined && userObject.gender.toLowerCase() == 'male'" >
                <span class = "knocks-male2"></span><span><static_message msg = "Male"></static_message></span>
              </div>
              <div class = "col s12" v-if ="userObject.gender != null && userObject.gender != undefined && userObject.gender.toLowerCase() == 'female'" >
                <span class = "knocks-female2"></span><span><static_message msg = "Female"></static_message></span>
              </div>
              <div class = "col s12" v-if ="userObject.birthdate != null && userObject.birthdate != undefined" >
                <span class = "knocks-birthday-cake"></span> <span> {{ birthDate(userObject.birthdate) }}</span>
              </div>
              <div class = "col s12" v-if ="userObject.email != null && userObject.email != undefined" >
                <span class = "knocks-email3"></span> <span> {{ userObject.email }}</span>
              </div>
              <knockscollapse
              title = "Common People"
              regular_class = "grey-text"
              v-if = "!thatsMe && userObject != null && userObject.common_people !== undefined && userObject.common_people.length > 0"
              icon = "knocks-group2">
              <div class= 'knocks_house_keeper' slot = "content">
                <knocksshowkeys
                :show_input = "userObject.common_people"
                :as_label = "false" as_chip
                list_classes="col s12 knocks_gray_border knocks_xs_padding   knocks_tinny_border_radius"></knocksshowkeys>
              </div>
              </knockscollapse>
            </div>
            </knockscollapse>
          </div>
        </div>
        <div class="extra content">
          <center>
          <knocksuseractions
          add_remove_only
          v-if = "userObject != null"
          style = "margin-top : 3px;"
          :user = "user"
          extended
          @add = "$emit('add')"
          :start_as ="userObject" :extras="{hover_id : 'user_report_'+user}"></knocksuseractions></center>
        </div>
      </div>
    </div>
    <!--Card Presentation Ends ==================================================================================-->
    <!--Small Card Presentation Begins ==========================================================================-->
    <div class="card small" v-if = "as_small_card && userObject != null" >
      <div class="card-image waves-effect waves-block waves-light">
        <knocksimg :src = "asset('media/avatar/compressed/'+user)" style ="top: -40px !important;" :classes = "[{'knocks_user_profile_scope' : thatsMe} , 'activator']" ></knocksimg>
      </div>
      <div class="card-content knocks_tinny_side_padding" style="max-height: unset !important;">
        <span class="card-title activator grey-text text-darken-4" style="display: block !important; line-height: inherit !important; margin-bottom: 0px !important;">
          <a :class = "[ 'knocks_text_xs knocks_text_anchor header']" :href = "userUrl"  v-if="userObject && !hide_name"> {{ displayName }}</a><slot name = "append_to_display_name"></slot>
          <i class="knocks-circle5 right"></i>
          <small
          v-if = "!thatsMe && userObject != null && userObject.common_people !== undefined && userObject.common_people.length > 0"
          class = 'grey-text knocks_text_xs knocks_house_keeper'
          style="display : block">
          <small>{{userObject.common_people.length}} <static_message msg = "Common People"></static_message></small>
          </small>
        </span>
        <p>
          <center>
          <knocksuseractions
          add_remove_only
          style = "margin-top : 3px;"
          :user = "user"
          extended
        :start_as ="userObject" :extras="{hover_id : 'user_report_'+user}"></knocksuseractions></center></p>
      </div>
      <div class="card-reveal knocks_house_keeper">
        <img :src = "userObject.compressedCoverUrl" style = "position :absolute; z-index : -1;left: 0;" :class = "[{'knocks_user_cover_scope' : thatsMe} , 'col s12 knocks_house_keeper knocks_blured_bgimg_1']" >
        <div class = "knocks_white_dark_blured_bg row ">
          <span class="card-title grey-text text-darken-4">
            <a :class = "[name_class , 'header']" :href = "userUrl"  v-if="userObject && !hide_name"> {{ displayName }}</a>
          <i class="knocks-close right"></i></span>
          <p>
            <div class = "col s12" >
              <span class = "knocks-user4"></span>
              <span v-if ="userObject.first_name != null && userObject.first_name != undefined" >{{userObject.first_name}} </span>
              <span v-if ="userObject.middle_name != null && userObject.middle_name != undefined" >{{userObject.middle_name}} </span>
              <span v-if ="userObject.last_name != null && userObject.last != undefined" >{{userObject.last_name}} </span>
            </div>
            <knocksaddressviewer class = "col s12"
            :address = "address"
            v-for = "(address,index) in userObject.addresses"
            :key = "index"
            v-if = "userObject.addresses">
            </knocksaddressviewer>
            <div class = "col s12" v-if ="userObject.gender != null && userObject.gender != undefined && userObject.gender.toLowerCase() == 'male'" >
              <span class = "knocks-male2"></span><span><static_message msg = "Male"></static_message></span>
            </div>
            <div class = "col s12" v-if ="userObject.gender != null && userObject.gender != undefined && userObject.gender.toLowerCase() == 'female'" >
              <span class = "knocks-female2"></span><span><static_message msg = "Female"></static_message></span>
            </div>
            <div class = "col s12" v-if ="userObject.birthdate != null && userObject.birthdate != undefined" >
              <span class = "knocks-birthday-cake"></span> <span> {{ birthDate(userObject.birthdate) }}</span>
            </div>
            <div class = "col s12" v-if ="userObject.email != null && userObject.email != undefined" >
              <span class = "knocks-email3"></span> <span> {{ userObject.email }}</span>
            </div>
            <div class="col s12">
              <knockscollapse
              title = "Common People"
              regular_class = "grey-text"
              v-if = "!thatsMe && userObject != null && userObject.common_people !== undefined && userObject.common_people.length > 0"
              icon = "knocks-group2">
              <div class= 'knocks_house_keeper' slot = "content">
                <knocksshowkeys
                :show_input = "userObject.common_people"
                :as_label = "false" as_chip
                list_classes="col s12 knocks_gray_border knocks_xs_padding   knocks_tinny_border_radius"></knocksshowkeys>
              </div>
              </knockscollapse>
            </div>
            <div class= "col s12">
              <center>
              <hr class="uk-divider-icon"/>
              <knocksuseractions
              :user = "user"
              extended
              :start_as ="userObject" :extras="{hover_id : 'user_report_'+user}"></knocksuseractions></center>
            </div>
          </p>
        </div>
      </div>
    </div>
    <!--Small Card Presentation Ends ==========================================================================-->
    <!--Label Presentation Begins =============================================================================-->
    <a class="ui image label"  contenteditable="false" v-if="as_label" :class = "label_classes" :href = "userUrl">
      <knocksimg :src = "asset('media/avatar/compressed/'+user)" :classes = "{'knocks_user_profile_scope' : thatsMe}" ></knocksimg>
      <el-tooltip :content = "displayName" placement="bottom-start">
      <span> {{handledDisplayName}} </span>
      </el-tooltip>
      <slot name = "append"></slot>
    </a>
    <!--Label Presentation Ends ========================================================================-->
    <!--Report Presentation Begins =====================================================================-->
    <div  :class="main_container" contenteditable="false" v-if="as_report && userObject != null">
      <div class = "row knocks_house_keeper knocks_text_dark">
        <!-- <div class = "col s12">
          <span class = "knocks-user14" v-if ="userObject.gender != null && userObject.gender != undefined && userObject.gender.toLowerCase() == 'female'" ></span>
          <span class = "knocks-user12" v-if ="userObject.gender != null && userObject.gender != undefined && userObject.gender.toLowerCase() == 'male'" ></span>
          <span class = "knocks-user-outline"  v-if ="userObject.gender == null || userObject.gender == undefined "></span>
          <static_message msg = "Name : "></static_message>
          <span v-if ="userObject.first_name != null && userObject.first_name != undefined" >{{userObject.first_name}} </span>
          <span v-if ="userObject.middle_name != null && userObject.middle_name != undefined" >{{userObject.middle_name}} </span>
          <span v-if ="userObject.last_name != null && userObject.last_name != undefined" >{{userObject.last_name}} </span>
        </div> -->
        <div class = "col s12">
          <div class = "col s12 knocks_house_keeper" v-if = "!thatsMe">
            <center>
            <knocksuseractions
            class = "knocks_tinny_bounds knocks_tinny_border_radius grey lighten-3 knocks_gray_border"
            style = "margin-top : 3px;"
            :user = "user"
            extended
            :start_as ="userObject" :extras="{hover_id : 'user_report_'+user}"></knocksuseractions></center>
          </div>
          <span class = "knocks-user14" v-if ="userObject.gender != null && userObject.gender != undefined && userObject.gender.toLowerCase() == 'female'" ></span>
          <span class = "knocks-user12" v-if ="userObject.gender != null && userObject.gender != undefined && userObject.gender.toLowerCase() == 'male'" ></span>
          <span class = "knocks-user-outline"  v-if ="userObject.gender == null || userObject.gender == undefined "></span>
          <static_message msg = "UserName : "></static_message>
          <span v-if ="userObject.username != null && userObject.username != undefined" >{{userObject.username}} </span>
        </div>
        <knocksaddressviewer class = "col s12"
        :address = "address"
        v-for = "(address,index) in userObject.addresses"
        :key = "index"
        v-if = "userObject.addresses">
        </knocksaddressviewer>
        <div class = "col s12" v-if ="userObject.gender != null && userObject.gender != undefined && userObject.gender.toLowerCase() == 'male'" >
          <span class = "knocks-male2"></span><span><static_message msg = "Male"></static_message></span>
        </div>
        <div class = "col s12" v-if ="userObject.gender != null && userObject.gender != undefined && userObject.gender.toLowerCase() == 'female'" >
          <span class = "knocks-female2"></span><span><static_message msg = "Female"></static_message></span>
        </div>
        <div class = "col s12" v-if ="userObject.birthdate != null && userObject.birthdate != undefined" >
          <span class = "knocks-birthday-cake"></span>
          <static_message msg = "Birthdate : "></static_message>
          <span> {{ birthDate(userObject.birthdate) }}</span>
        </div>
        <div class = "col s12" v-if ="userObject.email != null && userObject.email != undefined" >
          <span class = "knocks-email3"></span>
          <static_message msg = "Email : "></static_message>
          <span> {{ userObject.email }}</span>
        </div>
      </div>
    </div>
    <!--Report Presentation Ends =======================================================================-->
    <!--Name Presentation Begins =======================================================================-->
    <div v-if = "userObject != null && as_name">
      <div v-if = "!hide_popover">
        <span  v-popover:userpopover :class = "main_container">
          <span :class = "name_class" :href = "userUrl"  v-if="userObject && !hide_name"> {{ displayName }}</span>
          <slot name = "append_to_display_name"></slot>
        </span>
      </div>
      <div v-else>
        <span  :class = "main_container">
          <span :class = "name_class" :href = "userUrl"  v-if="userObject && !hide_name"> {{ displayName }}</span>
          <slot name = "append_to_display_name"></slot>
        </span>
      </div>
    </div>
    <!--Name Presentation Ends =======================================================================-->
    <!--URL Presentation Begins =======================================================================-->
    <div v-if = "userObject != null && as_url">
      <a v-if = "!hide_popover" :href = "userUrl">
        <span  v-popover:userpopover :class = "main_container">
          <span :class = "name_class" :href = "userUrl"  v-if="userObject && !hide_name"> {{ displayName }}</span>
          <slot name = "append_to_display_name"></slot>
        </span>
      </a>
      <a v-else :href = "userUrl">
        <span  :class = "main_container">
          <span :class = "name_class" :href = "userUrl"  v-if="userObject && !hide_name"> {{ displayName }}</span>
          <slot name = "append_to_display_name"></slot>
        </span>
      </a>
    </div>
    <!--URL Presentation ENDS =========================================================================-->
    <!--Result Presentation Begins ===================================================================-->
    <div v-if = "as_result && userObject != null">
      <div :class = "main_container">
        <knocksimg :src = "asset('media/avatar/compressed/'+user)" :classes = "[knocks_avatar_classes,{'knocks_user_profile_scope' : thatsMe}]"></knocksimg>
        <div class = "">
          <div  class="">
            <div class = "col" v-if = "!hide_text_info">
              <a :class = "name_class" :href = "userUrl"  v-if="userObject && !hide_name"> {{ displayName }}</a><slot name = "append_to_display_name"></slot><br/>
              <a :class = "username_class" :href = "userUrl" v-if="userObject != null && show_username" style = "display:flex"> {{'@'+userObject.username}} </a>
              <slot name = "append_to_name"></slot>
            </div>
            <div :class = "user_actions_container">
              <knocksuseractions v-if = "show_accept_shortcut"
              :extras = "extras"
              :user="user"
              :extended = "extended"
              :start_as = "userObject"
              :show_accept_shortcut = "show_accept_shortcut">
              </knocksuseractions>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--Name Presentation Begins =======================================================================-->
    <!--CallBack Presentation Begins ===================================================================-->
    <div v-if = "as_callback && userObject != null" class = "row knocks_house_keeper" :class = "[callback_container]">
      <a @click = "emitClick()" :class = "[main_container]">
        <knocksimg :src = "asset('media/avatar/compressed/'+user)" :classes = "[knocks_avatar_classes,{'knocks_user_profile_scope' : thatsMe}]"></knocksimg>
        <span :class ="[name_class]" >{{ displayName }}</span>
        <slot name = "append"></slot>
        <span v-if = "userObject.chatStatus && !clashProp" class="right uk-badge" :class = "[{'red' : !calcStatus} , {'green' : calcStatus}]">{{userObject.chatStatus}}
        </span>
        <slot name = "preppend"></slot>
      </a>
    </div>
    <!--CallBack Presentation Ends =====================================================================-->
  </div>
</div>
</template>
<script>
export default {
  name: 'knocksusershortcut',
  props : {
    user : {
      type : Number ,
      required : true ,
    } ,
    lazy_user : {
      type : Boolean ,
      default : false ,
    },
    callback_container : {
      type : String ,
      default : 'knocks_gray_on_hover knocks_standard_border_radius'
    },
    image_container_class : {
      type : String ,
      default : 'col s3'
    },
    name_container_class : {
      type : String ,
      default : 'col s9'
    },
    main_container : {
       type : String ,
       default : 'row'
    },
    name_class : {
      type : String ,
      default : 'knocks_text_anchor  knocks_text_bold knocks_tinny_side_padding'
    },
    username_class : {
      type : String ,
      default : 'knocks_text_xs knocks_text_bold knocks_tinny_side_padding'
    },
    label_classes : {
      type : [Array , Object , String ],
      default : 'blue knocks_inline'
    },
    knocks_avatar_classes : {
      type : String ,
      default : 'knocks_avatar knocks_house_keeper col '
    },
    user_actions_container : {
      type : String ,
      default : 'right'
    },
    show_image : {
      type : Boolean ,
      default : true
    } ,
    show_username : {
      type : Boolean ,
      default : true
    } ,
    show_accept_shortcut : {
      type : Boolean ,
      default : true
    },
    hide_username : {
      type : Boolean ,
      default : false
    },
    hide_name : {
      type : Boolean ,
      default : false
    },
    hide_text_info : {
      type : Boolean ,
      default : false
    },
    hide_popover : {
      type : Boolean ,
      default : false ,
    },
    hide_image : {
      type : Boolean ,
      default : false ,
    },
    as_chip : {
      type : Boolean ,
      default : false
    },
    as_result : {
      type : Boolean ,
      default :  false
    },
    as_report : {
      type : Boolean ,
      default :  false
    },
    as_name : {
      type : Boolean ,
      default : false ,
    },
    as_callback : {
      type : Boolean ,
      default : false ,
    },
    as_url : {
      type : Boolean ,
      default : false
    },
    as_label : {
      type : Boolean ,
      default : false ,
    },
    as_card : {
      type : Boolean , 
      default : false
    },
    as_small_card : {
      type : Boolean , 
      default : false
    },
    no_rebound : {
      type : Boolean , 
      default : false
    },
    extended : {
      type : Boolean , 
      default : false
    },
    extras : {
      type : Object ,
      default : null,
    },
  },
  data () {
    return {
      lazyRetriver : null ,
      regularRetriver : null ,
      userObject : null ,
      displayName : '' ,
      userUrl : '#' ,
      fullName : '' ,
      clashProp : false ,
      calcStatus : false ,
      tinnyHeight : true ,
      handledDisplayName : '' ,
    }
  },
  mounted(){
    if(!this.isKnown() || this.no_rebound){
      App.$emit('knocksRetriver' , { scope : ['user_retriver_'+this.user] } );
    }else this.initialize(window.UsersObject[this.user]);
    //Reacting on events
        const vm = this;
    //Update data globally
    App.$on('knocksUserDataUpdated' , (payloads)=>{
      if(payloads.user == vm.user){
        vm.initialize(payloads.update);
      }
    })
    App.$on('KnocksContentChanged' , ()=>{
      if(vm.userObject == null) return;
      setTimeout(()=>{
        if(vm.userObject != null && vm.userObject.id != vm.user){
          if(UsersObject[vm.user] != undefined){
            vm.initialize(window.UsersObject[vm.user]);
          }else {
              vm.userObject = null ;
              App.$emit('knocksRetriver' , { scope : ['user_retriver_'+vm.user] } );
          }
        }
      },300);
    });
    App.$on('knocksUserResetContent' , (id)=>{
      if(id == vm.user){
         vm.initialize(window.UsersObject[vm.user]);
      }
    });
    App.$on('knocksUserReload' , (id)=>{
      if(id == vm.user){
          console.log('reload')
          window.UsersObject[vm.user] = undefined;
          vm.userObject = null;
          console.log('null')
           App.$emit('knocksRetriver' , { scope : ['user_retriver_'+vm.user] })
      }
    });
    App.$on('knocksUserKeyUpdate' , (payloads)=>{
      if(payloads.user == vm.user){
        if(vm.userObject !== null){
        let i ;
        for(i = 0 ; i < payloads.patch.length; i++){
          vm.userObject[payloads.patch[i].key] = payloads.patch[i].value
        }
        vm.initialize(vm.userObject);
      }else{
        vm.holdOnChanges(payloads);
      }
    }
    });
  },
  computed : {
    thatsMe(){
      return this.user == window.UserId ? true : false ;
    },
    onDefaultView(){
       let arr = [
         this.as_chip ,
         this.as_report ,
         this.as_result ,
         this.as_callback ,
         this.as_name ,
         this.as_url ,
         this.as_label ,
         this.as_card , 
         this.as_small_card
       ] , i ;
       for (i = 0; i < arr.length; i++)
        if(arr[i])  return false;
        return true;
    }
  },
  methods : {
    isKnown(){
      return window.UsersObject[this.user] === undefined ? false : true ;
    },
    holdOnChanges(payloads){
      if(payloads === null || payloads == undefined) return;
      if(payloads.patch === undefined) return;
      setTimeout(()=>{
        if(this.userObject !== null){

        let i ;
        for(i = 0 ; i < payloads.patch.length; i++){
          this.userObject[payloads.patch[i].key] = payloads.patch[i].value
        }
        this.initialize(this.userObject);
        }else this.holdOnChanges();
      },500)
    },
    isGlobalyAuth(){
      return window.UserId === undefined || window.UserId === null || window.UserId.length === 0 ? false : true;
    },
    saveLazySource(e){
      return true ;
    },
    initialize(remoteObject){
      this.userObject = null ;
      this.userObject = remoteObject;
      this.getDisplayName();
      this.getFullName();
      this.formatChatStatus();
      this.userUrl = this.asset(this.userObject.username);
      this.userObject.userUrl = this.userUrl;
      this.userObject.compressedAvatarUrl = this.asset('media/avatar/compressed/'+this.user);
      this.userObject.avatarUrl = this.asset('media/avatar/'+this.user);
      this.userObject.coverUrl = this.asset('media/cover/'+this.user);
      this.userObject.compressedCoverUrl = this.asset('media/cover/compressed/'+this.user);
      this.userObject.avatarClasses = this.knocks_avatar_classes;
      this.userObject.name = this.displayName ;
      this.userObject.fullName = this.fullName ;
      this.userObject.thatsMe = this.thatsMe ;
      this.$emit('input' , this.userObject);
      this.$emit('ready' , this.userObject);
      window.UsersObject[this.user] = this.userObject;
      if(this.as_card){
      }

    },
    asset(url){
      return LaravelOrgin + url ;
    },
    getDisplayName(){
      if(!this.userObject) return;
      if(this.userObject.display_name === undefined || this.userObject.display_name.length == 0){
        this.displayName = this.first_name;
        return
      }
      let i, temp = [];
      for(i = 0; i < this.userObject.display_name.length; i++){
        if(this.userObject[ this.userObject.display_name[i] ] !== undefined 
          && this.userObject[ this.userObject.display_name[i] ] !== null
          && this.userObject[ this.userObject.display_name[i] ].length > 0){
          if(this.userObject.display_name[i] == 'nickname' && this.userObject.display_name.length > 1)
            temp.push('('+this.userObject[this.userObject.display_name[i]] + ')')
         else temp.push(this.userObject[this.userObject.display_name[i]])
        }
      }
      if(temp.length == 0){
        this.userObject.display_name = ['first_name' , 'last_name']
        temp.push(this.userObject.first_name)
        temp.push(this.userObject.last_name)
      }
      this.displayName = temp.join(' ');
      this.handledDisplayName = this.displayName.length > 15 ? this.displayName.substr(0,15)+'..' : this.displayName
    },
    getFullName(){
      if(!this.userObject) null;
      let arr = [
      'first_name' ,
      'last_name' ,
      'middle_name' ,
      'nickname' ,
      'username'
      ];
      let i, temp = [];
      for(i = 0; i < arr.length; i++){
        if(this.userObject[ arr[i] ] !== undefined){
          temp.push(this.userObject[arr[i]])
        }
      }
      this.fullName = temp.join(' ');
    },
    birthDate(bd){
      return moment(bd , 'YYYY-MM-DD').format('D MMM YYYY');
    },
    updateBalloonsTimer(){
      if(this.extras != null && this.extras.hover_id != undefined){
        App.$emit('knocksStopBallonTimer' , (this.extras.hover_id));
      }else return;
    },
    runBalloonsTimer(){
      if(this.extras != null && this.extras.hover_id != undefined){
        App.$emit('knocksTurnOnBallonTimer',(this.extras.hover_id));
      }else return;
    },
    formatChatStatus(){
      this.clashProp = true ;
      if(this.userObject == null) this.userObject.chatStatus = '';
      if(this.userObject.status !== undefined && this.userObject.last_seen !== undefined ){
        if(this.status == 'offline'){
          this.clashProp = false ;
           this.userObject.chatStatus  = 'offline';
           return;
        }
        if(this.userObject.status == 'online' && this.userObject.last_seen == null ) {
          this.clashProp = false ;
          this.userObject.chatStatus = ' ';
          return;
        }
        this.clashProp = false ;
        let offset = new Date().getTimezoneOffset();
        let finalDate = moment(this.userObject.last_seen).subtract(offset ,'m');
        if(this.userObject.chatStatus = moment().diff(finalDate , 'minutes') < 3) {
          this.calcStatus = true;
          this.userObject.chatStatus = ' ';
          return;
        }else{
          this.clashProp = false ;
          this.calcStatus = false;
          this.userObject.chatStatus = this.formatLastSeen(finalDate);
        }
      }else this.userObject.chatStatus =  this.userObject.status || 'offline';
    },
    formatLastSeen(d){
      let current = moment();
       if(current.diff(d , 'minutes') < 60) return  current.diff(d , 'minutes') + 'M';
      if(current.diff(d , 'hours') < 24) return  current.diff(d , 'hours') + 'H';
      if(current.diff(d , 'days') < 30) return  current.diff(d , 'days') + 'D';
      if(current.diff(d , 'months') < 12) return  current.diff(d , 'months') + 'MTH';
     return  current.diff(d , 'years') + 'Y';
    },
    emitClick(){ this.$emit('callback_click') ; } ,
  }
}
</script>
<style lang="css" scoped>
.knocks_avatar_card_tinny_height{
  height : 100px !important;
  width : 100px !important;
}
.card.small {
    height: 320px;
}
</style>
