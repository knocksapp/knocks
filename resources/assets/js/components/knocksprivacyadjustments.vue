<template>
<div>
	<knocksretriver
	url = "get_circles"
	prevent_on_mount
	:scope = "['kps_circles']"
	@success = "hashCircles($event)"
	v-model = "circlesRetriver"
	></knocksretriver>
	<el-button type="text" @click="triggerModal()">Click to open the Dialog</el-button>
	<el-dialog
	title="Warning"
	:visible.sync="centerDialogVisible"
	width="90%"
	center>
	<div>
		<center>
		<knockstaps :multiple = "false"
		anchor_active_class = "knocks_anchor_color_kit_dark knocks_theme_border"
		anchor_regular_class = "knocks_anchor_color_kit_light "
		anchor_class = "btn knocks_theme_border knocks_noshadow_ps"
		v-model="taps" hide_labels_on_small
		@input = "checkUserClicks()"
		:options = "[
		{ icon : 'knocks-globe' , label : 'Public' , static : true , value : 'public'} ,
		{ icon : 'knocks-atom2' , label : 'Circles' , static : true , value : 'circles'} ,
		{ icon : 'knocks-user-outline' , label : 'Users' , static : true , value : 'users'} ,
		
		]" ></knockstaps></center>
		<div :class = "[ { 'animated slideInUp' : taps == 'circles'} ,  { 'knocks_hidden' : taps != 'circles'} ]">
			<div v-for = "(circle , index) in allCircles" v-if = "allCircles != null" :key = "index" class = "row">
				<knockscirclechip :circle = "circle" v-model = "circleObject[circle]" @input = "hashUsers($event)"></knockscirclechip>
				<knocksmultipleswitch
				v-if = "couldBeMessured.indexOf(circle) != -1"
				class = "right"
				static_messages
				@input = "implementCircles()"
				v-model = "circleSwitch[circle]"
				:options = "[
				{ msg : 'Valid' , icon : 'knocks-eye6 animated rubberBand' , classes : 'green-text' , value : 1  } ,
				{ msg : 'Invalid' , icon : 'knocks-eye-off animated jello' , classes : 'orange-text' , value : 2  } ,
				{ msg : 'Invalid For All' , icon : 'knocks-eye-slash animated tada' , classes : ' red-text darken-4' , value : 3  }
				]"
				:startup_value = "1">
				</knocksmultipleswitch>
			</div>
		</div>
		<div :class = "[ { 'animated slideInUp' : taps == 'users'} ,  { 'knocks_hidden' : taps != 'users'} ]" v-if = "usersClickedOnce">
			<div class = "row">
		 	<knockselinput 
		 	icon = "knocks-search-2" 
		 	autocomplete 
		 	:autocomplete_start="0" 
		 	autocomplete_on_mount
		 	disable_placeholder
		 	autocomplete_from = "user/search" 
		 	@input = "refreshUsersContent()"
		 	@autocomplete="searchUsers = $event; userShowKey = 3" >
		 	</knockselinput>
			</div>
			<table>
				<tr 
				v-for = "(user , index) in searchUsers" 
				v-if = "searchUsers.length != 0" 
				:key = "index" 
					:class = "[{'animated slideOutLeft knocks_hidden' : index >= userShowKey} , {'animated slideInLeft' : index < userShowKey}]">
					<td>
						<knocksuser 
						:user = "user" 
						as_label  ></knocksuser>
					</td>
					<td>
						<div class="switch right">
							<label>
								<span class = "knocks-eye-off animated jello red-text knocks_circular_border"></span>
								<input type="checkbox" v-model = "usersSwitches[user]">
								<span class="lever"></span>
								<span class = "knocks-eye6 animated rubberBand green-text knocks_circular_border"></span>
							</label>
						</div>
					</td>
				</tr>
			</table>
			<a v-if = "searchUsers.length > userShowKey" @click = "userShowKey += 3">
				<static_message msg = "See More"></static_message>
			</a>
			<a v-if = "userShowKey > 3 && searchUsers.length > 3" class = "right" @click = "userShowKey -= 3">
				<static_message msg = "See Less"></static_message>
			</a>
		</div>
	</div>
	<span slot="footer" class="dialog-footer">
		<el-button @click="centerDialogVisible = false">Cancel</el-button>
		<el-button type="primary" @click="centerDialogVisible = false">Confirm</el-button>
	</span>
	</el-dialog>
</div>
</template>

<script>
export default {

  name: 'knocksprivacyadjustments',

  data () {
    return {
    	centerDialogVisible : false ,
    	circlesRetriver : null ,
    	allCircles : null , 
    	lastRetrive : null , 
    	searchUsers : [] , 
    	taps : 'public' , 
    	circleObject : {},
    	couldBeMessured : [] ,
    	users : [] , 
    	usersCircles : {} , 
    	circleSwitch : {} ,
    	usersResult : {} , 
    	usersClickedOnce : false , 
    	userShowKey : 3 , 
    	usersSwitches : {} , 

    }
  },
  methods : {
  	triggerModal(){
  		this.centerDialogVisible = true;
  		App.$emit('knocksRetriver' , {scope : ['kps_circles']});

  	},
  	hashCircles(e){
  		this.allCircles = e.response ;
  	},
  	implementCircles(){
  		let i , j , temp;
  		for(j = 0; j < this.users.length ; j++){
  			temp = [];
  			for(i in this.circleSwitch){
  				if( this.isMemberIn( this.users[j] , parseInt(i) ) ){
  					temp.push(this.circleSwitch[i])
  				}
  			}
           this.usersResult[ this.users[j] ] = this.userState(temp);
           this.usersSwitches[ this.users[j] ] = this.userState(temp);
  		}
  	},
  	isMemberIn(user , circle){
  		return this.usersCircles[user].indexOf(circle) == -1 ? false : true
  	},
  	userState(preset){
  		let i ;
  		if(preset.indexOf(3) != -1) return false
  		for(i = 0; i < preset.length ; i++){
  			if(preset[i] == 1) return true
  		}
  	    return false;
  	},
  	hashUsers(obj){
  		this.couldBeMessured.push(obj.id);
  		let i , j , current;
  			for(j = 0; j < obj.members.length; j++){
  				current = obj.members[j];
  				console.log('c is '+current);
  				if(this.users.indexOf(current) == -1){
  					this.users.push(current)
  					if(this.usersCircles[current] === undefined){
  						this.usersCircles[current] = [obj.id];
  					}else this.usersCircles[current].push(obj.id)
  				}
  			}
  	},
  	checkUserClicks(){
  		if(this.usersClickedOnce) return;
  		else if(this.taps == 'users') this.usersClickedOnce = true; else return;
  	},
  	refreshUsersContent(){
  		App.$emit('KnocksContentChanged')
  	},

  }
}
</script>

<style lang="css" scoped>
</style>