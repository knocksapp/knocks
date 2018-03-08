<template>
	<img @load = "isLoading = false" v-loading = "isLoading" :class = "classes" :id = "gid" :src = "source" :alt = "alt" @error = "source = error_src"/>
</template>

<script>
export default {

  name: 'knocksimg',
  props : {
  	classes : {
  		type : [ Array , String , Object],
  		default : null ,
  	},
  	gid   : {
  		type : String ,
  		default : null ,
  	},
  	src : {
  		type : String ,
  		default : null ,
  	},
    error_src : {
      type : String , 
      default : LaravelOrgin + 'snaps/avatar.jpg'
    } , 
    alt : {
      type : String ,
      default : null ,
    },
  },
  data () {
    return {
    	isLoading : true ,
      source : this.src , 
    }
  },
  mounted(){
  },
}
</script>

<style lang="css" scoped>
</style>