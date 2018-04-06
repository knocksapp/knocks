<template>
    <div>
        <knocksretriver
        v-model=  "join_request"
        url = "get_group_request"
        :xdata="{group_id : group_id}"
        @success="requestMember()"
        >
        </knocksretriver>
        <knocksretriver
        v-model=  "group_requests"
        url = "check_group_user_request"
        :xdata="{group_id : group_id}"
        >
    </knocksretriver>
      <div v-if="group_object != null && !as_result && !add_member_mode" class="knocks_fair_bounds knocks_sp_top_margin">
      <el-button 
      v-if="group_object.preset == 'public'"
      @click="isChecked()"
      type="primary"
      v-loading="isLoading"
      :disabled = "isLoading"
      >
      {{status}}
      <i v-if="!check" class="knocks-login"></i>
      <i v-if="check" class="knocks-log-out"></i>
      </el-button>
    </div>
    <div v-if="as_result && group_object != null && !add_member_mode" class="knocks_fair_bounds knocks_sp_top_margin">
      <el-button
      type="primary"
       v-if="group_object.preset == 'public'"
       @click="isChecked('public')"
       v-loading="isLoading"
       :disabled = "isLoading"
       >
      <span v-if="open"> Open <i class="knocks-login"></i></span>
      <span v-if="join"> Join <i class="knocks-log-out"></i></span> 
      </el-button>
    </div>
    <div v-if = "add_member_mode && group_object != null && !checkMem">
      <el-button 
      v-if="group_object.preset == 'public'"
      @click="addMemberToGroup('public')"
      type="primary"
      v-loading="isLoading"
      :disabled = "isLoading"
      >
      <span> Invite <i class="knocks-plus2"></i></span>
    </el-button>
    </div>
    <div v-if = "add_member_mode && group_object != null && !checkMem">
      <el-button 
      v-if="group_object.preset == 'closed'"
      @click="addMemberToGroup('closed')"
      type="primary"
      v-loading="isLoading"
      :disabled = "isLoading"
      >
      <span> Invite <i class="knocks-plus2"></i></span>
    </el-button>
    </div>
     <div v-if="as_result && group_object != null && !add_member_mode && group_requests != null" class="knocks_fair_bounds knocks_sp_top_margin">
      <el-button
      type="primary"
       v-if="group_object.preset == 'closed'"
       @click="isChecked('closed')"
       :disabled = "isLoading || group_requests.response"
       >
      <span v-if="close && !group_requests.response"> Ask for Join <i class="knocks-log-in"></i></span>
      <span v-if="open && !group_requests.response"> Open <i class="knocks-login"></i></span>
      <span v-if="join && !group_requests.response"> Join <i class="knocks-log-out"></i></span> 
      <span v-if="wait || group_requests.response"> Requested <i class="knocks-paper-plane"></i></span> 
      </el-button>
    </div>
    <div class="row" v-if = "as_owner && group_object != null && group_object.preset == 'closed'">
      <el-button 
      v-if="!declined"
      @click="isChecked('accpet')"
      type="primary"
      v-loading="isLoading"
      :disabled = "disabled"
      >
      <span v-if ="accpet"> Accept <i class="knocks-plus2"></i></span>
      <span v-if="confirmed"> Confirmed <i class="knocks-tick"></i></span>
    </el-button>
    <el-button 
      @click="isChecked('decline')"
      type="danger"
      v-loading="isLoading"
      :disabled = "disabled"
      v-if="!confirmed || declined"
      >
      <span> Decline <i class="knocks-close"></i></span>
    </el-button>
    </div>
    </div>
</template>

