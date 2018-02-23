<template>
	<div>
		
  <!-- Modal Trigger -->
  <knockspopover>
  <template slot = "container">
  	<el-button :class="trigger_class"  type="warning" round :href="'#'+gid+'_panel_modal'" v-if="userCircles != null" @click = "getuserCircles()">
  	<slot name = "trigger"></slot>
  </el-button>
  </template>
  <span slot = "content" class = "knocks_tooltip animated flipInX" style="margin-top:20px !important;"> 
    <span class = "knocks-locked4"></span>
    <static_message msg = "Choose Your Privacy Setting"></static_message>
  </span>
</knockspopover>
  <!-- Modal Structure -->
  <div :id="gid+'_panel_modal'" class="modal knocks_modal">
    <div class="modal-content">
      <slot name = "modal_header">
      	Pick Your privacy options
      </slot>
      <div class="col s12 knocks_fair_bounds">
      <div class = "row ">
          <el-button round class = "knocks_el_round_btn knocks_color_kit knocks_btn_color_kit knocks_borderless">Set default
          </el-button>
      </div>
      <div class = "row">
        <ul class="tabs knocks_text knocks_tabs">
        <li class="tab col s6"><a class="active knocks_tab_anchor" :href="'#'+gid+'_circles_tab'">
          <span class = "knocks-atom2"></span>
          <span class = "hide-on-med-and-down">Circles</span>
        </a></li>
        <li class="tab col s6"><a class=" knocks_tab_anchor"  :href="'#'+gid+'_users_tab'">
          <span class = "knocks-user-outline"></span>
          <span class = "hide-on-med-and-down">Users</span></a></li>
      </ul>
      </div>
      
      <div :id = "gid+'_circles_tab'">
      	 <table  class = "highlight bordered ">
      	 	<tbody>
      	 <tr v-for = "(circle , index) in userCircles" >
      		<td>
      			<knockscirclechip :circle = "circle"></knockscirclechip>
      		</td>
      		<td class = " knocks_fair_right">
      			  <knocksmultipleswitch v-model = "circlesCog[index].value" @input = "mapUsersCog()"
					  :options = "[ 
					     { msg : 'Valid' , icon : 'knocks-eye6 animated rubberBand' , classes : 'green-text' , value : 'valid'  } ,
					     { msg : 'Invalid' , icon : 'knocks-eye-off animated jello' , classes : 'orange-text' , value : 'invalid'  } ,
					     { msg : 'Invalid For All' , icon : 'knocks-eye-slash animated tada' , classes : ' red-text darken-4' , value : 'invalid_for_all'  }
					     ]"
					     startup_value = "valid"
					  static_messages >
				  </knocksmultipleswitch>
      		</td>
      	</tr>
      	 	</tbody>
      </table>
      </div>
      <div :id = "gid+'_users_tab'">
      	<table class = "highlight bordered ">
      		<tbody>
      			<tr v-for = "(user , index) in usersObject">
      			<td>
      				<knocksuser :user="user.user" as_chip show_image name_class = "knocks_text_dark knocks_text_bold" 
		             main_container =  "animated bounceInLeft  knocks_inline right" >
		           </knocksuser> 
      			</td>
      			<td>
      				<span v-for = "(cir , index) in belongsTo(user.user)">
		           	<knockscirclechip  :circle="cir" only_icon ></knockscirclechip>
		           </span>
      			</td>
      			<td>
				  <div class="switch">
				    <label>
				      <span class = "knocks-eye-off animated jello red-text knocks_circular_border"></span>    
				      <input type="checkbox" v-model = "usersCog[index].value" @change = "mapPrivacySetting()">
				      <span class="lever"></span>
				      <span class = "knocks-eye6 animated rubberBand green-text knocks_circular_border"></span>		      
				    </label>
				  </div>
      			</td>
      		</tr>
      		</tbody>
      	</table>
      </div>
    </div>
    </div>
  

  </div>
         
	</div>
</template>

