<template>
	<div class="row">
		<knocksretriver
		v-model=  "group_members"
		url = "get_group_members"
		:xdata="{group_id : group_object.id}"
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
				    </ul>
					  </el-tab-pane>

					  <el-tab-pane>
				    <span slot="label"><i class="el-icon-date"></i> Members</span>
				    <el-input placeholder="Find people" class="knocks_fair_bounds"></el-input>
				    <div class="row" v-if="group_members != null">
				    	<ul class="uk-list uk-list-divider">
				    	<li  v-for="mem in group_members.response">
				    	<knocksuser class="animated bounceIn" :user="mem.user_id" :as_result="true">
                         </knocksuser>
				      </li>
				  </ul>
				    </div>
					  </el-tab-pane>
					 
					  	
					  	
					  
			</el-tabs>
	</div>
</template>

<script>
export default {

  name: 'knocksgroupmembers',

  data () {
    return {
     group_members : null
    }
  },
  props:{
     group_object :{
     	type : Object,
        required : true
     } 
  },
  methods:{
       
  },
  mounted(){

  },
}
</script>

<style lang="css" scoped>
</style>