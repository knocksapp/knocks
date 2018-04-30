<template>
<div>
  <knocksretriver
  v-model=  "groups_id"
  url = "get_user_groups"
  @success="getGroupsName()"
  :xdata = "{ q : search }"
  :scope = "['group_filter']"
  >
  </knocksretriver>
  <static_message msg = "search for groups .." v-model = "searchPlaceHolder" class = "knocks_hidden"></static_message>
  
  <div class="row">
    <div class="row knocks_fair_bounds">
      <div class="ui icon input fluid">
        <input type="text" :placeholder="searchPlaceHolder" @input = "searchForGroups()" v-model = "search">
        <i class="search icon"></i>
      </div>
    </div>
    <div class = "row">
      <knocksshowkeys show_scope = "group" :show_input = "groupsIds"></knocksshowkeys>
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
    groupsObjects : [] ,
    groupsIds : [] , 
    lastResultQuery : null ,
    searchPlaceHolder :  '' , 
    }
  },
  mounted(){
  	 const vm = this;
     App.$on('knocksPushNewGroup' , (payloads)=>{
     	vm.groupsIds.push(payloads.id);
     })
  },
  methods:{
  	searchForGroups(){
  
  		App.$emit('knocksRetriver' , {scope : ['group_filter']})
  	},
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
       /*	const vm = this
       	axios({
             url : LaravelOrgin+'get_group_name',
             method : 'post',
             data : {groups : vm.groups_id.response}
       	}).then((response)=>{
                  vm.groups_name = response.data;
       	});*/
       	this.groupsIds = this.groups_id.response; 
       	if(this.groupsIds.length > 0) this.lastResultQuery = this.search;
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