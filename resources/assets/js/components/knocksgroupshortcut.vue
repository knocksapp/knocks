<template>
      
		

      <div v-if="group_object != null && group_name != null">
      	
			      <a v-if="as_chip" :href = "asset('group/'+group_id)">	<div class="chip" >
						    <knocksimg :src = "asset('media/group/picture/compressed/'+group_id)"></knocksimg>
						    {{group_name}}
			        </div></a>

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

							    <h3 v-if="members_count.members_count != null" class="knocks_text_dark">Members : <span class="green-text">{{members_count.members_count}}</span></h3>
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

              <div v-if = "as_result">
      <div class = "row">
        <div class="col l1 s3">
        <knocksimg classes="knocks_group_avatar_classes"  :src = "asset('media/group/picture/compressed/'+group_id)"></knocksimg>
      </div>
        <div class = "">
          <div  class="">
            <div class = "col s9">
              <a class = "knocks_text_anchor  knocks_text_bold knocks_tinny_side_padding" :href = "asset('group/'+group_id)"> {{ group_object.name }}</a><slot name = "append_to_display_name"></slot><br/>
              <span class = "knocks_text_xs knocks_text_bold knocks_tinny_side_padding"style = "display:flex">
              <strong class="knocks_text_dark">Members : </strong> <i class="green-text"> {{' ' + members_count.members_count}}</i> </span>
              <span v-if = "group_object.preset == 'public'" class="knocks_text_xs knocks_text_bold knocks_tinny_side_padding grey-text"> Public group <i class="knocks-global"> </i></span>

              <span v-if = "group_object.preset == 'closed'" class="knocks_text_xs knocks_text_bold knocks_tinny_side_padding grey-text"> Closed group <i class="knocks-lock2"> </i></span>
            </div>
            <div class = "right">
                 <knocksgroupjoining as_result :group_id = "group_id"></knocksgroupjoining>
            </div>
          </div>
        </div>
      </div>
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
      as_result :{
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
       formatGroupData(object){

       	this.group_object = object;
       	window.UserGroups[this.group_id] = object;
       	this.$emit('input' , this.group_object);
       },
        getGroupsName(){
       	const vm = this
       	axios({
             url : LaravelOrgin+'get_groupname',
             method : 'post',
             data : {group : vm.group_id}
       	}).then((response)=>{
                  vm.group_name = response.data.name;
                  vm.group_object = response.data;
                  vm.group_object.index = JSON.parse(response.data.index);
                  vm.formatGroupData(vm.group_object);
                  vm.members_count = vm.group_object.index;

       	});
       },
       asset(url){
      return LaravelOrgin + url ;
    },
     checkUserInGroups(){
     	const vm = this;
     	axios({
           url : LaravelOrgin + 'check_user_ingroup',
           method : 'post',
           data : {group : vm.group_id , user : parseInt(UserId)}
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
                   	App.$emit('knocksPushNewGroup' , { id : vm.group_id });
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
     this.checkUserInGroups();
  },
}
</script>

<style lang="css" scoped>
.knocks_group_avatar_classes{
  border-radius: 15px !important;
}
</style>