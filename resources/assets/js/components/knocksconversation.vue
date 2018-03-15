<template>
<div>
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
  <hr/> 
  <knocksretriver
  :xdata = "{ q : to , oldest : oldestMsg }"
  url = "chat/init"
  :scope = "['conversation_'+to]"
  @success = "messages = $event.response"
  ></knocksretriver>
  <div :class = "[{'knocks_hidden' :  !active} , 'animated fadeIn']">
    <div class = "knocks_gray_border grey knocks_standard_border_radius row lighten-2 " v-if = "chattingUser != null">
      <a @click = "emitClick()" class = " knocks_side_padding col knocks_tinny_top_margin">
        <span class = "knocks-chevron-left knocks_text_md "></span>
      </a>
      <div class = "col">
        <knocksimg :src = "chattingUser.compressedAvatarUrl" :classes = "chattingUser.avatarClasses"></knocksimg>
        <div style="margin-left : 5px" class = "col">
          <b class="">{{chattingUser.name}}</b>
          <br/>
          <small class = "grey-text">{{chattingUser.chatStatus}}</small>
        </div>
      </div>
    </div>
    <div class = "row knocks_house_keeper">
      <div class = "row" :id = "'knocks_chatting_container_'+to" >
        cont <br/>cont <br/>cont <br/>cont <br/>cont <br/>cont <br/>cont <br/>cont <br/>cont <br/>cont <br/>cont <br/>cont <br/>cont <br/>cont <br/>cont <br/>cont <br/>
        cont <br/>cont <br/>cont <br/>cont <br/>cont <br/>cont <br/>cont <br/>cont <br/>cont <br/>cont <br/>cont <br/>
        cont <br/>cont <br/>cont <br/>cont <br/>cont <br/>cont <br/>cont <br/>cont <br/>cont <br/>cont <br/>cont <br/>
        cont <br/>cont <br/>cont <br/>cont <br/>cont <br/>cont <br/>cont <br/>cont <br/>cont <br/>cont <br/>cont <br/>
      </div>
      <knocksmessagesender
      style = "margin-bottom: 2px !important;position: fixed;bottom: 10px;width:  100%;"
      :class = "[{'animated slideOutDown' : !active} , {'animated slideInUp' : active}]"
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
      :gid = "'knocks_conversation_'+to"></knocksmessagesender>
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
      let containerTop = $('#knocks_chatting_container_'+vm.to).offset().top 
      let senderHeight = $('#knocks_conversation_'+vm.to).height()
      let containerHeight = ( windowHeight  - ( containerTop  +  senderHeight + 10 ) );
      console.log(senderHeight)
      chattingContainer.css({'height' : containerHeight + 'px' })

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