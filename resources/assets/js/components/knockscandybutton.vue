<template>
	<div>
		 <knockselbutton
                          class="right green"
                          placeholder = "Send Request"
                          icon="knocks-send-1"
                          :error_at = "[{res : 'age proplem' , msg : 'Error : incorrect Age'}
                          ,{res : 'requested' , msg : 'Error : You have already send a request'}
                          ]"
                          success_at = "done"
                          submit_at = "check/candy"
                          success_msg = "Successfully"
                          gid = "candy"
                          :submit_data = " { to : to} "
                          v-if="as_request"
                          disable_placeholder
                          circle
                         
                          >
                          </knockselbutton>
                          <div class="row" v-if="as_accept">
                         
                          
                           <knockselbutton
                          class="right blue"
                          placeholder = "Ignore"
                          icon="knocks-close"
                          :error_at = "[{res : 'age proplem' , msg : 'Error : incorrect Age'}]"
                          success_at = "done"
                          submit_at = "ignore/candy"
                          success_msg = "This Request Has Been Ignored Successfully"
                          @knocks_submit_accepted = "ignoreFun(), passToParent1($event)"
                          gid = "candy2"
                          :submit_data = " { id : rec_id} "
                           v-if="as_accept"
                           :disabled="disabled"
                           disable_placeholder
                          circle

                          >
                          </knockselbutton>
                          <knockselbutton
                          class="right green "
                          :placeholder = "status"
                          icon="knocks-tick"
                          :error_at = "[{res : 'age proplem' , msg : 'Error : incorrect Age'}]"
                          success_at = "done"
                          submit_at = "accept/candy"
                          success_msg = "KnocksApp wish you Safe Experince"
                          @knocks_submit_accepted = "accpetFun(),passToParent1($event),passToParent2($event) "
                          gid = "candy1"
                          :submit_data = " { target : target} "
                          disable_placeholder
                          circle
                           :disabled="disabled"

                          >
                          </knockselbutton>
         
                        </div>
                         <knockselbutton
                         v-if="as_delete"
                          class="right red animated pulse"
                          placeholder = "Stop Monitering"
                          icon="knocks-controller-stop"
                          :error_at = "[{res : 'age proplem' , msg : 'Error : incorrect Age'}]"
                          success_at = "done"
                          submit_at = "ignore/candy"
                          success_msg = "This Request Has Been Ignored Successfully"
                          @knocks_submit_accepted = "ignoreFun(), passToParent1($event)"
                          gid = "candy2"
                          :submit_data = " { id : rec_id} "
                           :disabled="disabled"
                           disable_placeholder
                          circle

                          >
                        </knockselbutton>
	</div>
</template>
      
<script>
export default {
 props:{
   to : {
   	 type : Number,
   	 required : false
   },
    target : {
     type : Number,
     required : false
   },
   rec_id : {
     type : Number,
     required : false
   },
   as_request :{
     type : Boolean,
     required : false
   },
   as_accept :{
     type : Boolean,
     required : false
   },
    as_delete :{
     type : Boolean,
     required : false
   }
 },
  name: 'knockscandybutton',

  data () {
    return {
      status : 'Accpet',
      disabled : false,
      reqbtn : '',
    }
  },
  methods : {
      accpetFun(){
         this.status = 'Accepted'
         this.disabled = true
      },
      ignoreFun(){
         this.status = 'Ignored'
         this.disabled = true
      },
       
      passToParent1(e){
        let ob = e.submit_data ;
      ob.id = e.response;
     this.$emit('knocks_candy_request_deleted' , ob );
      },
      passToParent2(e){
        let ob = e.submit_data ;
      ob.id = e.response;
     this.$emit('knocks_candy_request_accepted' , ob );
      }
  }
}
</script>

<style lang="css" scoped>
</style>