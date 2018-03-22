<template>
	<div>
		<knocksretriver
		v-model=  "group_members"
		url = "get_group_members"
		:xdata="{group_id : group_object.id}"
	    >
	</knocksretriver>
	<knocksretriver
		v-model=  "group_requests"
		url = "get_group_user_request"
		:xdata="{group_id : group_object.id}"
		@success="requestCount()"
	  >
		</knocksretriver>
		  <div class="row knocks_fair_bounds" v-if="update_pic" style ="width : 30%;">
		  	<div class="">
          	 <knockscroppie
		    gid = "knocks_group_picture_uploader"
		    success_at = "done"
		    success_msg = "Updated Your group picture succecfully!"
		    :upload_data = "{ group_id : group_object.id }"
		    :error_at = "[]"
		    callback_event = "update"
		    :callback_payloads = "{}"
		    ref = "ss"
		    :special_submit = "true"
		    :scope = "['group_picture_handler']"
		    upload_at = "media/group/upload"
		    ></knockscroppie>
		</div>
		</div>
		<ul class="collapsible" >
      
    <li>
      <div class="collapsible-header"><i class="knocks-info grey-text"></i>Group Informations</div>

      <div class="collapsible-body">
 <el-button class="right knocks_fair_bounds" @click="showUploader()">Change Group Picture</el-button>
        <span>
        	
          <div class="row">
            <knockselinput
                class="col s7"
		        el_follower
		        :mat_follower=  "false"
				:start_as="group_object.name"
		        placeholder = "Group Name"
				is_required
		        gid = "q"
		        :max_len = "100"
		        v-model = "group_name"
		        :scope = "[ 'group_edit']"
            ></knockselinput>
              <knockselinput
                class="col s7"
		        el_follower
		        :mat_follower=  "false"
				:start_as="group_object.category"
		        placeholder = "Group Categroy"
				is_required
		        gid = "q"
		        :max_len = "100"
		        v-model = "group_category"
		        :scope = "[ 'group_edit']"
             ></knockselinput>

				<knockselbutton
				placeholder = "Submit changes"
				:error_at = "[{res : 'not_found' , msg : 'This data is invalid'}]"
				:scope = "[ 'career_edit']"
				validation_error = "You need to complete some fields"
				submit_at = "career/update"
				success_at = "done"
				success_msg = "Career is Updated Successfully"
				gid = "stage_one_net"
				:submit_data = " {} "
				button_classes = "right"
				>
				</knockselbutton>
          </div>
        </span>
      </div>
    </li>
    <li>
      <div class="collapsible-header"><i class="knocks-lock9 grey-text"></i>Group Privacy</div>
      <div class="collapsible-body">
      	<span>
        	
          <div class="row">
        <h4 style="margin-top: 25px" class="col s4 knocks_text_dark"><i class="knocks-lock7"></i> Group Privacy</h4>
        <div style="margin-top: 20px" class="col s8">
          <el-select v-model="radio4" placeholder="Select" clearable>
          <el-option
          label="Public"
          value="public">
          </el-option>
          <el-option
          label="Closed"
          value="closed">
          </el-option>
          <el-option
          label="Secret"
          value="secret">
          </el-option>
          </el-select>
        </div>
     
          </div>
        </span>
      </div>
    </li>
    <li>
      <div class="collapsible-header"><i class="knocks-group2 grey-text"></i>Group Members</div>
      <div class="collapsible-body">
      	<span>
           <div class="row" v-if="group_members != null && group_members.response != null">
				   <ul class="uk-list uk-list-divider">
				    	<li  v-for="(mem,index) in group_members.response" class="knocks_fair_bounds">
				    	<knocksuser
				        :show_accept_shortcut="false" 
				        class="col s10 animated fadeIn" 
				        :user="mem.user_id"  :as_result="true"
				        >
                        <span 
                        slot="append_to_display_name" 
                        class=""
                        ><el-badge 
                        v-if="mem.position == 'Owner'" 
                        value="Owner" 
                        class="item"
                        ></el-badge>
                        <el-tag 
                        size="mini" 
                        v-if="mem.position == 'Member'" 
                        type="info">Member
                        </el-tag>
                        </span>
                        </knocksuser>
                        <span class="right">
                        	<knocksgroupmemberdelete 
                        	@member_deleted="group_members.response.splice(index,1)" 
                        	:group_id="group_object.id" 
                        	:gid="index"
                            :member_delete = "mem.user_id"
                            ></knocksgroupmemberdelete>
                        </span>
      				     </li>
      			   </ul>
      		</div>
         </span>
       </div>
    </li>
    <li v-if="group_object.preset == 'closed' || group_object.preset == 'secret'">
      <div v-if="group_requests != null && group_requests.response != null" class="collapsible-header"><i class="knocks-mail4 grey-text"></i>Mange Users Requests </br> <el-badge :value="request_count" class="item"></el-badge></div>
      <div class="collapsible-body" v-if="group_requests != null && group_requests.response != null && group_object != null">
      	<span >
      		<div  v-for="(user,index) in group_requests.response" >
         <knocksuser v-if="user.response != 'accepted'" :user="user.sender_id" as_result></knocksuser>
         <knocksgroupjoining 
         v-if="user.response != 'accepted'" 
                     class="col s2 right" :group_id="group_object.id" as_owner :user_id="user.sender_id" @member_deleted="group_requests.response.splice(index,1)">
                     </knocksgroupjoining>
            </div>
      </span>
  </div>
    </li>
  </ul>
	</div>
</template>

<script>
export default {

  name: 'knocksgroupsettings',
  props:{
  	group_object:{
  		type : Object,
        required : true
  	}
  },
  data () {
    return {
      group_name : '',
      group_category : '',
      radio4 : '',
      group_members : null,
      group_requests : null,
      request_count : 0,
      update_pic : false
    }
  },
  methods : {
  	   showUploader(){
  	   	  const vm = this
  	   	  if(vm.update_pic)
  	   	  vm.update_pic = false;
  	   	else
  	   		vm.update_pic = true;

  	   },
  	   requestCount(){
  	   	    const vm = this
  	   	    let i;
  	   	    if(vm.group_requests.response != null){
  	   	    	for(i = 0; i < vm.group_requests.response.length; i++){
  	   	    		if(vm.group_requests.response[i].response == 'waiting')
  	   	    {
  	   	    	vm.request_count++;
  	   	    }
  	   	    	}
  	   	    
  	   	    }
  	   	    
  	   },
  	   emit(e){
       	   if(e.response == 'done'){
             this.$emit('member_deleted');
             setTimeout( ()=>{App.$emit('KnocksContentChanged');} , 300)
           }
       }
  },
  mounted(){
  	this.radio4 = this.group_object.preset;
  }
}
</script>

<style lang="css" scoped>
</style>