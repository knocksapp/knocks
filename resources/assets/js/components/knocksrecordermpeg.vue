<template>
	<div>
		<audio id = "thisisatest"></audio>
	</div>
</template>

<script>
export default {

  name: 'knocksrecordermpeg',

  data () {
    return {

    }
  },mounted(){
  	
  var	mp3encoder = new lamejs.Mp3Encoder(2, 44100, 128);
var mp3Data = [];
}
}
</script>

<style lang="css" scoped>
</style>