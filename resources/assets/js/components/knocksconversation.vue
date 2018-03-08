<template>
<div>
	<knocksuser
    :user = "to"
    as_callback
    v-model = "chattingUser"
    :class = "{'knocks_hidden' : toggleCase}"
    class = "animated slideInUp">
    	<a @click = "emitClick" slot = "append" class = "right knocks_side_padding">
    		<span class = "knocks-close"></span>
    	</a>
    </knocksuser>
    <knocksretriver
    :xdata = "{ q : to , oldest : oldestMsg }"
    url = "chat/init"
    :scope = "['conversation_'+to]"
    @success = "messages = $event.response"
    ></knocksretriver>
    <div :class = "[{'knocks_hidden' :  !toggleCase} , 'animated fadeIn']">
    	<div class = "knocks_gray_border " v-if = "chattingUser != null">
    		<a @click = "emitClick" class = " knocks_side_padding col">
    		<span class = "knocks-chevron-left"></span>
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
  	}
  },
  data () {
    return {
    	toggleCase : true ,
    	chattingUser : null , 
    	oldestMsg : null , 
    	messages : null ,
    }
  },
  mounted(){
  	const vm = this;
  	App.$on('knocksConversationToggle' , (payloads)=>{
  		if(payloads.to == vm.to){
  			vm.toggleCase = payloads.toggle ; 
  		}else vm.toggleCase = false ;
  	})
  },
  methods : {
  	emitClick(){ this.$emit('callback_click') ; } ,
  }
}
</script>

<style lang="css" scoped>
</style>