<template lang="html">
<div>
  <knocksretriver
  v-model=  "user_id"
  url = "userblock/isblockeduser"
  @success="getUsersName()"
  :xdata = "{ blocked_user_id }"
  :scope = "['user_filter']"
  >
  </knocksretriver>
  <div v-if = "!user_id.response">
	<el-tooltip class="item" effect="light" content="Block User" >
  <knocksbutton
  v-if = "blocked_user_id != auth"
  button_classes="ui  basic button"
  icon = "knocks-lock9 red-text left "
  disable_placeholder
  leave_class = "animated jello"
  :scope = "['block_user']"
  :gid = "'user_action_block_'+blocked_user_id+'_rand'+_uid"
  success_at = "done"
  :error_at = "[{ res : 'invalid' , msg : 'Invalid Operation' }]"
  success_msg = "Blocked succesfully."
  submit_at = "userblock/addblockeduser"
  @knocks_submit_accepted = "updateBlockedUser(blocked_user_id)"
  :submit_data = '{blocked_user_id : blocked_user_id}'
  ></knocksbutton>
  </el-tooltip>
</div>
<div v-if = "user_id.response">
  <el-tooltip class="item" effect="light" content="Unblock User" >
  <knocksbutton
  v-if = "blocked_user_id != auth"
  button_classes="ui  basic button"
  icon = "knocks-lock-open3 green-text left "
  disable_placeholder
  leave_class = "animated jello"
  :scope = "['unblock_user']"
  :gid = "'user_action_block_'+blocked_user_id+'_rand'+_uid"
  success_at = "done"
  :error_at = "[{ res : 'invalid' , msg : 'Invalid Operation' }]"
  success_msg = "Unblocked."
  submit_at = "userblock/unblockuser"
  @knocks_submit_accepted = "deleteBlockedUser(blocked_user_id)"
  :submit_data = '{blocked_user_id : blocked_user_id}'
  ></knocksbutton>
  </el-tooltip>
</div>
</div>

</template>

<script>
export default {
  name: 'knocksblockuser',
  props : {
  	blocked_user_id : {
  		type : Number ,
  		required : true
  	} ,

  },
  computed : {

  },
  data () {
    return {
      user_id : '',
      auth  : parseInt(UserId),
    }
  },
  methods : {

    getUsersName(){
     App.$emit('KnocksContentChanged')
    },

    updateBlockedUser(index){

      this.user_id.response = true ;
      App.$emit('knocksUserBlocked',{user : this.blocked_user_id})
    },
    deleteBlockedUser(index){

      this.user_id.response = false ;
      this.$emit('unblocked')
      App.$emit('knocksUserUnblocked',{user : this.blocked_user_id})
    },
},

}
</script>

<style lang="css">
</style>
