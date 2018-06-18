<template>
<div>
  <!--Retrivers -->
  <div>
    <knocksretriver
    v-if = "knockObject != null && is_auth"
    url = "object/hide"
    :xdata = "{ object : knockObject.object_id }"
    prevent_on_mount
    @success = "confirmHide($event)"
    :scope = "['knock_ignore_'+gid]"></knocksretriver>
    <knocksretriver
    v-if = "knockObject != null && is_auth"
    url = "knock/delete"
    :xdata = "{ knock : knockObject.id }"
    prevent_on_mount
    @success = "confirmDelete($event)"
    :scope = "['knock_delete_'+gid]"></knocksretriver>
    <knocksretriver
    v-model = "mainRetriver"
    url = "retrive_knock"
    :xdata = "{knock : knock}"
    @progress = "isLoading = true"
    prevent_on_mount
    @success = "init($event.response)"></knocksretriver>
  </div>
  <div v-if = "knockObject != null || isLoading">
    <transition    name="custom-classes-transition" enter-active-class="animated fadeIn" leave-active-class="animated fadeOut">
      <div class=" ":class = "[
        {'knocks_color_kit_light knocks_gray_border knocks_standard_border_radius panel' : !as_shortcut && ownerObject != null && !ownerObject.kid} ,
        {'knocks_baby_blue knocks_pink_border knocks_standard_border_radius panel' : !as_shortcut && ownerObject != null && ownerObject.kid}
        ]">
        <transition    name="custom-classes-transition"  enter-active-class="animated fadeIn" leave-active-class="animated fadeOut">
          
          <center><knocksloader :gid= "gid+'_knock_loading_span'" v-if = "isLoading" ></knocksloader></center>
        </transition>
        <div v-if = "knockObject != null && knock_type == 'normal' && !as_shortcut" class=" panel knocks_color_kit_light ">
          <knocksuser  @blocked = "explode()" image_container_class = "knocks_inline" name_container_class = " knocks_inline" :user="knockObject.user_id" show_image>
          </knocksuser>
          <div class="knocks_text_dark content " :id = "gid" @dblclick = "flowtext()"></div>
          <p class="right knocks_text_dark">{{knockObject.time}}</p>
        </div>
        <transition enter-active-class="animated fadeIn" leave-active-class="animated fadeOut">
          <div v-if="knockObject != null && knock_type == 'voice_note'  && !as_shortcut && !hiddenNow"  @mouseover = "tickSeen()">
            <div :id = "'knocks_date'+knockObject.numericDate"  class="section scrollspy knocks_house_keeper">
              <div class="row user knocks_house_keeper" style="" >
                <div class="col s6 knocks_house_keeper">
                  <knocksuser
                  @blocked = "explode()"
                  v-model = "ownerObject"
                  image_container_class = "knocks_inline"
                  name_container_class = " knocks_inline"
                  :user="knockObject.user_id" show_image>
                  <template slot = "append_to_display_name" class = "" v-if = "!expiry() || knockObject.exceptions || knockObject.index.check_in != null && knockObject != null">
                  <span class = "knocks-chevron-right3" v-if = "knockObject.type != 'self' && show_appendex"></span>
                  <knocksuser @blocked = "explode()" v-if = "knockObject.type == 'user' && show_appendex" :user = "knockObject.at" as_url class = "knocks_inline "></knocksuser>
                  <knocksgroupshortcut v-if = "knockObject.type == 'group' && show_appendex" :group_id = "knockObject.at" as_url class = "knocks_inline "></knocksgroupshortcut>
                  <span v-if="!expiry() && !hasSeen()" class="green-text right ">New</span>
                  <i v-if="knockObject.exceptions" class="knocks-eye-off red-text right "></i>
                  </template>
                  </knocksuser>
                </div>
                <div class="col s6 ">
                  <div class = "col s9">
                    <a class="knocks_text_dark knocks_mp_top_margin" :href="address_url" v-if="knockObject.index.check_in != null && !onlyLocation">
                      <p class="right knocks_text_sm opcty"> <i class="knocks_text_dark knocks-location3 opcty"></i>
                        {{knockObject.index.check_in.address_components[0].long_name}}
                      </p>
                    </a>
                  </div>
                  <div class = "col s3">
                    <el-dropdown trigger="click" class = "right" v-if = "is_auth">
                    <span class="el-dropdown-link">
                      <knockspopover>
                      <template slot = "container">
                      <i class=" knocks_icon knocks-more-horizontal knocks_text_anchor knocks_text_dark knocks_text_lmd"></i>
                      </template>
                      <span slot = "content"  class = "knocks_tooltip animated flipInX left" >
                        <span class = "knocks-more-horizontal "></span>
                        <static_message msg = "More Options"></static_message>
                      </span>
                      </knockspopover>
                    </span>
                    <el-dropdown-menu slot="dropdown" >
                    <el-dropdown-item v-if="userId == knockObject.user_id">
                    <div>
                      <span class = "knocks-trashcan4 knocks_icon_border blue-text"></span>
                      <static_message msg = "Edit" classes="blue-text"></static_message>
                    </div>
                    </el-dropdown-item>
                    <el-dropdown-item v-if="userId == knockObject.user_id || (knockObject.at == userId && (knockObject.type == 'self' || knockObject.type == 'user'))">
                    <div @click = "deletePost()">
                      <span class = "knocks-pencil9 knocks_icon_border red-text"></span>
                      <static_message msg = "Delete" classes="red-text"></static_message>
                    </div>
                    </el-dropdown-item>
                    <el-dropdown-item v-if = "ownerObject != null && !ownerObject.thatsMe" >
                    <div class ="teal-text text-accent-4">
                      <span class = "knocks-star3 knocks_icon_border  teal-text text-accent-4"></span>
                      <static_message msg = "See" classes="teal-text text-accent-4"></static_message> {{ownerObject.name}}
                      <static_message msg = "first" classes="teal-text text-accent-4"></static_message>
                    </div>
                    </el-dropdown-item>
                    <el-dropdown-item>
                    <div @click = "hidePost()">
                      <span class = "knocks-minus-circle2 knocks_icon_border orange-text text-lighten-1"></span>
                      <static_message msg = "Hide this time" classes= "orange-text text-lighten-1"></static_message>
                    </div>
                    </el-dropdown-item>
                    <el-dropdown-item>
                    <div @click = "hideAlways()">
                      <span class = "knocks-trash5 red-text text-accent-2 knocks_icon_border"></span>
                      <static_message msg = "Hide always" classes="red-text text-accent-2"></static_message>
                    </div>
                    </el-dropdown-item>
                    <el-dropdown-item>
                    <div>
                      <span class = "knocks-shield4 knocks_icon_border  deep-orange-text text-accent-3"></span>
                      <static_message msg = "Report" classes="deep-orange-text text-accent-3"></static_message>
                    </div>
                    </el-dropdown-item>
                    </el-dropdown-menu>
                    </el-dropdown>
                  </div>
                  
                  
                </div>
                
              </div>
              <div class="col s12 cnt  knocks_house_keeper">
                <div class="row knocks_house_keeper">
                  <h3 v-if="knockObject.index.check_in != null && onlyLocation">
                  <a class="knocks_text_dark " :href="address_url" >
                    <p class="center "> <i class=" knocks-location3 "></i>
                      <static_message msg = "** was at ##" replaceable v-if = "ownerObject != null"
                      :replacements = "[
                      { target : '##' , body : knockObject.index.check_in.address_components[0].long_name} ,
                      { target : '**' , body : ownerObject.name}
                      ]" ></static_message>
                    </p>
                  </a>
                  </h3>
                  <h3 v-if="onlyFiles">
                  <p class="center knocks_text_dark"> <i class=" knocks-file "></i>
                    <static_message msg = "** uploaded ## files" replaceable v-if = "ownerObject != null && knockObject.index.files_specifications.length > 1"
                    :replacements = "[
                    { target : '##' , body : knockObject.index.files_specifications.length } ,
                    { target : '**' , body : ownerObject.name}
                    ]" ></static_message>
                    <static_message msg = "** uploaded a file" replaceable v-if = "ownerObject != null && knockObject.index.files_specifications.length == 1"
                    :replacements = "[
                    { target : '**' , body : ownerObject.name}
                    ]" ></static_message>
                  </p>
                  </h3>
                  <div  class="knocks_text_dark content knocks_content_padding" :id = "gid" @dblclick = "flowtext()"></div>
                  <span class = "knocks_text_ms knocks-zoomin4 hide-on-large-only knocks_text_dark" @click = "flowtext()"></span> 
                </div>
                <div class="row knocks_house_keeper"  v-if="bodyLen > 350" ><div class="top">
                  <a class="rdmore right" :id="gid+'_readmore'" style="padding-left : 0.2 rem !important; padding-right : 0.2 rem !important;"  @click="rd();" href="javascript:void(0);">See more</a></div>
                </div>
                <div class="voice_pad"   v-if = "knockObject.index.has_voices">
                  <knocksplayer
                  :gid="gid+'_player'"
                  main_container = "row knocks_house_keeper"
                  class="voice col 12 knocks_house_keeper"
                  :show_volume="true"
                  buttons_container = "col"
                  :show_options="false"
                  :specifications = "{id : knockObject.index.voices_specifications , user : current_user , object : knockObject.object_id }"
                  full_back_loading
                  :load_on_mount="false"></knocksplayer>
                </div>
                <div v-if = "knockObject.index.kvc !== undefined && knockObject.index.kvc" class = "knocks_house_keeper row">
                  <el-tooltip>
                  <span class = 'blue-text text-darken-3 knocks_text_sm ' style="margin-left : 3px !important;">
                    <span class = " knocks-knocks-circle-fill"></span>
                    <static_message msg = "Created By Knocks Assistant"></static_message>
                  </span>
                  <div slot = "content">
                    <static_message msg = "Created By Knocks Assistant"></static_message>
                  </div>
                  </el-tooltip>
                  
                </div>
              </div>
              <div class = "row knocks_house_keeper" v-if = "knockObject.index.has_pictures"  >
                <knocksimageviewer :gid = "gid+'_image_viewer'"
                :sources = 'knockObject.index.images_specifications'
                :object_id = "knockObject.object_id"
                :user_id = "current_user"
                :created_at = "knockObject.created_at"
                :owner_object = "ownerObject"
                :knock_id = "knock"
                :owner_id = "knockObject.user_id"></knocksimageviewer>
              </div>
              <div class = "row knocks_house_keeper" v-if = "knockObject.index.has_files && knockObject.index.files_specifications.length > 0" style="padding : 4px !important">
                <knocksfileviewer :file="file" v-if = "knockObject.index.has_files == true && index < filesShowKey" :key="file" v-for = "(file,index)  in knockObject.index.files_specifications"  >
                </knocksfileviewer>
                <a :class ="[{'knocks_hidden':!(knockObject.index.files_specifications.length > filesShowKey)}]" @click = "filesShowKey += 3">
                  <static_message msg = "See More"></static_message> +{{knockObject.index.files_specifications.length - filesShowKey}}
                </a>
                <a :class ="[{'knocks_hidden':!(filesShowKey > 3 && knockObject.index.files_specifications.length > 3)}]" class = "right" @click = "filesShowKey -= 3">
                  <static_message msg = "See Less"></static_message>
                </a>
              </div>
              
              <div class="row knocks_house_keeper"  style="padding-right : 5px !important; padding-left : 5px !important;">
                <knocksreactionstats
                v-if = "ownerObject != null"
                :candy = "ownerObject.kid"
                knocks_reactor_ul = "knocks_tinny_reactor_ul"
                reactor_collapser_icon = "knocks_text_ms knocks-like knocks_dark_anchor"
                reply_initial_class = "btn btn-floating knocks_super_tiny_floating_btn right knocks_side_padding knocks_noshadow_ps  knocks_text_dark transparent"
                reactor_initial_class = "btn btn-floating knocks_reaction_trigger knocks_super_tiny_floating_btn knocks_noshadow_ps knocks_text_dark transparent"
                bar_classes ="transparent"
                :show_reply_on_mount = "show_reply_on_mount"
                :parent_date = "knockObject.created_at"
                :reply_scope="[ gid + '_reply_scope']"
                parent_type = "knock"
                :gid = "gid+'_reaction_stats'"
                :inverse_reactor = "inverse_reactor"
                :object_id = "knockObject.object_id">
                </knocksreactionstats>
                <knocksreply
                :replier_message = "replier_message"
                :scope= "[ gid + '_reply_scope']"
                :error_at="[]"
                :show_on_mount = "show_reply_on_mount"
                :object_id = "knockObject.object_id"
                :parent_id = "knockObject.id"
                submit_at = "comment/create"
                :recorder_upload_data = "{ user : current_user , index : {}}"
                :player_show_options = "false"
                :post_at = "current_user"
                parent_type = "knock"
                success_at = "done"
                success_msg = "yess"
                toggle_parent_type = "knock"
                :gid = "gid+'_reply'"></knocksreply>
              </div>
              <div class = "knocks_color_kit_light_active row knocks_down_border_radius knocks_house_keeper knocks_gray_top_border" v-if ="comments != null && comments.length > 0">
                <div class = "row knocks_house_keeper">
                  <a v-if = "comments != null && showKey < comments.length && showKey > 0" @click = "increaseRang()"
                    class = "knocks_side_padding knocks_text_sm knocks_text_anchor knocks_pointer" style = "margin-left:2px;">
                    <span class = "knocks-chat-2"></span> See More Comments
                  </a>
                  <a v-if = "comments != null && showKey < comments.length && showKey < 1" @click = "increaseRang()"
                    class = "knocks_side_padding knocks_text_sm knocks_text_anchor knocks_pointer" style = "margin-left:2px;">
                    <span class = "knocks-chat-2"></span> Show Comments
                  </a>
                  <span class = "grey-text right knocks_text_sm knocks_side_padding" v-if = "comments != null && comments.length > 0">{{showKey+'/'+comments.length}} Comments</span>
                </div>
                <div class="" v-for = "(com , index) in comments"  v-if = "comments != null && comments.length > 0" >
                  <knockscomment
                  v-if="inRange(index)"
                  :show_reply_on_mount = "show_comment_reply_on_mout && comments.indexOf(com) != -1"
                  :gid= "gid+'_comment_'+index"
                  :knock="com"
                  @invalid = "removeComment($event)"
                  :current_user="current_user"
                  :comments_to_show = "replies_to_show"
                  :show_comment_reply_on_mount = "reply_comment_reply_on_mout"
                  replier_message = "Reply here" ></knockscomment>
                </div>
                <div class = "col s12 knocks_house_keeper">
                  <a v-if = "comments != null && showKey > 1" @click = "reduceRang()"
                    class = "knocks_tinny_padding knocks_text_sm  knocks_text_anchor knocks_pointer" style = "margin-left:2px;">
                    <span class = "knocks-chat-1"></span> See Less Comments
                  </a>
                  <a v-if = "comments != null && showKey > 0" @click = "showKey = 0"
                    class = "knocks_tinny_padding knocks_text_sm right  knocks_text_anchor knocks_pointer" style = "margin-left:2px;">
                    <span class = "knocks-chat-1"></span> Hide All Comments
                  </a>
                </div>
              </div>
              
            </div>
          </div>
        </transition>
        <div @blocked = "explode()" v-if = "as_shortcut && knockObject != null "  class = "row"style="border-bottom : 1px solid #ccc">
          <knocksuser
          class = "knocks_house_keeper"
          hide_popover
          v-model = "ownerObject"
          image_container_class = "knocks_inline"
          name_container_class = " knocks_inline"
          :user="knockObject.user_id" show_image>
          <template slot = "append_to_display_name" class = "" v-if = "!expiry() || knockObject.exceptions || knockObject.index.check_in != null && knockObject != null">
          <span v-if="!expiry() && !hasSeen()" class="knocks_mp_top_margin new badge knocks_tinny_badge " ></span>
          <span v-if="knockObject.exceptions" class="knocks_mp_top_margin badge sec knocks_tinny_badge " data-badge-caption="Secured"><i class="knocks-eye-off"></i></span>
          </template>
          </knocksuser>
          <div class="col s12 cnt  knocks_house_keeper">
            <div class="row knocks_house_keeper">
              <div  class="knocks_text_dark content knocks_content_padding" :id = "gid" @dblclick = "flowtext()"></div>
            </div>
            <span class = "right knocksapp-zoom-in hide-on-large-only knocks_text_dark" @click = "flowtext()"></span> 
            <div class="row knocks_house_keeper"  v-if="bodyLen > 350" ><div class="top">
              <a class="rdmore right" :id="gid+'_readmore'" style="padding-left : 0.2 rem !important; padding-right : 0.2 rem !important;"  @click="rd();" href="javascript:void(0);">See more</a></div>
            </div>
            <div class="voice_pad"   v-if = "knockObject.index.has_voices">
              <knocksplayer
              :gid="gid+'_player'"
              main_container = "row knocks_house_keeper"
              class="voice col 12 knocks_house_keeper"
              :show_volume="true"
              buttons_container = "col"
              :show_options="false"
              :specifications = "{id : knockObject.index.voices_specifications , user : current_user , object : knockObject.object_id }"
              full_back_loading
              :load_on_mount="false"></knocksplayer>
            </div>
            <div class = "row knocks_house_keeper" v-if = "knockObject.index.has_pictures"  >
              <knocksimageviewer :gid = "gid+'_image_viewer'"
              :sources = 'knockObject.index.images_specifications'
              :object_id = "knockObject.object_id"
              :user_id = "current_user"
              :created_at = "knockObject.created_at"
              :owner_object = "ownerObject"
              :knock_id = "knock"
              :owner_id = "knockObject.user_id"></knocksimageviewer>
            </div>
            <knocksreactionstats
            v-if = "ownerObject != null"
            :candy = "ownerObject.kid"
            knocks_reactor_ul = "knocks_tinny_reactor_ul"
            reactor_collapser_icon = "knocks_text_ms knocks-like knocks_dark_anchor"
            reply_initial_class = "btn btn-floating knocks_super_tiny_floating_btn right knocks_side_padding knocks_noshadow_ps  knocks_text_dark transparent"
            reactor_initial_class = "btn btn-floating knocks_reaction_trigger knocks_super_tiny_floating_btn knocks_noshadow_ps knocks_text_dark transparent"
            bar_classes ="transparent"
            :no_reactor = "no_reactor"
            :show_reply_on_mount = "show_reply_on_mount"
            :parent_date = "knockObject.created_at"
            :reply_scope="[ gid + '_reply_scope']"
            no_reply_option
            parent_type = "knock"
            :gid = "gid+'_reaction_stats'"
            :inverse_reactor = "inverse_reactor"
            :object_id = "knockObject.object_id">
            </knocksreactionstats>
            <a :href ="asset('knock/'+knock)" target="_blank" class = "knocks_text_sm">
              <span class = "knocksapp-share4"></span>
            <static_message msg = "More Details"></static_message></a>
          </div>
        </div>
      </div>
    </transition>
  </div>
