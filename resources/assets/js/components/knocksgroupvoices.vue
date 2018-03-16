<template>
	<div>
		 <knocksretriver
    v-model=  "group_voices"
    url = "get_group_voices"
    :xdata="{group_id : group_id}"
    >
    </knocksretriver>
    <div class="row" v-if="group_voices != null">
    	<ul class="uk-list uk-list-divider" uk-margin>
       <li v-for = "(voice,index) in group_voices.response" class="col s12">
         <knocksuser :user = "voice.user" as_chip></knocksuser>
        <knocksplayer
                        :gid="index+'_group_player'"
                        main_container = "row knocks_house_keeper"
                        class="voice col 12 knocks_house_keeper"
                        :show_volume="false"
                        buttons_container = "col"
                        :show_options="false"
                        :specifications = "{id : voice.blob , user : current_user , object : voice.blob}"
                        full_back_loading
                        :load_on_mount="false"></knocksplayer></li>
       </ul>   
    </div>
	</div>
</template>

<script>
export default {

  name: 'knocksgroupvoices',
   props : {
    group_id : {
    	type : Number,
    	required : true
    }
  },
  data () {
    return {
      group_voices : null,
      current_user : UserId
    }
  },
   methods : {
  	asset(url){
        return window.Asset(url);
       },
  }
}
</script>

<style lang="css" scoped>
</style>