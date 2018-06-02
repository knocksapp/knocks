<template lang="html">
<div>
  <knocksretriver
  v-model=  "user_id"
  url = "userblock/isblockeduser"
  @success="getUsersName()"
  :xdata = "{ blocked_user_id }"
  :scope = "['user_filter']">
  </knocksretriver>
  <div v-if = "user_id.response" class = "col s10">
    <knocksimg :src = "asset('media/avatar/compressed/'+blocked_user_id)" :classes = "[knocks_avatar_classes, 'animated zoomInDown' ]" >
    </knocksimg>
    <div :class = "name_container_class" class="" >
       <el-tooltip class="item" effect="light" :content="displayName" >
      <a :class = "name_class" :href = "userUrl"  v-if="user_id.response "> {{ handledDisplayName }}</a><slot name = "append_to_display_name"></slot><br/>
      <a :class = "username_class" :href = "userUrl" v-if="user_id.response" style = "display:block"> {{'@'+user_id.response.username}} </a>
    </el-tooltip>
    </div>
  </div>
  <div 
  class = "col s2"
  v-if = "user_id.response !== undefined && user_id.response !== null && user_id.response.blocked !== undefined && !user_id.response.blocked">
    <el-tooltip class="item" effect="light" content="Block User" >
    <knockselbutton
    v-if = "blocked_user_id != auth"
    icon = "knocks-lock9"
    class = "right "
    disable_placeholder
    type = "danger"
    circle
    :scope = "['block_user']"
    success_at = "done"
    :error_at = "[{ res : 'invalid' , msg : 'Invalid Operation' }]"
    success_msg = "Blocked succesfully."
    submit_at = "userblock/addblockeduser"
    @knocks_submit_accepted = "updateBlockedUser(blocked_user_id)"
    :submit_data = '{blocked_user_id : blocked_user_id}'
    ></knockselbutton>
    </el-tooltip>
  </div>
  <div class = "col s2"
  v-if = "user_id.response !== undefined && user_id.response !== null && user_id.response.blocked !== undefined && user_id.response.blocked">
    <el-tooltip class="item" effect="light" content="Unblock User" >
    <knockselbutton
    v-if = "blocked_user_id != auth"
    circle
    class = "right"
    type = "success"
    icon = "knocks-lock-open3"
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
    ></knockselbutton>
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
      name_class : {
      type : String ,
      default : 'knocks_text_anchor  knocks_text_bold knocks_tinny_side_padding'
    },
    username_class : {
      type : String ,
      default : 'knocks_text_xs knocks_text_bold knocks_tinny_side_padding'
    },
    knocks_avatar_classes : {
      type : String ,
      default : 'knocks_avatar knocks_house_keeper col '
    },
    name_container_class : {
      type : String ,
      default : 'col s9'
    },

  },
  computed : {

  },
  data () {
    return {
      user_id : { response : null },
      auth  : parseInt(UserId),
      displayName : '' , 
      handledDisplayName : '' , 
      userUrl : '' , 
    }
  },
  mounted(){
    const vm = this
    App.$on('knocksUserUnblocked', (payloads)=>{
      if(vm.blocked_user_id == payloads.user && vm.user_id.response != null )
        vm.user_id.response.blocked = false
    })

    App.$on('knocksUserBlocked', (payloads)=>{
      if(vm.blocked_user_id == payloads.user && vm.user_id.response != null )
        vm.user_id.response.blocked = true
    })
  },
  methods : {

    getUsersName(){
      this.userUrl = this.asset(this.user_id.response.username);
      this.getDisplayName()
     App.$emit('KnocksContentChanged')
    },

    updateBlockedUser(index){

      this.user_id.response.blocked = true ;
      App.$emit('knocksUserBlocked',{user : this.blocked_user_id})
    },
    deleteBlockedUser(index){

      this.user_id.response.blocked = false ;
      this.$emit('unblocked')
      App.$emit('knocksUserUnblocked',{user : this.blocked_user_id})
    },
    asset(url){
      return LaravelOrgin + url ;
    },
    getDisplayName(){
      if(!this.user_id) return;
      if(this.user_id.response.display_name === undefined || this.user_id.response.display_name.length == 0){
        this.displayName = this.first_name;
        return
      }
      let i, temp = [];
      for(i = 0; i < this.user_id.response.display_name.length; i++){
        if(this.user_id.response[ this.user_id.response.display_name[i] ] !== undefined
          && this.user_id.response[ this.user_id.response.display_name[i] ] !== null
          && this.user_id.response[ this.user_id.response.display_name[i] ].length > 0){
          if(this.user_id.response.display_name[i] == 'nickname' && this.user_id.response.display_name.length > 1)
            temp.push('('+this.user_id.response[this.user_id.response.display_name[i]] + ')')
         else temp.push(this.user_id.response[this.user_id.response.display_name[i]])
        }
      }
      if(temp.length == 0){
        this.user_id.display_name = ['first_name' , 'last_name']
        temp.push(this.user_id.response.first_name)
        temp.push(this.user_id.response.last_name)
      }
      this.displayName = temp.join(' ');
      this.handledDisplayName = this.displayName.length > 15 ? this.displayName.substr(0,15)+'..' : this.displayName
    },
},

}
</script>

<style lang="css">
</style>
