<template>
	<div :class="container_classes" v-if = "show_container">
		<knocksloader  size = "small" v-if = "isLoading"></knocksloader>
		<img  :src = "source" v-if = "source != null" :class = "classes"/>
	</div>
</template>

<script>
export default {

  name: 'knockspreview',
  props : {
  	fill_from : {
  		type : String , 
  		required : true 
  	} , 
  	specifications : {
  		type : Object ,
  		default : null,
  	},
  	classes : {
  		type : String , 
  		default : 'knocks_image_element'	
  	},
  	container_classes : {
  		type : String , 
  		default : 'knocks_image_preview'
  	},
    show_container : {
      type : Boolean ,
      default : true 
    },
    is_static : {
      type : Boolean , 
      default : false
    } , 
    static_source : {
      type : String , 
      default : '' 
    },
    return_on_null : {
      type : String , 
      default : null
    },
    scope : {
      type : Array , 
      default : null
    },
    xhr_method : {
      type : String , 
      default : 'post'
    }
  },

  data () {
    return {
    	source : null ,
    	isLoading : false ,
    }
  }, 
  mounted(){
  	this.loadImage();
    const vm = this; 
        App.$on('new_picture_uploaded' , (payloads)=>{
      console.log('payloads'); console.log(payloads);
      if(vm.scope != null && payloads.scope != null){
        let sc ; 
        for(sc in payloads.scope){
          if(vm.scope.indexOf(payloads.scope[sc]) != -1){
            vm.source = payloads.blob;
            window.ImgBlobs[JSON.stringify(vm.specifications)] = payloads.blob;
            return;
          }
        }

      }
    });
  },
  methods : {
  	loadImage(){
      if(this.static_source){
        this.source = this.static_source;
        this.$emit('input' , this.static_source);
        return ;
      }
       if(window.ExsistsInImgBlobs(this.specifications)){
        if(window.ImgBlobs[JSON.stringify(this.specifications)] == null){

          this.source = this.return_on_null;
          return ;
        }
        this.source = window.ImgBlobs[JSON.stringify(this.specifications)];
        //console.log(window.ExsistsInImgBlobs(this.specifications));
        this.$emit('input' , this.static_source);
        return;
      }
  		const vm = this;
  		axios({
  			method : vm.xhr_method  , 
  			url : NodeOrgin+vm.fill_from ,
  			data : vm.specifications ,
  			onDownloadProgress:()=>{
  				vm.isLoading = true ; 
  			}

  		}).then((response)=>{
        //console.log(response.data);
        if(response.data == 'null' || response.data == null){


        vm.isLoading = false ; 
        vm.source = vm.return_on_null;
        window.ImgBlobs[JSON.stringify(vm.specifications)] = vm.return_on_null;
        vm.$emit('input' , vm.source);
        return;
        }
  			vm.isLoading = false ; 
  			vm.source = response.data;
        window.ImgBlobs[JSON.stringify(vm.specifications)] = response.data;
        vm.$emit('input' , vm.source);
  		}).catch(()=>{
        vm.isLoading = false;
      });
  	}
  }
}
</script>

<style lang="css" scoped>
</style>