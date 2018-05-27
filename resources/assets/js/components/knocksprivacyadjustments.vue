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
  v-model = "userPresetsRetriver"
  @success = "handleRetrivePresets($event)"
  ></knocksretriver>
  <knocksretriver
  url = "user/preset/default"
  prevent_on_mount
  :scope = "['kpsd_presets']"
  @success = "handleDefaultPreset($event.response)"
  ></knocksretriver>
   <el-tooltip  placement="bottom" effect="light" v-if = "!hide_trigger">
    <span slot = "content">
      <span class = "knocks-locked4 yellow-text text-darken-3" v-if = "publicValue == null || publicValue == ''"></span>   
      <span class = "knocks-globe knocks_text_md blue-text text-darken-3 knocks_icon_border" v-if = "publicValue == 'public'"></span>
      <span class = "knocks-group-1 knocks_text_md green-text knocks_icon_border" v-if = "publicValue == 'onlyforfriends'"></span>
      <span class = "knocks-star3 knocks_text_md yellow-text text-darken-3 knocks_icon_border" v-if = "publicValue == 'choosedefault'"></span>
      <span class = "knocks-heart red-text knocks_text_md knocks_icon_border" v-if = "publicValue == 'userpresets'"></span>
      <span class = "knocks-cog9 knocks_text_md pink-text text-darken-1 knocks_icon_border" v-if = "publicValue == 'custom'"></span>
      <static_message msg=  "Choose your privacy setting."></static_message>  
    </span>

  <a @click="triggerModal()" :class = "trigger_class">
    <center>
      <span class = "knocks-locked4" v-if = "publicValue == null || publicValue == ''"></span>
      <span class = "knocks-globe animated jello text-darken-3" v-if = "publicValue == 'public'"></span>
      <span class = "knocks-group-1 animated jello" v-if = "publicValue == 'onlyforfriends'"></span>
      <span class = "knocks-star3 animated jello text-darken-3 " v-if = "publicValue == 'choosedefault'"></span>
      <span class = "knocks-heart animated jello  " v-if = "publicValue == 'userpresets'"></span>
      <span class = "knocks-cog9  animated jello text-darken-1" v-if = "publicValue == 'custom'"></span>
    </center>
  </a>
   
