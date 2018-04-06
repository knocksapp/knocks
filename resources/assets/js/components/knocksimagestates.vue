<template>
	<div>
		<knocksretriver url = "media/image/states" :xdata = "{token : token}" v-model = "ret" @success = "handle($event)"></knocksretriver>
		     <knocksreactionstats
            v-if = "res != null"
            :candy = "candy"
            knocks_reactor_ul = "knocks_tinny_reactor_ul"
            reactor_collapser_icon = "knocks_text_ms knocks-like knocks_dark_anchor"
            reply_initial_class = "btn btn-floating knocks_super_tiny_floating_btn right knocks_side_padding knocks_noshadow_ps  knocks_text_dark transparent"
            reactor_initial_class = "btn btn-floating knocks_reaction_trigger knocks_super_tiny_floating_btn knocks_noshadow_ps knocks_text_dark transparent"
            bar_classes ="transparent"
            :parent_date = "created_at"
            :reply_scope="[ gid + '_reply_scope']"
            parent_type = "timelinephoto"
            :gid = "gid+'_reaction_stats'"
            
            :object_id = "res.object_id">
            </knocksreactionstats>
            <knocksreply
            v-if = "res != null"
            replier_message = "Leave a comment"
            :scope= "[ gid + '_reply_scope']"
            :error_at="[]"
            show_on_mount
            :object_id = "res.object_id"
            :parent_id = "token"
            submit_at = "comment/create"
            :recorder_upload_data = "{ user : auth, index : {}}"
            :player_show_options = "false"
            :post_at = "owner_object.id"
            parent_type = "timelinephoto"
            success_at = "done"
            success_msg = "yess"
            toggle_parent_type = "timelinephoto"
            :gid = "gid+'_reply'">
            	                           <h4 class="ui horizontal divider header transparent" slot = "top">
  <i class="knocks-balloon2"></i>
  <static_message msg = "Leave a comment"></static_message>
</h4>
            </knocksreply>

	</div>
</template>

<script>
export default {

  name: 'knocksimagestates',
  props : {
  	token : {
  		type : Number , 
  		required : true ,
  	},
  	candy : {
  		type : Boolean , 
  		default : false 
  	},
  	scope : {
  		type : Array ,
  		required : true ,
  	},
  	gid : {
  		type : String , 
  		required : true ,
  	},
  	created_at : {
  		type : String , 
  		default : ''
  	},
  	owner_object : {
  		type : Object ,
  		required : true
  	}
  },
  data () {
    return {
    	ret : { loading : false } , 
    	res : null ,
    	auth : parseInt(UserId)
    }
  },
  methods : {
  	handle(e){
  		if(e.response == 'invalid'){
  			this.res = null ; 
  			return ;
  		}
  		this.res = e.response;
  	}
  }
}
</script>

<style lang="css" scoped>
</style>