<template>
<div class = "">
  <knocksuser
  :user = "to"
  as_callback
  v-model = "chattingUser"
  @callback_click = "emitRestoreHead()"
  :class = "{'knocks_hidden' : active}"
  class = "animated slideInUp">
  </knocksuser>
  <a @click = "emitCloseHead()"  class = "right  col"   :class = "{'knocks_hidden' : active}">
    <span class = "knocks-close"></span>
  </a>
  <hr :class = "{'knocks_hidden' : active}"/> 
  <knocksretriver
  :xdata = "{ q : to , oldest : oldestMsg }"
  url = "chat/init"
  :scope = "['conversation_'+to]"
  @success = "messages = $event.response"
  ></knocksretriver>
  <div :class = "[{'knocks_hidden' :  !active} , 'animated fadeIn']" class = "inherited_height row">
    <div class = "knocks_gray_border grey  row knocks_house_keeper lighten-4 " v-if = "chattingUser != null" style=" height : 10%">
      <div class = "col s12 knocks_house_keeper "><a @click = "emitClick()" class = " knocks_side_padding col knocks_tinny_top_margin">
        <span class = "knocks-chevron-left knocks_text_md "></span>
      </a>
      <div class = "col">
        <knocksimg :src = "chattingUser.compressedAvatarUrl" :classes = "chattingUser.avatarClasses"></knocksimg>
        <div style="margin-left : 5px" class = "col">
          <b class="">{{chattingUser.name}}</b>
          <br/>
          <small class = "grey-text">{{chattingUser.chatStatus}}</small>
        </div>
      </div></div>
    </div>
    <div class = "row knocks_house_keeper">
      <div class = "col s12" :id = "'knocks_chatting_container_'+to"  style="min-height : 50vh; overflow-y : auto">
       hhhhh<br/>hhhhh<br/>hhhhh<br/>hhhhh<br/>hhhhh<br/>hhhhh<br/>hhhhh<br/>hhhhh<br/>hhhhh<br/>hhhhh<br/>hhhhh<br/>hhhhh<br/>hhhhh<br/>
       hhhhh<br/>hhhhh<br/>hhhhh<br/>hhhhh<br/>hhhhh<br/>hhhhh<br/>hhhhh<br/>hhhhh<br/>hhhhh<br/>hhhhh<br/>hhhhh<br/>hhhhh<br/>hhhhh<br/>
       hhhhh<br/>hhhhh<br/>hhhhh<br/>hhhhh<br/>hhhhh<br/>hhhhh<br/>hhhhh<br/>hhhhh<br/>hhhhh<br/>hhhhh<br/>hhhhh<br/>hhhhh<br/>hhhhh<br/>
       hhhhh<br/>hhhhh<br/>hhhhh<br/>hhhhh<br/>hhhhh<br/>hhhhh<br/>hhhhh<br/>hhhhh<br/>hhhhh<br/>hhhhh<br/>hhhhh<br/>hhhhh<br/>hhhhh<br/>
       hhhhh<br/>hhhhh<br/>hhhhh<br/>hhhhh<br/>hhhhh<br/>hhhhh<br/>hhhhh<br/>hhhhh<br/>hhhhh<br/>hhhhh<br/>hhhhh<br/>hhhhh<br/>hhhhh<br/>
      </div>
      <div class = "row">
      
    </div>
    </div>
  </div>
</div>
</template>

<script>
export default {

  name: 'knocksconversation',
  props : {
  	to : {
  		type : Number , 
  		required : true , 
  	} , 
  	type : {
  		type : String , 
  		default : 'user' , 
  	},
    active : {
      type : Boolean , 
      default : false , 
    }
  },
  data () {
    return {
    	toggleCase : true ,
    	chattingUser : null , 
    	oldestMsg : null , 
    	messages : null ,
      current_user : parseInt(UserId)
    }
  },
  mounted(){
  	const vm = this;
  	App.$on('knocksConversationToggle' , (payloads)=>{
  		if(payloads.to == vm.to){
  			vm.toggleCase = payloads.toggle ; 
  		}else vm.toggleCase = false ;
  	})
    $(document).ready(function(){
      let windowHeight = $('#knocks_rightbar').height();
      setTimeout(()=>{ 
      let chattingContainer = $('#knocks_chatting_container_'+vm.to);
      let containerTop = $('#knocks_rightbar_taps_container').height()
      let senderHeight = $('#knocks_rightbar_message_sender').height()
      let containerHeight = (  containerTop  -  (senderHeight + 47) );

      chattingContainer.css({'max-height' : containerHeight + 'px' })

      }  , 1000)

    })
  },
  methods : {
  	emitClick(){ this.$emit('callback_click') ; } ,
    emitCloseHead(){ this.$emit('close_head') ; } ,
    emitRestoreHead(){ this.$emit('restore_head') ; } ,
  }
}
</script>

<style lang="css" scoped>

</style>