</div>
</template>
<script>

export default {
   props:{
    knock : {
        type : Number,
        required : true 
    },
    current_user : {
      type : Number , 
      required : true ,
    },
    
     gid : {
        type : String,
        required : true
     },
     knock_type : {
         type : String,
         default : 'voice_note'
     },
     replier_message : {
      type : String , 
      default : ''
     },
     comments_to_show : {
      type : Array , 
      default : null
     },
    replies_to_show : {
      type : Array , 
      default : null
     },
     interested : {
      type : Boolean , 
      default : false
     },
    as_shortcut : {
      type : Boolean , 
      default : false
     },
     show_appendex : {
      type : Boolean , 
      default : false 
     },
    inverse_reactor : {
      type : Boolean ,
      default : true ,
    },
    show_reply_on_mount : {
      type : Boolean , 
      default : true ,
    },
    show_comment_reply_on_mout : {
      type : Boolean ,
      default : false
    },
    reply_comment_reply_on_mout : {
      type : Boolean ,
      default : false
    },
    no_reactor : {
      type : Boolean , 
      default : false 
    },
    is_auth : {
      type : Boolean ,
      default : parseInt(window.UserId) > 0
    }

    
  },


  data () {
    return {
        knockObject : null ,
        address_url : null,
        body : null ,
        bodyLen : 0 , 
        bodyText : '',
        counter : 0,
        counters : 0,
        comments : null ,
        maxRetrived : null ,
        isFired : false ,
        showKey : 0 ,
        passedOnce : false , 
        ownerObject : null ,
        interest : false ,
        userId : UserId ,
        isLoading : false ,
        hiddenNow : false , 
        onlyLocation : false ,
        onlyFiles : false ,
        filesShowKey : 3 ,
        mainRetriver : { loading : false }
    }; 
},
  computed : {
   commentsWatcher(){
    if(this.comments == null) return null;
    return this.comments.length - this.showKey;
   }

  },
  mounted(){
    this.askToBound(); 
    if(this.comments_to_show != null){

      this.showKey = this.comments_to_show.length;
      this.comments = this.comments_to_show;
      
    }    
    const vm = this;
    App.$on('knocksMemberRemoved' , (payloads)=>{
      if(vm.knockObject != null){
        if(vm.knockObject.user_id == payloads.user){
          window.UserKnocks[vm.knock] = undefined;
          vm.askToBound()
        }
      }
    })
    App.$on('knocks_refresh_posts_done' , ()=>{
      setTimeout( ()=>{
          if(vm.knockObject != null)
      if(vm.knockObject.id != vm.knock){
        //console.log(vm.knockObject.id+' << obid  decl>> '+vm.knock);   
        vm.knockObject = null;
        vm.comments = null;
        vm.askToBound(); 


      }
      } ,300)
    });
    
    App.$on('knocksShowInterest' , (payloads)=>{
      if(vm.knockObject == null || vm.as_shortcut) return;
      if(vm.interest) return;
      if(payloads.objectId == vm.knockObject.object_id && payloads.parentType == 'knock'){
        vm.interest = true;
        vm.retriveComments();
      }else return;
    });
   
    App.$on('knocksKnockContentChanged' , ()=>{
      vm.knockObject = null
      setTimeout(()=>{ vm.askToBound() },500)
      
    })
    
    
  }, 
  methods : {
    asset(url){
      return LaravelOrgin+url;
    },
    toNumericDate(date){
      return moment(date).format('YYYYMMDD');
    },
    askToBound(){
      if(window.UserKnocks[this.knock] != undefined){
        this.init(window.UserKnocks[this.knock])
      }else{
        this.mainRetriver.retrive()
      }
    },
    init(object){
      this.isLoading = false
      if(object == 'invalid'){
        this.$emit('invalid');
      }else{
          const vm = this
          object.index = typeof (object.index) == 'object' ? object.index : JSON.parse(object.index);
          this.knockObject = object
          window.UserKnocks[this.knock] = this.knockObject;
          this.knockObject.time = null;
          this.knockObject.timedate = null;
          this.onlyLocation =  this.isOnlyLocation()
          this.onlyFiles = this.isOnlyFiles()
          setTimeout( ()=>{
            this.hashDates();
            this.$emit('input' , this.knockObject);
            this.boundMyDom()
            if(this.interested){
              App.$emit('knocksShowInterest', { objectId : this.knockObject.object_id , parentType : 'knock'} );
            }  
          }, 400);        
          setTimeout(()=> {
            this.datecalc()
          },5000);
          setTimeout(()=> {
            this.height()
          },2000)
          if(this.knockObject.index.check_in != null)
            this.address_url = this.knockObject.index.check_in.url;
          this.retriveComments();
        }
    },
    isOnlyLocation(){
      return 
        this.knockObject.index.has_voices ||  
        this.knockObject.index.has_pictures || 
        this.knockObject.index.has_files || 
        (this.knockObject.body != null && this.knockObject.body.length > 0)
    },
    isOnlyFiles(){
     return 
       !this.knockObject.index.has_voices && 
       !this.knockObject.index.has_pictures 
       && (this.knockObject.body == null || this.knockObject.body.length == 0) 
       && this.knockObject.index.has_files
    },
    hashDates(){
      this.knockObject.time = moment.tz( this.knockObject.created_at.substring(0,18) , moment.tz.guess() ).fromNow();
      this.knockObject.timedate = moment.tz(this.knockObject.created_at.substring(0,18),  moment.tz.guess() ).format('MMMM Do YYYY, h:mm a');
      this.knockObject.disDate = moment.tz(this.knockObject.created_at,  moment.tz.guess()).format('MMMM Do YYYY');
      this.knockObject.numericDate = this.toNumericDate(this.knockObject.created_at);
    },
    boundMyDom(){
      if(this.knockObject.body == null){
        $('#'+this.gid).remove();
        $('#'+this.gid+'_lns').remove();
      }else if(this.knockObject.body.length == 0 ){
         $('#'+this.gid).remove();
         $('#'+this.gid+'_lns').remove();
      } else{
      $('#'+this.gid).html(this.knockObject.body);
      this.handleAlignment();
      this.bodyLen =  $('#'+this.gid).text().length;
      this.bodyText =  $('#'+this.gid).text();
      }
    },
    handleAlignment(){
      let fonts = { right : 'cairo' , left : 'titillium' }
      $('#'+this.gid).css({ 'text-align' : window.TextAlignWeight($('#'+this.gid).text()).max , 'font-family' : fonts[window.TextAlignWeight($('#'+this.gid).text()).max] })
    },
    showRange(){
      return this.comments.length - this.showKey -1;
    },
    inRange(index){
      return index > this.showRange() ? true : false;
    },
    increaseRang(){
      if(this.comments.length - this.showKey > 5 ) {
        this.showKey += 5;
      }else{
         this.showKey += this.comments.length - this.showKey;
        } 
    },
    reduceRang(){
      if( this.showKey -  5 < 1) {
        this.showKey = 1;
      }else{
         this.showKey -= 5 ;
        } 
    },
    tickSeen(){
      if(this.passedOnce || !this.is_auth) return ;
      this.passedOnce = true;
      if(this.knockObject != null && this.knockObject.index.seen[this.current_user] != undefined) return ;
      const vm = this;
      axios({
        url : LaravelOrgin + 'post/seen' , 
        method : 'post' ,
        data : {knock : vm.knock} 
      });
    },
    hasSeen(){
      if(!this.is_auth) return
      return this.knockObject != null && this.knockObject.index.seen[this.current_user] != undefined ? true : false;
    },

    rd(){
      const vm = this

      var readmore = $('.rdmore').text();
      if(!$('#'+vm.gid).hasClass('knock_readmore_clicked')){
      $('#'+vm.gid).css({
      'height': 'auto'
      });
      $('#'+vm.gid).removeClass('animated jello');
      $('#'+vm.gid).addClass('knock_readmore_clicked');
      $('#'+vm.gid).removeClass('animated pulse');
      $('#'+vm.gid).removeClass('animated shake');
      $('#'+vm.gid).removeClass('animated rubberBand');
      $('#'+vm.gid).addClass('animated fadeInDown');
      $('#'+vm.gid+'_readmore').text('See less');
      vm.counters = 1;
      }else
      {
      $('#'+vm.gid).css({
      'height': '7.4em'
      });
      $('#'+vm.gid+'_readmore').text('See More');
      $('#'+vm.gid).removeClass('animated pulse');
      $('#'+vm.gid).removeClass('knock_readmore_clicked');
      $('#'+vm.gid).removeClass('animated rubberBand');
      $('#'+vm.gid).removeClass('animated jello');
      $('#'+vm.gid).removeClass('animated fadeInDown');
      $('#'+vm.gid).addClass('animated shake');
      vm.counters = 0;
      }



      },
       flowtext(){
        const vm = this
    if(vm.counter == 0){
         $('#'+vm.gid+'_lns').removeClass('knocks-zoomin3');
         $('#'+vm.gid+'_lns').addClass('knocks-zoomout3');
         $('#'+vm.gid).removeClass('animated fadeInDown');
         $('#'+vm.gid).removeClass('animated fadeInDown');
         $('#'+vm.gid).removeClass('animated jello');
         $('#'+vm.gid).removeClass('animated rubberBand');
         $('#'+vm.gid).addClass('flow-text');
         $('#'+vm.gid).addClass('animated pulse');
         $('.rdmore').addClass('flow-text');
             vm.counter = 1;
             
              $('#'+vm.gid).css({
                'line-height': '1.6em'
                                 });


                $('#'+vm.gid).css({'height' : 'auto !important'})
            
         }
         else
         {
         $('#'+vm.gid+'_lns').removeClass('knocks-zoomout3');
         $('#'+vm.gid+'_lns').addClass('knocks-zoomin3');
         $('#'+vm.gid).removeClass('animated fadeInDown');
         $('#'+vm.gid).removeClass('animated fadeInDown');
         $('.rdmore').removeClass('flow-text');
         $('#'+vm.gid).removeClass('flow-text');
         $('#'+vm.gid).removeClass('animated pulse');
         $('#'+vm.gid).addClass('animated jello');
         $('#'+vm.gid).addClass('animated rubberBand');
            vm.counter = 0;
            //console.log(vm.counter);
            $('#'+vm.gid).css({
                'line-height': '1.3em'});
            $('#'+vm.gid).css({'height' : 'auto !important'})
         }
                        

       },

       lensHover(){
      
        $('.lensm').addClass('animated jello');
     },
     lensLeave(){
        
        $('.lensm').removeClass('animated jello');
      
     },
     hidePost(){
      this.hiddenNow = true;
      setTimeout( ()=>{ this.knockObject = null ;  }, 1000);
     },
     hideAlways(){
      this.isLoading = true;
      App.$emit('knocksRetriver' , {scope : ['knock_ignore_'+this.gid ]});
     },
     
     deletePost(){
      if(!this.is_auth) return
      this.isLoading = true;
      App.$emit('knocksRetriver' , {scope : ['knock_delete_'+this.gid ]});
     },
     confirmHide(e){
      if(!this.is_auth) return
      this.isLoading = false;
      if(e.response == 'done'){
        this.hidePost();
      }
     },
    confirmDelete(e){
      if(!this.is_auth) return
      this.isLoading = false;
      if(e.response == 'done'){
        this.hidePost();
      }
     },
     expiry(){
       const vm = this;
          var now = moment().format('YYYY-MM-DD hh:mm:ss');
          var created = moment(vm.knockObject.created_at, 'YYYY-MM-DD hh:mm:ss').format();
          var exp = moment(created).add(2,'days');
          var expire = moment(exp).format();
       
        var rule = moment().isSameOrAfter(expire);
        return rule;
     },
     retriveComments(){
        const vm = this;
        axios({
          method : 'post' , 
          url : LaravelOrgin + 'post/comments' , 
          data : { knock : vm.knock , max : vm.maxRetrived }
        }).then( (response)=>{
          if(vm.comments == null)
          vm.comments = response.data;
          else{
            let i ;
            for(i = 0; i < response.data.length; i++){
              if(vm.comments_to_show != null){
                if(vm.notInMountedComments(response.data[i]))
                  if(vm.comments.indexOf(response.data[i]) == -1)
                   vm.comments.splice(vm.comments.length - vm.comments_to_show.length , 0 , response.data[i])
              }
              else if(vm.notInMountedComments(response.data[i]))
                     if(vm.comments.indexOf(response.data[i]) == -1)
                      vm.comments.push(response.data[i])
            }
          }
          if(vm.comments.length > 0){
            vm.maxRetrived = Math.max.apply(null,vm.comments );
          }
          setTimeout( ()=>{ 
            if(vm.interest)
              vm.retriveComments(); 
          } , 10000);
        });
      },
      notInMountedComments(key){
        if(this.comments_to_show == null) return true;
        return this.comments_to_show.indexOf(key) == -1 ? true : false;
      },
      removeComment(e){
        let i ;
        for(i = 0; i < this.comments.length; i++){
          if(this.comments[i] == e) this.comments.splice(i , 1);
        }
      },

     datecalc(){
        const vm = this;    
        var now = moment();
             
        var created = moment(vm.knockObject.created_at, 'YYYY-MM-DD hh:mm:ss').format();
       

         },
         checklens(){
          const vm = this; 
          if (vm.counter == 1 && bodyLen <= 200)
              return true
              return false
          
         },
         height(){
          const vm = this;
          if(vm.bodyLen > 250)
          {
              $('#'+vm.gid).css({ 'height' : '7.4em'});
          }else{
              $('#'+vm.gid).css({ 'height' : 'auto'});
          }
         },
         generateUrl(string){
          return NodeOrgin +'vn/retrive/'+ this.current_user + '/'+this.knockObject.object_id+'/'+string;
         },
         explode(){
          if(window.UserKnocks[this.knock] != undefined)
            window.UserKnocks[this.knock] = null
          this.knockObject = null
          this.$emit('blocked')
         }

     }
      
       
       
    }
     
    
