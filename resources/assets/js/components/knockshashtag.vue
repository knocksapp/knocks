<template>
	<div :class = "[{'knocks_xs_padding' : result.length > 0}]">
		    
			<knockshashtagchip :hashtag = "res" v-for = "(res, index) in result" :key = "index" class = "animated fadeIn"></knockshashtagchip>
	</div>
</template>

<script>
export default {

  name: 'knockshashtag',
  props : {
  	body : {
  		type : String , 
  		default : ''
  	}
  },
  data () {
    return {
    	regex : /\B(\#[a-zA-Z_]+\b)(?!;)/g , 

    }
  },
  computed : {
  	result(){
		let m , res = [];
		do {
		    m = this.regex.exec(this.body);
		    if(m && res.indexOf(m[1]) == -1) {
		        res.push(m[1]);
		        
		    }
		} while (m);
  		this.$emit('input' , res);
  		return res;
  	}
  },
  methods : {

  }
}
</script>

<style lang="css" scoped>
</style>