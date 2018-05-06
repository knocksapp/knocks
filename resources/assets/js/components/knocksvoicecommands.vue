<template>
<div>
  <button class = "btn btn-floating waves-effect pulse "
  :class = "[{'knocks_color_kit' : !holding} , { 'red' : holding }]"
  @mousedown = "handleTap(true)"
  @mouseup = "handleTap(false)"
  @click = "(clickFlag = !clickFlag)"
  id = "knocks_voice_commands_button">
  <span class = " knocks_text_bold"
    :class = "[{'knocks-knocks-circle-core' : !holding} , { 'knocks-microphone-3' : holding }]"
  ></span>
  </button>
  <transition enter-active-class = "animated zoomIn" leave-activa-class = "animated zoomOut">
    <div id = "knocks_voice_commands_menu" v-if = "toggled" :class = "[{'red' : hasRecError}]">
      <div class = "row">
        <div class="knocks_house_keeper">
          <el-select v-model="recognitionLang" slot="prepend"  style = "width :110px !important">
          <el-option label = "English" value = "en"></el-option>
          <el-option label = "العربيه" value = "ar-sa"></el-option>
          </el-select>
          <div class="col s12">
            <div class="row">
              <div class="input-field col s12">
                <textarea 
                id = "knocks_voice_commands_menu_ta"
                v-model = "convertedText"
                @input = "handleTAI($event)" class="materialize-textarea  knocks_input_textarea_light_ps"></textarea>
                <label for="knocks_voice_commands_menu_ta" id="knocks_voice_commands_menu_tal"  class = "knocks_text_light">
                  <span class = "knocks-knocks "></span>
                  <static_message msg = "hold to speak or write here.."></static_message>
                </label>
              </div>
            </div>
            <transition enter-active-class = "animated bounceInLeft" leave-active-class = "animated bounceOutRight">
              <div v-if = "loading" class = "animated bounceInLeft">
                <div class="ui active inline loader"></div>
                <static_message msg = "Processing your voice.." classes = "blue-text text-lighten-3"></static_message>
              </div>
            </transition>
            <transition enter-active-class = "animated bounceInLeft" leave-active-class = "animated bounceOutUp">
              <div v-if = "speaking" class = "" > 
                <a class = "btn btn-floating pulse red lighten-3">
                  <span class = "knocks-assistive-listening-systems white-text "></span>
                </a>
                <static_message msg = "Listening.." classes = "red-text text-lighten-3"></static_message>
              </div>
            </transition>
              <transition enter-active-class = "animated bounceInLeft" leave-active-class = "animated bounceOutUp">
              <div v-if = "hasRecError" class = "" > 
                <div v-if = "errors.indexOf('network') != -1">
                  <a class = "btn btn-floating pulse red lighten-3">
                  <span class = "knocks-plug white-text "></span>
                </a>
                <static_message msg = "Please check you internet connection.." classes = "white-text text-lighten-3"></static_message>
                </div>
              </div>
            </transition>
          </div>
        </div>
      </div>
    </div>
  </transition>
</div>
</template>

<script>
export default {

  name: 'knocks_voice_commands_button',

  data () {
    return {
    

      holding : false ,
      interval : null ,
      counter : 0 ,
      clickFlag : false , 
      holdStatus : false , 
      wasHolding : false ,
      featureAvailable : false ,
      speaking : false , 
      loading : false , 
      hasRecError : false , 
      errors : [] ,
      convertedText : '' , 
      res : [] ,
      recognition : null ,
      recognitionLang : window.currentUserLanguage , 
      outterSummon : false ,
      enableKnockKnock : true


    }
  },
  mounted(){
    if(this.enableKnockKnock)
     this.startRecoginition()

   

  },
  computed : {
    toggled(){
      return this.clickFlag || this.outterSummon || this.wasHolding ? true : false
    }
  },
  methods :{
  	handleTap(flag){
      const vm = this
      this.holdStatus = flag
      this.stopRecognition()
      if(!flag && this.holding){
        this.holding = false; 
        this.wasHolding = true
        this.stopRecognition()
        return
      }
       if(!flag && !this.holding){
        this.wasHolding = false
       }
      if(flag && !this.holding){
       let interval = setInterval( ()=>{
        vm.counter += 300
        if(vm.holdStatus){
        if(vm.counter > 900 ){
          vm.holding = vm.wasHolding = true 
          vm.counter = 0
          vm.startRecoginition()
          clearInterval(interval)
          return
        }
      }else{
         this.holding = false 
          this.counter = 0
          clearInterval(interval)
      }
      } , 300)
        return
      }
    },
    handleTAI(e){

    },
    startRecoginition(){
    const vm = this
    if (window.hasOwnProperty('webkitSpeechRecognition')) {
      vm.featureAvailable = true ;
      vm.recognition = new webkitSpeechRecognition();

      vm.recognition.continuous = true;
      vm.recognition.interimResults = false;

      vm.recognition.lang = vm.recognitionLang;
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
        vm.hasRecError = false ;
        vm.errors = [];
        vm.speaking = false ;
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
      if(vm.toggled || !vm.enableKnockKnock)
      vm.convertToText();
      vm.$emit('recognition',vm.convertedText);
      //outter sommon
      //console.log(vm.convertedText)
      if(vm.enableKnockKnock && !vm.toggled && interim.startsWith( 'knock knock' ) ){
        vm.outterSummon = true
        vm.answer("who's there?")
      }
      //vm.$emit('input' , { text : vm.convertedText });
      vm.$emit('input' , {loading : vm.loading , speaking : vm.speaking , result : vm.convertedText});
      if(vm.convertedText.length > 0){
        if( !$('#knocks_voice_commands_menu_tal').hasClass('active') ){
          $('#knocks_voice_commands_menu_tal').addClass('active')
        }
      }

        // console.log(e.results)
        //vm.recognition.stop();
  
      };

      vm.recognition.onerror = function(e) {
        console.log(e)
        if(e.error == 'no-speach'){
          vm.recognition = null 
          vm.startRecoginition()
        }
        vm.hasRecError = true
        vm.loading = false 
        vm.speaking = false
        vm.errors = []
        vm.errors.push(e.error)
        if(vm.recognition != null){
                  vm.recognition.stop();
        }
        console.log(vm.res);
      }

    }else{
      vm.featureAvailable = false ;
    }

  },
  answer(ans){
var msg = new SpeechSynthesisUtterance();
var voices = window.speechSynthesis.getVoices();
msg.voice = voices[40]; // Note: some voices don't support altering params
msg.voiceURI = 'native';
msg.volume = 1; // 0 to 1
msg.rate = 1; // 0.1 to 10
msg.pitch = 1 ; //0 to 2
msg.text = ans;
msg.lang = 'en-US';

msg.onend = function(e) {
  console.log('Finished in ' + event.elapsedTime + ' seconds.');
};

speechSynthesis.speak(msg);

  },
  convertToText(){

    const vm = this
    let i;
       for(i=0; i < vm.res.length; i++){
           vm.convertedText += vm.res[i] + ' '; 
       }

  },
  stopRecognition(){
      this.$emit('leave');
      if(this.recognition){
        this.recognition.stop();
        this.convertToText();
        this.$emit('stopped',this.convertedText);
        this.$emit('input' , { text : this.convertedText });
        this.recognition = null ;
      }
    },
  },
  
}
</script>

<style lang="css" scoped>



</style>