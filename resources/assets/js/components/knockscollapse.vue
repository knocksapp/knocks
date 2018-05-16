<template>
<div :class = "main_container">
	<!--Toggler-->
	<div @click = "toggle($event)" class = "knocks_pointer" :id = "'knocks_'+_uid+'_toggler'">
		<div v-if = "toggler == 'default'" :class = "toggler_container">
			<span :class = "togglerClasses" v-if = "!dual_title">
				<span :class = "[icon]"></span>
        <el-tooltip>
				<static_message :msg = "title"></static_message>
        <div slot = "content">
          <span :class = "[icon]"></span>
            <static_message :msg = "title"></static_message>
          <p v-if = "comment" :class = "comment_class">
          <br><static_message :msg = "comment"></static_message>
        </p>
        </div>
      </el-tooltip>
        <small v-if = "comment" :class = "comment_class">
          <br><static_message :msg = "comment"></static_message>
        </small>
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
  	},
    comment : {
      type : String , 
      default : null
    },
    comment_class : {
      type : String , 
      default : ''
    },
    scope : {
      type : Array , 
      default : null , 
    },
    gid : {
      type : String , 
      default : null
    }
  },
  data () {
    return {
    	toggleCase : false ,
    	clickedOnce : false ,
    }
  },
  mounted(){
    const vm = this
    App.$on('KnocksCollapseToggle' , (payloads)=>{
      if(vm.scope == null || payloads.scope == undefined || payloads.scope == null) return
        console.log('col search')
      let tar ; 
      for(tar = 0 ; tar < vm.scope.length ; tar++){
        if(payloads.scope.indexOf(vm.scope[tar]) != -1){
          console.log('col match')
          vm.toggleById()
          return
        }
      }
    })

    App.$on('KnocksCollapseByGid' , (payloads)=>{
      console.log('resp')
      if(vm.gid == null || payloads.gid == undefined || payloads.gid == null) return
      
        if(payloads.gid == vm.gid){
          console.log('col match')
          vm.toggleById()
          return
        }   
    })
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
      this.$emit('input' , this.toggleCase)
  		let tar = e.currentTarget;
  		let parent = $(tar).parent();
  		let collapse = $(parent).find('.knocks_collapse_content_container');
  		if(this.toggleCase){
  			$(collapse).slideDown();
  		}else{
  			$(collapse).slideUp();
  		}
  	},
    toggleById(){
      let toggler = document.getElementById('knocks_'+this._uid+'_toggler')
      this.toggle({currentTarget : toggler})
    }
  }
}
</script>

<style lang="css" scoped>
</style>