</el-tooltip>
  <el-dialog
  :visible.sync="centerDialogVisible"
  width="90%"
  append-to-body
  center>
  <div >
    <center>
    <knockstaps :multiple = "false"
    anchor_active_class = "knocks_anchor_color_kit_dark knocks_theme_border"
    anchor_regular_class = "knocks_anchor_color_kit_light "
    anchor_class = "btn knocks_theme_border knocks_noshadow_ps"
    :scope = "['kps_taps']"
    v-model="taps" hide_labels_on_small
    @input = "checkUserClicks()"
    :options = "[
    { icon : 'knocks-eye6' , label : 'General' , static : true , value : 'public' } ,
    { icon : 'knocks-atom2' , label : 'Circles' , static : true , value : 'circles' , disabled : publicValue != 'custom'} ,
    { icon : 'knocks-user-outline' , label : 'Users' , static : true , value : 'users' , disabled : publicValue != 'custom'} ,
    
    ]" ></knockstaps></center>
    <div class = "row" v-if = "publicValue == 'custom' && taps != 'public'">
      <div class = "row" v-if = "!savingMode">
        <button class="ui primary basic button" @click = "saveAsDefault = false ; savingMode = true">
        <span class = "knocks-save"></span>
        <static_message msg = "Save Preset" class = "hide-on-small-only"></static_message>
        </button>
        <button class="ui orange basic button right" @click = "saveAsDefault = true ; savingMode = true">
        <span class = "knocks-star12"></span>
        <static_message msg = "Set As Default" class = "hide-on-small-only"></static_message>
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
        :scope = "['preset_adder']"
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
        @knocks_submit_accepted = "handleAddPreset($event)"
        computed_response
        :scope = "['preset_adder']"
        slot = "aside">
        </knockselbutton>
        </knockselinput>
      </div>
      
    </div>
    <div :class = "[ { 'animated slideInUp' : taps == 'circles' } ,  { 'knocks_hidden' : taps != 'circles' || savingMode } , 'row']" style="max-height : 400px; overflow : auto">
      <ul class ="uk-list uk-list-divider">
      <li class = "" >
        <div class="chip blue text-darken-3 col knocks_text_light knocks_text_bold knocks_text_ms">
          <span class = "knocks-globe"></span>
          <static_message msg = "Public"></static_message>
        </div>
        <knocksmultipleswitch
        class = "right"
        static_messages
        v-model = "circleSwitch['-1']"
        :options = "[
        { msg : 'Valid' , icon : 'knocks-eye6 animated rubberBand' , classes : 'green-text' , value : signs.valid  } ,
        { msg : 'Invalid' , icon : 'knocks-eye-off animated jello' , classes : 'orange-text' , value : signs.invalid  } ,
        { msg : 'Invalid For All' , icon : 'knocks-eye-slash animated tada' , classes : ' red-text darken-4' , value : signs.invalidForAll  }
        ]"
        :startup_value = "signs.valid"></knocksmultipleswitch>
      </li>
      <li v-for = "(circle , index) in allCircles" v-if = "allCircles != null" :key = "index" class = "">
        <knockscirclechip 
        :circle = "circle" 
        v-model = "circleObject[circle]" 
        @input = "hashUsers($event)" 
        @error = "allCircles.splice(index,1)"
        class = "col" no_rebound ></knockscirclechip>
        <knocksmultipleswitch
        v-if = "couldBeMessured.indexOf(circle) != -1"
        class = "right"
        static_messages
        @input = "implementCircles()"
        v-model = "circleSwitch[circle]"
        :recieve_scope = "[_uid + '_kpsj_'+circle]"
        :options = "[
        { msg : 'Valid' , icon : 'knocks-eye6 animated rubberBand' , classes : 'green-text' , value : signs.valid  } ,
        { msg : 'Invalid' , icon : 'knocks-eye-off animated jello' , classes : 'orange-text' , value : signs.invalid  } ,
        { msg : 'Invalid For All' , icon : 'knocks-eye-slash animated tada' , classes : ' red-text darken-4' , value : signs.invalidForAll  }
        ]"
        :startup_value = "signs.valid">
        </knocksmultipleswitch>
      </li>
    </ul>
    </div>
    <div :class = "[ { 'animated slideInUp' : taps == 'public'} ,  { 'knocks_hidden' : taps != 'public'} ]" >
      <ul class="collection">
        <li class="collection-item" @click = "tipFired = true; changePublicValue('public')" v-if = "!disable_quick_presets">
          <span class = "knocks-globe knocks_text_md blue-text text-darken-3"></span>
          <static_message msg = "Public" classes = "knocks_text_md"></static_message>
          <a @click = "tipFired = true; changePublicValue('public')" class = "right knocks_text_md">
            <span class = "knocks-checkmark animated rotateIn green-text" v-if = "publicValue == 'public'"></span>
            <span class = "knocks-minus  animated rotateIn red-text" v-if = "publicValue != 'public'"></span>
          </a>
          <p v-if = "publicValue == 'public'">
            <static_message msg = "This will make your content visible for everyone expect people that you are blocking."></static_message>
          </p>
        </li>
        <li class="collection-item" @click = "tipFired = true; changePublicValue('onlyforfriends')"  v-if = "!disable_quick_presets">
          <span class = "knocks-group-1 knocks_text_md green-text "></span>
          <static_message msg = "Only For Friends" classes = "knocks_text_md"></static_message>
          <a @click = "tipFired = true; changePublicValue('onlyforfriends')" class = "right knocks_text_md">
            <span class = "knocks-checkmark animated rotateIn green-text" v-if = "publicValue == 'onlyforfriends'"></span>
            <span class = "knocks-minus  animated rotateIn red-text" v-if = "publicValue != 'onlyforfriends'"></span>
          </a>
           <p v-if = "publicValue == 'onlyforfriends'">
            <static_message msg = "This will make your content only visible for your friends."></static_message>
          </p>
        </li>
        <li class="collection-item" @click = "tipFired = true; changePublicValue('choosedefault')" v-if = '!disable_quick_presets && userDefaultPreset.outcome != null'>
          <span class = "knocks-star3 knocks_text_md yellow-text text-darken-3 "></span>
          <static_message msg = "Use My Default Preset" classes = "knocks_text_md"></static_message> 
          <span class = " knocks_text_ms yellow-text text-darken-3 ">({{userDefaultPreset.name}})</span>
          <a @click = "tipFired = true; changePublicValue('choosedefault')" class = "right knocks_text_md">
            <span class = "knocks-checkmark animated rotateIn green-text" v-if = "publicValue == 'choosedefault'"></span>
            <span class = "knocks-minus  animated rotateIn red-text" v-if = "publicValue != 'choosedefault'"></span>
          </a>
          <p v-if = "publicValue == 'choosedefault'">
            <static_message msg = "This will automatically set your content visibility to your default Privacy Preset.">
            ></static_message> ({{userDefaultPreset.name}}).
          </p>
        </li>
        <li class="collection-item" @click = "tipFired = true; changePublicValue('userpresets')" v-if = "!disable_quick_presets" v-loading = "userPresetsRetriver.loading">
          <span class = "knocks-heart red-text knocks_text_md"></span>
          <static_message msg = "Choose From My Presets" classes = "knocks_text_md"></static_message>
          <a @click = "tipFired = true; changePublicValue('userpresets')" class = "right knocks_text_md">
            <span class = "knocks-checkmark animated rotateIn green-text" v-if = "publicValue == 'userpresets'"></span>
            <span class = "knocks-minus  animated rotateIn red-text" v-if = "publicValue != 'userpresets'"></span>
          </a>           
          <p :class =  "[{ 'knocks_hidden' :  !(publicValue != 'userpresets')}]">
            <static_message msg = "Knocks Privacy Presets let you quickly choose your content privacy setting from your own presets."></static_message>
          </p>
          <h4 class="ui horizontal divider header transparent" v-if = "publicValue == 'userpresets' && userPresets != null && userPresets.length > 0">
          <i class="knocks-locked4"></i>
          <static_message msg = "Your Presets"></static_message>
          </h4>
          <ul
            style = "max-height: 200px; overflow: auto;"
            class="uk-list uk-list-divider animated slideInUp"
            v-if = "publicValue == 'userpresets' && userPresets != null && userPresets.length > 0">
            <li v-for = "(pres , index) in userPresets">
              <el-button-group>
              <knockselbutton
              submit_at = "user/preset/fav"
              :submit_data = "{ preset : pres.id }"
              disable_placeholder
              @knocks_submit_accepted = "handleDefaultPreset({ outcome : pres.id , name : pres.name})"
              icon = "knocks-star yellow-text text-darken-3"
              :error_at = "[
              { res : 'invalid' , msg : 'You already have a preset with this name.' }
              ]"
              :disabled = "userDefaultPreset.outcome == pres.id"
              size = "small"
              rounded
              type = "default"
              success_at = "done"
              :scope = "['preset_fav']"
              >
              </knockselbutton>
              
              <knockselbutton
              submit_at = "user/preset/delete"
              :submit_data = "{ preset : pres.id }"
              disable_placeholder
              type = "default"
              size = "small"
              @knocks_submit_accepted = "handleDeletePreset($event , index)"
              icon = "knocks-trash red-text"
              :error_at = "[
              { res : 'invalid' , msg : 'You already have a preset with this name.' }
              ]"
              rounded
              computed_response
              :scope = "['preset_delete']"
              >
              </knockselbutton>
              </el-button-group>
              
              <span class = "knocks_text_ms knocks_text_dark_active knocks_side_padding">{{pres.name}}</span>
              <span class = "right">
                <input :value = "pres.id" v-model = "userPresetsRadio" type="radio" :id="'userpresets_'+pres.id" @change = "setRadioPreset(pres.preset)" />
                <label :for="'userpresets_'+pres.id"></label>
              </span>
            </li>
          </ul>
          <p :class = "[{'knocks_hidden' :!(presetsRetriverFired && userPresets != null && userPresets.length == 0)}]">
            <static_message msg = "You have no presets, select "></static_message>
             <i class = "knocks-cog9 knocks_text_ms pink-text text-darken-1"></i>
             <static_message msg = "Custom" classes = "knocks_text_bold"></static_message>
            <static_message msg = " and create your own Privacy Presets."></static_message>
          </p>
        </li>
        <li class="collection-item" @click = "tipFired = true; changePublicValue('custom')">
          <span class = "knocks-cog9 knocks_text_md pink-text text-darken-1"></span>
          <static_message msg = "Custom" classes = "knocks_text_md"></static_message>
          <a @click = "tipFired = true; changePublicValue('custom')" class = "right knocks_text_md">
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
      <div style="max-height : 400px; overflow : auto">
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
      <a :class ="[{'knocks_hidden':!(searchUsers.length > userShowKey)}]" @click = "userShowKey += 3">
        <static_message msg = "See More"></static_message>
      </a>
      <a :class ="[{'knocks_hidden':!(userShowKey > 3 && searchUsers.length > 3)}]" class = "right" @click = "userShowKey -= 3">
        <static_message msg = "See Less"></static_message>
      </a>
    </div>
    </div>
  </div>
    <span slot="footer" class="dialog-footer">
      <slot name = "footer"></slot>
    </span>
  </el-dialog>
