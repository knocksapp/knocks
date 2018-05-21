<template>
<div>
  	<!--Messages-->
	<static_message :msg = "placeholder" v-model = "messages.placeholder" class = "knocks_hidden"></static_message>
	<!--Messages-->
	<!--Retrievers-->
	<knocksretriver
	v-if = "fill_from"
	:url = "fill_from"
	v-model = "RemoteFeedsRetriever"
	:scope = "componentScope"
	:prevent_on_mount = "prevent_on_mount"
	:xdata = "xdata"
	@success = "handleFeeds($event)">
	</knocksretriver>
	<!--Retrievers-->
  <el-select 
  v-model="elselect"
  @input = "emit($event)"
  :multiple = "multiple"
  :id = "'knocks_elselect_'+_uid"
  :collapse-tags = "multiple_counter"
  :clearable = "!unclearable"
  :allow-create = "allow_create"
  :filterable = "!unfilterable"
  :class = "input_class"
  :default-first-option = "default_first"
  :placeholder="placeholder">
  <i slot="prefix"  class="knocks_text_md knocks_elselect_icon_handler el-icon-loading" v-if = "RemoteFeedsRetriever.loading"></i>
  <i slot="prefix"  :class="innerIcon" v-else></i>
    <el-option
      v-for="(item,index) in options"
      v-if ="isObect(item)" 
      :key="item.value"
      :label="labels[item.value]"
      :value="item.value">
      <div>
      	 <span :class = "[ item.icon  , icon_classes]" v-if = "item.icon !== undefined"></span>
         <static_message 
         v-model = "labels[item.value]" 
         :msg = "item.label" :class = "[label_classes]" v-if = "item.label !== undefined && item.static !== undefined && item.static"></static_message>
         <span :class = "[label_classes]" v-if = "item.label !== undefined && (item.static == undefined || !item.static)">{{item.label}}</span>
      </div>
    </el-option>
    <el-option
      v-for="item in options"
      v-if = "!isObect(item)" 
      :key="item"
      :label="item"
      :value="item">
      <div>
      	 <span :class = "[ general_icon  , icon_classes]" v-if = "general_icon.length > 0"></span>
         <static_message :class = "[label_classes]" v-if = "general_static" :msg = "item"></static_message>
         <span :class = "[label_classes]" v-else>{{item}}</span>
      </div>
    </el-option>
  </el-select>
  	<div class = "col s12" v-if = "isFired">
		<ul v-if = "!avoidClash">
			<li v-for = "err in erros" :class="[error_classes ,'uk-list uk-list-divider animated slideInDown']" >
				<span :class = "errorBus[err].icon"></span>
			    <static_message 
			    v-if = "errorBus[err].replacements !== undefined" 
			    replaceable  :replacements = "errorBus[err].replacements" :msg = "errorBus[err].msg"></static_message>
			    <static_message 
			    v-else
			   :msg = "errorBus[err].msg"></static_message>
		    </li>
		</ul>
	</div>
