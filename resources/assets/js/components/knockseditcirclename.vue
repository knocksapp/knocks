<template>
	<div>
<knockselinput
placeholder = "Type your new name.."
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
:scope = "[_uid+'circle_editor']"
v-model = "circleName"
@live_status = "statusEmit($event)"
@autocomplete = "emit($event)"
>
<knockselbutton
slot="aside"
disable_placeholder
icon = "knocks-pencil"
v-loading = "isLoading"
:disabled = "isLoading || circlesResult.length > 0"
submit_at = "update/circles"
computed_response
@knocks_submit_accepted = "refreshCircles($event)"

:error_at = "[{ res : 'already_exists' , msg : 'You already have this circle!' }]"
:success_msg= " 'Updated your Circle succesfully!'"
:scope = "[_uid+'circle_editor']"
validation_error = "There's some feilds we need you to complete it."
connection_error = "There's a problem in your connection, please try again."
:submit_data = "{ name : circleName , circle : circle }">
</knockselbutton>
</knockselinput>
	</div>
</template>

<script>
export default {

  name: 'knockseditcirclename',
  props : {
  	circle : {
  		type : Number , 
  		required : true
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
    statusEmit(e){
      if(this.circleName.length == 0 && e.value.length > 0) this.circleName = e.value
      this.$emit('exist_status' , e)
    },
  	refreshCircles(e){
  	 App.$emit('knocksCircleKeyUpdate' , { circle : this.circle, patch : [ { key : 'name' , value : this.circleName } ] })
  	}
  }
}
</script>

<style lang="css" scoped>
</style>