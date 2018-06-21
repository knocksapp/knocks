<template>
<div>
	<knocksretriver
	url = "hashtags/trends/get"
	v-model = "trendsRetriver"
	:xdata = "{}"
	@success = "handleTrends($event)">
	</knocksretriver>
	<knockscollapse
	icon = "knocks-fire"
	title = "Trends"
	gid = "knocks_trends_list_collapse"
	toggler_container = " grey lighten-4 row knocks_gray_hover knocks_margin_keeper knocks_gray_border knocks_fair_padding"
	active_class = "red-text knocks_text_ms">
	<div slot = "content" v-loading = "trendsRetriver.loading" element-loading-spinner="el-icon-loading">
		<knocksshowkeys
		:hide_count = "trends.length == 0"
		show_scope = "hashtag"
		:show_input = "trends"
		:show_key = "4"
		:see_messages = "{ less : 'See Less Trends' , more : 'See More Trends'}">
		</knocksshowkeys>
		<div class="row knocks_mp_top_margin">
			<el-button icon="el-icon-refresh" @click = 'trendsRetriver.retrive()' :loading = "trendsRetriver.loading" class = "right" circle></el-button>
		</div>
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
  		App.$emit('KnocksCollapseSwitchByGid' , { gid : 'knocks_trends_list_collapse' , switch : this.trends.length > 0  })
  	}
  }
}
</script>

<style lang="css" scoped>
</style>