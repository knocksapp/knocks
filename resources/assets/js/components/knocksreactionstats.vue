<template>
<div class=" knocks-border-reactionstats  knocks_house_keeper knocks_icon_reaction_states col s12 "   :class = "bar_classes" :id = "gid">
  
  <!-- <div class="row">
    <div class="col s12">
      <ul class="tabs">
        <div v-if="total > 0" v-for="(emj,index) in orderedemojiadv" >
          <li class="tab col s3 active " :class="emj"></li>
        </div>
      </ul>
    </div>
    <div v-if="total > 0" v-for="(emj,index) in orderedemojiadv" >
      <div v-for="eachuser in usersadv[index]">
      </div>
      <div class="col s12">{{eachuser}} </div>
    </div>
  </div> -->

  <div class=" knocks_reaction_tab stars">

    <div class="col s12 knocks_house_keeper" >
       <div class = "col l9 s8 knocks_house_keeper">
        <knockspopover v-if = "formNowDate != 'Invalid date' " class = "">
        <span slot = "container" style="padding-left : 0px !important; margin-left:0px;" >
          <span 
          class = "knocks_language_default_font knocks_text_sm    knocks_text_dark">
        <span class = "knocks-clock10  hide-on-small-only"></span> {{ formNowDate }}</span>
        </span>
        <span slot = "content"  class = "knocks_tooltip animated flipInX" >
        <span class = "knocks-calendar10"></span>
        <span class = "knocks_language_default_font">{{detailsDate}}</span>
      </span>
      </knockspopover>
      <knockspopover v-if = "formNowDate != 'Invalid date' ">
      <span slot = "container" >
      <span v-if = "total > 0" style = "margin-top:5px;" class = " uk-badge knocks_color_kit knocks_language_default_font">
      {{ totalDisplay(total) }}</span>
    </span>
    <span slot = "content"  class = "knocks_tooltip animated flipInX" >
        <span class = "knocks-knocks-circle-fill"></span>
        <span class = "knocks_language_default_font">{{total}}</span>
        <static_message msg = "Reaction" v-if = "total == 1"></static_message>
        <static_message msg = "Reactions" v-if = "total > 1"></static_message>
      </span>
      </knockspopover>
      <!-- <li class="tab col s14 " :class ="emj" @click="getusers(emj)"> -->
      <span class=" " @click="getusers(emj)" v-for="(emj,index) in orderedemojiadv" 
        :style = "{'z-index' : 20 + orderedemojiadv.length - index}">
        <!-- <el-badge :value="usersadv[index].length" class="item badge-font "> -->
        <knockspopover >
          <template slot = "container">
            <div  class = "btn btn-floating knocks_btn_floating_ssm knocks_reaction_state_btn modal-trigger" :class = "[emj,{'knocks_left_override':index > 0}]"  style="border:1px solid pink !important; margin-top:5px" 
             :href="'#'+gid+'_modal'" @click="doMotion()">
              <span  class="icons" ></span>
             </div>
          </template>
          <span slot = "content"  class = "knocks_tooltip animated flipInX" >
        <span :class = "emj"></span>
        <span class = "knocks_language_default_font" >{{usersadv[index].length}}</span>
      </span>
        </knockspopover>
        <!-- </el-badge> -->
      </span>
   
       </div>
        <div class = "col l3 s4 right knocks_house_keeper">
         <knocksreactor 
         :candy = "candy"
         :inverse = "inverse_reactor"
         @input = "showInterest()"
         :knocks_reactor_ul = "knocks_reactor_ul"
         :collapser_icon = "reactor_collapser_icon"
         :initial_class = "reactor_initial_class"
         :gid="gid+'_reactor'" class="right knocks_side_padding" :object_id ="object_id" :parent_id = "object_id" parent_type="post"></knocksreactor>
          <knockspopover v-if = "replyState" >
          <template slot = "container">
           <button v-if = "replyState"  @click = "hideReplyer()" :class = "reply_initial_class">
            <span class = "knocks-chevron-thin-up animated zoomIn" ></span>
          </button>
         </template>
          <span slot = "content"  class = "knocks_tooltip animated flipInX" style="margin-top:0.8rem !important;" v-if = "replyState">
             <span class = "knocks-chevron-thin-up animated zoomIn" ></span>
             <static_message msg = "Toggle Replier" classes="knocks_language_default_font"></static_message>
          </span>
        </knockspopover>
         <knockspopover >
          <template slot = "container" v-if="!replyState">
            <button v-if="!replyState" @click = "triggerReplyer()" :class = "reply_initial_class">
              <span class = "knocks-chat-2 animated rubberBand" ></span>
            </button>
          </template>
           <span slot = "content"  class = "knocks_tooltip animated flipInX" style="margin-top:0.8rem !important;" v-if = "!replyState">
             <span class = "knocks-chat-2 animated zoomIn" ></span>
             <static_message msg = "Toggle Replier" classes="knocks_language_default_font"></static_message>
          </span>
        </knockspopover>
       </div>
      
    </div>
    <div >



    </div>
  </div>
      <div :id="gid+'_modal'" class="modal knocks_modal">
    <div class="modal-content">
      <p class = "knocks_text_dark knocks_language_default_font">People Reactions</p>
       <div class="col s12" >
      <!-- <li class="tab col s14 " :class ="emj" @click="getusers(emj)"> -->
      <span class="knocks_fair_bounds " @click="getusers(emj)" v-for="(emj,index) in orderedemojiadv">
        <el-badge :value="usersadv[index].length" class="item badge-font">
        <div  class = "btn btn-floating knocks_reaction_state_btn" :class = "emj"  @click="doMotion()">
          <span v-if="total > 0"  class="icons" ></span>
        </div>
        </el-badge>
      </span>
    </div>
        <transition
        name="custom-classes-transition"
        enter-active-class="animated zoomIn"
        leave-active-class="animated zoomOut"
        >
        <div v-if="current.length >0" class = "col s12 dive knocks_color_kit_light_active">
          <div class="pos" >
            <div v-for="user in current" class="user"  >
              <knocksuser :user = "user" as_chip class = "animated lightSpeedIn col s11 knocks_language_default_font">
              
              </knocksuser>
              <div class = "col s1">
                <a  @click="cls()"><span class="knocks_text_dark knocks-close red-text right"></span></a>
              </div>
            </div>
          </div>
        </div>
      </transition>

      
    </div>
    <div class="">
      <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat knocks_language_default_font">Agree</a>
    </div>
  </div>
