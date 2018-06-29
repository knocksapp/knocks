<template>
	<div>
		  <knocksretriver
  url = "get/mykids/logs"
  v-model="myKidsLogs"
  :xdata="{kid_id : kid_id}"
  @success = "getKidLogs()"
  >
  </knocksretriver>

    	<div v-for="(log,index) in kidLogs">
    		<knockscandysessionlog :log_id="log" :kid_id = "kid_id"></knockscandysessionlog>
    		 
            </div>
    	</div>
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
       myKidsLogs : null,
       kidLogs : null
    }
  },
  methods : {
  	  getKidLogs(){
  	  	  const vm = this
  	  	  vm.kidLogs = vm.myKidsLogs.response;
  	  }
  }
}
</script>

<style lang="css" scoped>
</style>