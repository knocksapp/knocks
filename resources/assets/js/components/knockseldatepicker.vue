<template>
<div>
	<!--Messages-->
	<static_message v-if = "quick" :msg = "pre.msg" v-for = "(pre , index) in quick" :key = "index" v-model = "shortcuts[index]" class = "knocks_hidden"></static_message>
	<static_message :msg = "placeholder" v-model = "messages.placeholder" class = "knocks_hidden"></static_message>
	<static_message :msg = "start_placeholder" v-if = "type == 'daterange '" v-model = "messages.start_placeholder" class = "knocks_hidden"></static_message>
	<static_message :msg = "end_placeholder" v-if = "type == 'daterange '" v-model = "messages.end_placeholder" class = "knocks_hidden"></static_message>
	<!--Messages-->
	<el-date-picker
	:id = "'knocks_date_picker_'+_uid"
	:class = "picker_classes"
	v-model="datepicker"
	:type="type"
	format="yyyy/M/d"
	@change = "emit($event)"
	@input = "emit($event)"
	@create= "watchMyDom()"
	value-format="yyyy-MM-dd"
	:picker-options="quickOptions"
	:range-separator="range_separator"
  :start-placeholder="start_placeholder"
  :end-placeholder="end_placeholder"
	:prefix-icon = 'innerIcon'
	:default-time = "defaultTime"
	:placeholder="placeholder">
	</el-date-picker>
	<div class = "col s12" v-if = "isFired">
		<ul>
			<li v-for = "err in erros" :class="[error_classes ,'uk-list uk-list-divider animated slideInDown']" >
				<span :class = "error_bus[err].icon"></span>
			   <span>{{error_bus[err].msg}}</span>
		    </li>
		</ul>
	</div>