</div>
</template>

<script>
export default {

  name: 'knocksprivacyadjustments',
  props : {
    trigger_class : {
      type : [ Object , Array , String ],
      default : ''
    },
    hide_trigger : {
      type : Boolean , 
      default : false
    },
    scope : {
      type : Array , 
      default : null ,
    },
    signs : {
      type : Object , 
      default : ()=>{
        return {
          valid : 1 , 
          invalid : 2 , 
          invalidForAll : 3 
        }
      }
    },
    keys : {
      type : Object , 
      default : ()=>{
        return {
          circle : 'circle_id' , 
          user : 'user_id' , 
          preset : 'preset_id'
        }
      }
    },
    disable_quick_presets : {
      type : Boolean , 
      default : false
    },
    init : {
      type : Object , 
      default : null
    }
  },
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
    	publicValue :  'public' ,
    	presetAdderName : '' , 
    	savingMode : false , 
    	saveAsDefault : false ,
    	userPresets : [] , 
    	userPresetsRadio : null ,
    	userPresetsRadioSetting : null ,
	    userDefaultPreset : { outcome : null , name : null } ,
	    presetsRetriverFired : false ,
	    userPresetsRetriver : { loading : false } ,
	    tipFired : false ,
      initCounts : 0

    }
  },
  mounted(){
    if(!this.disable_quick_presets)
    this.changePublicValue('choosedefault');
    else this.changePublicValue('custom')
    if(this.init){
      this.initComponent(this.init , true)
    }
    const vm = this;
    App.$on('knocksPrivacyAdjustmentsTrigger' , (payloads)=>{
      if(vm.scope == null || payloads.scope === undefined || payloads.scope == null || payloads.scope.length == 0) return;
      let i ; 
      for(i = 0 ; i < payloads.scope.length; i++){
        if(vm.scope.indexOf(payloads.scope[i]) != -1){
          if(payloads.state){
            vm.triggerModal();
          }
        }
      }
    })
  },
  computed : {
  	circleSwitchStructure(){
  		let i , arr = []; 
      let temp
  		for (i in this.circleSwitch){
        temp = {}
        temp[this.keys.circle] = parseInt(i)
        temp[this.keys.preset] = this.circleSwitch[i]
  			arr.push(temp)
  		}
  		return arr;
  	},
  	resultObject(){
       let res  = { tip : this.publicValue }; 


       if(this.publicValue == 'custom'){
  	
  			res.circle_privacy = this.circleSwitchStructure 
  			res.user_privacy = this.usersExceptions 
      } else if(this.publicValue == 'userpresets'){
        if(this.userPresetsRadioSetting == null){
            res.circle_privacy = null 
            res.user_privacy = null 
          }else{
            res.circle_privacy = this.userPresetsRadioSetting.circle_privacy 
            res.user_privacy = this.userPresetsRadioSetting.user_privacy 
          }
      } 
  		this.$emit('input' , res);
  		return res;
  	}

  },
  methods : {
  	triggerModal(){
      this.circlesRetriver.retrive()
  		this.centerDialogVisible = true;	
  		if(
  		     (	this.resultObject.user_privacy === undefined 
	  			|| this.resultObject.circle_privacy === undefined 
	  			|| this.resultObject.user_privacy === null 
	  			|| this.resultObject.circle_privacy === null  )
  			    && !this.tipFired
  			
  		  ){
  		  	App.$emit('knocksRetriver' , {scope : ['kpsd_presets']});
          // App.$emit('knocksRetriver' , {scope : ['kps_circles']});
  		    App.$emit('knocks_change_taps_value' , {scope : ['kps_taps'] , index : 0})
  		}
      this.$emit('input' , this.resultObject);

  	},
  	boolToPreset(flag){
  		return flag ? this.signs.valid : this.signs.invalid
  	},
  	collectUsersExceptions(){
  		let i , arr = []; 
      let temp
  		for (i in this.usersSwitches){
  			if(this.usersResult[i] != this.usersSwitches[i]){
          temp = {}
          temp[this.keys.user] = parseInt(i)
          temp[this.keys.preset] = this.boolToPreset(this.usersSwitches[i])
  				arr.push( temp )
        }
  		}
  	   this.usersExceptions = arr ;
       this.$emit('input' , this.resultObject);
  	},
  	hashCircles(e){
      if(this.allCircles == null) this.allCircles = []
      let i 
      for(i = 0; i < e.response.length; i++){
        if(this.allCircles.indexOf(e.response[i]) == -1)
          this.allCircles.push(e.response[i])
      }
      for(i = 0; i < this.allCircles.length; i++){
        if(e.response.indexOf(this.allCircles[i]) == -1){
          this.allCircles.splice(i , 1)
        }
      }
      App.$emit('KnocksContentChanged')
      if(this.init){
        this.initComponent(this.init , false)
      }
      this.$emit('input' , this.resultObject);
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
      this.$emit('input' , this.resultObject);
  	},
  	isMemberIn(user , circle){
  		return this.usersCircles[user].indexOf(circle) == -1 ? false : true
  	},
  	userState(preset){
  		let i , ifa = false , v = false ;
  		for(i = 0; i < preset.length ; i++){
  			if(preset[i] == this.signs.invalidForAll) ifa =  true
  			if(preset[i] == this.signs.valid) v =  true
  		}
  	    return ifa || !v ? false : true;
  	},
  	hashUsers(obj){
  		this.couldBeMessured.push(obj.id);
  		let i , j , current;
  			for(j = 0; j < obj.members.length; j++){
  				current = obj.members[j];
  				if(this.users.indexOf(current) == -1){
  					this.users.push(current)
  				}
				if(this.usersCircles[current] == undefined){
					this.usersCircles[current] = [obj.id];
				}else this.usersCircles[current].push(obj.id)
  				
  			}
  	},
  	changePublicValue(value){

  		if(this.publicValue == value) { this.$emit('input' , this.resultObject); return ;}
  		this.publicValue = value;
  		if(this.publicValue == 'userpresets')
  			App.$emit('knocksRetriver' , {scope : ['kps_presets']});
      if (this.publicValue == 'custom') {
        // App.$emit('knocksRetriver' , {scope : ['kps_circles']});
        this.circlesRetriver.retrive()
      }
      if(this.publicValue == 'custom'){
        App.$emit('knocks_change_taps_value' , {scope : ['kps_taps'] , index : 1})
      }
      if(this.publicValue == 'public'){
        this.userPresetsRadioSetting = null ;
        this.userPresetsRadio = null ;
      }
      if(this.publicValue != 'custom' && this.disable_quick_presets)
        this.publicValue = 'custom'
      this.$emit('input' , this.resultObject);


  	},
  	checkUserClicks(){
  		if(this.taps == 'users'){

  			this.usersClickedOnce = true;
        this.$emit('input' , this.resultObject); 
  		}
  		else if(this.taps == 'circles'){
  			this.circlesClickedOnce = true; 
        this.$emit('input' , this.resultObject);
  			//App.$emit('knocksRetriver' , {scope : ['kps_circles']});
        this.circlesRetriver.retrive()
  		}else return;
  		
  	},
  	refreshUsersContent(){
  		App.$emit('KnocksContentChanged')
  	},
    setRadioPreset(preset){
      this.userPresetsRadioSetting = JSON.parse(preset);
      this.$emit('input' , this.resultObject);
    },
    handleDefaultPreset(e){
      this.userDefaultPreset = e; if(e.outcome != null)this.publicValue = 'choosedefault'; 
      else{
        if(this.publicValue == 'choosedefault') this.changePublicValue('public')
      }
      this.$emit('input' , this.resultObject);
    },
    handleAddPreset(e){
      if(e.submit_data.default) {
        this.handleDefaultPreset({ outcome : e.response , name :  e.submit_data.name})
        this.changePublicValue('choosedefault')
        } else{
          this.changePublicValue('custom')
        }
      this.savingMode = false ;
      this.userPresets.push({ name :  e.submit_data.name , index : this.resultObject , id : e.response.id })
      App.$emit('knocks_change_taps_value' , {scope : ['kps_taps'] , index : 0})
      this.$emit('input' , this.resultObject);

    },
    handleDeletePreset(e , index){
      this.userDefaultPreset.outcome = e.response.outcome; 
      let temp = this.userPresets;
      this.userPresets = null ;
      temp.splice(index , 1);
      if(temp.length == 0) this.changePublicValue('public');
      setTimeout( ()=>{ 
        this.userPresets = temp 
        this.userPresetsRadio = this.userPresets[0].id ;
        this.setRadioPreset(this.userPresets[0].preset);
        this.$emit('input' , this.resultObject);
      }  ,500);


    },
    handleRetrivePresets(e){
      this.presetsRetriverFired = true;
      this.userPresets = e.response;
      if(this.userPresets.length == 0) this.changePublicValue('public');
      else {
        this.userPresetsRadio = this.userPresets[0].id ;
        this.setRadioPreset(this.userPresets[0].preset);
      }
      this.$emit('input' , this.resultObject);
    },
    initComponent(obj , kpsc){
      if(this.initCounts >= 3) return
        this.initCounts++
      if(obj.tip !== undefined){
        this.changePublicValue(obj.tip)
      }else this.changePublicValue('custom')
      if(kpsc)
      // App.$emit('knocksRetriver' , {scope : ['kps_circles']}); 
        this.circlesRetriver.retrive()
      else{
         if(obj.circle_privacy !== undefined){
        let i 
        for(i = 0; i < obj.circle_privacy.length; i++){
          this.circleSwitch[obj.circle_privacy[i].circle_id] = this.signs.valid
          App.$emit('knocksSwitchChange',{ focus : [this._uid + '_kpsj_'+obj.circle_privacy[i].circle_id] , value : obj.circle_privacy[i].preset });
        }
        this.changePublicValue('public')
        this.changePublicValue('custom')
      }
      if(obj.user_privacy !== undefined){
        let i 
        this.usersExceptions = obj.user_privacy
      }
      }
    }

  }
}
</script>

<style lang="css" scoped>
</style>