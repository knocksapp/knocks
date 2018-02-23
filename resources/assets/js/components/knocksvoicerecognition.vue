<template>
	 <button @mousedown="startRecognition()" @mouseup = "stopRecognition()" :class = "[{'pulse animated infinite ':holding}]" class = "knocks_recoginition_button">
	 	<span class = "knocks-microphone" :class = "[{'red-text ':holding}]"></span>
	 </button>
</template>

<script>
export default {

  name: 'knocksvoicerecognition',	
<<<<<<< HEAD
=======
  props : {
    lang : {
      type : String , 
      default : 'en'
    }
  },
>>>>>>> master

  data () {
    return {
    	holding : false ,
    	recognition : null , 
    	res : [],
<<<<<<< HEAD
    	      recognitionLang : window.currentUserLanguage , 
      convertedText : ''
    }
  },
=======
    	recognitionLang : window.currentUserLanguage , 
      convertedText : '' , 
      speaking : false , 
      loading : false  ,
      isFired : false ,


    }
  },
  mounted() {

  },
>>>>>>> master
  methods : {
  	startRecognition(){
  		this.$emit('hold');
  		this.holding = true;
  		    const vm = this;
      
    if (window.hasOwnProperty('webkitSpeechRecognition')) {
  
      vm.recognition = new webkitSpeechRecognition();

      vm.recognition.continuous = true;
      vm.recognition.interimResults = false;

<<<<<<< HEAD
      vm.recognition.lang = vm.recognitionLang;
      vm.recognition.start();

      vm.recognition.onresult = function(e) {


=======
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
>>>>>>> master
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
<<<<<<< HEAD
      vm.$emit('input' , { text : vm.convertedText });
=======
      //vm.$emit('input' , { text : vm.convertedText });
      vm.$emit('input' , {loading : vm.loading , speaking : vm.speaking , result : vm.convertedText});
>>>>>>> master

        // console.log(e.results)
        //vm.recognition.stop();
  
      };

      vm.recognition.onerror = function(e) {
        vm.recognition.stop();
        console.log(vm.res);
      }

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