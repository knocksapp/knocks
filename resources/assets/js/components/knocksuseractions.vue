<template>
<div v-if = "userObject != null">
  <div v-if = "!add_remove_only">
  <el-popover
  ref="addtomypeople"
  placement="right"
  width="200"
  trigger="hover">
  <static_message msg= "Add ** to my people" replaceable :replacements = "[{target : '**' , body : userObject.name}]"></static_message>
  </el-popover>
  <el-popover
  style = "max-width : 100vw"
  ref="circlestoaccept"
  v-if = "bond == 'requester' && !show_accept_shortcut"
  placement="bottom"
  @show = "updateBalloonsTimer()"
  @hide="runBalloonsTimer()"
  trigger="click">
  <static_message msg= "Search where you want to add ** or create a new circle." classes = "knocks_text_dark knocks_text_ms"
  replaceable :replacements = "[{target : '**' , body : userObject.name}]">
  </static_message>
  <ul class="uk-list uk-list-striped">
    <knocksquickcircleadder v-model="userCirlces" :scope = "['action_un_cirlce_adder_'+user]" hide_errors placeholder = "Add or Search for circles"></knocksquickcircleadder>
    
    <li v-for = "(circle , index) in userCirlces" :class = "[{'knocks_hidden' : index >= userShowKey}]">
      <el-checkbox v-model="checkedCircles[circle]" class = "bounceInLeft" ></el-checkbox>
      <knockscirclechip class = "animated bounceInRight" :circle="circle" no_rebound :popover = "false"  v-if = "index < userShowKey"></knockscirclechip>
    </li>
  </ul>
  <div class = "row">
    <a :class ="[{'knocks_hidden':!(userCirlces.length > userShowKey)}]" @click = "userShowKey += 3">
      <static_message msg = "See More"></static_message>
    </a>
    <a :class ="[{'knocks_hidden':!(userShowKey > 3 && userCirlces.length > 3)}]" class = "right" @click = "userShowKey -= 3">
      <static_message msg = "See Less"></static_message>
    </a>
  </div>
  </el-popover>
  <el-button
  v-popover:addtomypeople type = "primary"
  @click = "addToMyPeople()"
  v-if="bond == 'other'"
  icon = " knocks-user-add-outline knocks_icon knocks_text_ms" class ="">
  </el-button>
  <el-button
  type = "danger"
  @click = "cancelRequest()"
  v-if="bond == 'requested'"
  icon = " knocks-plus-circle knocks_icon" class ="">
  </el-button>
  <div class = "row knocks_house_keeper" v-if = "bond == 'requester' && !show_accept_shortcut" style="display:block">
    
    <el-button-group>
    <knockselbutton
    type = "danger"
    placeholder = "Decline"
    submit_at = "request/ignore"
    success_at = "done"
    reset_on_success
    :error_at = "[{ res : 'invalid' , msg : 'You already have this circle!' }]"
    :success_msg= " 'Done.'"
    :scope = "['add_friend']"
    @knocks_submit_accepted = "resetContentReject()"
    validation_error = "There's some feilds we need you to complete it."
    connection_error = "There's a problem in your connection, please try again."
    :submit_data = "{ to : user }">
    </knockselbutton>
    <knockselbutton
    type = "success"
    placeholder = "Accept"
    submit_at = "request/accept"
    success_at = "done"
    reset_on_success
    :error_at = "[{ res : 'invalid' , msg : 'You already have this circle!' }]"
    :success_msg= " 'Added to your Circles succesfully!'"
    :scope = "['add_friend']"
    @knocks_submit_accepted = "resetContent()"
    validation_error = "There's some feilds we need you to complete it."
    connection_error = "There's a problem in your connection, please try again."
    :submit_data = "{ target : user, circles : attachedCircles }">
    </knockselbutton>
    <!-- <el-button  type="success">Accept</el-button> -->
    <el-button type="success" v-popover:circlestoaccept >
    <i class = "el-icon-arrow-down el-icon--right"></i>
    </el-button>
    </el-button-group>
  </div>
  <div class="ui buttons white" v-if = "bond == 'friend' && bond != 'me' && userObject.id != auth && extended">
    <knocksbutton 
    button_classes="ui red basic button"
    icon = "knocksapp-circle-minus left "
    disable_placeholder
    leave_class = "animated jello"
    :gid = "'user_action_remove_'+user+'_rand'+_uid"
    success_at = "done"
    :error_at = "[{ res : 'invalid' , msg : 'Invalid Operation' }]"
    success_msg = "Removed succesfully."
    submit_at = "circle/friend/unpair"
    @knocks_submit_accepted = "unpairFriends()"
    :submit_data = '{user : user}'
    ></knocksbutton>

    <button class="ui blue basic button"><span class = "knocks-speech-bubble-1"></span></button>
    <button class="ui yellow basic button"><span class = "knocksapp-star"></span></button>
    </div>
      <div class="ui buttons white" v-if = "bond == 'me' && extended">
    <a :href="asset( 'user/settings')" class="ui secondary basic button"><span class = "knocks-gear"></span> Settings</a>
    </div>
  </div>
    <div v-if = "add_remove_only" class = "col">

    <knocksbutton 
    v-if = "bond == 'friend'"
    button_classes="ui negative basic button"
    icon = "knocksapp-circle-minus "
    leave_class = ""
    hover_class = ""
    placeholder = "Remove"
    :gid = "'user_action_remove_'+user+'_rand'+_uid"
    success_at = "done"
    :error_at = "[{ res : 'invalid' , msg : 'Invalid Operation' }]"
    success_msg = "Removed succesfully."
    submit_at = "circle/friend/unpair"
    @knocks_submit_accepted = "unpairFriends()"
    :submit_data = '{user : user}'
    ></knocksbutton>
    <div class = "ui two buttons" v-if = "bond == 'requester'">
    <knocksbutton
    v-if = "bond == 'requester'"
    placeholder = "Decline"
    submit_at = "request/ignore"
    success_at = "done"
    label_class = "center"
    reset_on_success
    leave_class = ""
    hover_class = ""
    button_classes = "ui negative basic button "
    :error_at = "[{ res : 'invalid' , msg : 'You already have this circle!' }]"
    :success_msg= " 'Done.'"
    :scope = "['add_friend']"
    @knocks_submit_accepted = "resetContentReject()"
    validation_error = "There's some feilds we need you to complete it."
    connection_error = "There's a problem in your connection, please try again."
    :submit_data = "{ to : user }">
    </knocksbutton>
    <knocksbutton
    type = "success"
    v-if = "bond == 'requester'"
    placeholder = "Accept"
    leave_class = ""
    hover_class = ""
    label_class = "center"
    submit_at = "request/accept"
    success_at = "done"
    button_classes = "ui positive basic button "
    reset_on_success
    :error_at = "[{ res : 'invalid' , msg : 'You already have this circle!' }]"
    :success_msg= " 'Added to your Circles succesfully!'"
    :scope = "['add_friend']"
    @knocks_submit_accepted = "resetContent()"
    validation_error = "There's some feilds we need you to complete it."
    connection_error = "There's a problem in your connection, please try again."
    :submit_data = "{ target : user, circles : attachedCircles }">
    </knocksbutton>
  </div>

  <el-button
  @click = "addToMyPeople()"
  class = "ui primary basic button"
  v-if="bond == 'other'"
  :class = "{'knocks_hidden' : bond != 'other'}"
  icon = " knocks-user-add-outline knocks_icon knocks_text_ms" >
  Add To My People
  </el-button>
  <el-button
  @click = "cancelRequest()"
  v-if="bond == 'requested'"
  class = "ui negative basic button"
  icon = " knocks-cancel-circle knocks_icon">
  Cancel Request
  </el-button>

  <a  v-if = "bond == 'me'" :href="asset('user/settings')" class="ui secondary basic button"><span class = "knocks-gear"></span> Settings</a>
  

    </div>
  </div>
  </template>

