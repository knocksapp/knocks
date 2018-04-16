<template>
	<div class="row" v-if = "dev">
	<p style = "font-family : monospace !important">
		<p class = "red-text">is loading :  {{isLoading}}</p>
		<p class = "red-text">progress :  {{loadingPercentage}}</p>
		<p class = "red-text">has errors :  {{hasErrors}}</p>
		<!-- <p class = "red-text">status :  {{status}}</p> -->
		<p class = "red-text">response data :  {{response}}</p>
	</p>
</div>
</template>

<script>
export default {

  name: 'knocksretriver',
  props : {
  	xdata : {
  		type : Object , 
  		default : null , 
  	},
  	method : {
  		type : String , 
  		default : 'post'
  	},
  	url : {
  		type : String , 
  		required : true
  	},
  	free_origin : {
  		type : Boolean , 
  		default : false
  	},
  	timeout : {
  		type : Number , 
  		default : 15000
  	},
  	recursed : {
  		type : Boolean ,
  		default : false 
  	},
  	recursion_time : {
  		type : Number , 
  		default : 10000
  	},
  	recursion_precondition : {
  		type : Boolean , 
  		default : null ,
  	},
    precondition : {
      type : Boolean , 
      default : null ,
    },
  	behind_recursion : {
  		type : Boolean , 
  		default : false ,
  	},
  	dev : {
  		type : Boolean , 
  		default : false 
  	},
    scope : {
      type : Array , 
      default : null ,
    } , 
    prevent_on_mount : {
      type : Boolean , 
      default : false ,
    }
  },
  data () {
    return {
    	isLoading : false , 
    	loadingPercentage : null ,
    	response : null , 
    	errors : null , 
    	hasErrors : false ,
    	status : null ,
    	result : null ,
    	windowStatus : true ,
    	recursionStopped : false ,
    }
  },
  computed : {
  	finalUrl(){
  		return this.free_origin ? this.url : LaravelOrgin + this.url;
  	},
 
  },
  mounted(){
  	this.resultCollector();
  	if(!this.prevent_on_mount) this.retrive();
    this.watchMyWindow();
    const vm = this;
    App.$on('knocksRetriver' , (payloads)=>{
      if(vm.scope == null) return;
      let i, j;
      for (i = 0 ; i < payloads.scope.length; i++){
        for(j = 0; j < vm.scope.length; j++){
          if(payloads.scope[i] == vm.scope[j]){
            vm.retrive();
            return;
          }
        }
      }
    });
  },
  methods : {
  	retrive(){
      if(this.precondition != null && this.precondition == false) return;
  		const vm = this;
  		axios({
  			method : vm.method , 
  			url : vm.finalUrl , 
  			data : vm.xdata , 
  			onDownloadProgress : (progressEvent)=>{
  				vm.resultCollector();
  				vm.$emit('progress' , vm.result);
  				vm.isLoading = true;
  				vm.loadingPercentage = Math.floor((progressEvent.loaded * 100) / progressEvent.total);
  			},	
			timeout : vm.timeout ,
  		}).then((res)=>{
  			vm.isLoading = false ;
  			vm.response = res.data;
  		    vm.hasErrors = false ;
  			vm.errors = null;
  			vm.resultCollector();
  			vm.$emit('success' , vm.result);
  			if(vm.recursed && ( vm.recursion_precondition == null || vm.recursion_precondition == true ) ){
  				   setTimeout( ()=>{ 
  				   	if(vm.behind_recursion || (!vm.behind_recursion && vm.windowStatus) ){
  				   		//Recursion
  				   		vm.$emit('recursion' , vm.result);
  				    	vm.retrive(); 
  				    }else{
  				    	vm.$emit('stop' , vm.result);
  				    	vm.recursionStopped = true;
  				    	//Stop
  				    }
  				   } , vm.recursion_time);
  			}
  		}).catch((err)=>{
  			vm.isLoading = false ;
  			vm.hasErrors = true ;
  			vm.errors = err.response;
  			vm.resultCollector();
  			vm.$emit('catch' , vm.result);
        if(err.response.status == 401)
          App.$emit('logoutGlobal');
  		});
  	},
  	resultCollector(){
  		this.result = {
  			loading : this.isLoading , 
  			progress : this.loadingPercentage ,
  			response : this.response , 
  			status : this.status , 
  			hasErrors : this.hasErrors , 
  			errors : this.errors , 
  			monitor : {
  				data : this.xdata , 
  				url : this.finalUrl , 
  				timeout : this.timeout , 
  				recursion : this.recursed , 
  				recursion_time : this.recursion_time , 
  				recursion_precondition : this.recursion_precondition , 

  			}
  		}
  		this.$emit('input' , this.result); 
  	},
    watchMyWindow(){
        const vm = this;
        $(document).ready(function(){
        $(window).focus(function(){
          vm.windowStatus = true ;
            if(vm.behind_recursion || (!vm.behind_recursion && vm.windowStatus) ){
               vm.recursionStopped = false;
              if(vm.behind_recursion) vm.retrive(); 
          }
        });
        $(window).blur(function(){
            vm.windowStatus = false ;
        });
      });
    }
  }
}
</script>

<style lang="css" scoped>
</style>