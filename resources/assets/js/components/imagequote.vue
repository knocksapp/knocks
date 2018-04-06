<template>
  
   <span v-loading = "isLoading">
   	 <span v-if = "quote != null" :class = "classes" >{{quote}}</span>
   	 <a class = "animated rubberBand" v-if ="refreshOption" style ="z-index:999998 !important">
   	 	<static_message msg = "Refresh"></static_message>
   	 	<span class = "knocks-refresh8" @click = "retrive()"></span></a>
   </span>
  
</template>

<script>
export default {

  name: 'imagequote',
  props : {
  	object_id : {
  		type : Number , 
  		required : true 
  	},
  	blob_token : {
  		type: Number , 
  		required : true
  	},
  	classes : {
  		type : String , 
  		default : 'animated bounceIn'
  	},
  	gid : {
  		type : String , 
  		required : true
  	}
  },

  data () {
    return {
    	quote : null ,
    	isLoading : true ,
    	refreshOption : false ,
    }
  },
  mounted(){
  	this.retrive();
  },
  methods : {
  	retrive(){
  		const vm = this ;
  		axios({
  			url : LaravelOrgin + 'blob/qoute' , 
  			data : {  id : vm.blob_token } , 
  			onDownloadProgress : ()=>{ vm.isLoading = true; } ,
  			method : 'post'
  		}).then((response)=>{
  			vm.isLoading = false;
  			vm.refreshOption = false;
  			if(response.data !='invalid'){
  				vm.quote = response.data;
  			}
  		}).catch((err)=>{
  			vm.isLoading = false;
  			vm.refreshOption = true;
  		})
  	}
  }
}
</script>

<style lang="css" scoped>
</style>