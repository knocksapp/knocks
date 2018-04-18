<template>
<transition enter-active-class = "animated bounceInRight" :leave-active-class = "leaveActiveClass" >
  <div :class = "container_class"
    v-if="!closed"
    :id = "gid"
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
      <knocksuser :user=  "constrains.index.sender_id" v-model = "domainUser" :show_username = "false" @input = "notifyMe()"
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
      <knocksuser no_rebound :user=  "constrains.index.sender_id" v-model = "domainUser" :show_username = "false"
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
      <div class = "knocks_fair_bounds">
        <knocksuser  :user=  "constrains.index.sender_id" v-model = "domainUser" :show_username = "false"
        image_container_class = "knocks_inline" main_container = "row knocks_house_keeper" name_container_class = " knocks_inline" :extras="{hover_id : gid}">
        </knocksuser>
        <a :href = "asset('knock/'+constrains.index.knock+'/'+constrains.index.comment)" target="_blank">
          <static_message  style = "padding : 3px;" classes = " knocks_text_dark" v-if="domainUser != null" msg = "** commented on a knock."
          replaceable :replacements = "[ {target : '**' , body : domainUser.name}]"></static_message>
        </a>
      </div>
      <knocksknock  :knock = "constrains.index.knock" :gid="gid+'_ballon_comment_'+constrains.index.comment" interested
      :comments_to_show = "[constrains.index.comment]"
      :show_comment_reply_on_mout = "!hide_replies"
      :show_reply_on_mount = "false"
      :current_user = "auth" replier_message = "Leave a comment" ></knocksknock>
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
      sm : { fr : '' }


    }
  },
  mounted(){
  	this.countDown();
  	this.soundNotification();
    this.swipeToLeave();
    this.watchCallBacks();
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
      if(this.constrains.index.category == 'friend_request'){
      // App.$emit('knocksUserKeyUpdate' ,
      //  { user : this. constrains.index.sender_id  , 
      //   patch : [ 
      //   { key : 'requested' , value : false } ,
      //   { key : 'requester' , value : true } , 
      //   { key : 'is_friend' , value : false  } 
      //  ]})
      }
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
	  	 	if(this.intervalCounter == 10){
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
      if(this.mute) return;
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