</div>
<!-- <div v-if="total > 0" v-for="(emj,index) in orderedemojiadv" >
  <span :class ="emj"  >
    <span  v-for="eachuser in usersadv[index]">
      {{eachuser}}
    </span>
  </span>
</div> -->
</template>
<script>
export default {

  name: 'knocksreactionstats',

  props : {
    gid : {
      type : String ,
      required : true ,
    },
    object_id : {
      type : Number ,
      required : true
    },
    bar_classes : {
      type : String , 
      default : 'knocks_color_kit_light_active'
    },
    reply_scope : {
      type : Array , 
      default : null
    },
    parent_type : {
      type : String ,
      default : 'comment'
    },
    show_reply_on_mount : {
      type : Boolean , 
      default : true
    },
    toggle_same_repliers : {
      type : Boolean , 
      default : false 
    },
    reactor_initial_class : {
      type : String,
      default : 'btn btn-floating knocks_reaction_trigger  knocks_btn_color_kit knocks_color_kit'
    },
    reply_initial_class : {
      type : String,
      default : 'btn btn-floating right knocks_side_padding knocks_color_kit knocks_btn_color_kit'
    },
    reactor_collapser_icon : {
       type : String ,
       default : 'knocks-like'
    },
    knocks_reactor_ul : {
      type : String ,
      default : 'knocks_reactor_ul'
    },
    parent_date : {
      type : String , 
      default  : ''
    },
    owner_id : {
      type : Number , 
      default : null
    } , 
    owner_object : {
      type : Object , 
      default : null
    } , 
    mention_on_reply : {
      type : Boolean , 
      default : false 
    },
    toggle_object_id : {
      type : Number , 
      default : null ,
    },
    inverse_reactor : {
      type : Boolean ,
      default : true ,
    },
    candy : {
      type : Boolean , 
      default : false , 
    }

  },

  mounted(){

    //this.time = moment(this.parent_date , 'YYYY-MM-DD hh:mm:ss').format('YYYY-MM-DD hh:mm:s');
    this.time = this.parent_date.substring(0,18);
    this.timer();
    this.replyState = this.show_reply_on_mount;
    $('.modal').modal();
    $('.knocks_reaction_state_btn').click(function(){
        $('.knocks_reaction_state_btn').removeClass('animated rubberBand infinite');
      $(this).addClass('animated rubberBand infinite');
    });
    const vm = this;
    $(window).resize(function(){
      vm.windowWidth = $(window).width();
    });


    App.$on('knocksReplyState' , (payloads)=>{
      if(payloads.type == vm.parent_type && payloads.scope != vm.reply_scope && payloads.relatives){
        vm.replyState = false;
      } 
      if(payloads.type == vm.parent_type && payloads.scope[0] == vm.reply_scope[0]){
        vm.replyState = false;
      }

    });

    //Search db
    this.retriveReactions();

    App.$on('knocksShowInterest' , (payloads)=>{
      if(vm.interest) return;
      if(payloads.objectId == vm.object_id && payloads.parentType == vm.parent_type){
        vm.interest = true;
        vm.retriveReactions();
      }else return;
    });


  },
  computed:{
    formNowDate(){
    
      return this.time == null ? '' : moment(this.time).fromNow();
    },
    formNowDateSpliced(){
      return this.requireSplicing ? this.formNowDate.substring(0,5)+'..' : this.formNowDate;
    },

    requireSplicing(){
      return this.formNowDate.length > 4 && this.windowWidth < 800 ? true : false ;
    },
    detailsDate(){

      return  this.time == null ? '' : moment(this.time).format('MMMM Do YYYY, h:mm a');
    },
    formattedDate(){
      return moment.tz( this.time , moment.tz.guess() ).format('YYYY-MM-DD')
    }
  },

  data () {
    return {
      results :[],
      orderedemoji:[],
      orderedcount:[],
      orderedemojiadv:[],
      orderedcountadv:[],
      sad : null ,
      angry : null,
      like : null ,
      dislike : null,
      love : null ,
      poker : null,
      laugh : null,
      finger : null,
      total : 0,
      hoveron :1,
      sadusers : [],
      angryusers : [],
      likeusers : [],
      dislikeusers :[],
      loveusers :[],
      pokerusers : [],
      laughusers :[],
      fingerusers :[],
      users : [],
      usersadv :[],
      current:[],
      replyState : false ,
      time : null ,
      windowWidth : WindowWidth,
      interest : false ,
    
    }
  },
  methods :{

    retriveReactions(){
      const vm = this;
          axios({
    method:'post',
    url: LaravelOrgin +'getstats_reaction/reaction',
    data :{'object_id' : vm.object_id}
    })
    .then(function(response) {
      vm.results =[];
      vm.orderedemoji=[];
      vm.orderedcount=[];
      vm.orderedemojiadv=[];
      vm.orderedcountadv=[];

        vm.results = response.data;
        vm.sad = response.data.sad;
        vm.angry = response.data.angry;
        vm.like = response.data.like;
        vm.dislike = response.data.dislike;
        vm.love = response.data.love;
        vm.poker = response.data.poker;
        vm.laugh = response.data.laugh;
        vm.finger = response.data.finger;

        vm.sadusers = response.data.sadusers;
        vm.angryusers = response.data.angryusers;
        vm.likeusers = response.data.likeusers;
        vm.dislikeusers = response.data.dislikeusers;
        vm.loveusers = response.data.loveusers;
        vm.pokerusers = response.data.pokerusers;
        vm.laughusers = response.data.laughusers;
        vm.fingerusers = response.data.fingerusers;

        vm.total = vm.sad + vm.angry + vm.like + vm.dislike + vm.love + vm.poker + vm.laugh + vm.finger ;

        vm.orderedemoji=["knocks-thumb-up2 knocks_icon_reaction_states pink white-text darken-1" ,
        "knocks-thumb-down2 knocks_icon_reaction_states pink lighten-5s",
        "knocks-sad-face-eyebrows2 yellow-text  knocks_icon_reaction_states light-blue darken-4" ,
        "knocks-stubborn-face2 orange-text knocks_icon_reaction_states darken-3s blue-grey" ,
        "knocks-heart8 ed-text knocks_icon_reaction_states pink lighten-5 red-text" ,
        "knocks-neutral-face2 lime-text accent-1 knocks_icon_reaction_states deep-purple darken-1" ,
        "knocks-laughing-face4 yellow-text red knocks_icon_reaction_states" ,
        "knocks-middle-finger2 yellow-text darken-2 knocks_icon_reaction_states red darken-4"];
        vm.users = [vm.likeusers,vm.dislikeusers,vm.sadusers,vm.angryusers,vm.loveusers,vm.pokerusers,
        vm.laughusers,vm.fingerusers];

        vm.orderedcount=[vm.like , vm.dislike , vm.sad , vm.angry , vm.love , vm.poker , vm.laugh , vm.finger];

        var length = vm.orderedcount.length;
          for (var i = (length - 1); i >= 0; i--) {
          for (var j = (length - i); j > 0; j--) {
              if ( vm.orderedcount[j] > vm.orderedcount[j - 1]) {

                  var tmp1 = vm.orderedemoji[j];
                  var tmp2 = vm.orderedcount[j];
                  var tmp3 = vm.users[j];
                  vm.orderedemoji[j] = vm.orderedemoji[j - 1];
                  vm.orderedcount[j] = vm.orderedcount[j - 1];
                  vm.users[j]        = vm.users[j - 1];
                  vm.orderedemoji[j - 1] = tmp1;
                  vm.orderedcount[j - 1] = tmp2;
                  vm.users[j - 1] = tmp3;
              }
          }
      }

      for (var i =0 ; i <= (length - 1); i++)
      {
        if((vm.orderedcount[i] > 0))
        {
          vm.orderedcountadv.push(vm.orderedcount[i]);
          vm.orderedemojiadv.push(vm.orderedemoji[i]);
          vm.usersadv.push(vm.users[i]);
        }
      }
      setTimeout( ()=>{ if(vm.interest) vm.retriveReactions()} ,5000);
    });
    },
    showInterest(){
      if(this.interest) return;
      App.$emit('knocksShowInterest' , { objectId : this.object_id , parentType : this.parent_type });
      if(this.toggle_object_id != null && this.object_id != this.toggle_object_id)
        App.$emit('knocksShowInterest' , { objectId : this.toggle_object_id , parentType : this.parent_type });
    },
    emojidetailson(){
        $($(document).find('.salma')).removeClass('default-margin').addClass('hoverd-reactions');
        this.hoveron = 1;
    },
    emojidetailsoff(){
        $($(document).find('.salma')).removeClass('hoverd-reactions').addClass('default-margin');
        this.hoveron = 0;
    },
    getusers(emj)
    {
      this.current = [];
      setTimeout(  ()=>{
        for(var i = 0 ; i < this.orderedemoji.length ; i++)
        {
          if(emj == this.orderedemoji[i])
          {
            this.current = this.users[i];
          }
        }
      }, 300);



    },
    doMotion()
    {
      $('.knocks_reaction_state_btn').click(function(){
          $('.knocks_reaction_state_btn').removeClass('animated rubberBand infinite');
        $(this).addClass('animated rubberBand infinite');
      });

    $($(document).find('.btn btn-floating')).addClass(' animated pulse');

    },
    cls(){
      const vm = this;
      
        vm.current = [];
    
    },
    totalDisplay(total){
      return total > 1000 ? parseInt(total/1000)+'K' : total; 
    },
    timer(){
      let offset = new Date().getTimezoneOffset();
      this.time = moment(this.parent_date).subtract(offset ,'m');
      setInterval( ()=>{this.time = ''; 
        let offset = new Date().getTimezoneOffset();
        this.time = moment(this.parent_date).subtract(offset ,'m');
       }
          , 5000);
    },
    triggerReplyer(){
      this.showInterest();
      App.$emit('knocksReplyState' , 
        { scope : this.reply_scope[0] , state : true  , type : this.parent_type , relatives: this.toggle_same_repliers}
        );
      this.replyState  = true ;
      if(this.mention_on_reply && this.owner_id != null){
         App.$emit('KnocksReplyMention' , 
        { scope : this.reply_scope[0] , state : true  , type : this.parent_type ,user : this.owner_id , userObject : this.owner_object}
        );
      }
    },
    hideReplyer(){
      App.$emit('knocksReplyState' ,
        { scope : this.reply_scope[0] , state : false  , type : this.parent_type , relatives: this.toggle_same_repliers}
        );
      this.replyState  = false ;
    }
//     showusers(emj){
//
//     const vm = this;
//
//       for(var i = 0 ; i< vm.orderedemoji.length ; i++){
//         if(emj == vm.orderedemoji[i])
//             vm.reactionusers = vm.users[i];
//       }
// }
    }

}


