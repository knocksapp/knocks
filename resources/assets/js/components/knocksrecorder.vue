<template>
<div  :class = "main_container" @mouseover = "showInterest()">
  <div :class = "recorder_container">
    <knockspopover v-if="(currentBlob == null || isRecording) && mainRecorder != null" >
    <template slot = "container">

       <span v-if = "isRecording && timer_right" :class = "timer_class" >{{ displayDuration }}</span>
    <button @mousedown="startRecord()"  @mouseup="stopRecord()"  :class = "recordButtonClasses" 
    v-if="currentBlob == null || isRecording">
    <span :class = "recordIconClasses"></span>
    </button>
    </template>
    <span slot = "content"  class = "knocks_tooltip animated flipInX" v-if="currentBlob == null || isRecording">

      <span :class = "record_icon_on_stop"></span>
      <static_message msg = "Hold To Record" v-if = "!isRecording"></static_message>
      <span v-if = "isRecording">Recording{{ displayDuration }}</span>
    </span>
    </knockspopover>

        <knockspopover v-if=" mainRecorder == null" >
    <template slot = "container">

       <span v-if = "isRecording && timer_right" :class = "timer_class" >{{ displayDuration }}</span>
    <button @click = "record()"  :class = "recordButtonClasses" 
    v-if="currentBlob == null || isRecording">
    <span :class = "recordIconClasses"></span>
    </button>
    </template>
    <span slot = "content"  class = "knocks_tooltip animated flipInX"  v-if=" mainRecorder == null" >

      <span :class = "record_icon_on_stop"></span>
      <static_message msg = "Click to Record" v-if = "!isRecording"></static_message>
    </span>
    </knockspopover>


    <knockspopover v-if="currentBlob != null && !isRecording">
    <template slot = "container">
    <button v-if="currentBlob != null && !isRecording"
    :class = "cancel_button"
    @click = "resetRecord()"
    >
    <span :class = "cancel_icon"></span>
    </button>
    </template>
    <span slot = "content"  class = "knocks_tooltip animated flipInX" v-if="currentBlob != null && !isRecording" >
      <span :class = "cancel_icon"></span>

      <static_message msg = "Cancel Record"></static_message> {{ displayDuration }}
    </span>
    </knockspopover>
<el-progress text-inside type="circle" :percentage="limitPercentage" status="exception" :width = "35" v-if = "isRecording && !timer_right">
    <span  :class = "timer_class" >{{ displayDuration }}</span>
  </el-progress>
  </div>
  <transition enter-active-class = "animated zoomIn" leave-active-class = "animated flipOutX">
  <div :class = "player_container" v-if = "isFired && currentSource != null && !upload_on_finish && !hide_player">
    <knocksplayer
    :initial_class = "player_initial_class"
    :play_class = "player_play_class"
    :pause_class = "player_pause_class"
    :icon_play_class = "player_icon_play_class"
    :icon_pause_class = "player_icon_pause_class"
    :volume_off_class = "player_volume_off_class"
    :volume_low_class = "player_volume_low_class"
    :volume_high_class = "player_volume_high_class"
    :timer_classes = "player_timer_classes"
    :runtime_classes = "player_runtime_classes"
    :main_container = "player_main_container"
    :buttons_container = "player_buttons_container"
    :sniper_container = "player_sniper_container"
    :timer_container = "player_timer_container"
    :show_timer = "player_show_timer"
    :options_container = "player_options_container"
    :show_options = "player_show_options"
    :runtime_container = "player_runtime_container"
    :show_runtime = "player_show_runtime"
    :volume_container = "player_volume_container"
    :show_volume = "player_show_volume"
    :volume_icon_grid = "player_volume_icon_grid"
    :volume_sniper_container = "player_volume_sniper_container"
    :source = "currentBlob"
    :duration="recordDuration"
    :gid = "gid+'_player'">
    </knocksplayer>
  </div>
</transition>
</div>
</template>

