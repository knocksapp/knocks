<template>
	<span :class = "classes">{{result}}</span>
</template>

<script>
export default {

  name: 'knocksmeganumber',
  props : {
  	num : {
  		type : Number , 
  		required : true
  	},
  	classes : {
  		type : [Array , Object , String] , 
  		default : '' ,
  	}
  },
  data () {
    return {

    }
  },
  computed : {
  	result(){
  		let res = window.MigaNumber(this.num)
  		this.$emit('input' , res)
  		return res
  	}
  }
}
</script>

<style lang="css" scoped>
</style>