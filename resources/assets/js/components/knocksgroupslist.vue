<template>
	<div>
		<knocksretriver
		v-model=  "groups_id"
		url = "get_user_groups"
		@success="getGroupsName()"
	     >
		</knocksretriver>
		
   
		<div class="row">
			<el-input
			placeholder = "Search for group"
			gid = "search"
			class="col s12"
			prefix-icon = "knocks-search10"
			v-model = "search"
			></el-input>

			<ol>
				<li v-for="(item,index) in filteredItems" class="knocks_text_dark">
					<a class="knocks_text_dark" @click="returnView(item.id)"><span class="knocks-group2 knocks_text_dark"></span>  {{item.name}}</a></li>
			</ol>

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
       returnView(id){
       	axios({
       		url : 'group/'+id,
       		method : 'get',
       		data : {groups_id : id}
       	}).then({
             
       	});
       }
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