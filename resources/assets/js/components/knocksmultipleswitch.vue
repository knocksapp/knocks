<template>
	<div :class = "[main_container]" >
		<a class="knocks_hidden_wrapper" v-if = "isFired && isHovered" @click = "hoverModeToggle()"></a>
		<a :class = "[switch_btn_classes , left_switch_class]" @click = "staticAssign(nextIndex)" >
			<span v-if = "options.length > 0 && valueIndex != null" :class = "[options[valueIndex].icon , options[valueIndex].classes]"></span>
		</a>
		<a :class = "[switch_btn_classes , right_switch_class]" @click = "hoverModeToggle()">
			<span :class = "togglerClasses" ></span>
			<slot></slot>
		</a>
		<ul :class = "[ulClasses]">
			<li v-for = "(option , index) in options" :class = "[ul_listitem]">
				<br/>
				<a :class = "[ul_anchor_class]" @click = "assign(index)">
					<span :class = "[option.icon,option.classes]"></span>
				    <static_message :msg="option.msg" v-if="static_messages" :classes="option.classes"></static_message>
				</a>
			</li>
		</ul>
		
	</div>
</template>

<script>
export default {

  name: 'knocksmultipleswitch',
  props : {
  	main_container :  {
  		type : String , 
  		default : 'row knocks_multiple_switch'
  	},
  	switch_btn_classes :  {
  		type : String , 
  		default : 'btn knocks_basic_button'
  	},
  	left_switch_class :  {
  		type : String , 
  		default : 'knocks_left_button'
  	},
  	right_switch_class :  {
  		type : String , 
  		default : 'knocks_right_button knocks_small_button'
  	},
  	switch_icon_class_on :  {
  		type : String , 
  		default : 'knocks-chevron-thin-up'
  	},
  	switch_icon_class_off :  {
  		type : String , 
  		default : 'knocks-chevron-thin-down'
  	},
  	switch_icon_class :  {
  		type : String , 
  		default : 'knocks_text_dark'
  	},
  	ul_on_hover_class : {
  		type : String , 
  		default : 'knocks_switch_ul_onhover animated fadeIn'
  	},
  	ul_on_leave_class : {
  		type : String , 
  		default : ' knocks_switch_ul_onleave'
  	},
  	ul_initial_class : {
  		type : String , 
  		default : 'knocks_switch_ul knocks_regular_division '
  	},
  	options : {
  		type : Array , 
  		default : null
  	} ,
  	static_messages : {
  		type : Boolean , 
  		default : false 
  	} ,  
  	ul_anchor_class : {
  		type : String ,
  		default : 'knocks_text_anchor '
  	} , 
  	ul_listitem : {
  		type : String , 
  		default : 'knocks_switch_ul_anchor'
  	},
    send_scope : {
      type :Array ,
      default : null
    },
    recieve_scope : {
      type : Array ,
      default : null 
    },
    startup_value : {
      type : [String , Array , Number ,Object] , 
      default : null ,
    }
  },

  data () {
    return {
    	isHovered : false , 
    	isFired : false ,
    	btnClick : false ,
    	value : null ,
    	valueIndex : 0 ,

    }
  },
  computed : {
  	ulClasses(){
  		let classes = [this.ul_initial_class];
	  	if(this.isHovered) classes.push(this.ul_on_hover_class);
	  	else classes.push(this.ul_on_leave_class);
	  	return classes;
  	},
  	togglerClasses(){
  		let classes = [this.switch_icon_class];
  		if(this.isHovered) classes.push(this.switch_icon_class_on);
  		else classes.push(this.switch_icon_class_off);
  		return classes;
  	},
  	modelOptions(){
  		let option , currentObject; 
  		currentObject = [];
  	   for(option in this.options){
  	   	currentObject.push(this.options[option].value);
  	   }
  	   return currentObject;
  	},
  	nextIndex(){
  		return this.valueIndex == (this.options.length -1) ? 0 : this.valueIndex+1;
  	}
  },
  mounted(){
    if(this.startup_value == null )
  	  this.staticAssign(0);
    else{
      this.staticAssign(this.getValueIndex(this.startup_value));
    }
    const vm = this;
    this.$on('input' , (value)=>{ 
      if(vm.send_scope != null) App.$emit('knocksSwitchChange' , {focus : vm.send_scope , value : vm.value } ); 
    });
    App.$on('knocksSwitchChange' , (scopes)=>{
      if(vm.recieve_scope != null){
        let sc ; 
        for(sc in vm.recieve_scope){
          if(scopes.focus.indexOf(vm.recieve_scope[sc]) != -1){
            vm.staticAssign(vm.getValueIndex(scopes.value))
          }
        }
      }
    })
  },
  methods : {
  	 hoverModeToggle(){
  	 	if(!this.isFired) this.isFired = true;
	  	this.isHovered = !this.isHovered;
	  	this.btnClick = true ;
	  },
	  assign(index){
	  	this.value = this.options[index].value;
	  	this.valueIndex = index ;
	  	this.$emit('input' , this.value);
	  	this.hoverModeToggle();
	  },
	  staticAssign(index){
	    this.value = this.options[index].value;
	  	this.valueIndex = index ;
	  	this.$emit('input' , this.value);
	  },
    getValueIndex(value){
      let option;
      for(option in this.options){
        if(this.options[option].value == value){
          return parseInt(option);
        }
      }
      console.warn('KNOCKS DEVELOPMENT TEAM >> The value you\'re looking for is not provided in the mentioned options, make sure you are looking for the correct value.');
      return -1;
    }

  }
}
</script>

<style lang="css" scoped>

</style>