<script>
export default {

  name: 'knocksgroupjoining',
  props : {
        as_result : {
        type : Boolean,
        default : false 
      },
      group_id : {
        type : Number,
        required : true
      },
      add_member_mode : {
         type : Boolean,
         default : false,
      },
      user_id : {
        type : Number,
        required : false
      },
      as_owner :{
        type : Boolean,
        required : false
      }
    },
  data () {
    return {
       status : 'Join Group',
       open : false,
       join : false,
       close : false,
       accept : false,
       wait : false,
       loading_status : false,
       group_object : null,
       isLoading : false,
       checkMem : false,
       join_request : null,
       group_requests : null,
       confirmed : false,
       accpet : true,
       disabled : false,
       declined : false,
    }
  },
  methods : {
      isChecked(state){
        const vm = this;
        if(state == 'public'){
           if(vm.join)
           {
             axios({
              url : LaravelOrgin + 'join_public_group',
              method : 'post',
              data : {user : parseInt(UserId) , group : vm.group_id},
              onDownloadProgress : (progressEvent)=>{
                  vm.isLoading = true;
                },  
             }).then((response)=>{
                   if(response.data == 'done'){
                    App.$emit('knocksPushNewGroup' , { id : vm.group_id });
                    this.$notify({
                  title: 'Success',
                  message: 'You Have Joined Group '+vm.group_object.name+' Successfully',
                  type: 'success'
                });
                    setTimeout(()=>{
                         window.location.href = LaravelOrgin + 'group/'+vm.group_id
                    },1200);
                   }else{
                    this.$notify.error({
                    title: 'Error',
                    message: 'This is an error message'
                  });
                   }
             });
             }
             else if(vm.open){
             window.location.href = LaravelOrgin + 'group/'+vm.group_id
             } 
          }
             if(state == 'closed'){
           if(vm.close)
           {
             axios({
              url : LaravelOrgin + 'send_group_request',
              method : 'post',
              data : {sender_id : parseInt(UserId) , reciver_id : vm.group_id},
              onDownloadProgress : (progressEvent)=>{
                  vm.isLoading = true;
                },  
             }).then((response)=>{
                   if(response.data == 'done'){
                    vm.wait = true;
                    vm.close = false;
                    this.$notify({
                  title: 'Success',
                  message: 'Your Request has been sent to join Group '+vm.group_object.name+' Successfully',
                  type: 'success'
                });
                   }else{
                    this.$notify.error({
                    title: 'Error',
                    message: 'This is an error message'
                  });
                   }
             });
             }
             else if(vm.open){
             window.location.href = LaravelOrgin + 'group/'+vm.group_id
             } 
          }
          if(state == 'accpet'){
             axios({
              url : LaravelOrgin + 'join_public_group',
              method : 'post',
              data : {user : vm.user_id , group : vm.group_id, state : 'request'},
              onDownloadProgress : (progressEvent)=>{
                  vm.isLoading = true;
                },  
             }).then((response)=>{
                   if(response.data == 'done'){
                    App.$emit('knocksPushNewGroup' , { id : vm.group_id });
                    this.$notify({
                  title: 'Success',
                  message: 'You Have Accpeted The Member Request to Group '+vm.group_object.name+' Successfully',
                  type: 'success'
                });
                    vm.isLoading = false;
                    vm.confirmed = true;
                    vm.accpet = false;
                    vm.disabled = true;
                   }else{
                    this.$notify.error({
                    title: 'Error',
                    message: 'This is an error message'
                  });
                   }
             });
             
          }
          if(state == 'decline'){
                 axios({
                   url : LaravelOrgin + '/decline_request_group',
                   method : 'post',
                   data : {user : vm.user_id, group : vm.group_id},
                   onDownloadProgress : (progressEvent)=>{
                  vm.isLoading = true;
                },  
                 }).then((response)=>{
                     vm.isLoading = false;
                    vm.declined = true;
                    vm.accpet = false;
                    vm.disabled = true;
                 });
          }
      },
      getGroup(){
        const vm = this 
        axios({
          url : LaravelOrgin + 'get_group_for_join',
          method : 'post',
          data : {group : vm.group_id}
        }).then((response)=>{
              vm.group_object = response.data;
        });
      },
     checkMemberInGroups(){
      const vm = this;
      axios({
           url : LaravelOrgin + 'check_user_ingroup',
           method : 'post',
           data : {group : vm.group_id , user : vm.user_id}
      }).then((response)=>{
            if(response.data == 'in'){
               vm.checkMem = true;
               vm.open = true;
               vm.close = false;
               vm.join = false;
               vm.wait = false;
            }
            else
            {
              vm.checkMem = false;
              if(vm.group_object.preset == 'closed'){
                   vm.close = true;
                   vm.join = false;
                   vm.wait = false;
               }else{
                vm.join = true;
                vm.close = false;
                vm.wait = false;
               }
            }
        });
     },
     requestMember(){
      const vm = this
      setTimeout(()=>{
        let i;
        for(i =0; i < vm.join_request.length; i++)
        {
          if(vm.join_request.response != null){
          if(vm.join_request.response[i].sender_id == vm.user_id && vm.join_request.response[i].reciver_id == vm.group_id && vm.join_request.response[i].response == 'waiting')
        
        {
          vm.wait = true;
          vm.open = false;
          vm.close = false;
          vm.join = false;
          vm.isLoading = true;
        }else{
          vm.open = true;
          vm.wait = false;
        }
        }
      }
      },100);
      
     },
     addMemberToGroup(state){
          const vm = this;
        if(state == 'public'){
             axios({
              url : LaravelOrgin + 'add_member_public_group',
              method : 'post',
              data : {user : vm.user_id , group : vm.group_id},
              onDownloadProgress : (progressEvent)=>{
                  vm.isLoading = true;
                },  
             }).then((response)=>{
                   if(response.data == 'done'){
                    App.$emit('knocksPushNewGroup' , { id : vm.group_id });
                    this.$notify({
                  title: 'Success',
                  message: 'New Member Have Add to Group '+vm.group_object.name+' Successfully',
                  type: 'success'
                });
                    vm.$emit('member_added', (vm.user_id))
                   }else{
                    this.$notify.error({
                    title: 'Error',
                    message: 'This is an error message'
                  });
                   }
             });
          }
           if(state == 'closed'){
             axios({
              url : LaravelOrgin + 'add_member_public_group',
              method : 'post',
              data : {user : vm.user_id , group : vm.group_id},
              onDownloadProgress : (progressEvent)=>{
                  vm.isLoading = true;
                },  
             }).then((response)=>{
                   if(response.data == 'done'){
                    App.$emit('knocksPushNewGroup' , { id : vm.group_id });
                    this.$notify({
                  title: 'Success',
                  message: 'New Member Have Add to Group '+vm.group_object.name+' Successfully',
                  type: 'success'
                });
                    vm.$emit('member_added', (vm.user_id))
                   }else{
                    this.$notify.error({
                    title: 'Error',
                    message: 'This is an error message'
                  });
                   }
             });
          }

     },
  },
  mounted(){
        this.getGroup()
        setTimeout(()=>{
          this.checkMemberInGroups() 
        },1000);
        
  },
}
</script>

<style lang="css" scoped>
</style>