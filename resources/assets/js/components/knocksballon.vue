<template>
<transition enter-active-class = "animated bounceInRight" :leave-active-class = "leaveActiveClass" v-if = "constrains.category != 'hidden'">
  <div :class = "container_class"
    v-if="(!closed || keep_showing) && isValid "
    :id = "gid"
    style=""
    @mouseover = "hoverAct()"
    @mouseleave="mouseLeaveAct()">
    <knocksretriver
    url = "ballon/seen"
    :xdata = "{ ballon : constrains.id }"
    prevent_on_mount
    @success = "handleSeen($event)"
    :scope = "['ballon_'+gid+'_seen']"></knocksretriver>
    <div class = " knocks_fair_bounds" >
      <a @click = "leaveActiveClass = 'animated zoomOut'; closed = true" v-if = "!keep_showing" class="right knocks_text_anchor knocks_text_md"><span uk-icon="close"></span></a>
    </div>
    <!--System Ballons-->
    <div v-if = "constrains.index.category == 'System'">
      <div v-html = "constrains.content"></div>
    </div>
    <!--Friend Requests-->
    <div v-if = "constrains.index.category == 'friend_request'" class = "knocks_fair_bounds" >
      <knocksuser @blocked = "isValid = false" :user=  "constrains.index.sender_id" v-model = "domainUser" :show_username = "false" @input = "notifyMe()"
      image_container_class = "knocks_inline" main_container = "row knocks_house_keeper" name_container_class = " knocks_inline" :extras="{hover_id : gid}">
      </knocksuser>
      <static_message  style = "padding : 3px;" classes = "knocks_text_ms knocks_text_dark" v-if="domainUser != null" msg = "** sent you a friendship request."
      replaceable :replacements = "[ {target : '**' , body : domainUser.name}]" v-model = "sm.fr"></static_message>
      <br  v-if = "domainUser != null && domainUser.is_friend"/>
      <b v-if = "domainUser != null && domainUser.is_friend" class = "green-text right">
      <span class = "knocksapp-circle-checkmark"></span>
      <static_message msg = "Accepted"></static_message>
      </b>
      <br/>
      <a class = "knocks_text_pink" :href = "domainUser.userUrl" v-if = "domainUser != null">
        <span class = "knocksapp-home4"></span>
        <static_message  style = "padding : 3px;" classes = " " v-if="domainUser != null" msg = "Visit ##$##'s home."
        replaceable :replacements = "[ {target : '##$##' , body : domainUser.name}]"></static_message>
      </a>
      <center>
      <knocksuseractions
      style = "margin-top : 3px;"
      @user_action = "closeBallon()"
      v-if="domainUser != null"
      :user = "constrains.index.sender_id"
      :start_as ="domainUser" :extras="{hover_id : gid}"></knocksuseractions>
      </center>
    </div>
    
    <!--Friend Request Acceptance -->
    <div  v-if = "constrains.index.category == 'friend_request_accepted'" class = "knocks_fair_bounds">
      <knocksuser @blocked = "isValid = false" no_rebound :user=  "constrains.index.sender_id" v-model = "domainUser" :show_username = "false"
      image_container_class = "knocks_inline" main_container = "row knocks_house_keeper" name_container_class = " knocks_inline" :extras="{hover_id : gid}">
      </knocksuser>
      <div class = "knocks_fair_bounds">
        <static_message  style = "padding : 3px;" classes = "knocks_text_ms knocks_text_dark" v-if="domainUser != null" msg = "** accepted your friendship request."
        replaceable :replacements = "[ {target : '**' , body : domainUser.name}]"></static_message>
        <br/>
        <a class = "knocks_text_pink" :href = "domainUser.userUrl" v-if = "domainUser != null">
          <span class = "knocksapp-home4"></span>
          <static_message  style = "padding : 3px;" classes = " " v-if="domainUser != null" msg = "Visit ##$##'s home."
          replaceable :replacements = "[ {target : '##$##' , body : domainUser.name}]"></static_message>
        </a>
      </div>
    </div>
    <!--Commentss -->
    <div v-if = "constrains.index.category == 'comment'">
      <div v-if = "constrains.index.object_type == 'knock'">
      <div class = "knocks_fair_bounds">
        <knocksuser @blocked = "isValid = false"  :user=  "constrains.index.sender_id" v-model = "domainUser" :show_username = "false"
        image_container_class = "knocks_inline" main_container = "row knocks_house_keeper" name_container_class = " knocks_inline" :extras="{hover_id : gid}">
        </knocksuser>
        <div class = "row" v-if = "constrains.index.commenters.length > 1">
        </div>
        <a :href = "asset('knock/'+constrains.index.knock+'/'+constrains.index.comment)" target="_blank" v-if = "constrains.index.commenters.length == 1">
          <static_message  style = "padding : 3px;" classes = " knocks_text_dark" v-if="domainUser != null" msg = "** responded to a knock."
          replaceable :replacements = "[ {target : '**' , body : domainUser.name}]"></static_message>
        </a>
        <a v-else :href = "asset('knock/'+constrains.index.knock+'/'+constrains.index.comment)" target="_blank">
          <static_message  style = "padding : 3px;" classes = " knocks_text_dark" v-if="domainUser != null" msg = "** and $$ other/s responded to a knock."
          replaceable :replacements = "[ {target : '**' , body : domainUser.name} , { target : '$$' , body : constrains.index.commenters.length -1}]"></static_message>
        </a>
        <knockscollapse title = "See All" active_title = "Hide All" icon = "knocksapp-maximize" dual_title v-if = "constrains.index.commenters.length > 1"
        toggler_container = "row knocks_blue_gray_hover knocks_tinny_border_radius knocks_margin_keeper knocks_tinny_padding knocks_text_xs">
        <div class = "row" slot = "content">
          <knocksshowkeys :show_input = "constrains.index.commenters"></knocksshowkeys>
        </div>
        </knockscollapse>
      </div>
      <knockscollapse title = "Show The Knock" active_title = "Hide The Knock" icon = "knocks-chat-2" dual_title v-if = "!extended"
      toggler_container = "row knocks_blue_gray_hover knocks_tinny_border_radius knocks_margin_keeper knocks_tinny_padding">
      <knocksknock  :knock = "constrains.index.knock" :gid="gid+'_ballon_comment_'+constrains.index.comment"  slot = "content"
      :comments_to_show = "constrains.index.comments"
      :show_comment_reply_on_mout = "!hide_replies"
      :show_reply_on_mount = "false"
      :current_user = "auth" replier_message = "Leave a comment" ></knocksknock>
      </knockscollapse>
      <knocksknock v-if= "extended" :knock = "constrains.index.knock" :gid="gid+'_ballon_ext_comment_'+constrains.index.comment"
      :comments_to_show = "constrains.index.comments"
      :show_comment_reply_on_mout = "!hide_replies"
      :show_reply_on_mount = "false"
      :current_user = "auth" replier_message = "Leave a comment" ></knocksknock>
    </div>
    </div>
    <!--Replies-->
    <div v-if = "constrains.index.category == 'reply'">
      <div class = "knocks_fair_bounds">
        <knocksuser @blocked = "isValid = false"  :user=  "constrains.index.sender_id" v-model = "domainUser" :show_username = "false"
        image_container_class = "knocks_inline" main_container = "row knocks_house_keeper" name_container_class = " knocks_inline" :extras="{hover_id : gid}">
        </knocksuser>
       <a :href = "asset('rply/'+constrains.index.reply)" target="_blank" v-if = "constrains.index.repliers.length == 1">
          <static_message  style = "padding : 3px;" classes = " knocks_text_dark" v-if="domainUser != null" msg = "** replied to a comment."
          replaceable :replacements = "[ {target : '**' , body : domainUser.name}]"></static_message>
        </a>
        <a :href = "asset('rply/'+constrains.index.reply)" target="_blank" v-if = "constrains.index.repliers.length > 1">
          <static_message  style = "padding : 3px;" classes = " knocks_text_dark" v-if="domainUser != null" msg = "** and $$ other/s replied to a comment."
          replaceable :replacements = "[ {target : '**' , body : domainUser.name} , { target : '$$' , body : constrains.index.repliers.length -1}]"></static_message>
        </a>
        <knockscollapse title = "See All" active_title = "Hide All" icon = "knocksapp-maximize" dual_title v-if = "constrains.index.repliers.length > 1"
        toggler_container = "row knocks_blue_gray_hover knocks_tinny_border_radius knocks_margin_keeper knocks_tinny_padding knocks_text_xs">
        <div class = "row" slot = "content">
          <knocksshowkeys :show_input = "constrains.index.repliers"></knocksshowkeys>
        </div>
        </knockscollapse>
      </div>
      <knockscollapse title = "Show The reply" active_title = "Hide The reply" icon = "knocks-chat-2" dual_title v-if = "!extended"
      toggler_container = "row knocks_blue_gray_hover knocks_tinny_border_radius knocks_margin_keeper knocks_tinny_padding">
      <knocksknock  :knock = "constrains.index.knock" :gid="gid+'_ballon_reply_'+constrains.index.comment"  slot = "content"
      :comments_to_show = "[constrains.index.comment]"
      :replies_to_show = "constrains.index.replies"
      :show_comment_reply_on_mout = "false"
      :reply_comment_reply_on_mout = "!extended"
      :show_reply_on_mount = "false"
      :current_user = "auth" replier_message = "Leave a comment" ></knocksknock>
      </knockscollapse>
      <knocksknock v-if= "extended" :knock = "constrains.index.knock" :gid="gid+'_ballon_reply_ext_'+constrains.index.comment"
      :comments_to_show = "[constrains.index.comment]"
      :replies_to_show = "constrains.index.replies"
      :show_comment_reply_on_mout = "!hide_replies"
      :show_reply_on_mount = "false"
      :current_user = "auth" replier_message = "Leave a comment" ></knocksknock>
    </div>
    <div v-if = "constrains.index.category == 'reaction'">  
      <div class = "knocks_fair_bounds">
        <knocksuser @blocked = "isValid = false"  :user=  "constrains.index.sender_id" v-model = "domainUser" :show_username = "false"
        image_container_class = "knocks_inline" main_container = "row knocks_house_keeper" name_container_class = " knocks_inline" :extras="{hover_id : gid}">
        </knocksuser>
        <div v-if = "constrains.index.object_type =='knock'">
          <a :href = "asset('knock/'+constrains.index.child)" target="_blank">
            <static_message  style = "padding : 3px;" classes = " knocks_text_dark" v-if="domainUser != null" msg = "** reacted on your knock."
            replaceable :replacements = "[ {target : '**' , body : domainUser.name}]"></static_message>
          </a>
          <knockscollapse title = "Show The Knock" active_title = "Hide The Knock" icon = "knocks-chat-2" dual_title
          toggler_container = "row knocks_blue_gray_hover knocks_tinny_border_radius knocks_margin_keeper knocks_tinny_padding">
          <knocksknock  :knock = "constrains.index.child" :gid="gid+'_ballon_reaction_knock_child'"  slot = "content"
          as_shortcut
          :current_user = "auth" replier_message = "Leave a comment" ></knocksknock>
          </knockscollapse>
        </div>
        <div v-if = "constrains.index.object_type =='comment'">
          <a :href = "asset('knock/'+constrains.index.child)" target="_blank">
            <static_message  style = "padding : 3px;" classes = " knocks_text_dark" v-if="domainUser != null" msg = "** reacted on your comment."
            replaceable :replacements = "[ {target : '**' , body : domainUser.name}]"></static_message>
          </a>
          <knockscollapse title = "Show My Comment" active_title = "Hide My Comment" icon = "knocks-chat-2" dual_title
          toggler_container = "row knocks_blue_gray_hover knocks_tinny_border_radius knocks_margin_keeper knocks_tinny_padding">
          <knockscomment  :knock = "constrains.index.child" :gid="gid+'_ballon_reaction_knock_child'"  slot = "content"
          as_shortcut
          :current_user = "auth" replier_message = "Leave a comment" ></knockscomment>
          </knockscollapse>
        </div>
        <div v-if = "constrains.index.object_type =='reply'">
          <a :href = "asset('knock/'+constrains.index.child)" target="_blank">
            <static_message  style = "padding : 3px;" classes = " knocks_text_dark" v-if="domainUser != null" msg = "** reacted on your reply."
            replaceable :replacements = "[ {target : '**' , body : domainUser.name}]"></static_message>
          </a>
          <span class = "right knocks_text_md">
            <span :class = "reactions[constrains.index.reaction]"></span>
          </span>
          <knockscollapse title = "Show My Reply" active_title = "Hide My Reply" icon = "knocks-chat-2" dual_title
          toggler_container = "row knocks_blue_gray_hover knocks_tinny_border_radius knocks_margin_keeper knocks_tinny_padding">
          <knockschildreply  :knock = "constrains.index.child" :gid="gid+'_ballon_reaction_knock_child'"  slot = "content"
          as_shortcut
          :current_user = "auth" replier_message = "Leave a comment" ></knockschildreply>
          </knockscollapse>
        </div>
        <div v-if = "constrains.index.object_type =='blob'">
          <a :href = "asset('knock/'+constrains.index.child)" target="_blank">
            <static_message  style = "padding : 3px;" classes = " knocks_text_dark" v-if="domainUser != null" msg = "** reacted on your image."
            replaceable :replacements = "[ {target : '**' , body : domainUser.name}]"></static_message>
          </a>
          <span class = "right knocks_text_md">
            <span :class = "reactions[constrains.index.reaction]"></span>
          </span>
          <knockscollapse title = "Show My Image" active_title = "Hide My Image" icon = "knocksapp-picture" dual_title
          toggler_container = "row knocks_blue_gray_hover knocks_tinny_border_radius knocks_margin_keeper knocks_tinny_padding">
          <knocksimageviewer :gid = "gid+'_image_viewer_'+constrains.index.child"
          :sources = '[constrains.index.child]'
          :object_id = "constrains.index.object_id"
          :user_id = "auth"
          class = 'knocks_bold_white_border z-depth-2 knocks_tinny_border_radius'
          :knock_id = "constrains.index.object_id"
          :owner_object = "domainUser"
          slot = "content"
          :owner_id = "auth"></knocksimageviewer>
          </knockscollapse>
        </div>
      </div>
    </div>
    <el-tooltip v-if = "formNowDate != 'Invalid date' " class = "knocks_fair_bounds">
    <span slot = "content"  class = "" >
      <span class = "knocks-calendar10"></span>
      <span class = "knocks_language_default_font">{{detailsDate}}</span>
    </span>
    <span >
      <span
        class = "knocks_language_default_font knocks_text_sm    gray-text text-darken-3">
        <span class = "knocks-clock9  "></span> {{ formNowDate }}</span>
      </span>
      </el-tooltip>
      <el-tooltip v-if = "formNowDate != 'Invalid date' && constrains.seen == 1 " class = "knocks_fair_bounds">
      <span slot = "content"  class = "" >
        <span class = "knocksapp-circle-checkmark"></span>
        <span class = "knocks_language_default_font">{{detailsDates}}</span>
      </span>
      <span >
        <span
          class = "knocks_language_default_font knocks_text_sm  green-text  gray-text text-darken-3">
          <span class = "knocksapp-circle-checkmark  "></span>
        <static_message msg = "Seen "></static_message> {{ formNowDates }}</span>
      </span>
      </el-tooltip>
    </div>
  </transition>
  </template>

