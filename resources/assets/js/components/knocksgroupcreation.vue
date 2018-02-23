<template>
<div>
	<knocksretriver
	v-model=  "allcircles"
	url = "/get_all_circles"
	
	>
	</knocksretriver>
	
	<el-button type="primary" @click="outerVisible = true" class="btncreate knocks_fair_bounds knocks_color_kit" style="border-color : #691a40 !important"><i class="knocks-group2"></i> Create Group</el-button>
	<el-dialog
	:visible.sync="outerVisible"
	width="30%"
	center
	>
	
	<template slot="title" > <span class="knocks_text_dark" style="font-size : 30px;"><i class="knocks-group-outline"></i> Groups</span></template>
	<span>
		
		<div>
			<h6 class="knocks_text_dark"> Groups are great for getting things done and staying in touch with just the people you want. Share photos and videos, have conversations, make plans and more.</h6>
			<el-carousel  type="card" :autoplay="false" indicator-position	="none" height="100px">
			<el-carousel-item v-for="(circle,index) in allcircles.response" :key="index" style="background-color : rgb(245,245,245) !important; border-radius : 35px !important; border: 1px solid #e7e7e7">
			<h3 class="animated fadeIn center knocks_text_dark" ><a @click="pushMembers(allcircles.response[index].id,allcircles.response[index].circle_name)" class="knocks_text_dark"><i :class="'knocks-'+getThumbnails(index)"></i> {{allcircles.response[index].circle_name}}</a></h3>
			
			</el-carousel-item>
			</el-carousel>
			<br/>
			<knockselinput
			placeholder = "Group Name"
			gid = "groupname"
			icon = "knocks-group2"
			:is_required = "true"
			:scope = "['CreateGroup']"
			v-model = "group_name"
			></knockselinput>
			<knockselinput
			placeholder = "Group Category"
			gid = "groupname"
			icon = "knocks-grid8"
			:is_required = "true"
			:scope = "['CreateGroup']"
			v-model = "group_category"
			></knockselinput>
			<transition enter-active-class="animated fadeIn" leave-active-class="animated fadeOut" >
			<div class="row" v-if = "flag == true">
				<h3  class="animated bounceIn knocks_text_dark">Members of {{circle_name}} :</h3>
 
				<div v-for="(user,index) in circle_members">
					<knocksuser class="animated bounceIn col knocks_fair_bounds" :user="user" :as_chip="true">
					<a slot="append" @click="removeMember(index)"><i class="red-text knocks-close"></i></a>
					</knocksuser>
				</div>
             </div>
             
         </transition>
         
         <transition enter-active-class="animated fadeIn" leave-active-class="animated fadeOut" >
             <div class="row" v-if = "flag2 == true">
             	<hr>

				<h3  class="animated bounceIn knocks_text_dark">Other Members :</h3>
 
				<div v-for="(user,index) in retrivedFriends">
					<knocksuser class="animated bounceIn col knocks_fair_bounds" :user="user" :as_chip="true">
					<a slot="append" @click="removeMemberss(index)"><i class="red-text knocks-close"></i></a>
					</knocksuser>
				</div>

             </div>
         </transition>

             <transition  enter-active-class="animated fadeIn" leave-active-class="animated fadeOut">

             <div class="row" v-if = "flag1 == true">
             	<hr>
				<h3  class="animated bounceIn knocks_text_dark">Suggestions :</h3>
                
				<div v-for="(user,index) in search_members">
					<knocksuser class="animated bounceIn col knocks_fair_bounds" :user="user" :as_chip="true">
					<a slot="append" @click="addToMembers(index)"><i class="green-text knocks-plus5"></i></a>
					</knocksuser>
				</div>
			</div>
		</transition>

					    <knockselinput
						placeholder = "Search Name"
						gid = "search"
						@change = "searchFriends()"
						icon = "knocks-lens"
						:scope = "['CreateGroup']"
						v-model = "search"
						></knockselinput>

			<div class="col s12">
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
		</div>
	</span>
	
	<span slot="footer" class="dialog-footer">
		<knockselbutton
		placeholder="Create"
		class="knocks_color_kit knocks_fair_bounds"
		:error_at = []
		:precondition = "radio4.length > 0"
		:scope = "['CreateGroup']"
		validation_error = "You need to complete some fields"
		reset_on_success
		submit_at = "/create_group"
		success_msg = "You Created the group Succecfully."
		gid = "stage_one_net"
		@knocks_submit_accepted = "outerVisible = false"
		button_classes = "right"
		success_at="done"
		:submit_data = " {name : group_name , category : group_category, preset : radio4 , normal_members : retrivedFriends, circle_members : circle_members} "
		>
		</knockselbutton>
	</span>
	</el-dialog>
