<template>
	<div>
		<knocksretriver
		v-model=  "group_members"
		url = "get_group_members_positions"
		:xdata="{group_id : group_id , user_id : user_id}"
	     >
		</knocksretriver>
                     <div v-if="group_members != null &&  group_members.response != null">
                     	<div v-if = "group_members.response[0].position == 'Member'">
		                  <knockselbutton
                          class="right"
                          placeholder = "Set As Admin"
                          :error_at = "[{res : 'not_found' , msg : 'This data is invalid'}]"
                          success_at = "done"
                          :disabled = "disabled"
                          :scope = "['Group_member_position']"
                          submit_at = "set_member_admin"
                          success_msg = "User position is Updated Successfully"
                          gid = "position_group_memberss"
                          @knocks_submit_accepted = "isDisabled()"
                          :submit_data = " {group_id : group_id , user_id : user_id} "
                          >
                          </knockselbutton>
                      </div>
                      <div v-if = "group_members.response[0].position == 'Admin'">
                      <knockselbutton
                          class="right"
                          placeholder = "Set As Member"
                          :error_at = "[{res : 'not_found' , msg : 'This data is invalid'}]"
                          success_at = "done"
                          :disabled = "disabled"
                          :scope = "['Group_member_position']"
                          submit_at = "set_admin_member"
                          success_msg = "User position is Updated Successfully"
                          gid = "position_group_memberss"
                          @knocks_submit_accepted = "isDisabled()"
                          :submit_data = " {group_id : group_id , user_id : user_id} "
                          >
                          </knockselbutton>
                      </div>
                    </div>
	</div>
</template>

<script>
export default {

  name: 'knocksgroupmemberposition',
  props : {
       user_id :{
         type : Number,
         required : true
       },
       group_id : {
         type : Number,
         required : true
       }
  },
  data () {
    return {
        group_members : null,
        disabled : false,
    }
  },
  methods : {
        isDisabled(){
        	 const vm = this;
        	 vm.disabled = true;

        }
  },
}
</script>

<style lang="css" scoped>
</style>