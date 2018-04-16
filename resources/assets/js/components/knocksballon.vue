<template>
<transition enter-active-class = "animated bounceInRight" :leave-active-class = "leaveActiveClass" >
  <div class = "knocks_ballon knocks_standard_border_radius knocks_color_kit_light knocks_gray_border knocks_house_keeper animated shake "
    v-if="!closed"
    :id = "gid"
    @mouseover = "hoverAct()"
    @mouseleave="mouseLeaveAct()">
    <div class = " knocks_fair_bounds" >
      <a @click = "leaveActiveClass = 'animated zoomOut'; closed = true" class="right knocks_text_anchor knocks_text_md"><span uk-icon="close"></span></a>
    </div>
    <!--System Ballons-->
    <div v-if = "constrains.index.category == 'System'">
      <div v-html = "constrains.content"></div>
    </div>
    <!--Friend Requests-->
    <div v-if = "constrains.index.category == 'friend_request'" class = "knocks_fair_bounds" >
      <knocksuser :user=  "constrains.index.sender_id" v-model = "domainUser" :show_username = "false"
      image_container_class = "knocks_inline" main_container = "row knocks_house_keeper" name_container_class = " knocks_inline" :extras="{hover_id : gid}">
      </knocksuser>
      <static_message  style = "padding : 3px;" classes = "knocks_text_ms knocks_text_dark" v-if="domainUser != null" msg = "** sent you a friendship request."
      replaceable :replacements = "[ {target : '**' , body : domainUser.name}]"></static_message>
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
    <div v-if = "constrains.index.category == 'friend_request_accepted'" class = "knocks_fair_bounds">
      <knocksuser :user=  "constrains.index.sender_id" v-model = "domainUser" :show_username = "false"
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
        <knocksuser :user=  "constrains.index.sender_id" v-model = "domainUser" :show_username = "false"
        image_container_class = "knocks_inline" main_container = "row knocks_house_keeper" name_container_class = " knocks_inline" :extras="{hover_id : gid}">
        </knocksuser>
        <a :href = "asset('knock/'+constrains.index.knock+'/'+constrains.index.comment)" target="_blank">
          <static_message  style = "padding : 3px;" classes = " knocks_text_dark" v-if="domainUser != null" msg = "** commented on a knock."
          replaceable :replacements = "[ {target : '**' , body : domainUser.name}]"></static_message>
        </a>
      </div>
      <knocksknock  :knock = "constrains.index.knock" :gid="gid+'_ballon_comment_'+constrains.index.comment" interested
      :comments_to_show = "[constrains.index.comment]"
      show_comment_reply_on_mout
      :show_reply_on_mount = "false"
      :current_user = "auth" replier_message = "Leave a comment" ></knocksknock>
    </div>
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
      auth : parseInt(UserId)


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
  },
  methods : {

  	hoverAct(){
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
      App.$emit('knocksUserKeyUpdate' ,
       { user : this. constrains.index.sender_id  , 
        patch : [ 
        { key : 'requested' , value : false } ,
        { key : 'requester' , value : true } , 
        { key : 'is_friend' , value : false  } 
       ]})
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
  	  var vidId = document.getElementById('knocks_notification');
      vidId.play();
      setTimeout(function () {
          vidId.pause();
      },3000);
  	
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
  }
}
}
</script>

<style lang="css" scoped>

</style>