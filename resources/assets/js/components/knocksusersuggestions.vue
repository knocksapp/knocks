<template>
	<div class = "knocks_house_keeper knocks_tinny_border_radius blue-grey lighten-5 knocks_gray_border">
		<knocksretriver
		url = "user/suggestions"
		:xdata = "{c : currentSuggest}"
		v-model = "gripper"
		:scope = "['knocks_user_suggest'+_uid]"
		@success = "handleSugges($event)"></knocksretriver>
		<div class = "row " style="min-height : 320px ">
			<p class = "center knocks_text_ms knocks_text_bold blue-grey-text text-darken-2">
				<static_message msg = "People you may know"></static_message>
			</p>
			
			<knocksuser 
			:user = "user" 
			v-if = "(index == currentFrame || (index == (currentFrame -1) && !isSmallScreen))"
			:class = "[currentTransition , 'col l6 s12']"
			@input = "handleUser($event , index)"
			v-for = "(user , index) in currentSuggest" 
			:key = "index" 
			as_card></knocksuser>
		 
		</div>
		<div class="row"  element-loading-text="Loading..." v-loading = "gripper.loading" element-loading-spinner="el-icon-loading">
			<div class = "col s2">
			<el-button  class = "" type="info" icon="el-icon-arrow-left" circle @click = "slide('left')"></el-button>
		</div>
			<el-slider
			v-if = "currentSuggest.length > 1"
      v-model="currentFrame"
      :step="step"
      class = "col s8"
      :max = "currentSuggest.length - 1"
      :min = "1"
      show-stops>
    </el-slider>
    <div class = "col s2">
			<el-button type="info" icon="el-icon-arrow-right" class = "right" circle @click = "slide('right')"></el-button>
		</div>
		</div>
	</div>
</template>

<script>
export default {

  name: 'knocksusersuggestions',

  data () {
    return {
    	currentSuggest : [] , 
    	gripper : { loading : false } , 
    	currentTransition : 'animated slideInLeft' ,
    	currentFrame : 1 , 
    	isSmallScreen : window.innerWidth < 780 , 
    	step : 2
    }
  },
  mounted(){
  	const vm = this
  	$(document).ready(function(){
  		vm.isSmallScreen = window.innerWidth < 780 
  			vm.step = vm.isSmallScreen ? 1 : 2
  		$(window).resize(function(){
  			vm.isSmallScreen = window.innerWidth < 780 
  			vm.step = vm.isSmallScreen ? 1 : 2
  		})
  	})
  },
  methods : {
  	handleSugges(e){
  		this.$emit('input' , e.response)
  		let i 
  		for(i = 0 ; i < e.response.length; i++){
  			if(this.currentSuggest.indexOf(e.response[i]) == -1)
  				this.currentSuggest.push(e.response[i])
  		}
  		App.$emit('KnocksContentChanged')
  		
  	},
  	slide(direction){
  		this.currentTransition = direction == 'right' ?'animated slideInLeft' : 'animated slideInRight'  
  		let t = this.currentFrame
  		t = direction == 'right' ? t += this.step : t -= this.step
  		this.currentFrame = t > this.currentSuggest.length -1 ? this.currentSuggest.length -1  : t
  		if(this.currentFrame >= this.currentSuggest.length - 1) {
  			this.currentFrame = this.currentSuggest.length % 2 == 0 ? this.currentSuggest.length -1 : this.currentSuggest.length
  			App.$emit('knocksRetriver' , {scope : ['knocks_user_suggest'+this._uid] })
  			this.currentTransition = 'animated slideInLeft'
  		}
  		if(this.currentFrame < 1 && this.currentSuggest.length > 2) {
  			this.currentFrame = this.currentSuggest.length -1
  			this.currentTransition = 'animated slideInRight'
  		}
  		if(this.currentFrame < 1 && this.currentSuggest.length < 2){ 
  			this.currentFrame = 2
  			this.currentTransition = 'animated slideInRight'
  		}
  		App.$emit('KnocksContentChanged')
  	},
  	handleUser(e , index){
  		if(e){
  			// if(e.is_friend){
  			// 	this.currentSuggest.splice(index , 1)
  			// 	App.$emit('KnocksContentChanged')
  			// 	App.$emit('knocksRetriver' , {scope : ['knocks_user_suggest'+this._uid] })
  			// }
  		}
  	}
  }
}
</script>

<style lang="css" scoped>
</style>