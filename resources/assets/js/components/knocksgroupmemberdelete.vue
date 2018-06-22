<template>

	<div>
      <knocksretriver
    v-model=  "group_members"
    url = "get_group_members"
    :xdata="{group_id : group_id}"
    prevent_on_mount
    :scope = "['group_members']"
    >
    </knocksretriver>
			<knocksretriver
		url = "remove_member"
		:xdata = "{group_id : group_id , mem_id : member_delete}"
		prevent_on_mount
		:scope = "['remove_member'+gid]"
		@success = "emit($event)"
	     >
		</knocksretriver>
    <knocksretriver
    url = "delete_group"
    :xdata = "{group_id : group_id }"
    prevent_on_mount
    :scope = "['delete_group']"
       >
    </knocksretriver>
		<div v-if = "!flag_member.response">
     <el-popover
  ref="popover5"
  placement="top"
  width="160"
  v-model="visible2">
  <p v-if="member_delete != auth">Are you sure to remove this user?</p>
  <p v-if="member_delete == auth">Are you sure that you want to leave this group</p>
  <div style="text-align: right; margin: 0">
    <el-button size="mini" type="text" @click="visible2 = false">cancel</el-button>
    <el-button type="danger" size="mini"  @click="removeMember()">yes</el-button>
  </div>
</el-popover>

<el-dialog
  :visible.sync="centerDialogVisible"
  width="95%"
  center>
  <span slot="title" class="red-text knocks_text_md"><i class="knocks-info"></i> Group Leave Warrning </span>
  <span class="knocks_text_ms">
    <div class="row">
      if you want to leave this group you should leave your 
    <strong class="red-text"> Ownership </strong>
    to one of your group 
    <strong class="blue-text">Members </strong>
    or 
    <strong class="green-text">Admins</strong>
     to lead the group after you <i class="knocks-badge3 amber-text"></i>
   </div>
     <div class="row knocks_fair_bounds" style="border: 1px solid grey; border-radius: 15px" v-if="group_members != null">
      <ul class="uk-list uk-list-divider">
    <li v-for="mem in group_members.response">
       <knocksgroupmemberposition :user_id = "mem.user_id" @OwnerAdded="disabled = false" :group_id="group_id" dialog></knocksgroupmemberposition>
      <knocksuser  :show_accept_shortcut="false" class="col s10 animated fadeIn" :user="mem.user_id" :as_result="true">
                    <span slot="append_to_name" class=""><span v-if="mem.position == 'Owner'" style="font-size : 10px !important" class="uk-badge red">Owner</span><span v-if="mem.position == 'Member'" style="font-size : 10px !important" class="uk-badge blue">Member</span> <span 
                  v-if="mem.position == 'Admin'" 
                  class="uk-badge green knocks_text_sm" 
                  style="font-size : 10px !important">
                   Admin
                  </span></span>
                         </knocksuser>
</li>
</ul>
          </div>
  </span>
  <span slot="footer" class="dialog-footer">
    <el-button @click="centerDialogVisible = false">Cancel</el-button>
    <el-button type="danger"  :disabled="disabled" @click="removeOwner()" :icon="btn_label">Leave this Group</el-button>
  </span>
</el-dialog>
<el-tooltip class="item" effect="light" content="Kick Member" placement="left">
	<el-button v-popover:popover5 circle :icon="kick" v-if="flag_member.response && flag" type="danger"></el-button>
</el-tooltip>
<el-tooltip class="item" effect="light" content="Kick Member" placement="left">
  <el-button v-popover:popover5 circle :icon="kick" v-if="canKick()" type="danger"></el-button>
</el-tooltip>
<el-tooltip class="item" effect="light" content="Leave this Group" placement="left">
  <el-button circle v-popover:popover5 v-if="member_delete == auth " :icon="leave" @click="loadMem()"  type="danger"></el-button>
</el-tooltip>
</div>

</div>
</template>

<script>
export default {

  name: 'knocksgroupmemberdelete',
  props:{
     group_id : {
     	type : Number,
     	required : true
     },
     member_delete : {
     	type : Number,
     	required : true
     },
     gid : {
     	type : Number,
     	required : true,
     },
     position : {
      type : String,
      required : false,
     },
     authposition : {
      type : String , 
      required : false
     }
  },
  data () {
    return {
       visible2 : false,
       flag_member : false,
       flag_admin : false,
       flag : false,
       flag3 : false,
       auth : parseInt(UserId) , 
       centerDialogVisible : false,
       group_members : null,
       disabled : true,
       check : [],
       btn_label : 'knocks-exit',
       kick : 'el-icon-close',
       leave : 'knocks-exit',
    }
  },
  methods:{
       removeMember(){
       	const vm = this
        if( vm.group_members.response != null){
          let i;
        for(i=0; i < vm.group_members.response.length; i++)
          if(vm.group_members.response[i].position == 'Owner'){
            vm.check.push(i);
          }
          if(vm.check.length > 1){
            vm.disabled = false;
          }
          if(vm.group_members.response.length < 2){
            vm.btn_label = 'Delete This Group';
             vm.disabled = false;
          }
         
        }
        if(vm.authposition == 'Owner')
        {
          if(vm.position == 'Owner'){
             vm.centerDialogVisible = true;
              vm.visible2 = false;

            }else{
              vm.visible2 = false;
            App.$emit('knocksRetriver' , { scope : ['remove_member'+vm.gid]});
           
            }        
        }
         if(vm.authposition == 'Member' || vm.authposition == 'Admin')
        {
            vm.visible2 = false;
            App.$emit('knocksRetriver' , { scope : ['remove_member'+vm.gid]});
             window.location.href = LaravelOrgin + 'group/'+vm.group_id;  
        }
       	   
       },
       removeOwner(){
           const vm = this
           if(vm.btn_label == 'Leave'){
            App.$emit('knocksRetriver' , { scope : ['remove_member'+vm.gid]});
            vm.centerDialogVisible = false;
          }else{
            App.$emit('knocksRetriver' , { scope : ['delete_group']});
            vm.centerDialogVisible = false;
             window.location.href = LaravelOrgin;  
          }
           
       },
       emit(e){
        const vm = this 
       	   if(e.response == 'done'){
             this.$emit('member_deleted');
             setTimeout( ()=>{App.$emit('KnocksContentChanged');} , 300)
                this.$notify({
                  title: 'Success',
                  message: 'You Have Kicked This Member From Group Successfully',
                  type: 'success'
                });

            
           }
       	 
       	else {
           this.$notify({
                  title: 'Connection Timeout',
                  message: 'Please , Check your Connection',
                  type: 'Error'
                });

        }
       },
     canKick(){
      if(this.authposition == 'Owner' && this.member_delete != parseInt(UserId) && this.position != 'Owner') return true;
      if(this.authposition == 'Admin' && this.member_delete != parseInt(UserId) && this.position != 'Owner') return true;
      return false ;
     },
     loadMem(){
     App.$emit('knocksRetriver',{scope : ['group_members']});

     }

  },

}
</script>

<style lang="css" scoped>
</style>