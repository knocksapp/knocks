<template>
<div :class = "main_container">
	<div id="row">
	<div class = "col s9 knocks_house_keeper">
		<knocksinput
		placeholder = "Circle Name"
		:gid = "gid+'_circle_name_input'"
		icon = "knocks-atom2"
		:mat_follower = "false"
		el_follower
		v-model = "circleName"
		is_required
		:scope = "['add_circle']">
		</knocksinput>
	</div>

	<div class = "row knocks_house_keeper">
		<br/>
	  <knocksiconpicker v-model ="circleIcon" class = "right"
       btn_class = " knocks_text_dark knocks_noshadow_ps knocks_collapse_toggler knocks_basic_button knocks_tinny_padding knocks_collapse_toggler"
       btn_icon = "knocks-smile-o"
       show_selections
       :gid = "gid+'_icon_picker'"
       collapse_align="right"
       parent_style= ""
      ></knocksiconpicker>
		</div>

</div>
<div id="row">
	<div class = "col s9">
		<span class = "knocks_text_dark knocks_text_md">{{circleName}}</span> <span v-for = "icon in circleIcon" class = "knocks_text_md " :class = "'knocks-'+icon.class"></span>
	</div>
	<div class = "col s3">
		 <transition
		    name="custom-classes-transition"
		    enter-active-class="animated zoomIn"
		    leave-active-class="animated zoomOut"
		  >
		<knockspopover>
			<template slot = "container">
				<knocksbutton v-if = "circleName.length > 0"
				disable_placeholder
				icon = "knocks-plus5"
				submit_at = "create/circles"
				success_at = "done"
				:gid = "gid+'_add_circle'"
				reset_on_success
				button_classes = "waves-effect waves-light btn knocks_standard_border_radius knocks_btn_color_kit knocks_color_kit knocks_text_md col s12 "
				label_classes = ""
				@knocks_submit_accepted = "refreshCircles()"
				:error_at = "[{ res : 'already_exists' , msg : 'You already have this circle!' }]"
				:success_msg= " 'Added to your Circles succesfully!'"
				:scope = "['add_circle']"
				validation_error = "There's some feilds we need you to complete it."
				connection_error = "There's a problem in your connection, please try again."
				:submit_data = "{ name : circleName ,icon: circleIcon }">
				</knocksbutton>
			</template>
			 <span slot = "content"  class = "knocks_tooltip animated flipInX" >
	              <span class = "knocks-plus5"></span>
	              <static_message msg = "Add Circle"></static_message>
            </span>
		</knockspopover>

	</transition>
	</div>
</div>
</div>
</template>

<script>
export default {

  name: 'knocksaddcircle',
  props : {
  	gid : {
  		type : String ,
  		required : true
  	},
  	main_container : {
  		type : String ,
  		default : 'row knocks_color_light_opacity_kit knocks_regular_border z-depth-1 knocks_regular_border knocks_standard_border_radius knocks_tinny_padding'
  	}
  },

  data () {
    return {
    	circleName : '' ,
    	circleIcon : null ,

    }
  },
  methods : {
  	refreshCircles(){
  		App.$emit('knocksRequestCirclesRefresh');
  	}
  }
}
</script>

<style lang="css" scoped>

</style>