<script>
export default {

  name: 'knocksballon',
  props : {
  	gid : {
  		type : String , 
  		required : true
  	},
  	constrains : {
  		type : Object , 
  		default : null
  	},
    container_class : {
      type : String , 
      default : 'knocks_ballon knocks_standard_border_radius knocks_color_kit_light knocks_gray_border knocks_house_keeper animated shake ' 
    },
    keep_showing : {
      type : Boolean , 
      default : false
    },
    mute : {
      type : Boolean ,
      default : false
    },
    hide_replies :{
      type : Boolean , 
      default : false
    },
    show_browser_notification : {
      type : Boolean , 
      default : false
    },
    extended : {
      type : Boolean , 
      default : false
    },
    index_time : {
      type : Number ,
      default : 0
    }
   },

  data () {

    return {
    	balloonInterval : null ,
    	intervalCounter : 0 ,
    	hovered : false , 
    	closed : false ,
      leaveActiveClass : 'animated slideOutRight' , 
      outterHover : false ,
      domainUser : null ,
      auth : parseInt(UserId) , 
      seenOnce : false ,
      seenTime : null ,
      time : null , 
      times : null ,
      sm : { fr : '' },
      isValid : true ,
      reactions : {
       'like' :  "knocks-thumb-up2 knocks_circular_border knocks_xs_padding knocks_text_ms pink white-text darken-1" ,
       'dislike' : "knocks-thumb-down2 knocks_circular_border knocks_xs_padding knocks_text_ms pink lighten-5s",
        'sad' : "knocks-sad-face-eyebrows2 yellow-text  knocks_circular_border knocks_xs_padding knocks_text_ms light-blue darken-4" ,
        'angry' : "knocks-stubborn-face2 orange-text knocks_circular_border knocks_xs_padding knocks_text_ms darken-3s blue-grey" ,
        'love' : "knocks-heart8 ed-text knocks_circular_border knocks_xs_padding knocks_text_ms pink lighten-5 red-text" ,
        'poker' : "knocks-neutral-face2 lime-text accent-1 knocks_circular_border knocks_xs_padding knocks_text_ms deep-purple darken-1" ,
        'laugh' : "knocks-laughing-face4 yellow-text red knocks_circular_border knocks_xs_padding knocks_text_ms" ,
        'middle_finger' : "knocks-middle-finger2 yellow-text darken-2 knocks_circular_border knocks_xs_padding knocks_text_ms red darken-4"
      },
      reloadCategories : [
      'friendship_unpair' , 
      'friend_request_ignored' , 
      'friend_request_accepted' , 
      'friend_request' , 
      'friend_request_canceled'  
      ]


    }
  },
  mounted(){
  	this.countDown();
  	this.soundNotification();
    this.swipeToLeave();
    this.watchCallBacks();
    if(!this.keep_showing){
      setTimeout( ()=>{
        //this.listenForSwips();
      } , 1000)
    }
    
    const vm = this;
    App.$on('knocksStopBallonTimer' , (gid)=>{
      if(vm.gid == gid){
        vm.outterHover = true ;
      }
    });
     App.$on('knocksTurnOnBallonTimer' , (gid)=>{
      if(vm.gid == gid){
        vm.outterHover = false;
        if(!vm.hovered) vm.countDown();
      }
    });


   this.timer();

   if(this.show_browser_notification){
    document.addEventListener('DOMContentLoaded', function () {
  if (!Notification) {
    
    return;
  }

  if (Notification.permission !== "granted")
    Notification.requestPermission();
   }); 

  
   }
      
   
  },
  computed : {
    formNowDate(){
    
      return this.time == null ? '' : moment(this.time).fromNow();
    },
    formNowDateSpliced(){
      return this.requireSplicing ? this.formNowDate.substring(0,5)+'..' : this.formNowDate;
    },

    requireSplicing(){
      return this.formNowDate.length > 4 && this.windowWidth < 800 ? true : false ;
    },
    detailsDate(){

      return  this.time == null ? '' : moment(this.time).format('MMMM Do YYYY, h:mm a');
    },
    formattedDate(){
      return moment.tz( this.time , moment.tz.guess() ).format('YYYY-MM-DD')
    },
    formNowDates(){
    
      return this.times == null ? '' : moment(this.times).fromNow();
    },
    formNowDateSpliceds(){
      return this.requireSplicings ? this.formNowDates.substring(0,5)+'..' : this.formNowDates;
    },

    requireSplicings(){
      return this.formNowDates.length > 4 && this.windowWidth < 800 ? true : false ;
    },
    detailsDates(){

      return  this.times == null ? '' : moment(this.times).format('MMMM Do YYYY, h:mm a');
    },
    formattedDates(){
      return moment.tz( this.times , moment.tz.guess() ).format('YYYY-MM-DD')
    },
  },
  methods : {
    timer(){
      let offset = new Date().getTimezoneOffset();
       if(this.constrains.created_at == undefined) this.time = null ;
       else this.time =  this.constrains.created_at
       if(this.seenTime != null) this.times =  this.seenTime;
       if(this.constrains.updated_at == undefined) this.times =  null ;
       else this.times =  this.constrains.updated_at
        this.time = moment(this.time).subtract(offset ,'m');
        this.times = moment(this.times).subtract(offset ,'m');
      setInterval( ()=>{
        this.time = ''; 
        if(this.constrains.created_at == undefined) this.time = null ;
        else this.time =  this.constrains.created_at
        if(this.seenTime != null) this.times =  this.seenTime;
        if(this.constrains.updated_at == undefined) this.times =  null ;
        else this.times =  this.constrains.updated_at

        this.time = moment(this.time).subtract(offset ,'m');
        this.times = moment(this.times).subtract(offset ,'m');

     

       }
          , 5000);
    },
  	hoverAct(){
      if(!this.hovered && !this.seenOnce){
        App.$emit('knocksRetriver' , { scope : ['ballon_'+this.gid+'_seen'] })
      }
      this.hovered = true;
  		this.intervalCounter = 0;
      // this.swipeToLeave();
  		clearInterval(this.balloonInterval);
  	},
    watchCallBacks(){
      if(this.constrains.index.category == 'friend_request_accepted'){
      App.$emit('knocksUserKeyUpdate' ,
       { user : this. constrains.index.sender_id  , 
        patch : [ 
        { key : 'requested' , value : false } ,
        { key : 'requester' , value : false } , 
        { key : 'is_friend' , value : true  } 
       ]})
      }
      if( this.reloadCategories.indexOf( this.constrains.index.category ) != -1){
        
        App.$emit('knocksUserReload' , this.constrains.index.sender_id)
      // App.$emit('knocksUserKeyUpdate' ,
      //  { user : this. constrains.index.sender_id  , 
      //   patch : [ 
      //   { key : 'requested' , value : false } ,
      //   { key : 'requester' , value : true } , 
      //   { key : 'is_friend' , value : false  } 
      //  ]})
      }
    },
    listenForSwips(){
      if(this.keep_showing || this.closed) return;
      const vm = this;
       $('#'+vm.gid).swipe( {
        //Generic swipe handler for all directions
        swipe:function(event, direction, distance, duration, fingerCount, fingerData) {
          if(vm.keep_showing || vm.closed) return;
          if(direction == 'left') { 

            $('#'+vm.gid).css({'right' : $(window).width() - ( $('#'+vm.gid).offset().left + $('#'+vm.gid).width() ) + distance + 'px'})       
            if(distance > 100){
              $('#'+vm.gid).css({'opacity' : 0.5}) 
              vm.leaveActiveClass = 'animated slideOutLeft';
              $('#'+vm.gid).css({'right' : $(window).width() + 17 + 'px'}) 
              vm.closed = true;
            }
          }
          if(direction == 'right'){
           $('#'+vm.gid).css({'right' : $(window).width() - ( $('#'+vm.gid).offset().left + $('#'+vm.gid).width() ) - distance + 'px'})
              if(distance > 100){
              $('#'+vm.gid).css({'opacity' : 0.5}) 
              vm.leaveActiveClass = 'animated slideOutRight';
               $('#'+vm.gid).css({'right' : -2 + 'px'})
              vm.closed = true;
            }
         }
          //if( ( direction == 'down' ) && distance > ( $(window).height() * 70 / 100 ) ) vm.viewportClose();
        },
        //Default is 75px, set to 0 for demo so any distance triggers swipe
         threshold:0
      });
    },
  	mouseLeaveAct(){
      this.hovered = false ;
      if(!this.outterHover);
  		this.countDown();
  	},
    asset(url){
      return window.Asset(url);
    },
  	countDown(){
      if(this.keep_showing) return;
	  	this.balloonInterval = setInterval( ()=>{
	  	if(this.hovered || this.outterHover){
	  	   clearInterval(this.balloonInterval);
	  	 }else{
	  	 	if(this.intervalCounter == (10 + (this.index_time * 10))){
	  	 	   clearInterval(this.balloonInterval);
	  	 	   this.closed = true;
	  	 	   return;
	  	 	}
	  		this.intervalCounter++;
	  	 }
  	}, 1000);
  	}, 
    closeBallon(){
      clearInterval(this.balloonInterval);
      this.closed = true;
    },
  	soundNotification(){
      if(this.mute || this.constrains.category == 'hidden') return;
  	  var vidId = document.getElementById('knocks_notification');
      vidId.play();
      setTimeout(function () {
          vidId.pause();
      },3000);
  	
  },
  handleSeen(e){
    if(e.response == 'done'){
      this.$emit('seen')
      App.$emit('knocksBallonGlobalSeen' , { ballon : this.constrains.id})
      this.seenOnce = true;
      this.seen = moment();
    }
  },
  swipeToLeave(){
    // const vm = this;
    //  // setTimeout( ()=>{
    //      $('#'+vm.gid).swipe( {
    //     //Generic swipe handler for all directions
    //     swipe:function(event, direction, distance, duration, fingerCount, fingerData) {
    //       if(direction == 'left') vm.leaveActiveClass = 'animated bounceOutLeft';
    //       if(direction == 'right')vm.leaveActiveClass = 'animated bounceOutRight';
    //       setTimeout(
    //         ()=>{
    //           vm.closed = true;
    //         }
    //         ,300);
    //       vm.closed = true;
    //     },
    //     //Default is 75px, set to 0 for demo so any distance triggers swipe
    //      threshold: 0
    //   });

     // } , 500);
  },
  notifyMe() {
    if(!this.show_browser_notification) return;
 if (Notification.permission !== "granted")
    Notification.requestPermission();
  else {
    //Friend request
    let options = {} , title , url 
    if(this.constrains.index.category == 'friend_request'){
     options = {
      icon : this.domainUser.compressedAvatarUrl , 
      body : this.domainUser.name+' Sent you a friendship request'
     }
     url = this.domainUser.userUrl;
    }else if(this.constrains.index.category == 'friend_request_accepted'){
     options = {
      icon : this.domainUser.compressedAvatarUrl , 
      body : this.domainUser.name+' Accepted your friendship request.'
     }
     url = this.domainUser.userUrl;
    }else if(this.constrains.index.category == 'comment'){
     options = {
      icon : this.domainUser.compressedAvatarUrl , 
      body : this.domainUser.name+' Commented on a knock.'
     }
     url = this.asset('knock/'+this.constrains.index.knock+'/'+this.constrains.index.comment)
    }
    var notification = new Notification('Knocks', options);

    notification.onclick = function () {
      window.open(url);      
    };

  } 
}
}
}
</script>

<style lang="css" scoped>

</style>