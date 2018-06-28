<template>
  <div v-if ="showWb && pwb" :id = "_uid">
    <div style="position : fixed; height : 100%; width : 100%; top : 0; left : 0; z-index : 999999999999999999999999;" class="knocks_light_color_kit">
      <p class="center knocks_text_lg">
      <static_message
      msg = "Welcome Back"
      :id = "_uid+'_sm'"
      class = "animated rotateIn knocks_text_dark"></static_message>
      </p>
      <span
      :id = "_uid+'_sp'"
      :style="'position : absolute; font-size : '+width/4+'px; margin-left : '+((width/2)-(width/8))+'px; top : '+((height/2)-(width/8))+'px;'" 
      class = "knocks-knocks-circle-fill animated rotateIn knocks_text_dark"></span>
    </div>
  </div>
</template>

<script>
export default {

  name: 'knockswatchmywindow',
  props : {
  	small : {
  		type : Number , 
  		default : 750
  	},
  	midium : {
  		type : Number , 
  		default : 1024
  	},
    pwb : {
      type : Boolean ,
      default : false
    }
  },
  data () {
    return {
    	result : {} , 
    	height : 0 ,
    	width : 0 ,
    	isSmall : false , 
    	isMidium : false , 
    	isLarge : false , 
    	isFocused : true , 
      showWb : false ,
      fromBlur : false , 
      blurInterval : null ,
      blurCounter : 0 ,
    }
  },
  mounted(){
  	const vm = this
  	$(document).ready(function(){
  		vm.emit('init')
  		$(window).resize(function(){
  			vm.emit('resize')
  		})
  		$(window).focus(function(){
        if(!vm.isFocused) vm.fromBlur = true
  			vm.isFocused = true
  			vm.emit('focus')
        if(vm.pwb && vm.fromBlur){
          vm.showWb = true
          setTimeout(()=>{
            $('#'+vm._uid+'_sp').removeClass('animated rotateIn')
            $('#'+vm._uid+'_sm').addClass('animated slideOutUp')
            $('#'+vm._uid+'_sp').addClass('animated rotateOut')
            $('#'+vm._uid+'_sp').addClass('animated rotateOut')
            if(vm.pwb && vm.fromBlur)
            setTimeout(()=>{
              $('#'+vm._uid).addClass('animated zoomOut')
              if(vm.pwb && vm.fromBlur)
              setTimeout(()=>{
                vm.showWb = false
                $('#'+vm._uid+'_sp').addClass('animated rotateIn')
              },1000)
            },1000)
          },1000)
          
        }
  		})
  		$(window).blur(function(){
        vm.fromBlur = false
  			vm.isFocused = false
  			vm.emit('blur ')
        if(vm.pwb){
          vm.showWb = false
          $('#'+vm._uid).removeClass('animated zoomOut')
          $('#'+vm._uid+'_sp').removeClass('animated rotateOut')
          $('#'+vm._uid+'_sm').removeClass('animated slideOutUp')
        } 

  		})
  	})
  },
  methods : {
  	emit(e){
  		this.width = window.innerWidth
  		this.height = window.innerHeight
  		this.isSmall = this.width <= this.small
  		this.isMidium = this.width > this.small && this.width <= this.midium
  		this.isLarge = this.width > this.midium
  		this.result = {
  			height : this.height , 
  			width : this.width , 
  			isSmall : this.isSmall , 
	    	isMidium : this.isMidium , 
	    	isLarge : this.isLarge , 
	    	isFocused : this.isFocused , 

  		}
  		this.$emit('input' , this.result)
  		this.$emit(e , this.result)
  	}
  }
}
</script>

<style lang="css" scoped>
</style>