<template>
<div :class = "[main_container]">
	<!--Retrievers-->
	<knocksretriver
	url = "user/ask/first/address"
	:prevent_on_mount = "!ask_first"
	v-model = "askFirstRetriver"
	@success = "handleAskFirst($event)"></knocksretriver>
	<knocksretriver
	url = "address/state/get"
	prevent_on_mount
	v-model = "checkStatesRetriver"
	:xdata = "{ country : country}"
	:scope = "['knocks_retriver_states_'+_uid]"
	@success = "suggestedStates = $event.response"></knocksretriver>
	<knocksretriver
	url = "address/region/get"
	prevent_on_mount
	v-model = "checkRegionsRetriver"
	:xdata = "{ country : country , state : state}"
	:scope = "['knocks_retriver_regions_'+_uid]"
	@success = "suggestedRegions = $event.response"></knocksretriver>
	<!--Retrievers-->
	<!--Messages-->
	<static_message msg = "Your address was added successfully" class ="knocks_hidden" v-model = "messages.btnSuccess"></static_message>
	<static_message msg = "You already have this address." class ="knocks_hidden" v-model = "messages.btnDublicate"></static_message>
	<static_message msg = "You need to enter your country first." class ="knocks_hidden" v-model = "messages.countryMissing"></static_message>
	<static_message msg = "Region" v-model = "messages.region"  class ="knocks_hidden" ></static_message>
	<static_message msg = "Country" v-model = "messages.country" class ="knocks_hidden" ></static_message>
	<static_message msg = "State" v-model = "messages.state" class ="knocks_hidden" ></static_message>
	<static_message :msg = "title" v-model = "messages.title" class ="knocks_hidden" v-if = "show_title"></static_message>
	<!--Messages-->
	<!--Form-->
	<div v-if = "(!hasAddress && ask_first) || !ask_first">
		<p v-if = "show_title" :class = "title_classes">
			<span class = "knocks-map10"></span>
		  <span>{{messages.title}}</span>
	    </p>
		<div class="col s12 ">
			<div class="ui right pointing blue basic label " style="float : left !important; width : 25.3%" v-if = "!tiny">
				<span class = "knocks-earth-globe hide-on-small-only"></span>
				<span>{{messages.country}}</span>
			</div>
			<el-select
			v-model="country"
			clearable
			:placeholder="messages.country"
			filterable
			:class = "[{'col  s8' : !tiny} , {'col s12' : tiny}]"
			@input = "checkStates()"
			default-first-option>
			<i slot="prefix" style = "line-height : 200% !important" class="knocks_text_md knocks-earth-globe"></i>
			<el-option
			v-for="(item , index) in countries"
			:key="item.name"
			:label="item.emoji + item.name"
			:value="index">
			<span style="float: left; ">{{ item.emoji + item.name }}</span>
			<span style="float: right; font-size: 12px" class="hide-on-small-only blue-text" v-if = "!tiny">{{ item.native }}</span>
			</el-option>
			</el-select>
			<span class = "el-icon-loading right" v-if = "checkStatesRetriver.loading"></span>
		</div>
		<div class = "col s12">
			<br/>
			<div class="ui right pointing blue basic label" style="float : left !important; width : 25.3%" v-if = "!tiny">
				<span class = "knocks-map10 hide-on-small-only"></span>
				<span>{{messages.state}}</span>
			</div>
			<el-select
			v-model="state"
			clearable

			allow-create
			:placeholder="messages.state"
			filterable
			@input = "checkRegions()"
			:class = "[{'col  s8' : !tiny} , {'col s12' : tiny}]"
			default-first-option>
			 <i slot="prefix" style = "line-height : 200% !important" class="knocks_text_ms knocks-map10"></i>
			<el-option
			v-for="(item , index) in suggestedStates"
			:key="index"
			:label="item"
			:value="item">
			</el-option>
			</el-select>
		</div>
		<div class = "col s12">
			<br>
			<div class="ui right pointing blue basic label" style="float : left !important; width : 25.3%" v-if = "!tiny">
				<span class = "knocksapp-build2 hide-on-small-only"></span>
				<span>{{messages.region}}</span>
			</div>
			<el-select
			v-model="region"
			clearable
			allow-create
			:placeholder="messages.region"
			filterable
			:class = "[{'col  s8' : !tiny} , {'col s12' : tiny}]"
			default-first-option>
			<i slot="prefix" style = "line-height : 200% !important" class="knocks_text_md knocksapp-build2"></i>
			<el-option
			v-for="(item , index) in suggestedRegions"
			:key="index"
			:label="item"
			:value="item">
			</el-option>
			</el-select>
			<span class = "el-icon-loading right" v-if = "checkRegionsRetriver.loading"></span>
		</div>
		<div class="col s12">
		<br>
		<knocksbutton
		:gid = "'knocks_add_address_'+_uid"
		:scope = "['knocks_add_address_'+_uid]"
		:precondition = "country != null && country.length > 0"
		:submit_data = "{
		  object : {
		  country : country ,
		region : region ,
		state : state ,
		index : {}
		}
		}"
		button_classes ='ui purple basic button fluid'
		leave_class = ""
		hover_class = ""
		:materialize_feedback = "false"
		placeholder = "Add Address"
		submit_at = "address/create"
    computed_response
		:error_at = "[{ res : 'invalid' , msg : messages.btnDublicate }]"
		:success_msg= "messages.done"
    @knocks_submit_accepted = "passToParent($event)">
		:validation_error = "messages.countryMissing"
		></knocksbutton>
		</div>
	</div>
	<!--Form-->