</script>
<style>
.knocks-border-reactionstats
{
  border: 0px solid  !important;
  //padding-right: 100px !important;
  border-radius: 4px !important;

}
.knocks_icon_reaction_states
{
  font-size: 15px;
  color: #691a40;
  border : 1px solid transparent !important;
  border-radius: 10px;


}
.knocks_icon_reaction_states{
  color: black;
  border-radius: 15px !important;
  display: inline-block !important;
  /*padding-right: 20px !important;*/
}
.bk
{
    background-color: #fff3e0 !important;
}
.number
{

  font-size: 30%!important;
  font-family: titillium;
  border-radius: 40%;
  background-color: white;
  font-weight: 600 !important;
  color: black !important;
}
.total
{
    font-size: 20px !important;
    color: #1a237e !important;
    font-family: titillium;
}
.hoverd-reactions
{
    //margin-right: 30px !important;
}
.default-margin
{
    //margin-right: -15px !important;
}
.showing{
  background-color: white !important;
  border-radius: 16px !important;
  background-color: lightgrey;
  border-style: solid;
  border-width: 5px;
}
.icons{
  //margin-left: 40px !important;
}
.dive{
//border: 1px solid #691a40;
//margin: 1%;
//border-radius: 16px !important;
//margin-left: 10px !important;
margin-top: 1% !important;
border-radius: 15px;
padding: 2% !important;
/*width : 100% !important;*/


}
.user{
  /*font-size: 30px !important;*/
  color: #1a237e !important;
  /*font-family: titillium ;*/
}
.knocks_reaction_bar{
  //margin: 5%;
}
.knocks_reaction_tab{
  //margin-top: 10%;
}
.badge-font{
  font-family: titillium;
}
.pos{
  //padding: 10px !important;
}
.bk{
     color :  red;
     background-color: transparent !important;
}
</style>
