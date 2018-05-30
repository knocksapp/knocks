<template>
 <div class="progress " :class = "bg">
      <div class="indeterminate " :class = "prog"></div>
  </div>
</template>
<script>
export default {

  name: 'knocksloaderbar',
  props : {
  	bg : {
  		type : [Array , Object , String] , 
  		default : 'pink lighten-2'
  	},
  	prog : {
  		type : [Array , Object , String] , 
  		default : 'knocks_color_kit_active'
  	},
  },
  data () {
    return {

    };
  }
};
</script>

<style lang="css" scoped>
</style>