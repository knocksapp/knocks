<template>

	<div>


			<knocksretriver
		url = "remove_member"
		:xdata = "{group_id : group_id , mem_id : member_delete}"
		prevent_on_mount
		:scope = "['remove_member'+gid]"
		@success = "emit($event)"
	     >
		</knocksretriver>
		<div v-if = "!flag_member.response">
     <el-popover
  ref="popover5"
  placement="top"
  width="160"
  v-model="visible2">
  <p>Are you sure to remove this user?</p>
  <div style="text-align: right; margin: 0">
    <el-button size="mini" type="text" @click="visible2 = false">cancel</el-button>
    <el-button type="danger" size="mini"  @click="removeMember()">confirm</el-button>
  </div>
</el-popover>

	<el-button v-popover:popover5 v-if="flag_member.response && flag" type="danger"><i class="knocks-close"></i> Kick</el-button>
  <el-button v-popover:popover5 v-if="canKick()" type="danger"><i class="knocks-close"></i> Kick</el-button>
  <el-button v-popover:popover5 v-if="member_delete == auth"  type="danger"><i class="knocks-close"></i> Leave</el-button>
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
      required : true,
     },
     authposition : {
      type : String , 
      required : true
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
    }
  },
  methods:{
       removeMember(){
       	const vm = this
       	    vm.visible2 = false;
       	    App.$emit('knocksRetriver' , { scope : ['remove_member'+vm.gid]});
       },
       emit(e){
       	   if(e.response == 'done'){
             this.$emit('member_deleted');
             setTimeout( ()=>{App.$emit('KnocksContentChanged');} , 300)
           }
       	 
       	else alert('error')
       },
     canKick(){
      if(this.authposition == 'Owner' && this.member_delete != parseInt(UserId) && this.position != 'Owner') return true;
      if(this.authposition == 'Admin' && this.member_delete != parseInt(UserId) && this.position != 'Owner') return true;
      return false ;
     }

  },

}
</script>

<style lang="css" scoped>
</style>