<template>
<div :class = "main_container">
	<!--Toggler-->
	<div @click = "toggle($event)" class = "knocks_pointer">
		<div v-if = "toggler == 'default'" :class = "toggler_container">
			<span :class = "togglerClasses" v-if = "!dual_title">
				<span :class = "[icon]"></span>
				<static_message :msg = "title"></static_message>
				<span :class = "indecatorClasses"></span>
			</span>
			<span :class = "togglerClasses" v-else>
				<span :class = "[icon]"></span>
				<static_message :msg = "title" :class = "[{'animated fadeIn' : !toggleStatus} , {'knocks_hidden' : toggleStatus}]"></static_message>
				<static_message :msg = "active_title" :class = "[{'animated fadeIn' : toggleStatus} , {'knocks_hidden' : !toggleStatus}]" ></static_message>
				<span :class = "indecatorClasses"></span>
			</span>
		</div>
		<div v-if = "toggler == 'custom'">
			<slot name = "toggler"></slot>
		</div>
	</div>
	<!--Content-->
	<div v-if = "show_content_on_mount || clickedOnce" class = "knocks_collapse_content_container">
		<slot name = "content"></slot>
	</div>
</div>
</template>
<script>
export default {
  name: 'knockscollapse',
  props : {
  	toggler : {
  		type : String , 
  		default : 'default'
  	},
  	title : {
  		type : String , 
  		default : ''
  	} ,
  	active_title : {
  		type : String , 
  		default : ''
  	} ,
  	icon : {
  		type : String , 
  		default : ''
  	},
  	indecator_icon_on : {
  		type : String , 
  		default : 'knocksapp-chevron-up right animated rotateInDownLeft'
  	},
  	indecator_icon_off : {
  		type : String , 
  		default : 'knocksapp-chevron-down right animated rotateInUpLeft'
  	},
  	regular_class : {
  		type : String , 
  		default : 'knocks_text_ms knocks_text_dark'
  	},
  	active_class : {
  		type : String , 
  		default : 'knocks_text_dark_active knocks_text_ms'
  	},
  	show_content_on_mount : {
  		type : Boolean ,
  		default : false 
  	},
  	main_container : {
  		type : String , 
  		default : 'row knocks_house_keeper'
  	},
  	toggler_container : {
  		type : String , 
  		default : 'row knocks_gray_hover knocks_margin_keeper knocks_tinny_padding'
  	},dual_title : {
  		type : Boolean , 
  		default : false
  	}
  },
  data () {
    return {
    	toggleCase : false ,
    	clickedOnce : false ,
    }
  },
  mouted(){

  },
  computed : {
  	toggleStatus(){
  		return this.toggleCase
  	},
  	togglerClasses(){
  		let arr = [];
  		if(this.toggleStatus){
  			arr.push(this.active_class)
  		}else{
  			arr.push(this.regular_class)
  		}
  		return arr;
  	},
  	indecatorClasses(){
  		let arr = [];
  		if(this.toggleStatus){
  			arr.push(this.indecator_icon_on)
  		}else{
  			arr.push(this.indecator_icon_off)
  		}
  		return arr;
  	}
  },
  methods : {
  	toggle(e){
  		this.clickedOnce = true;
  		this.toggleCase = !this.toggleCase
  		let tar = e.currentTarget;
  		let parent = $(tar).parent();
  		let collapse = $(parent).find('.knocks_collapse_content_container');
  		if(this.toggleCase){
  			$(collapse).slideDown();
  		}else{
  			$(collapse).slideUp();
  		}
  	}
  }
}
</script>

<style lang="css" scoped>
</style>