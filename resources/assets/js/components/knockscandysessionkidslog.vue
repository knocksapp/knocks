<template>
<div>
  <knockscollapse toggler = "custom"  @control = "collapse = $event">
    <div slot = "toggler" class = "row">
      <knocksuser main_container="col s10" :user="kid_id"></knocksuser>
      <span class = "col white-text right blue knocks_standard_border_radius knocks_fair_bounds" v-if = "kidLogs">{{kidLogs.length}}</span> 
    </div>
  <div slot = "content"  v-loading = "myKidsLogs.loading" element-loading-spinner="knocks-speech-bubble-2 knocks_text_lg ">
    <knocksretriver
    url = "get/mykids/logs"
    v-model="myKidsLogs"
    :xdata="{kid_id : kid_id}"
    @success = "getKidLogs()"
    >
    </knocksretriver>
    <knocksshowkeys 
      list_classes = "row knocks_house_keeper"
      list_item_class = "knocks_house_keeper"
     :show_input = "kidLogs" show_scope=  "candylog" v-if = "kidLogs"></knocksshowkeys>
  </div>
  </knockscollapse>
</div>
</template>

<script>
export default {

  name: 'knockscandysessionkidslog',
  props:{
     kid_id : {
     	type : Number,
     	required : true
     }
	},
  data () {
    return {
       myKidsLogs : { loading : false },
       kidLogs : null , 
       collapse : null ,
    }
  },
  methods : {
  	  getKidLogs(){
  	  	  const vm = this
  	  	  // vm.kidLogs = vm.myKidsLogs.response;
          let arr = []; 
          let i 
          for (i = 0 ; i < vm.myKidsLogs.response.length; i++){
            arr.push({ log_id : vm.myKidsLogs.response[i] , kid_id : vm.kid_id})
          }
          vm.kidLogs = arr

  	  }
  }
}
</script>

<style lang="css" scoped>
</style>