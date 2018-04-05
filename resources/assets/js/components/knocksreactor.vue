<template>
<div>
  <knocksuser :user = "auth" class = "knocks_hidden" v-model = "authModel"></knocksuser>
  <div class="fixed-action-btn knocks_reactor_target knocks_house_keeper " 
     :class = "[
     {'horizontal knocks_reactor_index' : inverse } ,
     {'vertical knocks_reactor_container' : !inverse} , 
     ]">
    <a :class="[initial_class , {'pulse' : selected != null } , intialButton]" @dblclick="resetORLike()" @mousedown="beginTimer()" @mouseup="checkTimer()"
    @touchstart="beginTimer()" @touchend="checkTimer()"
    >
      <i class="material-icons" :class = "intialReactor"></i>
    </a>
    <ul v-if = "authModel != null" :class = "[
     {'knocks_reactor_candy' : inverse && (candy || authModel.kid)} , 
     {'knocks_reactor_adult' : inverse && !candy && !authModel.kid} , 
     {knocks_reactor_ul : !inverse} , 
     { 'knocks_horizontal_reactor col' : inverse } ,
     'knocks_reactor_target_ul'
     ]" >
      <li>
        <a  style = "margin-top: 10px"
        @click="assign('like')"  class="knocks_reaction_btn btn-floating pink darken-1" :class="[{'pulse':selected == 'like'}]" :id = "gid+'_like'">
          <i class="material-icons" :class = "[like_icon , {'knocks_active_reaction infinite rubberBand':selected == 'like'}]"></i>
        </a>
      </li>
      <li>
        <a  @click="assign('dislike')" class="knocks_reaction_btn btn-floating  purple lighten-1" :class="[{'pulse':selected == 'dislike'}]" :id = "gid+'_dislike'">
          <i class="material-icons" :class = "[dislike_icon, {'knocks_active_reaction infinite rubberBand':selected == 'dislike'}]"></i>
        </a>
      </li>
      <li>
        <a  @click="assign('love')"  class="knocks_reaction_btn btn-floating  pink lighten-5" :class="[{'pulse':selected == 'love'}]" :id = "gid+'_love'">
          <i class="material-icons" :class = "[love_icon, {'knocks_active_reaction infinite rubberBand':selected == 'love'}]"></i>
        </a>
      </li>
      <li>
        <a  @click="assign('laugh')"  class="knocks_reaction_btn btn-floating red" :class="[{'pulse':selected == 'laugh'}]"   :id = "gid+'_laugh'">
          <i class="material-icons" :class = "[laughing_icon, {'knocks_active_reaction infinite rubberBand':selected == 'laugh'}]"></i>
        </a>
      </li>
      <li v-if = "!candy && !authModel.kid">
        <a  @click="assign('poker')"  class="knocks_reaction_btn btn-floating deep-purple darken-1" :class="[{'pulse':selected == 'poker'}]"   :id = "gid+'_poker'">
          <i class="material-icons" :class = "[poker_icon, {'knocks_active_reaction infinite rubberBand':selected == 'poker'}]"></i>
        </a>
      </li>
      <li v-if = "!candy && !authModel.kid">
        <a  @click="assign('angry')"  class="knocks_reaction_btn btn-floating blue-grey darken-3" :class="[{'pulse':selected == 'angry'}]"  :id = "gid+'_angry'">
          <i class="material-icons" :class = "[angry_icon, {'knocks_active_reaction infinite rubberBand':selected == 'angry'}]"></i>
        </a>
      </li>
      <li v-if = "!candy && !authModel.kid">
        <a  @click="assign('sad')"  class="knocks_reaction_btn btn-floating  light-blue darken-4" :class="[{'pulse':selected == 'sad'}]"  :id = "gid+'_sad'">
          <i class="material-icons" :class = "[sad_icon, {'knocks_active_reaction infinite rubberBand':selected == 'sad'}]"></i>
        </a>
      </li>
      <li v-if = "!candy && !authModel.kid">
        <a  @click="assign('finger')"  class="knocks_reaction_btn btn-floating red darken-4" :class="[{'pulse':selected == 'finger'}]"  :id = "gid+'_finger'">
          <i class="material-icons" :class = "[middlefinger_icon, {'knocks_active_reaction infinite rubberBand':selected == 'finger'}]"></i>
        </a>
      </li>
    </ul>
  </div>
