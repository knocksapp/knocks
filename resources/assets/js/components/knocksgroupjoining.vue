<template>
    <div>
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
      }
    },
  data () {
    return {
       status : 'Join Group',
       open : false,
       join : false,
       close : false,
       loading_status : false,
       group_object : null,
       isLoading : false,
       checkMem : false,
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
       
     checkUserInGroups(){
      const vm = this;
      axios({
           url : LaravelOrgin + 'check_user_ingroup',
           method : 'post',
           data : {group : vm.group_id , user : parseInt(UserId)}
      }).then((response)=>{
            if(response.data == 'in'){
               vm.open = true;
               vm.join = false;
               vm.checkUser = true;
            }
            else
            {
              vm.join = true;
              vm.open = false;
              vm.checkUser = false;
            }
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
            }
            else
            {
              vm.checkMem = false;
            }
        });
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

     }
  },
  mounted(){
        this.getGroup()
        this.checkUserInGroups()
        this.checkMemberInGroups()     
  },
}
</script>

<style lang="css" scoped>
</style>