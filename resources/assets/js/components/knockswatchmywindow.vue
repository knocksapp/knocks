<template>
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
  			vm.isFocused = true
  			vm.emit('focus')
  		})
  		$(window).focus(function(){
  			vm.isFocused = false
  			vm.emit('blur ')
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