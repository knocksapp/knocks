<template v-if = "!hidden" :class = "[{'knocks_hidden' : hidden}]">
  <span :class = "[openTag , classes ,{'animated fadeInUp': !isLoading}]" :id="gid" :style = "styles" v-if = "msg == null && !hidden" >
      <knocksloaderbar v-if = "isLoading"></knocksloaderbar :class = "{'animated fadeOutUp': !isLoading}">
      {{restructed}}
  </span>
    <span :class = "openTag +`  `+ classes" :id="gid" :style = "styles" v-else>
      <knocksloaderbar v-if = "isLoading"></knocksloaderbar>
      {{restructed}}
  </span> 
</template>
<script>
export default  {
  props : {
    msgid : Number  ,
    tag : {
      type : String ,
      default : ''
    },
    classes : {
      type : String ,
      default : ''
    } ,
    gid : {
      type : String ,
      default : ''
    } ,
    styles : {
      type : String ,
      default : ''
    } ,
    align : {
      type : Boolean ,
      default : true
    } ,
    parent_class : {
      type : String ,
      default : '',
    } , 
    msg : {
      type : String , 
      default : null
    },
    replaceable : {
      type : Boolean , 
      default : false 
    } , 
    replacements : {
      type : Array , 
      default : null
    },
    input_language : {
      type : String , 
      default : 'en'
    },
    hidden : {
      type : Boolean , 
      default : false ,
    }

  } ,


  data : function() {
    return {
      user_language : document.querySelector('meta[name="user_lang"]').getAttribute('content') ,
      lang_font : document.querySelector('meta[name="lang_font"]').getAttribute('content') ,
      lang_alignment : document.querySelector('meta[name="lang_alignment"]').getAttribute('content') ,
      openTag : '' ,
      closeTag : '' ,
      translation : '' ,
      isLoading : false ,
      restructed : '' , 
      checkedOnce : false ,

    }
  },

  beforCreated(){

  },
  mounted(){
    this.openTag = this.openingTag();
    if(this.user_language == this.input_language && this.msg != null){
      this.translation = this.msg;
      if(!this.replaceable) {
        this.restructed = this.msg;
        this.$emit('input' , this.restructed);
      }
      else{ setTimeout(()=>{ this.$emit('checkForReplacments'); },500);  }
    }else this.getMessage();
    
    const vm = this;
    this.$on('checkForReplacments' , ()=>{
      if(vm.checkedOnce) {
        vm.$emit('input' , vm.restructed);
        return;
      }
      vm.checkedOnce = true;
      if(vm.replaceable == true){
        let looper , body;
        body = vm.translation;
        for(looper in vm.replacements){
          body = body.replace(vm.replacements[looper].target , vm.replacements[looper].body )
        }
        vm.restructed = body;
      }else vm.restructed = vm.translation; 
      vm.$emit('input' , vm.restructed);
    });
  },


  computed : {


  }


  , methods : {


    openingTag(){
      var classString = 'knocks_font_'+this.lang_font;
      if (!this.align  && this.align ) classString += ' knocks_text_'+this.lang_alignment;
      return classString;
    } ,



    getMessage(){
      const vm = this ;
      if(StaticMessages[this.msg] != undefined) {this.translation = StaticMessages[this.msg]; vm.isLoading = false; return }
      if(vm.msg == null){
        axios({
          method : 'post' ,
          url : LaravelOrgin+'gettrans',
          data : {language : this.user_language, id : this.msgid } ,
          onDownloadProgress : function(progressEvent){
            vm.isLoading = true;
          }
          })
        .then(function(response){
             vm.isLoading = false ;
             vm.translation =  response.data;
             vm.$emit('checkForReplacments');

           });
      }else{
        axios({
          method : 'post' ,
          url : LaravelOrgin+'gtrans',
          data : {language : this.user_language, word : this.msg } ,
          onDownloadProgress : function(progressEvent){
            vm.isLoading = true;
          }
          })
        .then(function(response){
             vm.isLoading = false ;
             vm.translation =  response.data;
             window.StaticMessages[vm.msg] = vm.translation;
             vm.$emit('checkForReplacments');
        });
      }


} ,
}
}
</script>
