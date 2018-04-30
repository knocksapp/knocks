<template>
<input v-model = "myInput" type = "text" placeholder = "test" @input = "local($event)"/>
</template>

<script>
export default {

  name: 'knocksrecordermpeg',

  data () {
    return {
    	myInput : '' ,
    }
  } , 
  methods : {
  	local(e){
  		App.$emit('val' , this.myInput);
  	}
  }
}
</script>

<style lang="css" scoped>
</style>