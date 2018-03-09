<template>
    <div>
    	<el-checkbox-button :checked="check" @change="isChecked()" v-loading="loading_status">
                       {{status}}
    		<i v-if="!check" class="knocks-login"></i>
            <i v-if="check" class="knocks-log-out"></i>
            
    	</el-checkbox-button>


    	
    </div>
</template>

<script>
export default {

  name: 'knocksgroupjoining',

  data () {
    return {
       status : 'Join Group',
       check : false,
       loading_status : false
    }
  },
  methods : {
  	  isChecked(){
  	  	const vm = this;
  	  	if(vm.check == false)
  	  	{
  	  		vm.status = 'Exit Group'
  	  		vm.check = true;
  	  	}
        
    else{
    	vm.status = 'Join Group'
    	vm.check = false;
    }
    	
  	  }
  }
}
</script>

<style lang="css" scoped>
</style>