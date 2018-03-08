<template>
<div>
  <knocksretriver
  :xdata = "{}"
  v-model=  "friendsToChat"
  recursed
  behind_recursion
  @success = "updateUsersLastSeens($event)"
  url = "user/friendstochat"></knocksretriver>
  <transition enter-active-class = "animated slideInDown" leave-active-class = "animated slideOutUp">
      <div v-if = "currentChats.length > 0" class = "row" >
    <h4 class="ui horizontal divider header transparent">
    <i class="knocks-chat10"></i>
    <static_message msg = "Current Conversations"></static_message>
    </h4>
    <knocksconversation :to = "chat" 
     @callback_click = "currentChats.splice(index , 1 ); hasConversation = false"
    v-for = "(chat , index) in currentChats" :key = "index"></knocksconversation>
  </div>
  </transition>
  <div v-if = "friendsToChat != null" :class = "{'animated slideOutDown' : hasConversation}">
       <h4 class="ui horizontal divider header transparent">
    <i class="knocks-group-outline"></i>
    <static_message msg = "Friends To Chat"></static_message>
    </h4>
    <knocksuser 
    @callback_click = "addConversation(friend.id)" :user = "friend.id" v-for = "friend in friendsToChat.response" as_callback :key = "friend.id"></knocksuser>
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
    addConversation(user){

      if(this.currentChats.indexOf(user) == -1) this.currentChats.push(user)
        App.$emit('knocksConversationToggle' , { to : user , toggle : true } );
    }
  }
}
</script>

<style lang="css" scoped>
</style>