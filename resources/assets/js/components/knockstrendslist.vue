<template>
<div>
	<knockscollapse
	icon = "knocks-fire"
	title = "Trends"
	toggle_on_mount
	toggler_container = " grey lighten-4 row knocks_gray_hover knocks_margin_keeper knocks_gray_border knocks_fair_padding"
	active_class = "red-text knocks_text_ms">
	<div slot = "content" v-loading = "trendsRetriver.loading" element-loading-spinner="el-icon-loading">
		<knocksretriver
		url = "hashtags/trends/get"
		v-model = "trendsRetriver"
		:xdata = "{}"
		@success = "handleTrends($event)">
		</knocksretriver>
		<knocksshowkeys show_scope = "hashtag" :show_input = "trends" :show_key = "4" :see_messages = "{ less : 'See Less Trends' , more : 'See More Trends'}"></knocksshowkeys>
	</div>
	</knockscollapse>
</div>
</template>

<script>
export default {

  name: 'knockstrendslist',

  data () {
    return {
    	trends : [] , 
    	trendsRetriver : { loading : false }
    }
  },
  methods : {
  	handleTrends(e){
  		this.trends = e.response
  	}
  }
}
</script>

<style lang="css" scoped>
</style>