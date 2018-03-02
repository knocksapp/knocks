<template>
	<div>
		<knocksretriver
		v-model=  "groups_id"
		url = "get_user_groups"
		@success="getGroupsName()"
	     >
		</knocksretriver>
		
   
		<div class="row">
      <div class="row">
              <el-input
      v-if = "groups_name != null && groups_name.length > 0"
      placeholder = "Search for groups .."
      gid = "search"
      class="col s12"
          
      v-model = "search"
      >
          <template slot="prepend"> <span class="knocks-search2"></span> </template>
      </el-input>
      </div>
      <div class = "row">
          <ul class= "uk-list uk-list-divider">
        <li v-for="(item,index) in filteredItems" class="knocks_text_dark knocks_house_keeper">
          <a class="knocks_text_dark" :href= "asset('group/'+getId(item.name))">
            <img class = "circle" :src = "asset('media/group/picture/compressed/'+getId(item.name))" style="width : 30px">
            <span>{{item.name}}</span>
          </a>
          </li>
      </ul>
      </div>

		</div>
	</div>
</template>

<script>
export default {

  name: 'knocksgroupslist',

  data () {
    return {
    groups_id : [],
    groups_name : [],
    search : '',
    thisId : '',
    }
  },
  mounted(){
     
  },
  methods:{
    asset(url){
      return LaravelOrgin+url
    },
    getId(name){
      let i ;
      for(i = 0 ; i < this.groups_name.length; i++){
        if(name == this.groups_name[i].name) return this.groups_name[i].group_id;
      }
      return false
    },
       getGroupsName(){
       	const vm = this
       	axios({
             url : LaravelOrgin+'get_group_name',
             method : 'post',
             data : {groups : vm.groups_id.response}
       	}).then((response)=>{
                  vm.groups_name = response.data;
       	});
       },
       // returnView(id){
       // 	axios({
       // 		url : 'group/'+id,
       // 		method : 'get',
       // 		data : {groups_id : id}
       // 	}).then({
             
       // 	});
       // }
  },
  computed: {
 filteredItems() {
      return this.groups_name.filter(item => {
         return item.name.toLowerCase().indexOf(this.search.toLowerCase()) > -1
      })
    
    }
  }
}
</script>

<style lang="css" scoped>
</style>