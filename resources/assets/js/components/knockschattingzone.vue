<template>
<div>
  <transition enter-active-class = "animated slideInUp" leave-active-class = "animated slideOutDown">
     <!--  <knocksmessagesender 
      id = "knocks_rightbar_message_sender"
      v-if = "hasConversation"
      style = "position: fixed; bottom: 2px;width: 100%;z-index : 1" 
      replier_message = "Reply here"
      :scope= "[ '_reply_scope']"
      :error_at="[]"
      submit_at = "reply/create"
      :recorder_upload_data = "{ user : current_user , index : {}}"
      :player_show_options = "false"
      :post_at = "current_user"
      parent_type = "comment"
      success_at = "done"
      success_msg = "yess"
      toggle_parent_type = "comment"
      :gid = "'knocks_conversation_'+activeChat"></knocksmessagesender> -->
  </transition>
    <br class = "hide-on-med-and-up">
  <knocksretriver
  :xdata = "{}"
  v-model=  "friendsToChat"
  recursed
  behind_recursion
  @success = "updateUsersLastSeens($event)"
  url = "user/friendstochat"></knocksretriver>
  <transition enter-active-class = "animated slideInDown" leave-active-class = "animated slideOutUp">
      <div v-if = "currentChats.length > 0" class = "row" >
    <h4 class="ui horizontal divider header transparent" v-if = "!hasConversation">
    <i class="knocks-chat10"></i>
    <static_message msg = "Current Conversations"></static_message>
    </h4>
    <knocksconversation 
    :to = "chat" 
    @callback_click = "hasConversation = false"
    @close_head = "closeChatHead(index)"
    @restore_head = "restoreChat(chat)"
    :active = "isActive(chat)"
    :class = "[{'animated slideInDown' : (isActive(chat) && isCurrent(chat) || !hasConversation)}, {'animated slideOutUp knocks_hidden' : !(isActive(chat) && isCurrent(chat) || !hasConversation)}]"
    v-for = "(chat , index) in currentChats" :key = "index"></knocksconversation>
  </div>
  </transition>
  <div v-if = "friendsToChat != null && friendsToChat.response != null && currentChats.length != friendsToChat.response.length" :class = "{'animated slideOutDown' : hasConversation}">
       <h4 class="ui horizontal divider header transparent">
    <i class="knocks-group-outline"></i>
    <static_message msg = "Friends To Chat"></static_message>
    </h4>
    <knocksuser 
    class = "knocks_gray_hover row knocks_tinny_margin knocks_standard_border_radius"
    @blocked = "removeFriends(index)"
    @callback_click = "addConversation(friend.id)"
    v-if="!isCurrent(friend.id) && index < 10"
    :user = "friend.id" v-for = "(friend , index) in friendsToChat.response" as_callback :key = "index"></knocksuser>
  </div>
  
</div>
</template>

<script>
export default {

  name: 'knockschattingzone',

  data () {
    return {
      friendsToChat : null ,
      currentChats : [] , 
      hasConversation : false , 
      activeChat : null , 
      current_user : parseInt(UserId) , 
    }
  },
  mounted(){
    const vm = this;
    App.$on('knocksConversationToggle' , (payloads)=>{ vm.hasConversation = payloads.toggle });
  },
  methods : {
    updateUsersLastSeens(e){
      let i ;
      for(i = 0 ; i < e.response.length; i++){
        App.$emit('knocksUserKeyUpdate' , 
          { 
            user : e.response[i].id , 
            patch : [ 
            { key : 'last_seen' , value :  e.response[i].last_seen } ,
            { key : 'status' , value :  e.response[i].status } 
          ] 
        })
      }
    },
    isActive(chat){
      if(!this.hasConversation) return false ;
      return this.activeChat == chat ? true : false ;
    },
    isCurrent(chat){
     return (this.currentChats.indexOf(chat) == -1) ? false : true ;
    },
    addConversation(user){

      if(this.currentChats.indexOf(user) == -1) this.currentChats.push(user)
        this.activeChat = user ;
        App.$emit('knocksConversationToggle' , { to : user , toggle : true } );
    },
    restoreChat(chat){
      this.hasConversation = true ; 
      this.activeChat = chat;
    },
    closeChatHead(index){
      this.currentChats.splice(index , 1); this.hasConversation = false; this.activeChat = null ;
    },
    removeFriends(index){
      this.friendsToChat.response.splice(index , 1)
      App.$emit('knocksContentChanged')
    }
  }
}
</script>

<style lang="css" scoped>
</style>