</div>
</template>

<script>
export default {

  name: 'knocksgroupcreation',

  data () {
    return {
          outerVisible: false,
          innerVisible: false,
          radio4: '',
          state2: '',
          group_name:'',
          people : '',
          allcircles: Object,
          circle_id : '',
          allusers : null,
          search : '',
          all_members : [],
          retrivedFriends : [],
          circle_name : '',
          search_members : [],
          circle_members : [],
          circle_thumbnail:null,
          group_category : '',
          flag : false,
          flag1 : false,
          flag2 : false,

    }
  },
  mounted(){
  	

 
  	
  },
  methods:{
  	getThumbnails(index){
     const vm = this;
     return JSON.parse(this.allcircles.response[index].thumbnail)[0].class;
  	},
  	pushMembers(circle_id,circle_name){

  		const vm = this;
  		vm.circle_members = [];
  		vm.circle_id = circle_id;
       axios({
       	   url : 'get_circle_members',
       	   method : 'post',
       	   data :{circle_id : vm.circle_id}
       }).then((response)=>{
            if(response.data != null)
            {
                 vm.circle_members = response.data;
                 let i = 0;
                 let j = 0;
                 let len = vm.retrivedFriends.length;
                 let len1 = vm.search.length;
                 console.log('here '+vm.search_members.length)
                 while(i < len)
                 {
                 	if(vm.circle_members.indexOf(vm.retrivedFriends[i]) != -1){
                 		vm.retrivedFriends.splice(i,1);
                 		App.$emit('KnocksContentChanged');
                 		i--;
 
                 	}
                 	len = vm.retrivedFriends.length;
                 	i++;
                 }
                 while(j < len1)
                 {
                  if(vm.circle_members.indexOf(vm.search_members[i]) != -1){
                    vm.search_members.splice(i,1);

                    App.$emit('KnocksContentChanged');
                    j--;
 
                  }
                  len1 = vm.search_members.length;
                  j++;
                 }

                 vm.circle_name = circle_name

				        if(vm.retrivedFriends == 0){
				        	vm.flag2= false
				        }
                if(vm.search_members == 0){
                  vm.flag1= false
                }
                 vm.flag = true;

            }
            
         
       });
  	},
  	removeMember(index){
        const vm = this;
        vm.circle_members.splice(index,1)
        App.$emit('KnocksContentChanged');
        if(vm.circle_members == 0){
        	vm.flag = false
        }
  	},
  	removeMembers(index){
        const vm = this;
        vm.search_members.splice(index,1)
        App.$emit('KnocksContentChanged');
        if(vm.search_members == 0){
        	vm.flag1= false
        }
  	},
  	removeMemberss(index){
        const vm = this;
        vm.retrivedFriends.splice(index,1)
        App.$emit('KnocksContentChanged');
        if(vm.retrivedFriends == 0){
        	vm.flag2= false
        }
  	},
  	addToMembers(index){
        const vm = this;
        vm.retrivedFriends.push(vm.search_members[index]);
        vm.search_members.splice(index,1);
        App.$emit('KnocksContentChanged');
        vm.flag2 = true;
        if(vm.retrivedFriends  == 0){
        	vm.flag2= false;
        	
        }
        if(vm.search_members  == 0){
        	vm.flag1= false;
        	
        }

  	},
  	 
      createFilter(queryString) {
        return (link) => {

          return (link.value.toLowerCase().indexOf(queryString.toLowerCase()) === 0);
        };
      },
      searchFriends(){
      	    const vm = this;

      	    if(this.search.length <= 2 ){
      	    	this.search_members = [];
      	    	vm.flag1 = false;
      	    	return;
      	    }

            axios({
            	method : 'post',
            	url : 'user/search',
            	data : {q : vm.search}
            }).then((response)=>{
            	console.log(response.data);
                 let i;
                 for(i = 0; i < response.data.length; i++){
                 	 
                 	 if(vm.search_members.includes(response.data[i]) || vm.circle_members.includes(response.data[i]) || vm.retrivedFriends.includes(response.data[i])){
                 	 	
                 	 }else{
                 	 	vm.search_members = []
                 	 	console.log(vm.search_members)
                 	 	vm.search_members.push(response.data[i]);
                 	 	vm.flag1 = true;
                 	 	App.$emit('KnocksContentChanged');
                      

                 	 }
                 }
                
              
            });
            
          
           
      },
      loadAll() {
          const vm = this;
         return vm.allusers; 
      },
      handleSelect(item) {
        console.log(item);
      }

  }
}
</script>

<style lang="css" scoped>
.btncreate:focus{
	background-color: transparent !important;
}
</style>