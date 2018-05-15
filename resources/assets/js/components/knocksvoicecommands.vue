<template>
<div >
  <!--retrivers-->
  <knocksretriver
  url = "user/search/global"
  prevent_on_mount
  :scope = "['kvc_users']"
  :xdata = "{q : currentQuery}"
  @success = "handleUsersSuggestions($event)"></knocksretriver>
  <knocksuser :user = "auth" class = "knocks_hidden" v-model = "authModel" @input = "handleAuth()"></knocksuser>
  <!--retrivers-->
  <button class = "btn btn-floating waves-effect pulse "
  :class = "[
  {'knocks_color_kit' : !holding} ,
  { 'red' : holding } ,
  { 'animated jello' : speaking } ,
  { 'animated rotateIn  knocks_color_kit_active' : loading } ,
  ]"
  @mousedown = "handleTap(true)"
  @mouseup = "handleTap(false)"
  @click = "(clickFlag = !clickFlag)"
  id = "knocks_voice_commands_button">
  <span class = " knocks_text_bold"
    :class = "[{'knocks-knocks-circle-core' : !holding} , { 'knocks-microphone-3' : holding }]"
  ></span>
  </button>
  <transition enter-active-class = "animated zoomIn" leave-activa-class = "animated zoomOut">
    <div id = "knocks_voice_commands_menu" class = "animated rubberBand " v-if = "toggled" :class = "[{'red' : hasRecError}]">
      <div class = "row">
        <div class="knocks_house_keeper">
          <el-select v-model="recognitionLang" slot="prepend"  style = "width :110px !important" class = "right">
          <el-option label = "English" value = "en"></el-option>
          <el-option label = "العربيه" value = "ar-sa"></el-option>
          </el-select>
          <div class="col s12">
            <div class="row">
              <transition enter-active-class = "animated bounceInLeft" leave-active-class = "animated bounceOutRight">
                <div v-if = "answerMessage && answerMessage.length > 0" class = "animated bounceInLeft">
                  <br/>
                  <static_message :msg = "answerMessage" classes = "knocks_text_light knocks_text_md animated jello text-lighten-3"></static_message>
                </div>
              </transition>
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
              <knocksbutton
              leave_class = "animated jello"
              placeholder = "Go"
              @knocks_button_clicked  = "excute"
              :submit_flag = "false"
              gid = "knocks_voice_commands_button_excuter"
              button_classes = "waves-effect waves-light btn knocks_btn_light knocks_color_kit_light knocks_text_md col s12 "
              label_classes="knocks_text_sm center"
              validation_error = "There're some fields we need you to complete.">
              </knocksbutton>
              <br v-if = "hasRedirect && !redirectStopped"/>
              <el-button
              type = "danger"
              v-if = "hasRedirect && !redirectStopped"
              @click  = "stopRedirect()">
              <static_message msg = "Stop"></static_message>
              <span class = "knocksapp-circle-cancel"></span>
              </el-button>
            </div>
            <transition enter-active-class = "animated bounceInLeft" leave-active-class = "animated bounceOutUp">
              <div v-if = "currentKeyScope == 'visit_profile' && usersSuggestions.length > 0">
                <div>
                  <knocksshowkeys
                  v-if = "usersSuggestions != null && usersSuggestions.length > 1"
                  list_classes = "uk-list"
                  as_label  extended :show_input = "usersSuggestions"></knocksshowkeys>
                </div>
              </div>
            </transition>
            <transition>
              <div class = "knocks_house_keeper" 
              :class ="[
            {'animated zoomIn' : currentKeyScope =='knock' || currentKeyScope == 'spell_knock' || currentCallBackScope =='knock' || currentCallBackScope == 'spell_knock'} ,
            {'knocks_hidden' : !(currentKeyScope =='knock' || currentKeyScope == 'spell_knock' || currentCallBackScope =='knock' || currentCallBackScope == 'spell_knock')} ,
              ]">
                <knock
                knocker_container = " knocks_ligjt_blured_bg knocks_ragular_border row knocks_xs_padding"
                :scope= "['knock_voice_commands_knocker']"
                :error_at="[]"
                submit_at = "post/create"
                :recorder_upload_data = "{ user : auth }"
                :player_show_options = "false"
                :post_at = "auth"
                parent_type = "self"
                @success = "knockSuccess($event)"
                success_at = "done"
                success_msg = "Done."
                gid = "knockknock_voice_commands"></knock>
              </div>
            </transition>
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
      enableKnockKnock : true , 
      answerMessage  : '' ,
      callbacks : {
        spell_knock : {
          agree : this.publishKnock , 
        }
      }, 
      map : {
        agree : {
          keywords : ['yeah' , 'yes' , 'ok' , 'alright'] , 
          callback : this.invokeDblCB
        },
        visit_profile : { 
          keywords : ['go' , 'to' , 'visit' , 'profile' , 'home'] ,
          callback : this.visitProfile
        }, 
        visit_my_profile : {
           keywords : ['go' , 'to' , 'profile' , 'home' , 'my' , 'own'] ,
           callback : this.visitMyProfile
        },
        remote_close : {
         keywords :['close' , 'exit' , 'quit'] ,
         callback : this.remoteClose
       } , 
        logout : {
         keywords : ['log' , 'out' , 'sign' , 'signout' , 'logout'] , 
         callback : this.logout
       }, 
        stop : { 
          keywords : ['stop' , 'it' , 'hold' , 'on'] ,
          callback : this.holdOn
        },
        knock : { 
          keywords : ['create' , 'new' , 'knock' , 'post'] ,
          callback : this.createKnock
        },
        spell_knock :{
          keywords : ['i' , 'want' , 'to' , 'say'] , 
          callback : this.initKnock
        }
      },
      fixedReplies : {
        whosthere : ["Who's there?!" ] , 
        stop : ["Canceled!"] , 
        close : ["Okay, See you!" ] , 
        knockssuccess : ["Your knock was published successfully."]
      },
      authModel : null ,
      textToSpeach : null ,
      usersSuggestions : [] , 
      currentKeyScope : null , 
      currentCallBackScope : null , 
      currentQuery : null , 
      redirectStopped : false ,
      hasRedirect : false , 
      auth : parseInt(UserId)


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
  //Dom Events Methods ====================================================>
  //Triggers And Holders
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
      vm.counter += 200
      if(vm.holdStatus){
      if(vm.counter > 600 ){
        vm.holding = vm.wasHolding = true 
        vm.counter = 0
        //vm.pauseSpeach()
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
  //Textrea Handler
  handleTAI(e){
    this.answerMessage = null
  },



  //Recognition Process Methods ============================================>
  //Starting 
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
      if( (vm.toggled || !vm.enableKnockKnock ) )
      vm.convertToText();
      vm.$emit('recognition',vm.convertedText);
      //outter sommon
      //console.log(vm.convertedText)
      if(!vm.toggled){
        if(vm.enableKnockKnock  && (interim ==  'knock knock' || interim == 'knock knock ' ) ){
           vm.clickFlag = true
           vm.answer(vm.getRandomAnswer('whosthere'))
           vm.convertedText = ''
           vm.loading = vm.speaking = false
           return
        }else if(vm.enableKnockKnock  && !(interim ==  'knock knock' || interim == 'knock knock ' ) ){
          vm.stopRecognition()
          vm.startRecoginition()
        }
      }
      //vm.$emit('input' , { text : vm.convertedText });
      vm.$emit('input' , {loading : vm.loading , speaking : vm.speaking , result : vm.convertedText});
      if(vm.convertedText.length > 0){
        if( !$('#knocks_voice_commands_menu_tal').hasClass('active') ){
          $('#knocks_voice_commands_menu_tal').addClass('active')
        }
        if(vm.toggled){
                  vm.excute()
        vm.stopRecognition()
        }

      }

        // console.log(e.results)
        //vm.recognition.stop();
  
      };

      vm.recognition.onerror = function(e) {
        console.log(e)
        if(e.error == 'no-speech' && vm.enableKnockKnock && !vm.toggled){
          if(vm.recognition){
            vm.stopRecognition()
          }
          vm.recognition = null 
          vm.startRecoginition()
        }
        vm.hasRecError = true
        vm.loading = false 
        vm.speaking = false
        vm.errors = []
        if(e.error == 'network' && vm.toggled && vm.holding){
          vm.answer('Please check your internet connection.');
          vm.stopRecognition()
        }
        if(e.error == 'no-speech' && (vm.toggled) && vm.wasHolding){
          vm.answer('excuse me?!')
        }
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
  //Ending
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
  //Handling Recognition output
  convertToText(){
    const vm = this
    let i;
       for(i=0; i < vm.res.length; i++){
           vm.convertedText += vm.res[i]
           if(i + 1 != vm.res.length) vm.convertedText+=' '
       }
  },


  //Recognition Output Analysis Methods =====================================>
  //Detect which function maybe requested
  getKeywordMatch(){
      let i 
      for(i in this.map){
        if(this.matchedArrays(this.map[i].keywords , this.spliter(this.convertedText))){
          return i;
        }
      }
      return false
  },
  //Compare Recognition output with sictor keywords
  matchedArrays(arrayOne , arrayTwo){
      let i , counter
      counter = 0
      for(i = 0 ; i < arrayTwo.length; i++){
        if(arrayOne.indexOf(arrayTwo[i].toLowerCase()) != -1){
          counter++
        }
      }
      return (counter >= (arrayTwo.length) * 7/12 || counter >= (arrayOne.length) * 7/12)  ? true : false
  },
  //Split Into Tokens And Removes The Extra Space
  spliter(str){
      let temp = str.split(' ')
      if(temp[temp.length-1] == '' || temp[temp.length-1] == ' ')
        temp.splice(temp[temp.length-1] , 1)
      return temp
  },
  //Remove The Ownership S from the tokens endings
  removeOwnerShip(str){
    if(str.endsWith("'s")){
      str = str.split('')
      str.splice(str.length - 1 , 1)
      str.splice(str.length - 1 , 1)
      return str.join('')
    }
    return str
  },


  //CALLBACKS AND EXCUTERS ==================================================>
  //Visiting Profile
  //MAIN EXCUTER
  excute(){
      this.resetAll()
      this.currentKeyScope = this.getKeywordMatch()
      if(this.currentKeyScope){
        this.map[this.currentKeyScope].callback()
      }else{
        this.answer("Excuse me ?")
        this.resetAll()
        
        
      }
  },
  invokeDblCB(){
    if(!this.currentCallBackScope) return
    this.callbacks[this.currentCallBackScope].agree()
  },
  //First Excuter, Activates User Retriever and requests supplies
  visitProfile(){
    let splitted = this.spliter(this.convertedText)
    let target = splitted.indexOf('profile');
    if(target == -1) target = this.convertedText.indexOf('home');
    if(target == -1) return false;
    let user =  this.removeOwnerShip( splitted[target - 1] ).toLowerCase();
    if (this.map.visit_profile.keywords.indexOf(splitted[target-2].toLowerCase()) == -1){
      user =  this.removeOwnerShip( splitted[target-2] ) +' '+ user
    }
    this.currentQuery = user
    setTimeout( ()=>{
      App.$emit('knocksRetriver' , {scope : ['kvc_users']})
    }, 200)
  },
  visitMyProfile(){
    if(window.location.pathname == '/user/profile/'+this.auth){
      this.answer("You're already in your profile")
      return
    }
    this.countDown({
      msgs : ['heading to your profile in 3..' , '2' , '1'] , 
      callback : ()=>{
        window.location.href = this.asset('user/profile/'+this.auth)
      }
    })
  },
  //Handling Retriver output
  handleUsersSuggestions( e ){
      this.usersSuggestions = null 
      this.usersSuggestions = e.response
      App.$emit('knocksContentChanged')
      if(e.response.length == 0 ){
        this.stopRecognition()
        this.answer("We could not find any user who's name is "+e.monitor.data.q)
      }
      if(e.response.length > 1){
        this.stopRecognition()
        this.answer('Which one ?')
      }
      if(e.response.length == 1){
        if(window.location.pathname == '/user/profile/'+this.usersSuggestions[0] ){
          this.stopRecognition()
          this.answer("You are already in "+e.monitor.data.q+"'s home.")
        }else{
          this.countDown({
            msgs : ["Okay, we're going ahead!, in 3..." , "2.." , "1"] , 
            timers : [4500 , 1500 , 1000] , 
            callback : ()=>{ 
              window.location.href = this.asset('user/profile/'+this.usersSuggestions[0]);
              this.holding = this.wasHolding = this.clickFlag = false
              }
          })
        }
      }
  },
  //Creating A New KNOCKS
  createKnock(){
    this.answer("Okay, begin with 'i want to say ' and complete your content please.")
  },
  initKnock(){
      let content = this.convertedText
      App.$emit('knocksKnockerBoundContent' , {scope : ['knock_voice_commands_knocker'] , content : content.toLowerCase().split('i want to say ').join('') , reset : true})
      this.answer("Would you like to publish your knock as, '"+content.toLowerCase().split('i want to say ').join('')+"'")
  },
  //Publish Knock
  publishKnock(){
    this.countDown({
      msgs : ['Publishing your knock in 3..' , '2..' ,'1'] , 
      callback : ()=>{ App.$emit('knocksButtonRemoteClick', {scope : ['knock_voice_commands_knocker'] })}
    })  
  },
  //Handle Knocking Success
  knockSuccess(e){
    if(this.authModel != null)
      this.answer("Okay, "+this.authModel.name+"!, your knock '"+e.body+" ,' was published successfully.")
      else this.answer(this.getRandomAnswer('knockssuccess'))
    this.resetAll()
  },
  //Remote Closing The KVC
  remoteClose(){
    this.answer(this.getRandomAnswer('close'))
    this.wasHolding = this.holding = this.clickFlag =  false
  },
  //Logging OUT
  logout(){
       this.countDown({
        msgs : ["Okay, we're leaving in 3..." , "2.." , "1, we hope to see you soon in KnocksApp!"] , 
        callback : ()=>{
          this.holding = this.wasHolding = this.clickFlag = false
          App.$emit('logoutGlobal')
        }
       })
  },
  //Remote Close
  holdOn(){
      this.answerMessage = null
      this.hasRedirect = false 
      this.redirectStopped = true
      this.answer("Okay, order canceled")
  },


  //Assistance functions ==============================================>
  //Reseting
  resetAll(){
      this.currentQuery = null 
      this.currentCallBackScope = this.currentKeyScope ? this.currentKeyScope : null
      this.currentKeyScope = null 
      this.answerMessage = null 
      this.hasRedirect = false 
      this.redirectStopped = false
      this.refactorMaps()
  },
  refactorMaps(){
    
  },
  pauseSpeach(){
    thsynth = window.speechSynthesis;
    if(!synth.paused)
    synth.pause();

    },
  //Generate URLS
  asset(url){

      return window.Asset(url);
  },
  //COUNTDOWN
  countDown(object){
      this.stopRecognition()
         this.hasRedirect = true
         this.redirectStopped = false
         this.answer(object.msgs[0])
         if(!this.redirectStopped)
          setTimeout(()=>{    
            this.answerMessage = null
            this.stopRecognition()
            this.answer(object.msgs[1])
            if(!this.redirectStopped)
            setTimeout(()=>{
              this.answerMessage = null
              this.stopRecognition()
              this.answer(object.msgs[2])
              if(!this.redirectStopped)
              setTimeout(()=>{
                if(!this.redirectStopped){
                   object.callback()
                }  
              },object.timers !== undefined && object.timers[2] !== undefined ? object.timers[2] : 1500)
            },object.timers !== undefined && object.timers[2] !== undefined ? object.timers[1] : 1500)
          },object.timers !== undefined && object.timers[2] !== undefined ? object.timers[0] :  3500)
  }, 
  //Answering The USER
  answer(ans){

    if( window.speechSynthesis.paused) window.speechSynthesis.paused = false
    this.answerMessage = null
    this.stopRecognition()
    this.answerMessage = ans;
    if(!this.textToSpeach){
    this.textToSpeach = new SpeechSynthesisUtterance();
    var voices = window.speechSynthesis.getVoices();
    this.textToSpeach.voice = voices[10]; // Note: some voices don't support altering params
    this.textToSpeach.voiceURI = 'native';
    this.textToSpeach.volume = 1; // 0 to 1
    this.textToSpeach.rate = 0.92; // 0.1 to 10
    this.textToSpeach.pitch = 1 ; //0 to 2
    this.textToSpeach.lang = 'en-US';
    }
    this.textToSpeach.text = ans;
    const vm = this;
    this.textToSpeach.onend = function(e) {

      if(vm.enableKnockKnock)
        setTimeout( ()=>{
          vm.startRecoginition()
           vm.loading = vm.speaking = false
        } , 300)
    };
    speechSynthesis.speak(this.textToSpeach);
    this.loading = this.speaking = false
    this.convertedText = ''
  },
  handleAuth(){
    this.fixedReplies.whosthere.push('Hello, '+this.authModel.name+'!')
    this.fixedReplies.whosthere.push('Hi, '+this.authModel.name+'!')
    this.fixedReplies.close.push('Okay, '+this.authModel.name+'!, See you')
    this.fixedReplies.close.push('Alright, '+this.authModel.name+'!')
    this.fixedReplies.whosthere.push('Welcome Back, '+this.authModel.name+'!')
    this.fixedReplies.stop.push('Okay, '+this.authModel.name+"!, we're not going to anywhere.")
    this.fixedReplies.stop.push('Alright, '+this.authModel.name+', cancelation done!')
  },
  getRandomAnswer(key){
    return this.fixedReplies[key][Math.floor((Math.random() * (this.fixedReplies[key].length - 1 ) ))]
  },
  stopRedirect(){

    this.redirectStopped = true; this.hasRedirect = false
    //this.pauseSpeach()
    this.answerMessage = null
    setTimeout( ()=>{ 
      this.redirectStopped = true; this.hasRedirect = false
      this.answer(this.getRandomAnswer('stop'))
    }, 500)
    
  }
  
  },
  
}
</script>

<style lang="css" scoped>



</style>