</div>
</template>
<script>
export default {
  name: 'knockseldatepicker',
  props : {
  	quick : {
  		type : Array , 
  		default : null ,
  	} , 
  	margins : {
  		type : Object , 
  		default : null 
  	},
  	is_required : {
  		type : Boolean , 
  		default : false 
  	},
  	type : {
  		type : String , 
  		default : 'date'
  	},
  	scope : {
  		type : Array , 
  		default : null
  	},
  	picker_classes : {
  		type : [  Object , Array , String ] , 
  		default : 'col s12 knocks_house_keeper'
  	},
  	error_classes : {
  		type : [ Object , String ] , 
  		default : 'red-text'
  	},
  	placeholder : {
  		type : String , 
  		default : 'Pick a day'
  	},
  	icon : {
  		type : String , 
  		default : 'el-icon-date'
  	} , 
  	default_time : {
  		type : Object , 
  		default : null
  	},
  	unlink_panels : {
  		type : Boolean , 
  		default : false
  	},
	range_separator : {
	  	type : String , 
	  	default : 'to'
	},
	start_placeholder : {
	  	type : String ,
	  	default : "Start date"
	},
	end_placeholder : {
	  	type : String ,
	  	default : "End date"
	},
  	error_bus : {
  		type : Object , 
  		default : ()=>{
  			return{
  				is_required : { msg : 'This field is required.' , icon : 'knocks-alert-circle' } , 
  				max : { msg : 'This date has passed the maximum value.' , icon : 'knocks-alert-circle' } , 
  				min : { msg : 'This date is less than the minimum value.' , icon : 'knocks-alert-circle' } , 
  			}
  		}
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
  },
  data () {
    return {
    	datepicker : null ,
    	pickerOptions : null ,
    	clientDate : moment().subtract( new Date().getTimezoneOffset() ,'m').format('YYYY-MM-DD') ,
    	offset : new Date().getTimezoneOffset() ,
    	shortcuts : [] ,
    	shortcutsDates : [] , 
    	messages : {
    		placeholder : '' , 
    		start_placeholder : '' , 
    		end_placeholder : '' ,
    	},
       defaultTime : this.default_time ? this.createObjectDate(this.default_time) : null ,
       erros : [] ,
       isFired : false , 
       isValid : false
    }
  },
  mounted(){
  	if(this.defaultTime){
  		this.datepicker = this.defaultTime
  		this.$emit('input' , this.datepicker)
  	}

  	const vm = this
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
	        vm.datepicker = null;
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
    innerIcon(){
      var classes =  this.icon ;
      if(!this.isFired) classes += ' '+this.icon_focus;
      if(this.focus) classes += ' '+this.icon_focus;
      if(this.isValid) classes += ' '+this.icon_success;
      if(!this.isValid && this.isFired) classes += ' '+this.icon_error;
      else classes += ' '+ this.icon_class;
      return classes;
    },
  	limits(){
  		if(!this.margins) return null
  		let limits = {} 
  	    //max
  		if(this.margins.max !== undefined) limits.max = this.createObjectDate(this.margins.max)
  		//min
  		if(this.margins.min !== undefined) limits.min = this.createObjectDate(this.margins.min)
  		return limits
  	},
  	quickShortcuts(){
  	    this.shortcutsDates = this.getShortcutsDates()
  		const vm = this
  		if(!this.quick) return []
  		let temp = [] , i 
  		for(i = 0 ; i < this.quick.length; i++ ){
  			let date = vm.shortcutsDates[i]
  			temp.push({
            text: vm.shortcuts[i],
            onClick(picker) {
            	vm.watchMyDom()
              //console.log(picker)
              //picker.$emit('pick',  moment(vm.shortcutsDates[i]).format('YYYY-MM-DD') );
            }
          })
  		}
  		return temp
  	},
  	quickOptions(){
  		const vm = this
  		if(!this.quick) return null ;
  		let options = {
  		  disabledDate(time) {
  		  	let max = vm.limits.max !== undefined && vm.limits.max !== null ? vm.limits.max : '2100-01-01'
  		  	let min = vm.limits.min !== undefined && vm.limits.min !== null ? vm.limits.min : '1900-01-01'
            return time.getTime() > new Date(max) || time.getTime() < new Date(min)
          },
          shortcuts : this.quickShortcuts
  		}
  		return options
  	},
  },
  methods : {
  	createObjectDate(object){
  		if(object.date !== undefined){
  			return object.date
  		}
  		let from = object.from !== undefined ? object.from : this.clientDate
  		return object.count > 0 ? moment(from).add(object.count , object.unit).format('YYYY-MM-DD') 
  		:  moment(from).subtract(object.count * -1 , object.unit ).format('YYYY-MM-DD') 
  	},
  	getShortcutsDates(){
  		if(!this.quick) return []
  		let temp = [] , i
  		for(i = 0 ; i < this.quick.length; i++){
  			temp.push( this.createObjectDate(this.quick[i].margins)  )
  		}
  		return temp
  	},
  	watchMyDom(){
  		const vm = this
  		vm.isFired = true
	  	$('.el-picker-panel__shortcut').click(function(){
	  		let index = vm.shortcuts.indexOf($(this).text())
	  		if(index == -1 || vm.datepicker == vm.shortcutsDates[index]) return
	  		setTimeout(()=>{
	  			vm.datepicker = vm.shortcutsDates[index]
	  			vm.emit(vm.datepicker)
	  		},300)
	  	})
  	},
  	ifValid(){
  		this.erros = []
  		if(this.is_required && ( this.datepicker == null  || this.datepicker.length == 0 || this.datepicker == 'Invalid date' ) ) this.erros.push('is_required')
  		if(this.limits.max && ( new Date( this.limits.max ).getTime()  < new Date( this.datepicker ).getTime()  ) )  this.erros.push('max')
  		if(this.limits.max && ( new Date( this.limits.max ).getTime()  < new Date( this.datepicker ).getTime()  ) ) this.erros.push('min')
  		return this.erros.length == 0 ? true : false
  	},
  	emit(e){
  		this.$emit('input' , e);
  		this.isValid = this.ifValid()
  		this.isFired = true
  	}

  }
}
</script>

<style lang="css" scoped>
</style>