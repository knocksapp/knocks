<template>

	<div>
		<knocksretriver
		v-model=  "flag_member"
		url = "check_member_position"
		:xdata = "{group_id : group_id , mem_id : member_delete}"
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

	<el-button v-popover:popover5  type="danger"><i class="knocks-close"></i></el-button>
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
     }
  },
  data () {
    return {
       visible2 : false,
       flag_member : false,
    }
  },
  methods:{
       removeMember(){
       	const vm = this
       	    vm.visible2 = false;
       	    App.$emit('knocksRetriver' , { scope : ['remove_member'+vm.gid]});
       },
       emit(e){
       	   if(e.response != 'invalid')
       	  this.$emit('member_deleted');
       	else alert('error')
       }
  },

}
</script>

<style lang="css" scoped>
</style>