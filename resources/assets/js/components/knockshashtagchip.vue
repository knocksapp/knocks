<template>
	<span>
		<knocksretriver
		url = "hashtag/lazy"
		:xdata = "{ hashtag : hashtag }"
		v-model = "retriver"
		@success = "handle($event)"
		:scope = "['hashtag_input']"
		>	
		</knocksretriver>
		<a class="ui  image label" :class = "[
		{'blue' : model == null || model < 100} ,
		 {'yellow' : model != null && model < 500} ,
		 {'orange' : model != null && model < 600} , 
		 {'red' : model != null && model >= 600} , 
		 ]">
  
  {{hashtag}}
  <div v-if = "retriver != null" v-loading = "retriver.loading" class="detail">
  	<span v-if = "model != null">{{toMiga(model)}}</span>
  	<span  class  = "knocks-fire"></span>
  </div>
</a>
	</span>
</template>

<script>
export default {

  name: 'knockshashtagchip',
  props : {
  	hashtag : {
  		type : String , 
  		required : true ,
  	}
  },
  data () {
    return {
    	retriver : null , 
    	model : null ,
    }
  },
  methods : {
  	handle(e){
  		this.model = e.response ;
  		this.$emit('input' , this.model)
  	},
  	toMiga(num){
  		return window.MigaNumber(num);
  	}
  }
}
</script>

<style lang="css" scoped>
</style>