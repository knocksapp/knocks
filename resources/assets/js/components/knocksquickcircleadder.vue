<template>
<knockselinput
:placeholder = "placeholder"
is_required
check_live
check_at = "circle/check"
check_valid_at = "valid"
check_invalid_at = "invalid"
check_live_msg = "You already have a circle with this name"
autocomplete
@loading = "isLoading = true"
@loading_done = "isLoading = false"
inner_placeholder
:autocomplete_start="0"
autocomplete_on_mount
autocomplete_from = "circle/search"
has_slot
:hide_errors = "hide_errors"
:scope = "scope"
v-model = "circleName"
@autocomplete = "emit($event)"
>
<knockselbutton
slot="aside"
disable_placeholder
icon = "knocks-plus5"
v-loading = "isLoading"
:disabled = "isLoading || circlesResult.length > 0"
submit_at = "create/circles"
computed_response
@knocks_submit_accepted = "refreshCircles($event)"
:error_at = "[{ res : 'already_exists' , msg : 'You already have this circle!' }]"
:success_msg= " 'Added to your Circles succesfully!'"
:scope = "scope"
validation_error = "There's some feilds we need you to complete it."
connection_error = "There's a problem in your connection, please try again."
:submit_data = "{ name : circleName ,icon: '' }">
</knockselbutton>
</knockselinput>
</template>

<script>
export default {

  name: 'knocksquickcircleadder',
  props : {
  	scope  : {
  		type : Array , 
  		default : null ,
  	},
  	placeholder : {
  		type : String , 
  		default : 'Add a new circle..'
  	},
  	hide_errors : {
  		type : Boolean ,
  		default : false 
  	}
  },
  data () {
    return {
    	circleName : '' , 
    	isLoading : false ,
    	circlesResult : [] ,
    }
  },
  methods : {
  	emit(e){
  		this.$emit('input' , e);
  		this.circlesResult = e;
  		App.$emit('KnocksContentChanged');
  	},
  	refreshCircles(e){
  		this.circlesResult.push(e.response)
  		App.$emit('KnocksContentChanged');
      this.$emit('knocks_circle_added' , e.response);
  	}
  }
}
</script>

<style lang="css" scoped>
</style>