<script>
export default {

  name: 'knocksuseractions',
  props : {
  	user : {
  		type : Number , 
  		required : true
  	} , 
  	start_as : {
  		type : Object , 
  		default : null
  	} ,
    show_accept_shortcut : {
      type : Boolean , 
      default : false ,
    },
    extended : {
      type : Boolean , 
      default : false ,
    },
    add_remove_only : {
      type : Boolean , 
      default : false 
    },
    extras : {
    type : Object , 
    default : null,
  }
  },
  data () {
    return {
    	userObject : null , 
      userCirlces : [] ,
      checkedCircles : {},
      userShowKey : 3 ,
      rand : Math.floor(Math.random() * 5000) + 1 , 
      auth  : parseInt(UserId)

    }
  },
  mounted(){
  	if(this.start_as != null) this.userObject = this.start_as;
  	const vm = this;
    App.$on('KnocksGlogbalCirclesList' , ()=>{
      vm.userCirlces = window.UserCirclesList;
    });

    App.$on('knocksUserKeyUpdate' , (payloads)=>{
      if(payloads.user == vm.user){
        if(vm.userObject !== null){
        let i ;
        for(i = 0 ; i < payloads.patch.length; i++){
          vm.userObject[payloads.patch[i].key] = payloads.patch[i].value
        }
       
      }
    }
    });

  	App.$on('KnocksContentChanged' , ()=>{
      if(vm.userObject == null) return;
      if(vm.userObject != vm.user){
        if(UsersObject[vm.user] != undefined){
          vm.reboundUser(); 
        }
      }
      setTimeout(()=>{
        if(vm.userObject != vm.user){        
          if(UsersObject[vm.user] != undefined){
            vm.reboundUser(); 
          }
        }
      },300);
    })
    App.$on('knocksUserResetContent' , (id)=>{
      if(id == vm.user){
         vm.reboundUser(); 
      }
    })
  },
  computed : {
  	thatsMe(){
  		return this.userObject.id == UserId ? true : false;
  	},
    bond(){
      if( this.userObject.thatsMe ) return 'me' ;
      if(this.userObject.is_friend) return 'friend';
      if(this.userObject.requester) return 'requester';
      if(this.userObject.requested) return 'requested';
      if(!this.userObject.requested) return 'other';
    },
    attachedCircles(){
      let array , cir ;
      array = [];
      for(cir in this.checkedCircles){
        if(this.checkedCircles[cir])
          array.push(parseInt(cir));
      }
      return array;
    }
  },
  methods : {
  	addToMyPeople(){
  		const vm = this;
  		axios({
  			url : LaravelOrgin + 'request/one' , 
  			method : 'post' ,
  			data : { to : vm.user }
  		}).then((res)=>{
  			if(res == 'invalid'){
  				//Do something
  				return;
  			}else{
  			   vm.userObject.requested = true;
  		     vm.updateClientData();
  			}
  		})
  	},
  	cancelRequest(){
		const vm = this;
  		axios({
  			url : LaravelOrgin + 'request/cancel' , 
  			method : 'post' ,
  			data : { to : vm.user }
  		}).then((res)=>{
  			if(res == 'invalid'){
  				//Do something
  				return;
  			}else{
  			   vm.userObject.requested = false;
  		       vm.updateClientData();
  			}
  		})
  	},
    resetContent(){     
      window.UsersObject[this.user].is_friend = true;
      window.UsersObject[this.user].requester = window.UsersObject[this.user].requested = false ;
      App.$emit('knocksUserResetContent' , this.user);
      App.$emit('knocksUserKeyUpdate' ,
       { user : this.user  , 
        patch : [ 
        { key : 'requested' , value : false } ,
        { key : 'requester' , value : false } , 
        { key : 'is_friend' , value : true  } 
       ]})

      let i ;
      for(i in this.checkedCircles){
        if(this.checkedCircles){
          App.$emit('' , { circle : parseInt(i) , member : this.user  })
        }
      }

      this.$emit('user_action' , { action : 'accept' })
    },
    resetContentReject(){
       window.UsersObject[this.user].is_friend = false;
      window.UsersObject[this.user].requester = window.UsersObject[this.user].requested = false ;
      App.$emit('knocksUserResetContent' , this.user);
      App.$emit('knocksUserKeyUpdate' ,
       { user : this.user  , 
        patch : [ 
        { key : 'requested' , value : false } ,
        { key : 'requester' , value : false } , 
        { key : 'is_friend' , value : false  } 
       ]})

    },
    unpairFriends(){
       App.$emit('knocksUserKeyUpdate' ,
       { user : this.user  , 
        patch : [ 
        { key : 'requested' , value : false } ,
        { key : 'requester' , value : false } , 
        { key : 'is_friend' , value : false  } 
       ]})
       App.$emit('knocksMemberRemoved' , {user : this.user})
    },
  	updateClientData(){
  		App.$emit('knocksUserDataUpdated' , {user : this.user , update : this.userObject});
  	},
  	reboundUser(){
        this.userObject = UsersObject[this.user];
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
    asset(url){
      return window.Asset(url)
    }
 
  }
}
</script>

<style lang="css" scoped>
</style>