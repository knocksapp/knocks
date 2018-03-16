<template>
<div id = "knocks_rightbar"
	:class = '[{"animated slideInRight" : show} ,  {"animated slideOutRight" : !show} ]'
	class = "knocks_house_keeper fixed  grey lighten-5" >
	<div style="height : inherit">
		<div style="height : 5vh" class = "knocks_gray_bottom_border">
			<knockstaps :multiple = "false"
			v-model="tap"
			anchor_class = " col s4 center knocks_gray_hover knocks_tinny_border_radius knocks_tinny_padding "
			left_most_class = ""
			right_most_class = ""
			anchor_regular_class=" grey-text text-darken-2 knocks_text_ms "
			anchor_active_class = "blue-text knocks_text_md animated rubberBand grey lighten-4 "
			:options = "
			[ 
			{ icon : 'knocks-speech-bubble-2' , label : '' , static : false , value : 'chat'} ,
			{ icon : 'knocks-balloon' , label : '' , static : true , value : 'ballons'} ,
			{ icon : 'knocks-user-add-outline' , label : '' , static : true , value : 'requests'}
			]" >
			</knockstaps>
		</div>
		<div style="height : calc(95vh - 50px)" id = "knocks_rightbar_taps_container">
			<knockschattingzone style = "height : inherit" :class = "[{'animated fadeOut' : tap != 'chat' },{'animated fadeIn' : tap == 'chat' }]"></knockschattingzone>
			        
		</div>
	</div>
</div>
</template>
<script>
export default {

  name: 'knocksrightbar',
  props : {
  	show : {
  		type : Boolean , 
  		default : true 
  	}
  },

  data () {
    return {
    	tap : 'chat'
    }
  }
}
</script>

<style lang="css" scoped>
</style>