</div>
</template>

<script>
export default {

  name: 'knocksquickaddress',
  props : {
  	main_container : {
  		type : String,
  		default : 'row white knocks_tinny_border_radius knocks_gray_border knocks_fair_bounds'
  	},
  	title : {
  		type : String ,
  		default : 'Add an address'
  	},
  	title_classes : {
  		type : String ,
  		default : 'knocks_text_dark knocks_text_ms center'
  	},
  	show_title : {
  		type : Boolean ,
  		default : false
  	},
  	tiny : {
  		type : Boolean ,
  		default : false
  	},
  	ask_first : {
  		type : Boolean ,
  		default : false ,
  	} ,

  },
  data () {
    return {
    	askFirstRetriver : { loading : false , response : null } ,
    	checkStatesRetriver : { loading : false , response : null } ,
    	checkRegionsRetriver : { loading : false , response : null } ,
    	hasAddress : false ,
    	countries : window.Countries.countries ,
  		country : null ,
  		messages : {
  			country : '' ,
  			state : '' ,
  			region : '' ,
  			btnDublicate : '' ,
  			btnSuccess : '' ,
  			countryMissing : '' ,
  			title : '' ,
  		},
  		state : null ,
  		region : null	 ,
  		suggestedStates : [] ,
  		suggestedRegions : [] ,
    }
  },
  methods : {
		passToParent(e){
				let ob = e.submit_data.object ;
				ob.current = 'f'
				ob.id = e.response;
				this.$emit('knocks_address_submited' , ob );
		},
  	handleAskFirst(e){
  		this.hasAddress = e.response.has_address
  	},
  	checkStates(){
  		if( !this.country) return
  		if(this.country.length > 0){
  			setTimeout( ()=>{
  				App.$emit('knocksRetriver' , {scope : [ 'knocks_retriver_states_'+this._uid ]})
  			}, 300)
  		}
  	},
  	checkRegions(){
  		if(this.state == null || this.country == null ) return
  		if(this.state.length > 0 && this.country.length > 0){
  			setTimeout( ()=>{
  				App.$emit('knocksRetriver' , {scope : [ 'knocks_retriver_regions_'+this._uid ]})
  			}, 300)
  		}
  	}
  }
}
</script>

<style lang="css" scoped>
</style>
