<template>
	<el-tooltip :content = "body">
		<span :class = "classes">{{result}}</span>
	</el-tooltip>
</template>
<script>
export default {
  name: 'knockstextlenhandler',
  props : {
  	body : {
  		type : String , 
  		default : ''
  	} , 
  	len : {
  		type : Number , 
  		default : 17
  	},
  	classes : {
  		type : [Array , Object , String] , 
  		default : ''
  	}
  },
  data () {
    return {
    }
  },
  computed : {
  	result(){
  		return this.body.length > this.len ? this.body.substr(0,this.len) + '...' : this.body
  	}
  }
}
</script>

<style lang="css" scoped>
</style>