</div>
</template>

<script>
export default {

  name: 'knocksreactor',
  props : {
    gid : {
      type : String ,
      required : true ,
    },
    object_id : {
      type : Number ,
      required : true
    },
    parent_id : {
      type : Number ,
      required : true
    },
    parent_type : {
      type : String ,
      required : true
    },
    initial_class : {
      type : String,
      default : 'btn btn-floating knocks_reaction_trigger  knocks_btn_color_kit knocks_color_kit'
    },
    collapser_icon : {
       type : String ,
       default : 'knocks-like knocks_text_dark knocks_text_anchor'
    },
    like_icon : {
      type : String ,
       default : 'knocks-thumb-up2'
    } ,
    dislike_icon : {
      type : String ,
       default : 'knocks-thumb-down2'
    } ,
    love_icon : {
      type : String ,
       default : 'knocks-heart8 red-text'
    } ,
    poker_icon : {
      type : String ,
       default : 'knocks-neutral-face2 lime-text accent-1'
    } ,
    laughing_icon : {
      type : String ,
       default : 'knocks-laughing-face4  yellow-text'
    } ,
    angry_icon : {
      type : String ,
       default : 'knocks-stubborn-face2 orange-text'
    } ,
    sad_icon : {
      type : String ,
       default : 'knocks-sad-face-eyebrows2 yellow-text lighten-5'
    } ,
    middlefinger_icon : {
      type : String ,
       default : 'knocks-middle-finger2 yellow-text darken-2'
    },
    knocks_reactor_ul : {
      type : String ,
      default : 'knocks_reactor_ul'
    },
    inverse : {
      type : Boolean ,
      default : true
    },
    candy : {
      type : Boolean , 
      type : false ,
    }
  },
  mounted(){

    //Search db
    const vm = this;
    axios({
    method:'post',
    url: LaravelOrgin +'checkinit_reaction/reaction',
    data :{'object_id' : vm.object_id}
    })
    .then(function(response) {

      //vm.assign(response.data.type);
      vm.selected = response.data;


    });



    $('.knocks_reaction_btn').hover( function(){
      $(this).removeClass('animated jello').addClass('animated swing');
      $($(this).find('i')).removeClass('animated jello').addClass('animated rubberBand');
    });
    $('.knocks_reaction_btn ').mouseleave( function(){
      $(this).removeClass('animated swing').addClass('animated jello');
      $($(this).find('i')).removeClass('animated rubberBand').addClass('animated jello');
    });
    $('.knocks_reactor_container').click(function(){

      if(!$(this).hasClass('active')){
          let top = $(this).offset().top;
          let height = $(this).height();
        //$('html , body').animate({ scrollTop : (   (top  - $(window).height()) + height + 10 )} , 1000);
        $($(this).find('a > i') ).addClass('animated rotateIn');
        $($(this).find('.knocks_reactor_target_ul')).addClass('animated bounceInUp');
        setTimeout(()=>{  $($(this).find('a > i')).removeClass('animated rotateIn'); } , 800);
      }else{
        $($(this).find('.knocks_reactor_target_ul')).removeClass('animated bounceInUp jello');
      }
    });
    $('.knocks_reactor_container').hover(function(){
      // $($('body').find('.knocks_reactor_container')).hide(); $(this).show();
      const btn = this;
      if(!$(this).hasClass('active')){
          let top = $(this).offset().top;
          let height = $(this).height();
          console.log(height);
        //$('html , body').animate({ scrollTop : (   (top  - $(window).height()) + height + 10 )} , 1000);
        //setTimeout( ()=>{$(btn).openFAB();} , 100);
        $($(this).find('a > i') ).addClass('animated rotateIn');
        $($(this).find('.knocks_reactor_target_ul')).addClass('animated ');
        setTimeout(()=>{  $($(this).find('a > i')).removeClass('animated rotateIn'); } , 800);
      }else{
        $($(this).find('.knocks_reactor_target_ul')).removeClass('animated  ');
      }
    });
    $('.knocks_reactor_container ').hover( function(){

      $( $(this).find('i') ).removeClass('animated rubberBand').addClass('animated ');
    });
    $('.knocks_reactor_container ').mouseleave( function(){
       $($('body').find('.knocks_reactor_container')).show();
      $( $(this).find('i') ).removeClass('animated jello').addClass('animated ');
    });

  },
  data () {
    return {
      selected : null ,
      timer : 0 ,
      interval : null , 
      auth : parseInt(UserId) , 
      authModel : null , 
    }
  },
  computed : {
    intialReactor(){
      if(this.selected == null){
        return this.collapser_icon;
      }else{
        if(this.selected == 'like'){
          return this.like_icon+' animated rubberBand infinite';
        }else if(this.selected == 'dislike'){
          return this.dislike_icon+' animated rubberBand infinite';
        }else if(this.selected == 'love'){
          return this.love_icon+' animated rubberBand infinite';
        }else if(this.selected == 'laugh'){
          return this.laughing_icon+' animated rubberBand infinite';
        }else if(this.selected == 'poker'){
          return this.poker_icon+' animated rubberBand infinite';
        }else if(this.selected == 'angry'){
          return this.angry_icon+' animated rubberBand infinite';
        }else if(this.selected == 'sad'){
          return this.sad_icon+' animated rubberBand infinite';
        }else if(this.selected == 'finger'){
          return this.middlefinger_icon+' animated rubberBand infinite';
        }
      }
    } ,
    intialButton(){
      if(this.selected == null){
        return this.initial_class;
      }else{
        if(this.selected == 'like'){
          return 'pink darken-1';
        }else if(this.selected == 'dislike'){
          return 'purple lighten-1';
        }else if(this.selected == 'love'){
          return 'pink lighten-5';
        }else if(this.selected == 'laugh'){
          return 'red darken-4';
        }else if(this.selected == 'poker'){
          return 'deep-purple darken-1';
        }else if(this.selected == 'angry'){
          return 'blue-grey darken-3';
        }else if(this.selected == 'sad'){
          return 'light-blue darken-4';
        }else if(this.selected == 'finger'){
          return 'red darken-4';
        }
      }
    }
  },
  methods : {
    assign(value){
      const vm = this;
      if(this.selected == value){
        this.selected = null;
        this.reactPlay();
        this.delete();

      }else{
        this.selected = value ;
        this.disreactPlay();
        this.insert();
      }
      this.$emit('input', this.selected);
    },
      insert() {

  const vm = this;

  axios({
    method:'post',
    url: LaravelOrgin +'insert_reaction/reaction',
    data :{'object_id' : vm.object_id , 'type' : vm.selected , 'parent_id' : vm.parent_id ,'parent_type' : vm.parent_type }
  })
  .then(function(response) {
console.log("inserted");

    });
  },

delete() {

const vm = this;

axios({
method:'post',
url: LaravelOrgin +'delete_reaction/reaction',
data :{'object_id' : vm.object_id}
})
.then(function(response) {
console.log("deleted");

});
},

    resetORLike(){
      if(this.selected != null){
       this.selected = null;
       this.delete();
       this.$emit('input' , this.selected);
       this.reactPlay();
      } else {
        this.selected = 'like';
        this.disreactPlay();
        this.insert();
        this.$emit('input' , this.selected);
      }
    },
    beginTimer(){
      const vm  = this;
      this.timer = 0;
      this.interval = setInterval( ()=>{
        vm.timer += 100;
      } ,100);
    },
    checkTimer(){
      clearInterval(this.interval);
      if(this.timer > 300){
        this.resetORLike();
      }
    },
    reactPlay(){
      let soundTrack = document.getElementById('knocks_react_vid_src');
      soundTrack.volume = 0.2;
      soundTrack.play();
      //setTimeout( ()=>{ soundTrack.pause(); } ,500);
    } ,
    disreactPlay(){
      let soundTrack = document.getElementById('knocks_disreact_vid_src');
      soundTrack.volume = 0.2;
      soundTrack.play();
      //setTimeout( ()=>{ soundTrack.pause(); } ,500);
    }
  }
}
</script>