<script>
export default {

  name: 'knocksprivacysetter',
  props : {
  	gid : {
  		type : String , 
  		required : true 
  	} , 
  	trigger_class : {
  		type : String , 
  		default : 'modal-trigger  el-button  knocks_el_round_btn right knocks_noshadow_ps knocks_borderless '
  	}
  },

  data () {
    return {
    	userCircles : null , 
    	circlesCog : [] , 
    	membersObject : {} , 
    	usersObject : [] , 
    	handeldOnce : false ,
    	usersCog : [] ,
    	circlesContainer : [],
    	privacySettingObject :{ users : [] , circles : []} ,
    	privacySetting : {} ,
    }
  },
  mounted(){
  	$('ul.tabs').tabs();
  	$('#'+this.gid+'_panel_modal').modal();
  	const vm = this;
    App.$on('KnocksGlogbalCirclesList' , ()=>{
      vm.getuserCircles();
    });
  	App.$on('circleLoaded' , (data)=>{
      if(vm.userCircles != null)
  		if(data[1] == vm.userCircles.length && !vm.handeldOnce){
  			vm.handeldOnce = true ;
  			//Load the circle members 
  			let circle;
  			for(circle in vm.userCircles){
  				vm.membersObject[vm.userCircles[circle]] = window.UserCircles[vm.userCircles[circle]].members;
  			}
  			vm.mapUsersObject();
  		}
  	});
    
      this.getuserCircles();

  },
  methods : {
  	getuserCircles(){
      this.userCircles = window.UserCirclesList;
      this.mapCircleConfiguration();
  	},
  	mapCircleConfiguration(){
  		let circle ; 
  		this.circlesCog = [];
  		for(circle in this.userCircles){
  			this.circlesCog.push({circle : this.userCircles[circle] , value : 'valid' });
  		}			
  	} ,
  	mapUsersObject(){
  		let circle , member , currentMember , mentionIndex; 
  		for (circle in this.membersObject){
  			for(member in this.membersObject[circle]){
  				currentMember = this.membersObject[circle][member];
  				mentionIndex = this.isMentioned(currentMember);
  				if(mentionIndex == -1){
  					this.usersObject.push({user : currentMember , circles : [parseInt(circle)]});
  				}else{
  					// console.log(this.isMentioned(currentMember));
  					if(this.usersObject[mentionIndex].circles.indexOf(parseInt(circle) ) == -1){
  						this.usersObject[mentionIndex].circles.push(parseInt(circle) )
  					}
  				}
  			}
  			this.mapUsersCog();
  		}
  	},isMentioned(targetUser){
  		let member , flag ; 
  		for(member in this.usersObject){
  			if(this.usersObject[member].user == targetUser)
  				return member;
  		}
  		return -1 ; 
  	},
  	isMentionedUserCog(targetUser){
  		let member , flag ; 
  		for(member in this.usersCog){
  			if(this.usersCog[member].user == targetUser)
  				return member;
  		}
  		return -1 ; 
  	},
  	belongsTo(user){
  	   return this.usersObject[this.isMentioned(user)].circles;
     },
    calcUserCog(user){
    	let circles = this.usersObject[this.isMentioned(user)].circles;
    	let circle , ownedCircles , result;
    	ownedCircles = [];
    	if(this.hasException(user)){
    		//console.log('exception');
    		return this.getUserException(user);
    	}
    	for(circle in this.circlesCog){
    		if(circles.indexOf(this.circlesCog[circle].circle) != -1){
    			ownedCircles.push(this.circlesCog[circle].value);
    		}
    	}
    	if(ownedCircles.indexOf('invalid_for_all') != -1){

    		return false;
    	}else if (ownedCircles.indexOf('valid') != -1){
    		
    		return true;
    	}else if (ownedCircles.indexOf('invalid') != -1){
    		
    		return false;
    	}else return 'unknown';
    },
    mapUsersCog(){
    	this.usersCog = [];
    	let user, mentionedIndex ;
    	for(user in this.usersObject){
    		mentionedIndex = this.isMentionedUserCog(this.usersObject[user].user);
    		if(mentionedIndex == -1){
    			this.usersCog.push({user : this.usersObject[user].user , value : this.calcUserCog(this.usersObject[user].user)});
    		}else{
    			this.usersCog[mentionedIndex].value = this.calcUserCog(this.usersObject[user].user);
    		}
    		
    	}
    	this.mapPrivacySetting();
    },
    mapPrivacySetting(){
    	//console.log('mapping..');
    	let privacySetting = { circles : this.circlesCog , users : [] };
    	let user;
    	for(user in this.usersCog){
    		if(this.exceptionOrNot(user)){
    			//console.log('exeption case');
    			privacySetting.users.push({ user : this.usersCog[user].user , preset : this.validOrInvalid(this.usersCog[user].value) })
    		}
    	}
    	this.privacySettingObject = privacySetting;
    	this.resructurePrivacySetting();

    },
    exceptionOrNot(index){
    	
    	let usersObjectLocation = this.usersObject[index];
    	let usersCogLocation = this.usersCog[index];

    	let circles = usersObjectLocation.circles;
    	let ownedCircles = [] ;
    	let circle;
    	for(circle in this.circlesCog){
    		if(circles.indexOf(this.circlesCog[circle].circle) != -1){
    			ownedCircles.push(this.circlesCog[circle].value);
    		}
    	}
    	if(ownedCircles.indexOf('invalid_for_all') != -1 && usersCogLocation.value == true){
    		return true ;
    	}else if(ownedCircles.indexOf('valid') != -1 
    		&& ownedCircles.indexOf('invalid_for_all') == -1 && usersCogLocation.value == false){
    		return true ;
    	}else if(ownedCircles.indexOf('invalid') != -1 && usersCogLocation.value == true
    		&& ownedCircles.indexOf('valid') == -1 
    		){
    		return true;
    	}else return false ;
    },
    validOrInvalid(state){
    	return state ? 'valid' : 'invalid' ;
    },
    convertToNumericPreset(preset){
    	if(preset == 'valid') return 1;
    	if(preset == 'invalid') return 2;
    	if(preset == 'invalid_for_all') return 3;
    },
   resructurePrivacySetting(){
  	let user , circle , currentCircle , currentUser;
  	let finalObject = {user_privacy : [] , circle_privacy : []};
  	for(circle in this.privacySettingObject.circles){
  		currentCircle = this.privacySettingObject.circles[circle];
  		finalObject.circle_privacy.push
  		({ circle_id : currentCircle.circle , preset_id : this.convertToNumericPreset(currentCircle.value)});
  	}
  	for(user in this.privacySettingObject.users){
  		currentUser = this.privacySettingObject.users[user];
  		finalObject.user_privacy.push
  		({ user_id : currentUser.user , preset_id : this.convertToNumericPreset(currentUser.preset)});
  	}
  	this.privacySetting = finalObject ;
  	this.$emit('input' , this.privacySetting);
  },
  hasException(userId){
  	let user ; 
  	for(user in this.privacySettingObject.users){
  		if(this.privacySettingObject.users[user].user == userId)
  			return true;
  	}
  	return false;
  },
  getUserException(userId){
  	let user ; 
  	for(user in this.privacySettingObject.users){
  		if(this.privacySettingObject.users[user].user == userId)
  			return this.privacySettingObject.users[user].preset;
  	}
  	return false;
  }
  },

  
}
</script>

<style lang="css" scoped>
</style>