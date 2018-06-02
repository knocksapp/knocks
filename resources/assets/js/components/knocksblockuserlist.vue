<template lang="html">
  <div>
    <div>
    <knocksretriver
    v-model=  "user_id"
    url = "user/search/global"
    @success="getUsersName()"
    :xdata = "{ q : search }"
    :scope = "['user_filter']"
    prevent_on_mount
    >
    </knocksretriver>
    <static_message msg = "search for users .." v-model = "searchPlaceHolder" class = "knocks_hidden"></static_message>

    <div class="row">
      <div class="row knocks_fair_bounds">
        <div class="ui icon input fluid">
          <input type="text" :placeholder="searchPlaceHolder" @input = "searchForUsers()" v-model = "search">
          <i class="search icon"></i>
        </div>
      </div>

        <knocksshowkeys show_scope = "block" :show_input = "userIds" as_result blocker :as_label = "false"></knocksshowkeys>

    </div>
  </div>

</div>
</template>

<script>
export default {
  name: 'knocksblockuserlist',

  data () {
    return {
    user_id : [],
    search : '',
    thisId : '',
    userIds : [] ,
    lastResultQuery : null ,
    searchPlaceHolder :  '' ,
    }
  },
  mounted(){
    const vm = this

  },
  methods:{
    searchForUsers(){

      this.user_id.retrive()
    },
    asset(url){
      return LaravelOrgin+url
    },
    getUsersName(){
      this.userIds = []

      setTimeout(()=>{
        this.userIds = this.user_id.response;
     if(this.userIds.length > 0) this.lastResultQuery = this.search;
     App.$emit('KnocksContentChanged')
      },200)
     
    },


},

}
</script>

<style lang="css">
</style>