<script>
export default {



  props : {
    upload_data : {
      type : Object ,
      required : true 
    },
    upload_on_finish : {
      type : Boolean , 
      default : false ,
    } , 
    main_container : {
      type : String , 
      default : 'row'
    } ,
    record_button_initial : {
      type : String , 
      default : 'btn btn-floating knocks_tiny_floating_btn wave-effect knocks_record_button knocks_btn_color_kit'
    } ,
    record_button_tester : {
      type : String , 
      default : 'btn btn-floating knocks_tiny_floating_btn wave-effect knocks_record_button pink white-text'
    } ,
    record_button_on_record : {
      type : String , 
      default : 'knocks_btn_recording pulse'
    } ,
    record_button_on_stop : {
      type : String , 
      default : 'knocks_color_kit'
    } ,
    record_icon_on_record : {
      type : String , 
      default : 'knocks-record'
    } ,
    record_icon_on_stop : {
      type : String , 
      default : 'knocks-microphone'
    } ,
    cancel_button : {
      type : String , 
      default : 'btn btn-floating knocks_tiny_floating_btn knocks_color_kit knocks_btn_color_kit animated rubberBand'
    } ,
    cancel_icon : {
      type : String , 
      default : 'knocks-close'
    } ,
    timer_class : {
      type : String , 
      default : 'animated rubberBand infinite knocks_text_dark_active'
    } ,
    timer_right : {
      type : Boolean , 
      default : false 
    },
    player_container : {
      type : String , 
      default : ''
    } ,
    recorder_container : {
      type : String , 
      default : ''
    },
    gid : {
      type : String ,
      required : true ,
    },
    scope : {
      type : Array , 
      default : null 
    },
    hide_player : {
      type : Boolean , 
      default : false 
    },


    //knocks_player_props
    player_initial_class : {
      type :String ,
      default : 'btn knocks_tiny_floating_btn btn-floating knocks_color_kit knocks_btn_color_kit right'
    },
    player_play_class : {
      type :String ,
      default : 'animated flipInX'
    },
    player_pause_class : {
      type :String ,
      default : 'animated flipInY'
    },
    player_icon_play_class : {
      type :String ,
      default : 'knocks-play5 animated jello'
    },
    player_icon_pause_class : {
      type :String ,
      default : 'knocks-pause4 animated rubberBand'
    },
    player_volume_off_class : {
      type : String ,
      default : 'knocks-volume8 knocks_text_dark knocks_text right knocks_text_md animated flipInY'
    },
    player_volume_low_class : {
      type : String ,
      default : 'knocks-volume6 knocks_text_dark right knocks_text_md animated jello'
    },
    player_volume_high_class : {
      type : String ,
      default : 'knocks-volume7 knocks_text_dark_active right knocks_text_md animated rubberBand'
    },
    player_timer_classes : {
      type : String ,
      default : 'knocks_text_right knocks_text_dark_active'
    },
    player_runtime_classes : {
      type : String ,
      default : 'knocks_text_right knocks_text_dark'
    },
    player_main_container : {
      type : String ,
      default : 'row'
    },
    player_buttons_container : {
      type : String ,
      default : 'col s3'
    },
    player_sniper_container : {
      type : String ,
      default : 'col s7'
    },
    player_timer_container : {
      type : String ,
      default : 'col s2'
    },
    player_show_timer : {
      type : Boolean ,
      default : true
    },
    player_options_container : {
      type : String , 
      default : 'row'
    },
    player_show_options : {
      type : Boolean ,
      default : true
    },
    player_runtime_container : {
      type : String , 
      default : 'timer_container'
    } , 
    player_show_runtime : {
      type : Boolean , 
      default : true
    },
    player_volume_container : {
      type : String , 
      default : 'col s5 push-s3'
    },
    player_show_volume : {
      type : Boolean , 
      default : true
    },
    player_volume_icon_grid : {
      type : String , 
      default : 'col s4'
    },
    player_volume_sniper_container : {
      type : String , 
      default : 'col s8'
    }, 
    upload_on_scope : {
      type : Boolean , 
      default : false
    },
    loop_recording : {
      type : Boolean , 
      default : false ,
    },
    volatile : {
      type : Boolean , 
      default : false ,
    },
    record_limit : {
      type : Number , 
      default : 300000
    }

  },
  data () {
    return {
      mainRecorder : null ,
      chunks : [] , 
      isRecording : false ,
      len : 0,
      recordReady : false ,
      currentSource : null ,
      isFired : false ,
      isSupporting : false ,
      recordDuration : 0 ,
      currentBlob : null ,
      interest : false ,
      recognition : null ,
      res : [], 
      recognitionLang : window.currentUserLanguage , 
      convertedText : '' , 
      // limitPercentage : 0 ,  


    }
  },
  mounted(){
 
    const vm = this;
    this.$emit('input' , { hasRecord : false , text : this.convertedText });
    // this.$on('knocksSwitchRecordingKit',()=>{
    //   vm.record();
    // });
    this.$on('recordStarted' , () => {
      App.$emit('runningRecord');

      vm.recordReady = false ;
      vm.mainRecorder.ondataavailable = function(e) {
        vm.chunks.push(e.data);
        console.log('started');
      }
    });

    this.$on('recordStoped' , () => {
      vm.mainRecorder.onstop = function(e) {
        var blob = new Blob(vm.chunks, { 'type' : 'audio/webm; codecs=opus'  });
      //var audElement = document.getElementById('ele');
      var audioSource = URL.createObjectURL(blob);
      //console.log(console.log(audioSource));
      //audElement.controls = true;
      //audElement.src = audioSource;
      vm.currentSource = audioSource;
      var reader = new window.FileReader();
       reader.readAsDataURL(blob); 
       reader.onloadend = function() {
                vm.currentBlob = reader.result;
                App.$emit('BlobEncoded');     
                vm.$emit('LocalBlobEncoded');
        }
      vm.isFired = true;
      vm.chunks = [];
      App.$emit('recordFinished');
      vm.$emit('input' , { hasRecord : true , text : vm.convertedText});
      
      }
    });

    this.$on('LocalBlobEncoded' , ()=>{
      if(vm.upload_on_finish == true){
        vm.upload();
      }
    });

    App.$on('knocks_submit' , (scope) =>{
        if(!vm.upload_on_finish && !vm.upload_on_scope){
            if(scope != null){
            let i;
            if(vm.scope == null) return;
            for(i = 0; i < scope.length; i++){
              if(vm.scope.indexOf(scope[i]) != -1){
               vm.upload();
               return;
              }
            }
            return;
           }else if(scope == null && vm.scope == null){
            vm.isFired = true;
            App.$emit('knocks_input_status' , vm.isValid);
         }
      }else return;
    });

} , 
computed :{
  mediaDevicesSupport(){
    return navigator.mediaDevices ? true : false ;
  } , 
  displayDuration(){
    return moment( parseInt(this.recordDuration )  ).format('m:ss');
  } , 
  recordButtonClasses(){
    let btnClass = [];
    if(this.mainRecorder != null ) btnClass.push(this.record_button_initial);
    else btnClass.push(this.record_button_tester);
    if(this.isRecording) btnClass.push(this.record_button_on_record);
    if(!this.isRecording && this.mainRecorder != null) btnClass.push(this.record_button_on_stop); 
    return btnClass;
  },
  recordIconClasses(){
    let iconClass = [];
    if(this.isRecording) iconClass.push(this.record_icon_on_record);
    if(!this.isRecording) iconClass.push(this.record_icon_on_stop); 
    return iconClass;
  },
limitPercentage (){
  if(!this.isRecording) return 0 ;
  return  parseInt(this.recordDuration / this.record_limit * 100 );
  
}
},



methods : {
  record(){
    if(!this.mediaDevicesSupport){
      console.warn(' KNOCKS Development Team >> Your browser dosn\'t support the audio recording.');
      if(this.$parent.ballons == null) this.$parent.ballons = [];
      this.$parent.ballons.push({
            content : 
            '<span>Your browser doesn\'t support the audio recording by KNOCKS, <br/>We recommend both of <br/>'+
            ' <i class = "knocks-firefox2 knocks_icon"></i> Mozilla Firefox <br/> or '+
            ' <i class = "knocks-chrome2 knocks_icon"></i> Google Chrome    </span>'
             , 
            index : { replyable : false  , category : 'System'} , 
            poped : 0 ,
            seen : 0 ,
            id : null 
          });
      return ;
    }else{
        const vm = this;
        var constraints = { audio: true , audioBitsPerSecond : 16000 };
        navigator.mediaDevices.getUserMedia(constraints).then(function(stream) {
          vm.mainRecorder = new MediaRecorder(stream);
          vm.isSupporting = true ;

        }).catch( ()=>{ 
          if(KnocksRecorderFired){
            return;
          }
          KnocksRecorderFired = true;
          console.warn(' KNOCKS Development Team >> Your browser dosn\'t support the audio recording.');
        
        let ballon = {
              content : 
              '<span>Your browser doesn\'t support the audio recording by KNOCKS, <br/>We recommend both of <br/>'+
              ' <i class = "knocks-firefox2 knocks_icon"></i> Mozilla Firefox <br/> or '+
              ' <i class = "knocks-chrome2 knocks_icon"></i> Google Chrome    </span>'
               , 
              index : { replyable : false , category : 'System'} , 
              poped : 0 ,
              seen : 0 ,
              id : null ,
              
            };
            App.$emit('KnocksAddBallon' , {ballon : ballon});
        vm.isSupporting = false ;
          
        });

    }
  } , 
  convertToText(){
    const vm = this
    let i;
       for(i=0; i < vm.res.length; i++){
           vm.convertedText += vm.res[i] + ' '; 
       }

  },
  startRecord(){
    
    this.isRecording = true ;
    this.chunks = [];
    document.getElementById('knocks_recording_vid_src').play();
    setTimeout(()=>{
      this.mainRecorder.start();
      this.$emit('recordStarted');
      this.$emit('record_started');
      this.startDictation();
    },500);
    const vm = this;
    vm.recordDuration = 0 ;
    var interval = setInterval(()=>{
      App.$on('recordFinished' , ()=>{ clearInterval(interval); });
      vm.recordDuration += 50;
      //vm.$refs.myUniqueID.updateProgress(vm.limitPercentage);
      
      if(vm.recordDuration == vm.record_limit){
        vm.stopRecord();
      }
    },50);
  } , 
  stopRecord(){
    this.stopRecognition();
    this.isRecording = false ;
    const vm = this;
    //if(this.isRecording)
    this.mainRecorder.stop();
    this.$emit('recordStoped');
    this.$emit('record_stopped');

        if(this.volatile){
      setTimeout(()=>{this.resetRecord()},500)
    }
    vm.recordReady = true ;
  } ,
  upload(){
    if(this.currentBlob == null){
      App.$emit('knocksMediaQueryLogged' , { scope : this.scope , token : null , query : 'record' , hasRecord : false });
      return;
    }
    if(this.upload_data.user == undefined || this.upload_data.user == null || this.upload_data.user.length == 0 ){
      console.warn('KNOCKS DEVELOPMENT TEAM >> You need to be explicit about the user id, otherwise the operation cant be done.');
      return ;
    }
    let uploadObject = this.upload_data ;
    uploadObject.blob = this.currentSource.replace('data:audio/webm; codecs=opus;base64,',''); 
    uploadObject.extended = this.currentBlob.replace('data:audio/webm; codecs=opus;base64,',''); 
    uploadObject.duration = this.recordDuration  ;
    
    const vm = this;
    axios({
      method : 'post' , 
      url : LaravelOrgin+'blob/record' , 
      data : uploadObject ,
      headers :  {'knocks_csrf': window.NodeCsrf }
    }).then( (response)=>{
  if(response.data != 'invalid'){
        App.$emit('recordUploaded');
        App.$emit('knocksMediaQueryLogged' , { scope : vm.scope , token : response.data , query : 'record' , hasRecord : true  });
        vm.resetRecord();
      }
      
    });

 
  } , 
  showInterest(){
    if(this.interest) return;
    this.interest = true ;
    this.$emit('knocksSwitchRecordingKit');
    return;
  },
  resetRecord(){
    this.currentBlob = null ;
    this.currentSource = null ;
    this.recordDuration = 0 ;
    this.isFired = false ;
    this.$emit('record_reset');
    this.$emit('input' , { hasRecord : false , text : this.convertedText });
  },
  startDictation() {
    const vm = this;
      
    if (window.hasOwnProperty('webkitSpeechRecognition')) {
  
      vm.recognition = new webkitSpeechRecognition();

      vm.recognition.continuous = true;
      vm.recognition.interimResults = false;

      vm.recognition.lang = vm.recognitionLang;
      vm.recognition.start();

      vm.recognition.onresult = function(e) {


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
      vm.$emit('input' , { hasRecord : true , text : vm.convertedText });

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
    console.log('stoped recognition');
    if(this.recognition){
          this.recognition.stop();
    this.recognition = null ;
    }
  }
}
}
</script>

<style lang="css" scoped>
</style>