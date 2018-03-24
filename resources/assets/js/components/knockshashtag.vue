<template>
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
		return this.collectHashTags(this.body);
  	}
  },
  methods : {
  	collectHashTags(body){
  		let m , res = [];
		do {
		    m = this.regex.exec(body);
		    if(m) {
		        res.push(m[1]);
		    }
		} while (m);
  		this.$emit('input' , res);
  		return res;
  	}
  }
}
</script>

<style lang="css" scoped>
</style>