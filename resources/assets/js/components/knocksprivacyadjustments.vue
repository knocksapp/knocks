<template>
<div>
	<knocksretriver
	url = "get_circles"
	prevent_on_mount
	:scope = "['kps_circles']"
	@success = "hashCircles($event)"
	v-model = "circlesRetriver"
	></knocksretriver>
	<knocksretriver
	url = "user/preset/get"
	prevent_on_mount
	:scope = "['kps_presets']"
	@success = "userPresets = $event.response"
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
		{ icon : 'knocks-globe' , label : 'Public' , static : true , value : 'public' } ,
		{ icon : 'knocks-atom2' , label : 'Circles' , static : true , value : 'circles' , disabled : publicValue != 'custom'} ,
		{ icon : 'knocks-user-outline' , label : 'Users' , static : true , value : 'users' , disabled : publicValue != 'custom'} ,
		
		]" ></knockstaps></center>
		<div class = "row" v-if = "publicValue == 'custom' && taps != 'public'">
			<div class = "row" v-if = "!savingMode">
				<button class="ui primary basic button" @click = "saveAsDefault = false ; savingMode = true">
					<span class = "knocks-save"></span>
					<static_message msg = "Save Preset"></static_message>
				</button>
				<button class="ui positive basic button right" @click = "saveAsDefault = true ; savingMode = true">
					<span class = "knocks-star12"></span>
					<static_message msg = "Set As Default"></static_message>
				</button>
			</div>
			<div v-if = "savingMode" class="row animated slideInUp">
			<a @click = "savingMode = false" class="right knocks_text_ms red-text">
				<static_message msg = "Close"></static_message>
				<span class = "knocks-close3 "></span>
			</a><br/><br/>
			<knockselinput
			placeholder = "Preset Name"
			is_required
			check_live
			check_at = "user/preset/check"
			check_valid_at = "valid"
			check_invalid_at = "invalid"
			check_live_msg = "You already have a preset with this name"
			has_slot
			v-model = "presetAdderName"
			>
			<knockselbutton 
			submit_at = "user/preset/save"
			:submit_data = "{ name : presetAdderName , object : resultObject , default : saveAsDefault }"
			disable_placeholder
			knocks_submit_accepted = "userPresets.push(presetAdderName)"
			icon = "knocks-plus"
			:error_at = "[
			{ res : 'invalid' , msg : 'You already have a preset with this name.' }
			]"
			success_at = "done"
			slot = "aside">
			</knockselbutton>
			</knockselinput>
			</div>
			
		</div>
		<div :class = "[ { 'animated slideInUp' : taps == 'circles' } ,  { 'knocks_hidden' : taps != 'circles' || savingMode } , 'row']" style="max-height : 500px; overflow : auto">
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
		<div :class = "[ { 'animated slideInUp' : taps == 'public'} ,  { 'knocks_hidden' : taps != 'public'} ]" >
			    <ul class="collection">
      <li class="collection-item" @click = "changePublicValue('public')">
      	<span class = "knocks-globe knocks_text_md blue-text text-darken-3"></span>
      	<static_message msg = "Public" classes = "knocks_text_md"></static_message>
      	 <a @click = "changePublicValue('public')" class = "right knocks_text_md">
      	 	<span class = "knocks-checkmark animated rotateIn green-text" v-if = "publicValue == 'public'"></span>
      	 	<span class = "knocks-minus  animated rotateIn red-text" v-if = "publicValue != 'public'"></span>
      	 </a>
      </li>
      <li class="collection-item" @click = "changePublicValue('onlyforfriends')">
      	<span class = "knocks-group-1 knocks_text_md green-text "></span>
      	<static_message msg = "Only For Friends" classes = "knocks_text_md"></static_message>
      	 <a @click = "changePublicValue('onlyforfriends')" class = "right knocks_text_md">
      	 	<span class = "knocks-checkmark animated rotateIn green-text" v-if = "publicValue == 'onlyforfriends'"></span>
      	 	<span class = "knocks-minus  animated rotateIn red-text" v-if = "publicValue != 'onlyforfriends'"></span>
      	 </a>
      </li>
      <li class="collection-item" @click = "changePublicValue('choosedefault')">
        <span class = "knocks-star3 knocks_text_md yellow-text text-darken-3 "></span>
        <static_message msg = "Use My Default Preset" classes = "knocks_text_md"></static_message>
         <a @click = "changePublicValue('choosedefault')" class = "right knocks_text_md">
          <span class = "knocks-checkmark animated rotateIn green-text" v-if = "publicValue == 'choosedefault'"></span>
          <span class = "knocks-minus  animated rotateIn red-text" v-if = "publicValue != 'choosedefault'"></span>
         </a>
      </li>
      <li class="collection-item" @click = "changePublicValue('userpresets')" >
      	<span class = "knocks-heart red-text knocks_text_md"></span>
      	<static_message msg = "Choose From My Presets" classes = "knocks_text_md"></static_message>
      	 <a @click = "changePublicValue('userpresets')" class = "right knocks_text_md">
      	 	<span class = "knocks-checkmark animated rotateIn green-text" v-if = "publicValue == 'userpresets'"></span>
      	 	<span class = "knocks-minus  animated rotateIn red-text" v-if = "publicValue != 'userpresets'"></span>
      	 </a>
      	 <h4 class="ui horizontal divider header transparent" v-if = "publicValue == 'userpresets' && userPresets != null && userPresets.length > 0">
  <i class="knocks-locked4"></i>
  <static_message msg = "Your Presets"></static_message>
