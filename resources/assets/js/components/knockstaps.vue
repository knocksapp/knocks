<template>
	<div :class = "main_container">
		<a :class = "[indexEquiv(index) , valueEquiv(option.value) , anchor_class]" 
		v-for = "(option, index) in options" @click = "assign(option.value)" >
			<span :class = "label_class" v-if="option.label != undefined && (option.static == undefined || option.static == false )">{{ option.label }}</span>
			<static_message :class = "{'hide-on-med-and-down' : hide_labels_on_small}" :classes = "label_class" v-if="option.label != undefined && (option.static != undefined && option.static)" :msg="option.label"></static_message>
			<span :class = "[icon_class , option.icon]" v-if="option.icon != undefined"></span>
		</a>
	</div>
</template>

<script>
export default {

  name: 'knockstaps',
  props : {
  	main_container : {
  		type : String , 
  		default : 'row ',
  	},
  	options : {
  		type : Array , 
  		required : true
  	},
  	multiple : {
  		type : Boolean , 
  		default : false 
  	},
  	label_class : {
  		type : String , 
  		default : ''
  	},
  	icon_class : {
  		type : String , 
  		default : ''
  	},
  	anchor_active_class : {
  		type : String , 
  		default : 'knocks_anchor_color_kit_dark'
  	},
  	anchor_regular_class : {
  		type : String , 
  		default : 'knocks_anchor_color_kit_light knocks_sm_side_padding'
  	},
  	right_most_class : {
  		type : String , 
  		default : 'knocks_right_button' ,
  	},
  	left_most_class : {
  		type : String , 
  		default : 'knocks_left_button' ,
  	},
  	middle_class : { 
  		type : String , 
  		default : 'knocks_center_button'
  	},
  	anchor_class : {
  		type : String , 
  		default : 'btn knocks_light_active_border knocks_noshadow_ps'
  	},
  	define_first: {
  		type : Boolean ,
  		default : true
  	},
  	define_with_index : {
  		type : Number , 
  		default : null ,
  	},
    scope : {
      type : Array , 
      default : null
    },
    is_required : {
      type : Boolean , 
      default : false,
    },
    radio_unset : {
      type : Boolean , 
      default : false
    },
    hide_labels_on_small : {
      type : Boolean , 
      default : false ,
    }
  },
  data () {
    return {
    	assigned : [] ,
      isFired : false ,
    }
  },
  mounted(){
  	if(this.define_first){
  		this.assign(this.options[0].value);
  	}
  	if(this.define_with_index != null){
  		if(this.define_with_index > this.options.length-1){
  			let index =  this.options.length-1;
  			console.warn
  			('KNOCKS DEVELOPMENT TEAM >> The index you\'ve entered is not exisit in your options input, however it\'s updated to the last index in your options.');
  			if(this.multiple){
  			this.assigned = [];
  			this.assign(this.options[index].value);
  			return
	  		}else{ 
	  			this.assign(this.options[index].value);
	  		   return;
	  		}
  		}
  		if(this.multiple){
  			this.assigned = [];
  			this.assign(this.options[this.define_with_index].value);
  		}else this.assign(this.options[this.define_with_index].value);
  		return;
  		
  	}
      const vm = this;
      App.$on('knocks_submit' , (scope)=>{
            if(scope != null){
              let i;
              if(vm.scope == null) return;
              for(i = 0; i < scope.length; i++){
                if(vm.scope.indexOf(scope[i]) != -1){
                 vm.isFired = true;
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
          
  },
  computed : {
    isValid(){
      if(!this.isFired) return true;
      if(!this.is_required) return true;
      if(this.multiple){
        if(this.assigned == null) return false;
        if(!Array.isArray(this.assigned)) return false;
        if(this.assigned.length == 0) return false;
        return true;
      }else{
         if(this.assigned == null) return false;
         if(Array.isArray(this.assigned)) return false;
        return true;
      }
    }

  },
  methods : {
  	assign(value){
      if(!this.isFired) this.isFired = true;
      if(this.multiple && !Array.isArray(this.assigned)) this.assigned = [this.assigned];
  		if(this.isActive(value) && !this.multiple) {
        if(this.radio_unset){
          this.assigned = null ;
          this.emit();
          return;
        }
        else return;
      }
  		if(this.isActive(value) && this.multiple) {
  			this.assigned.splice(this.assigned.indexOf(value),1);
  			this.emit();
  			return;
  		}
  		if(this.multiple){
  			this.assigned.push(value);
  			this.emit();
  			return;
  		}else{
  			this.assigned = value;
  			this.emit();
  		}  
  	},
  	isActive(value){
  		if(!this.multiple)
  			return this.assigned == value ? true : false ;
  		return this.assigned.indexOf(value) == -1 ? false : true
  	},
  	indexEquiv(index){
  		if(index == 0) return this.left_most_class;
  		if(index == this.options.length-1) return this.right_most_class;
  		else return this.middle_class;
  	},
  	valueEquiv(value){
  		return this.isActive(value) ? this.anchor_active_class : this.anchor_regular_class;
  	},
  	emit(){
  		this.$emit('input' , this.assigned);
  	}
  }
}
</script>

<style lang="css" scoped>
</style>