</script>

<style lang="css" scoped>
/*.panel{
    border: 1px solid transparent;
    //border-radius: 15px;
    padding: 1rem;
    padding-bottom: 0;

}*/
.panel {
/*    border: 1px solid transparent;
    padding-top: 0.1rem;
    padding-bottom: 0rem;
    padding-right: 0.1rem;
    padding-left: 0.1rem;*/

}
.voice_pad{
  //margin-left: -8%;
  //margin-top: -2%;
}
.player{
    background-color: rgba(192,192,192,0.1);
    border-radius: 15px;
    margin-left: -2% !important;
    width: 70% !important;
}
.reactor{
     //margin-top: -6%;
    //margin-right: 2%;
}
.content{
  width: 100%;
  overflow: hidden;
  //height: 7.4em;
  line-height: 1.3em;
  word-wrap: break-word;
  word-break: break-word;
  //margin-left: 3%;
  //border-radius: 15px;
  padding: 0.3rem;
  //margin-top: -5% !important;
  padding-left: 0.7rem !important;
  padding-right: 0.7rem !important;

}
.opcty{
    color :  #01579b !important;
    //margin-top: -2%;
}
.since{

}
.rdmore{
    //margin-top: -2%;
    //margin-right: 6%;
}
.cnt{
    background-color:rgba(192,192,192,0.1);
    /*border-radius: 15px;*/
    margin-top: -1rem !important;
    height: 40% !important;


}

.lens{
    //margin-right: 1% !important;
    //margin-top: 1%;
}
.user{
  //margin-top: -3%;
  //margin-left: -3%;
}
.footer{
  //margin-bottom: -3%;
}
.privacy{
  background-color: ;
}
</style>