</div>
</template>
<script>
export default {
  name: 'knockselselect',
  props : {
  	feeds : {
  		type : Array , 
  		default : null , 
  	},
  	placeholder : {
  		type : String , 
  		default : 'Select'
  	},
  	multiple : {
  		type : Boolean , 
  		default : false
  	},
  	multiple_counter : {
  		type : Boolean , 
  		default : false
  	},
  	icon_classes : {
  		type : [String , Array , Object] , 
  		default : ''
  	},
  	label_classes : {
  		type : [String , Array , Object] , 
  		default : ''
  	},
  	general_icon : {
  		type : String , 
  		default : ''
  	},
  	general_static : {
  		type : Boolean , 
  		default : false
  	},
  	unclearable : {
  		type : Boolean , 
  		default : false
  	},
  	fill_from : {
  		type : String , 
  		default : null ,
  	},
  	scope : {
  		type : Array , 
  		default : null
  	},
  	prevent_on_mount : {
  		type : Boolean , 
  		default : false
  	},
  	xdata : {
  		type : Object , 
  		default : ()=>{
  			return {}
  		}
  	},
  	dynamic_fill : {
  		type : Boolean , 
  		default : false
  	},
  	icon : {
  		type : String , 
  		default : ''
  	},
  	icon_handlers : {
  		type : String , 
  		default : 'knocks_elselect_icon_handler knocks_text_md'
  	},
    icon_class : {
      type : String ,
      default : ''
    },
    icon_focus : {
      type : String ,
      default : ''
    },
    icon_success : {
      type : String ,
      default : 'teal-text'
    },
    icon_error : {
      type : String ,
      default : 'knocks_text_error'
    },
    unfilterable : {
    	type : Boolean , 
    	default : false
    },
    allow_create : {
    	type : Boolean , 
    	default : false
    },
    default_first : {
    	type : Boolean , 
    	default : false
    },
    is_required : {
    	type : Boolean , 
    	default : false
    },
  	error_mixins : {
  		type : Array , 
  		default : null ,
  	},
  	error_classes : {
  		type : [ Object , String ] , 
  		default : 'red-text'
  	},
  	max_len : {
  		type : Number , 
  		default : null
  	},
  	min_len : {
  		type : Number , 
  		default : null
  	},
  	max_picks : {
  		type : Number , 
  		default : null
  	},
  	min_picks : {
  		type : Number , 
  		default : null
  	},
  	input_class : {
  		type : [String , Array , Object] ,
  		default : 'col s12 knocks_house_keeper'
  	}
  },
  data () {
    return {
    	elselect : null ,
    	options : [] ,
    	messages : {
    		placeholder : ''
    	},
    	error_bus : {
			is_required : { msg : 'This field is required.' , icon : 'knocks-alert-circle' } , 
			max_len : { msg : "This value can't be more than ** characters" , icon : 'knocks-alert-circle' , replacements : [ {target : '**' , body : this.max_len} ]} , 
			min_len : { msg : "This value can't be less than ** characters" , icon : 'knocks-alert-circle' , replacements : [ {target : '**' , body : this.min_len} ]} , 
			max_picks : { msg : "You can't pick more than ** options" , icon : 'knocks-alert-circle' , replacements : [ {target : '**' , body : this.max_picks} ]} , 
			min_picks : { msg : "You need to pick atleast ** options" , icon : 'knocks-alert-circle' , replacements : [ {target : '**' , body : this.min_picks} ]} ,
  		},
    	RemoteFeedsRetriever : { loading : false } ,
    	isValid : false , 
    	isFired : false ,
    	erros : [] , 
    	avoidClash : false ,
    	labels : {} , 
    }
  },
  mounted(){
  	if(this.feeds) this.options = this.feeds

  	const vm = this
    setTimeout( ()=>{
    	let domInput = document.getElementById('knocks_elselect_'+this._uid)
    	domInput.onkeyup = ()=>{
    		if(vm.dynamic_fill){
    			App.$emit('knocksRetriver' , {scope : [ 'knocks_remote_filling_'+vm._uid ]})
    		}
    	}
    } , 300)

    App.$on('knocks_submit' , (scope)=>{
	    if(scope != null){
	      let i;
	      if(vm.scope == null) return;
	      for(i = 0; i < scope.length; i++){
	        if(vm.scope.indexOf(scope[i]) != -1){
	         vm.isFired = true;
	         vm.isValid = vm.ifValid()
	         App.$emit('knocks_input_status' , vm.isValid);
	         return;
	        }
	      }
	      return;
	   }else if(scope == null && vm.scope == null){
	    vm.isFired = true;
	    App.$emit('knocks_input_status' , vm.isValid);
	   }
	});


	App.$on('knocks_input_reset' , (scope)=>{
	    if(scope != null){
	      let i;
	      if(vm.scope == null) return;
	      for(i = 0; i < scope.length; i++){
	        if(vm.scope.indexOf(scope[i]) != -1){
	        vm.elselect = null;
	         vm.emit()
	         vm.isFired = false;
	         vm.isValid = false
	         return;
	        }
	      }
	      return;
	   }else if(scope == null && vm.scope == null){
	    
	   }
	});
    
  },
  computed : {
  	errorBus(){
  		if(!this.error_mixins) return this.error_bus
  		let i , arr = this.error_bus
  	    for(i = 0; i < this.error_mixins.length; i++){
  	    	arr[this.error_mixins[i].key] = this.error_mixins[i].mixin
  	    }
  	    return arr
  	},
  	componentScope(){
  		if(!this.scope){
  			return ['knocks_remote_filling_'+this._uid]
  		}
  		let i 
  		let arr = ['knocks_remote_filling_'+this._uid]
  		for(i = 0; i < this.scope.length; i++)
  			arr.push(this.scope[i])
  		return arr;
  	},
	innerIcon(){
	    var classes =  this.icon + ' '+this.icon_handlers;
	    if(!this.isFired) classes += ' '+this.icon_focus;
	    if(this.focus) classes += ' '+this.icon_focus;
	    if(this.isValid) classes += ' '+this.icon_success;
	    if(!this.isValid && this.isFired) classes += ' '+this.icon_error;
	    else classes += ' '+ this.icon_class;
	    return classes;
	  },
  },
  methods : {
  	isObect(item){
  		return typeof item == 'object' ? true : false
  	} ,
  	handleFeeds(e){
  		let i , j 
  		this.options = []
  		let temp = this.feeds ? this.feeds : []
  		for(i = 0 ; i < e.response.length; i++)
  			temp.push(e.response[i])
  		for(i = 0 ; i < temp.length ; i++){
  			for(j = 0 ; j < temp.length; j++){
  				if(temp[i] == temp[j] && i != j){
  					temp.splice(j , 1)
  				}
  				if(i != j){
  					if(typeof temp[i] == 'string' && typeof temp[j] == 'object' && temp[j].value == temp[i]){
  						temp.splice(j , 1)
  					}
  					if(typeof temp[j] == 'string' && typeof temp[i] == 'object' && temp[i].value == temp[j]){
  						temp.splice(j , 1)
  					}
  				}
  			}
  		}
  		this.options = temp
  	},
  	emit(e){
  		this.avoidClash = true
  		this.isFired = true
  		this.isValid = this.ifValid()
  		this.$emit('input' , e)
  		setTimeout( ()=>{ this.avoidClash = false } , 300)
  	},
   	ifValid(){
  		this.erros = []
  		if(this.is_required && ( this.elselect == null  || this.elselect.length == 0 ) ) this.erros.push('is_required')
  		if(this.max_len && !this.multiple && this.elselect && this.elselect.length > this.max_len ) this.erros.push('max_len')
  		if(this.min_len && !this.multiple && this.elselect && this.elselect.length < this.min_len ) this.erros.push('min_len')
  		if(this.max_picks && this.multiple && this.elselect && this.elselect.length > this.max_picks ) this.erros.push('max_picks')
  		if(this.min_picks && this.multiple && this.elselect && this.elselect.length < this.min_picks ) this.erros.push('min_picks')
  		return this.erros.length == 0 ? true : false
  	},
  }
}
</script>

<style lang="css" scoped>
.knocks_elselect_icon_handler{
	line-height : 200% ;
}
</style>