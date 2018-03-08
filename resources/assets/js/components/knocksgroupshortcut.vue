<template>
      
		

      <div>
      	
			      	<div class="chip" v-if="as_chip">
						    <knocksimg :src = "asset('media/group/picture/compressed/'+group_id)"></knocksimg>
						    {{group_name}}
			        </div>

			        <div v-if="as_dialog"> 
			        	<a @click="dialogVisible = true"><div class="chip">
						    <knocksimg :src = "asset('media/group/picture/compressed/'+group_id)"></knocksimg>
						    {{group_name}}
			        </div></a>
                        
							<el-dialog
							  :visible.sync="dialogVisible"
							  width="30%">
							   <template slot="title">
							   	<span  class="knocks_text_dark" style="font-size : 35px "><i class="knocks-group2"></i> {{group_name}}</span> 
							   </template>

							 <div class="row">
							 	<div class="col s6" style="padding-top : 50px" v-if="group_object != null"> 
							 		 <ul class="knocks_text_dark">
							    	<li class="knocks_fair_bounds"> <i class="knocks-group2"></i> Group Name : {{group_object.name}}</li>
							    	<li class="knocks_fair_bounds"> <i class="knocks-th-large"></i> Group Category : {{group_object.category}}</li>
							    	<li class="knocks_fair_bounds"> <i class="knocks-locked2"></i> Privacy : {{group_object.preset}}</li> 
							    	<li class="knocks_fair_bounds"> <i class="knocks-calendar2"></i> Created At : {{group_object.created_at}}</li>
							    </ul>

							    <h3 class="knocks_text_dark">Members : <span class="green-text">{{members_count.members_count}}</span></h3>
							 	</div>

							 	<div class="col s4 right"> 
                                      <knocksimg :src = "asset('media/group/picture/compressed/'+group_id)"></knocksimg>
                                         
							 	</div>
							 </div>


							  <span slot="footer" class="dialog-footer" v-if="group_object != null">
							    <el-button @click="dialogVisible = false">Cancel</el-button>
							    <el-button type="primary" @click="dialogVisible = false" v-if = "!checkUser && group_object.preset != 'public' && group_object.preset != 'closed'">  Ask for Join  <i class="knocks-lock2 gray-text" style="font-size : 15px"></i></el-button>

							    <el-button type="primary" @click="dialogVisible = false" v-if = "!checkUser && group_object.preset == 'closed'">Ask for Join  <i class="knocks-lock2 gray-text" style="font-size : 15px"></i></el-button>

							    <el-button type="primary" @click="dialogVisible = false,joinPublicGroup()" v-if = "!checkUser && group_object.preset == 'public'">Join</el-button>

							     <a :href= "asset('group/'+group_id)" v-if = "checkUser"><el-button type="primary" @click="dialogVisible = false">Open</el-button></a>


							  </span>
							</el-dialog>

			        </div>
      </div>


</template>

<script>
export default {

  name: 'knocksgroupshortcut',
  props:{

  	  group_id :{
  	  	type : Number,
  	  	required : true
  	  },
  	  as_chip :{
        type : Boolean,
        default : false,
  	  },
  	  as_dialog :{
        type : Boolean,
        default : false,
  	  },

  },
  data () {
    return {
       group_name : null,
       group_object : null,
       members_count : '',
         dialogVisible: false,
         checkUser: false,
    }
  },
  methods : {
       
        getGroupsName(){
       	const vm = this
       	axios({
             url : LaravelOrgin+'get_groupname',
             method : 'post',
             data : {group : vm.group_id}
       	}).then((response)=>{
                  vm.group_name = response.data.name;
                  vm.group_object = response.data;
                  vm.members_count = JSON.parse(response.data.index);
       	});
       },
       asset(url){
      return LaravelOrgin + url ;
    },
     checkUserInGroup(){
     	const vm = this;
     	axios({
           url : 'check_user_ingroup',
           method : 'post',
           data : {group : vm.group_id}
     	}).then((response)=>{
            if(response.data == true)
               vm.checkUser = true;
            else
            	vm.checkUser = false;

     	});
     },
     joinPublicGroup(){
             const vm = this;
             axios({
             	url : 'join_public_group',
             	method : 'post',
             	data : {user : UserId , group : vm.group_id}
             }).then((response)=>{
                   if(response.data == 'done'){
                   	this.$notify({
				          title: 'Success',
				          message: 'You Have Joined Group '+vm.group_name+' Successfully',
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

  },
  mounted(){
     this.getGroupsName();
     this.checkUserInGroup();
  },
}
</script>

<style lang="css" scoped>
</style>