</h4>
      	 <ul class="uk-list uk-list-divider animated slideInUp" v-if = "publicValue == 'userpresets' && userPresets != null && userPresets.length > 0">
      	 	<li v-for = "pres in userPresets">
            <a>
              <span :class = "['knocks-star12 yellow-text' , 'knocks_text_ms']"></span>
            </a>
      	 		<span class = "knocks_text_ms knocks_text_dark_active">{{pres.name}}</span>
      	 		    <span class = "right">
      <input :value = "pres.id" v-model = "userPresetsRadio" type="radio" :id="'userpresets_'+pres.id" @change = "setRadioPreset(pres.preset)" />
      <label :for="'userpresets_'+pres.id"></label>
    </span>

      	 	</li>
      	 </ul>
      	 <p v-if = "publicValue == 'userpresets' && userPresets != null && userPresets.length == 0">
      	 	<static_message msg = "You have no presets."></static_message>
      	 </p>

      </li>
      <li class="collection-item" @click = "changePublicValue('custom')">
      	<span class = "knocks-cog9 knocks_text_md pink-text text-darken-1"></span>
      	<static_message msg = "Custom" classes = "knocks_text_md"></static_message>
      	 <a @click = "changePublicValue('custom')" class = "right knocks_text_md">
      	 	<span class = "knocks-checkmark animated rotateIn green-text" v-if = "publicValue == 'custom'"></span>
      	 	<span class = "knocks-minus  animated rotateIn red-text" v-if = "publicValue != 'custom'"></span>
      	 </a>
      </li>
    </ul>
		</div>
		<div :class = "[ { 'animated slideInUp' : taps == 'users'} ,  { 'knocks_hidden' : taps != 'users' || savingMode } ]" v-if = "usersClickedOnce">
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
						v-if = "index < userShowKey"
						:user = "user"
						as_label  ></knocksuser>
					</td>
					<td>
						<div class="switch right">
							<label>
								<span class = "knocks-eye-off animated rotateIn red-text knocks_circular_border"></span>
								<input type="checkbox" v-model = "usersSwitches[user]" class = "knocks_kps_switch" @change = "collectUsersExceptions()">
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
	<span slot="footer" class="dialog-footer row">
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
    	circlesClickedOnce : false , 
    	userShowKey : 3 , 
    	usersSwitches : {} , 
    	usersExceptions : [] ,
    	publicValue : 'choosedefault' ,
    	presetAdderName : '' , 
    	savingMode : false , 
    	saveAsDefault : false ,
    	userPresets : [] , 
    	userPresetsRadio : null ,
    	userPresetsRadioSetting : null ,

    }
  },
  mounted(){

  },
  computed : {
  	circleSwitchStructure(){
  		let i , arr = [];
  		for (i in this.circleSwitch){
  			arr.push({ circle_id : parseInt(i) , preset_id : this.circleSwitch[i] })
  		}
  		return arr;
  	},
  	resultObject(){
       let res ; 

       if(this.publicValue == 'custom')
  		 res = {
        tip :  this.publicValue , 
  			circle_privacy : this.circleSwitchStructure , 
  			user_privacy : this.usersExceptions , 
  		}
      else if(this.publicValue == 'userpresets'){
        res = (this.userPresetsRadioSetting == null) ? {
            tip :  this.publicValue , 
            circle_privacy : null , 
            user_privacy : null , 
          }
          :
          {
            tip :  this.publicValue , 
            circle_privacy : this.userPresetsRadioSetting.circle_privacy , 
            user_privacy : this.userPresetsRadioSetting.circle_privacy , 
          }
      }
  		this.$emit('input' , res);
  		return res;
  	}

  },
  methods : {
  	triggerModal(){
  		this.centerDialogVisible = true;	
  		

  	},
  	boolToPreset(flag){
  		return flag ? 1 : 2
  	},
  	collectUsersExceptions(){
  		let i , arr = [];
  		for (i in this.usersSwitches){
  			if(this.usersResult[i] != this.usersSwitches[i])
  				arr.push({ userId : parseInt(i) , preset_id : this.boolToPreset(this.usersSwitches[i]) })
  		}
  	   this.usersExceptions = arr ;
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
  		let i , ifa = false , v = false ;
  		for(i = 0; i < preset.length ; i++){
  			if(preset[i] == 3) ifa =  true
  			if(preset[i] == 1) v =  true
  		}
  	    return ifa || !v ? false : true;
  	},
  	hashUsers(obj){
  		this.couldBeMessured.push(obj.id);
  		let i , j , current;
  			for(j = 0; j < obj.members.length; j++){
  				current = obj.members[j];
  				console.log('c is '+current);
  				if(this.users.indexOf(current) == -1){
  					this.users.push(current)
  				}
				if(this.usersCircles[current] == undefined){
					this.usersCircles[current] = [obj.id];
				}else this.usersCircles[current].push(obj.id)
  				
  			}
  	},
  	changePublicValue(value){
  		if(this.publicValue == value) return ;
  		this.publicValue = value;
  		if(this.publicValue == 'userpresets')
  			App.$emit('knocksRetriver' , {scope : ['kps_presets']});
      if (this.publicValue == 'custom') {
        App.$emit('knocksRetriver' , {scope : ['kps_circles']});
      }

  	},
  	checkUserClicks(){
  		if(this.taps == 'users'){

  			this.usersClickedOnce = true; 
  		}
  		else if(this.taps == 'circles'){
  			this.circlesClickedOnce = true; 
  			//App.$emit('knocksRetriver' , {scope : ['kps_circles']});
  		}else return;
  		
  	},
  	refreshUsersContent(){
  		App.$emit('KnocksContentChanged')
  	},
    setRadioPreset(preset){
      this.userPresetsRadioSetting = JSON.parse(preset);
    }

  }
}
</script>

<style lang="css" scoped>
</style>