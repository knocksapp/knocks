<template>

  <div @mouseover = "interest = true">

    <audio :id = "gid"  :src="playerSource"  @ended = "resetToOrgin()" controls 
    @loadedmetadata="getRunTime()" @loadeddata="canBePlayed(true)" @waiting="canBePlayed(false)" v-if = "interest && supportedType" style = "display : none"></audio>
    <div :class = "main_container">
      <div :class="buttons_container">
        <el-popover
          ref="playpo"
          placement="bottom"
          trigger="hover">
          <span v-if="!supportedType">Voice notes are not supported by your browser</span>
          <span v-if = "supportedType">Play/Pause</span>
        </el-popover>
         <el-button v-popover:playpo :class = "playingButtonClasses"  @click = "construct($event)"  :disabled = "!supportedType || loadingState">
            <!-- <knocksloader :gid = "gid+'_loader'" v-if = "isLoading"></knocksloader> -->
             <div class="ui active loader" v-if = "loadingState"></div>
            <span :class = "playingContentClasses"></span>
         </el-button>
      </div>
      <div :class = "sniper_container" v-if="!hide_sniper">
        <!-- <el-slider v-model="sniper" :format-tooltip="displayTimeF" @input="updateTime()"></el-slider> -->
        <input type="range"  min="0" max="100" v-model = "sniper" @input="updateTime()" />
      </div>
      <div  :class = "[timer_classes , timer_container]" v-if = "show_timer">
        <span>{{displayTime}}</span>
      </div>
    </div>
    <div :class = "options_container" v-if = "show_options">
      <div  :class = "[runtime_classes, runtime_container]" v-if = "show_runtime">
        <span v-if = "displayRunTime != 'Invalid date'">{{displayRunTime}}</span>
      </div>
      <div :class = "volume_container" v-if = "show_volume">
        <div :class = "volume_icon_grid">
          <span :class = "volumeIcon"></span>
        </div>
        <div :class = "volume_sniper_container">
           <el-slider v-model="volume" @input="updateVolume()"></el-slider>
          <!-- <input type="range"  min="0" max="100" v-model = "volume" @input="updateVolume()" /> -->
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {

  name: 'knocksplayer',
  props : {
    source : {
      type : String ,
      default : null
    },
    initial_class : {
      type :String ,
      default : 'btn btn-floating knocks_tiny_floating_btn knocks_color_kit knocks_btn_color_kit right'
    },
    play_class : {
      type :String ,
      default : 'animated flipInX'
    },
    pause_class : {
      type :String ,
      default : 'animated flipInY'
    },
    icon_play_class : {
      type :String ,
      default : 'knocks-arrows2 animated jello'
    },
    icon_pause_class : {
      type :String ,
      default : 'knocks-pause-1 animated rubberBand'
    },
    volume_off_class : {
      type : String ,
      default : 'knocks-volume8 knocks_text_dark knocks_text right knocks_text_md animated flipInY'
    },
    volume_low_class : {
      type : String ,
      default : 'knocks-volume6 knocks_text_dark right knocks_text_md animated jello'
    },
    volume_high_class : {
      type : String ,
      default : 'knocks-volume7 knocks_text_dark_active right knocks_text_md animated rubberBand'
    },
    timer_classes : {
      type : String ,
      default : 'knocks_text_right knocks_text_dark_active'
    },
    runtime_classes : {
      type : String ,
      default : 'knocks_text_right knocks_text_dark knocks_tinny_top_margin'
    },
    duration : {
      type : Number ,
      default : 0 ,
    },
    live : {
      type : Boolean ,
      default : false 
    } ,
    gid : {
      type : String , 
      required  : true 
    } ,
    specifications : {
      type : Object , 
      default : null ,
    } , 
    fill_from : {
      type : String , 
      default  : null ,
    } ,
    meta : {
      type : String , 
      default  : null ,
    } , 
    load_on_mount : {
      type : Boolean , 
      default : false 
    },
    main_container : {
      type : String ,
      default : 'row'
    },
    buttons_container : {
      type : String ,
      default : 'col s3'
    },
    sniper_container : {
      type : String ,
      default : 'col s7'
    },
    timer_container : {
      type : String ,
      default : 'col s2 '
    },
    show_timer : {
      type : Boolean ,
      default : true
    },
    options_container : {
      type : String , 
      default : 'row'
    },
    show_options : {
      type : Boolean ,
      default : true
    },
    runtime_container : {
      type : String , 
      default : 'timer_container'
    } , 
    show_runtime : {
      type : Boolean , 
      default : true
    },
    hide_sniper:{
        type : Boolean,
        default : false
    },
    volume_container : {
      type : String , 
      default : 'col s5 push-s3'
    },
    show_volume : {
      type : Boolean , 
      default : true
    },
    volume_icon_grid : {
      type : String , 
      default : 'col s4'
    },
    volume_sniper_container : {
      type : String , 
      default : 'col s8'
    },
    live_meta : {
      type : Boolean , 
      default : false ,
    },
    full_back_loading : {
      type : Boolean , 
      default : false ,
    },
    not_webm:{
      type : Boolean , 
      default : false 
  }
    


  },
  data () {
    return {
      sniper : 0,
      runTime : 0 ,
      playing : false ,
      timer : 0 ,
      volume : 70 ,
      liveDuration : null ,
      loadingDone : false ,
      isLoading : false ,
      loadedOnce : false ,
      metaLoading : false , 
      interest : false ,
      playable : false ,
      supportedType : false,
    }
  } ,
  computed : {
    currentTime(){
      return document.getElementById(this.gid).currentTime;
    },
    loadingState(){
      if(!this.interest) return false ;
      return !this.playable || this.metaLoading ? true : false;
    },
    playingButtonClasses(){
      let classArray = [];
      classArray.push(this.initial_class);
      if(this.playing) classArray.push(this.play_class);
      if(!this.playing) classArray.push(this.pause_class);
      return classArray;
    },
    playingContentClasses(){
      let classArray = [];
      if(!this.playing) classArray.push(this.icon_play_class);
      if(this.playing) classArray.push(this.icon_pause_class);
      return classArray;
    },
    displayTime(){
       return this.secondsToHms(parseInt(this.timer));
    },
    displayRunTime(){
      return moment(this.runTime ).format('m:ss');
    },
    volumeIcon(){
      if(this.volume > 70) return this.volume_high_class;
      if(this.volume > 0) return this.volume_low_class;
      return this.volume_off_class;
    },
    playerSource(){
      if(this.full_back_loading) 
        return LaravelOrgin+'media/record/retrive/'+this.specifications.id;
      else return !this.live ? this.source : null ; 

    }
    
  } , 
  mounted(){
    const vm = this;
    var testElement = document.createElement('audio');
    
    this.supportedType = !!(testElement.canPlayType && testElement.canPlayType('audio/webm;').replace(/no/, ''));
    App.$on('knocksGlobalPlayerRequested' , (payloads)=>{
      if(vm.gid != payloads && vm.playing){
        vm.playing = false ;
        vm.pauseRecord();
      }
    });
    App.$on('runningRecord' , ()=>{
      if(vm.playing){
        vm.pauseRecord();
        vm.playing = false ;
        vm.sniper = 0;
        vm.timer = 0;
      }
    });
    App.$on('recordFinished' , ()=>{
      //vm.runTime = document.getElementById('ele').duration;
    })
    this.$on('playingRecord' , ()=>{

      let interval = setInterval( ()=> {
        if(document.getElementById(vm.gid) != null){
          if(vm.playing && document.getElementById(vm.gid) ){
          vm.timer = document.getElementById(vm.gid).currentTime;   
          if(vm.timer >= vm.runTime){
            vm.timer = vm.runTime;
            vm.playing = false;
            vm.sniper = 100;
            clearInterval(interval);
            return ;
          }
          vm.sniper = (vm.timer / vm.runTime * 100) * 1000;
      
          }else{
            clearInterval(interval);
          }
        }else{
          clearInterval(interval);
        }
        
      },10);
    });


    //Getting the live tracks
    if(this.live || this.live_meta && !this.full_back_loading) this.getTrackMeta();
    if(this.live && this.load_on_mount && !this.full_back_loading) this.getTrackBlob();
    if(this.full_back_loading) this.fullBackLoad();

    this.$on('liveMetaReady' , (meta)=>{
      vm.runTime = meta.duration;
    });
  },
  methods : {
    getRunTime(){
      if(this.full_back_loading) { this.runTime = this.liveDuration; return; }
      if(!this.live)
      this.runTime = this.duration;
      
    },
    construct(event){
      console.log('PLAYING RECORD');
      if(!this.playing){
        if(!this.playable) return;
        this.playing = true ;
        App.$emit('knocksGlobalPlayerRequested' , this.gid);
        this.playRecord();
      }else{
        this.playing = false ;
        this.pauseRecord();
      }
    },
  handleLive(){
    const vp = this;
    if(this.live && !this.load_on_mount && !this.loadedOnce){
      this.getTrackBlob();
      let waitingInterval = setInterval( ()=>{
        if(vp.loadingDone){
          clearInterval(waitingInterval);
          vp.playRecord();
        }
      } ,100);
    }
  },
  canBePlayed(state){
    
    this.playable = state;
    this.isLoading = !state;
  },
  playRecord(){

    if(this.runTime == 0){
      let interval = setInterval( ()=>{
        if(this.runTime != 0){
            clearInterval(interval); 
        }
      }, 300)
    }
    if(this.live && !this.load_on_mount && !this.loadedOnce){
      this.handleLive();
      return ;
    }
    let audioTag = document.getElementById(this.gid);
    //this.runTime = audioTag.duration;
    this.$emit('playingRecord');
    let res = () =>{
      //audioTag.currentTime = audioTag.currentTime;
      if(!(audioTag.currentTime > 0 && !audioTag.paused && !audioTag.ended && audioTag.readyState > 2) )
        audioTag.play();
    }
    res();
      window.setTimeout(() => audioTag.pause(), 25);
      window.setTimeout(res, 50);
  },
  pauseRecord(){
    let audioTag = document.getElementById(this.gid);
    audioTag.pause();
  },
  updateTime(){
    let audioTag = document.getElementById(this.gid);
    audioTag.currentTime = ( (this.sniper / 100) * this.runTime/1000 ) ;
    this.timer = ( (this.sniper / 100) * this.runTime / 1000 ) ;
    $('.thumb').css({'display': 'none'});
  },
  updateVolume(){
    document.getElementById(this.gid).volume = this.volume/100;
    $('.thumb').css({'display': 'none'});
  },
  resetToOrgin(){
    console.log('reset');
    this.sniper = 0;
    this.timer = 0;
    document.getElementById(this.gid).currentTime = 0;
    this.playing = false;
  } , 
  secondsToHms(d) {
    d = Number(d);

    var h = Math.floor(d / 3600);
    var m = Math.floor(d % 3600 / 60);
    var s = Math.floor(d % 3600 % 60);

    return ('0' + m).slice(-2) + ":" + ('0' + s).slice(-2);
    },
  getTrackMeta(){
    if(this.fullBackLoad) return;
    const vm = this;
    axios({
        method:'post',
        url: NodeOrgin+vm.meta,
        //withCredentials: true,
        data : vm.specifications ,
      })
    .then((response) =>{
          if(response.data != null || response.data != 'null' || response != 'null'){
            vm.liveDuration = response.data.duration;
             vm.$emit('liveMetaReady' , response.data);
          }
      });
    },
    fullBackLoad(){
      if(this.specifications.id == undefined || this.specifications.user == undefined || this.specifications.object == undefined){
        console.warn('KNOCKS DEVELOPMENT TEAM >> You need to declare all of id, user and object in your specifications.');
        return ;
      }
      //Load Meta
      const vm = this;
      axios({
          method:'post',
          url: LaravelOrgin+'media/record/meta',
          data : { id : vm.specifications.id} , 
          onDownloadProgress : ()=> { vm.metaLoading = true ;}
          //withCredentials: true,
        })
      .then((response) =>{
            if(response.data != null || response.data != 'null' || response != 'null'){
              vm.metaLoading = false ;
              vm.liveDuration = response.data
              vm.runTime = vm.liveDuration;
               vm.$emit('liveMetaReady' , response.data);


            }
        });
    },
    displayTimeF(){
      return this.displayTime;
    },
  getTrackBlob(){
    let getterObject = this.specifications;
    getterObject._csrf = window.NodeCsrf;
    const vm = this ;
   axios({
      method:'post',
      url: NodeOrgin+vm.fill_from,
      data : vm.specifications ,
      onDownloadProgress : ()=>{
        vm.isLoading  = true ,
        vm.loadingDone = false ;
      }
    }).then((response) => {
        if(response.data != null || response.data != 'null' || response != 'null'){
           document.getElementById(vm.gid).src = response.data;
           vm.loadingDone = true ;
           vm.isLoading = false ;
           vm.loadedOnce = true ;
           vm.$emit('liveLoadingDone');
        }
    });
  }
  }
}
</script>

<style lang="css" scoped>
.thumb{
  display: none !important;
}
</style>