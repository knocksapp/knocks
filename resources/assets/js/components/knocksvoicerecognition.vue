<template>
     <el-tooltip  placement="bottom" effect="light">
    <span slot = "content">
      <span :class = "[{ 'knocks-microphone-3' : featureAvailable} , { 'knocks-muted' : !featureAvailable} , {'red-text ':holding} ]"></span>
      <static_message msg=  "Hold to search with your voice." :class = "[{'knocks_hidden' : !featureAvailable}]"></static_message>
      <static_message msg=  "Voice Searching is not available for your browser.":class = "[{'knocks_hidden' : featureAvailable}]"></static_message>
    </span>
    <span>
	 <button 
   :disabled= "!featureAvailable"
   @mousedown="startRecognition($event)" @click = "preventDefault($event)" @mouseup = "stopRecognition()" :class = "[{'pulse animated infinite ':holding}]" class = "knocks_recoginition_button">
	 	<span :class = "[{ 'knocks-microphone-3' : featureAvailable} , { 'knocks-muted' : !featureAvailable} , {'red-text ':holding} ]"></span>
	 </button>
  </span>
  </el-tooltip>
</template>

<script>
export default {

  name: 'knocksvoicerecognition',	
  props : {
    lang : {
      type : String , 
      default : 'en'
    }
  },

  data () {
    return {
    	holding : false ,
    	recognition : null , 
    	res : [],
    	recognitionLang : window.currentUserLanguage , 
      convertedText : '' , 
      speaking : false , 
      loading : false  ,
      isFired : false ,
      featureAvailable : window.hasOwnProperty('webkitSpeechRecognition') ,


    }
  },
  mounted() {
    
  },
  methods : {
    preventDefault(e){
      e.preventDefault()
    },
  	startRecognition(e){
      e.preventDefault();
  		this.$emit('hold');
  		this.holding = true;
  		    const vm = this;
      
    if (window.hasOwnProperty('webkitSpeechRecognition')) {
      vm.featureAvailable = true ;
      vm.recognition = new webkitSpeechRecognition();

      vm.recognition.continuous = true;
      vm.recognition.interimResults = false;

      vm.recognition.lang = vm.lang;
      vm.recognition.start();
      vm.recognition.onsoundstart = function(){
        vm.speaking = true ; 
        vm.loading = false ;
        vm.$emit('input' , {loading : vm.loading , speaking : vm.speaking , result : vm.convertedText});
      };
      vm.recognition.onsoundend = function(){
        vm.speaking = false ; 
        vm.loading = true ;
        vm.$emit('input' , {loading : vm.loading , speaking : vm.speaking , result : vm.convertedText});
      };

      vm.recognition.onresult = function(e) {
        vm.loading = false ;
        vm.res = [];
        vm.convertedText = '';
        var final = "";
        var interim = "";
      for (var i = e.resultIndex; i < e.results.length; ++i) {
        if (event.results[i].final) {
          final += e.results[i][0].transcript;
        } else {
          interim += e.results[i][0].transcript;
          vm.res.push(interim)
        }
      }
      
      vm.convertToText();
      vm.$emit('recognition',vm.convertedText);
      //vm.$emit('input' , { text : vm.convertedText });
      vm.$emit('input' , {loading : vm.loading , speaking : vm.speaking , result : vm.convertedText});

        // console.log(e.results)
        //vm.recognition.stop();
  
      };

      vm.recognition.onerror = function(e) {
        vm.recognition.stop();
        console.log(vm.res);
      }

    }else{
      vm.featureAvailable = false ;
    }

  	},
  	 stopRecognition(){
  	 	this.$emit('leave');
  		this.holding = false;
  		    if(this.recognition){
          this.recognition.stop();
             this.convertToText();
      this.$emit('stopped',this.convertedText);
      this.$emit('input' , { text : this.convertedText });
    this.recognition = null ;
    }
  	},
  	  convertToText(){
    const vm = this
    let i;
       for(i=0; i < vm.res.length; i++){
           vm.convertedText += vm.res[i] + ' '; 
       }

  },
  }
}
</script>

<style lang="css" scoped>
.knocks_recoginition_button{
	background-color: transparent !important;
	border : 0px solid transparent;
}
</style>