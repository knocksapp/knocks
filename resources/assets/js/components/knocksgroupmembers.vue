<template>
	<div class="row">
		<knocksretriver
		v-model=  "group_members"
		url = "get_group_members"
		:xdata="{group_id : group_object.id}"
		@success = "isOwner()"
	     >
		</knocksretriver>
			 <el-tabs type="border-card">
				  <el-tab-pane>
				    <span slot="label"><i class="knocks-info2"></i> Group Info</span>
				    <ul class="knocks_text_dark">
				    	<li class="knocks_fair_bounds"> <i class="knocks-group2"></i> Group Name : {{group_object.name}}</li>
				    	<li class="knocks_fair_bounds"> <i class="knocks-th-large"></i> Group Category : {{group_object.category}}</li>
				    	<li class="knocks_fair_bounds"> <i class="knocks-locked2"></i> Privacy : {{group_object.preset}}</li> 
				    	<li class="knocks_fair_bounds"> <i class="knocks-calendar2"></i> Created At : {{group_object.created_at}}</li>
               <knocksgroupshortcut as_result :group_id = "40"></knocksgroupshortcut>
               <knocksgroupshortcut as_result :group_id = "39"></knocksgroupshortcut>
               <knocksgroupshortcut as_result :group_id = "38"></knocksgroupshortcut>
               <knocksgroupshortcut as_result :group_id = "37"></knocksgroupshortcut>
				    </ul>
					  </el-tab-pane>

					  <el-tab-pane>
				    <span slot="label"><i class="knocks-group2"></i> Members</span>
				    <el-input placeholder="Find people" class="knocks_fair_bounds"></el-input>
				    <div class="row" v-if="group_members != null">
				    	<ul class="uk-list uk-list-divider">
				    	<li  v-for="(mem,index) in group_members.response" class="knocks_fair_bounds">
				    	<knocksuser  :show_accept_shortcut="false" class="col s10 animated bounceIn" :user="mem.user_id" v-model="members_names[index]" :as_result="true">
                    <span slot="append_to_display_name" class=""><el-badge v-if="mem.position == 'Owner'" value="Owner" class="item"></el-badge><el-tag size="mini" v-if="mem.position == 'Member'" type="info">Member</el-tag></span>

                         </knocksuser>
                         <span class="right"><knocksgroupmemberdelete @member_deleted="group_members.response.splice(index,1)" :group_id="26" :gid="index" :member_delete = "mem.user_id"></knocksgroupmemberdelete></span>
				      </li>
				  </ul>
				    </div>
					  </el-tab-pane>
					 <el-tab-pane v-if="flag">
					 	<span slot="label"><i class="knocks-plus2"></i> Add Members</span>
					 	<knockselinput v-model = "test" placeholder="search" autocomplete :autocomplete_start="2" autocomplete_from = "user/search" @autocomplete="user = $event" ></knockselinput>
					 	<ul class="uk-list uk-list-divider">
				    	<li >
				    	<knocksuser  main_container="col s12 knocks_house_keeper" v-for="(u ,index) in user" class="animated bounceIn" :user="user[index]" v-if="!inGroup(u)" :key = "u">
				    		<a slot="append_to_display_name" class="right"><el-button type="primary" ><i class="knocks-plus2"></i></el-button></a>
                         </knocksuser>

                         
                        
           
				      </li>
				  </ul>
					 </el-tab-pane>
					  	
					  	
					  
			</el-tabs>
	</div>
</template>

<script>
export default {

  name: 'knocksgroupmembers',

  data () {
    return {
     group_members : null,
     flag : false,
     memberInGroup : false,
     members_names : [],
     user : [],
     test : '' ,
     search : '',
    }
  },
  props:{
     group_object :{
     	type : Object,
        required : true
     } 
  },
  methods:{
       isOwner(){
       	const vm = this
       	let i;
       	 for (i = 0; i < vm.group_members.response.length; i++){
       	 	 if( parseInt(UserId) == vm.group_members.response[i].user_id && 
       	 	 	vm.group_members.response[i].position == 'Owner'){
                 return vm.flag = true;
           }else{
           	return vm.flag = false
           }
       	 }
        
       },
        inGroup(id){
              const vm = this
              let i;
              for(i = 0; i < vm.group_members.response.length; i++){
              	if(id == vm.group_members.response[i].user_id){
              		return true;
              	}                    
              }
              return false ;
        },
       emitChanged(){
       	App.$emit('KnocksContentChanged');
       }

  },
  mounted(){

  },
  computed : {
 
  },
}
</script>

<style lang="css" scoped>
</style>