<template>
<div>
	<knockscollapse
	regular_class = "teal-text knocks_text_ms text-accent-4"
	active_class = "knocks_text_light knocks_text_ms "
	toggler_container = "row knocks_margin_keeper knocks_tinny_padding"
	title = "I forgot my password." icon = "knocks-lock" >
	<div slot ="content" class = "row">
		<div class = 'col s12'>
			<p class = "knocks_text_light">
				<static_message msg = "In case you forgot your password, type your email and ask for a recovery email."></static_message>
			</p>
		</div>
		<div class="col s12">
			<knockselinput
			:scope = "['knocks_forgot_mypassword_'+_uid]"
			inner_placeholder
			placeholder = "Type your E-mail"
			icon = "knocks-email3"
			is_required
			icon_error = "red-text text-accent-1"
			regex = '^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$'
			regex_example = "Your email format is not correct, please follow this schema example@foo.bar"
			v-model = "email"></knockselinput>
		</div>
		<div class="col s12">
			<knockselbutton
			icon = "knocks-paper-plane-o"
			button_classes = "knocks_light_color_kit right"
			placeholder = "Send me an email"
			:error_at = "[
			{ res : 'not_exist' , msg : 'This email does not belong to any account.' } , 
			{ res : 'blocked' , msg : 'This account is blocked, check your mail to unblock it first.' } , 
			{ res : 'auth' , msg : 'You can not be here.' } , 
			]"
			:submit_data = "{ email : email }"
			:scope = "['knocks_forgot_mypassword_'+_uid]"
			submit_at = 'user/passwords/forgot/ask'></knockselbutton>
		</div>
	</div>
	</knockscollapse>
</div>
</template>

<script>
export default {

  name: 'knocksforgotmypassword',

  data () {
    return {
    	email : ''
    }
  }
}
</script>

<style lang="css" scoped>
</style>