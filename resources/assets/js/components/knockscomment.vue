<template>
<div class = "panel   knocks" v-if = "isLoading || knockObject != null " >

   <transition    name="custom-classes-transition"  enter-active-class="animated fadeIn" leave-active-class="animated fadeOut"> 
    <center><knocksloader :gid= "gid+'_knock_loading_span'" v-if = "knockObject == null" ></knocksloader></center>  
   </transition>

  <div v-if = "knockObject != null && !as_shortcut"  >
    <div v-if = "knock_type == 'normal' " class=" panel pink lighten-4">
      <knocksuser :user="knockObject.user_id" main_container = "col s2" show_image>
      </knocksuser>
      <div class="knocks_text_dark content" :id = "gid"></div>
      <a  class="rdmore right" @click="rd();" :id = "gid+'_readmore'" href="javascript:void(0);">See more</a>
      <p class="right knocks_text_dark">{{knockObject.time}}</p>
    </div>

   <transition    name="custom-classes-transition"  enter-active-class="animated fadeIn" leave-active-class="animated fadeOut"> 
    <div v-if=" knockObject != null && knock_type == 'voice_note'" class="">
<!--       <div   class="col s12  knocks_house_keeper" style="max-height:20px;"
       v-if = "!expiry() || knockObject.exceptions || knockObject.index.check_in != null"
      >
        <a class="knocks_text_dark" :href="address_url" v-if="knockObject.index.check_in != null">
          <p class="right  knocks_text_ms opcty"> <i class="knocks_text_dark knocks-location3 opcty"></i>
            Near, {{knockObject.index.check_in.address_components[0].long_name}}
          </p>
        </a>
   
        <span v-if="!expiry()" class="new knocks_tinny_badge badge right" ></span>
        <span v-if="knockObject.exceptions" class="badge sec right knocks_tinny_badge" data-badge-caption="Secured"><i class="knocks-eye-off"></i></span>
      </div> -->
      <div class = "row knocks_house_keeper">
      <div class="col knocks_house user"style = "width: 33px">
        <div class=" ">
          <!-- <center> -->
          <knocksuser  
          :user="knockObject.user_id" 
          main_container = " "
          hide_text_info
          v-model = "ownerObject"
          knocks_avatar_classes = "knocks_tinny_avatar"
          show_image></knocksuser><!-- </center>
 -->        </div>   
      </div>
      <div class="col  cnt row  knocks_light_color_kit knocks_gray_border knocks_house_keeper" style="max-width : calc(100% - 50px); margin-left: 15px !important;">
       
        <div class="col s12  ">
          <span class = "knocks_content_padding">
          <a v-if = "ownerObject != null"  class="knocks_inline left  knocks_side_padding  " :href = "asset(ownerObject.username)">{{ownerObject.name}}</a>
          <span  style = "margin-top: auto" 
           @dblclick = "flowtext()"
           class="knocks_text_dark content  col" :id = "gid"></span>
         </span>
        </div>
        <div class="row knocks_house_keeper" v-if="bodyLen > 350" ><div v-if="bodyLen > 350" class="top"><a class="rdmore right" @click="rd();" href="javascript:void(0);" :id = "gid+'_readmore'">See more</a></div>
      </div>
      <div class="voice_pad knocks_house_keeper"   v-if = "knockObject.index.has_voices">
        <!--       <knocksplayer class="voice col s8" gid="noded" live :specifications = "{id : 1}" fill_from="vn/blob" meta = "vn/meta" :load_on_mount="false" :show_volume="true" v-if="knockObject.index.has_voices" :show_options="false"></knocksplayer> -->
        <knocksplayer
        :gid="gid+'_player'"
        initial_class ="btn btn-floating knocks_super_tiny_floating_btn knocks_color_kit knocks_btn_color_kit right"
        main_container = "row knocks_house_keeper"
        class="voice col s12 knocks_content_padding" style = "padding-bottom : 2px"
        :show_volume="true"
        buttons_container = "col knocks_house_keeper"
        :show_options="false"
        :specifications = "{id : knockObject.index.voices_specifications , user : current_user , object : knockObject.object_id }"
        full_back_loading
        :load_on_mount="false"></knocksplayer>
        
      </div>
      <!-- <a class=" knocks_text_dark lens right" @click="flowtext()" href="#!"  ><i :id="gid+'_lns'" class="knocks-zoomin3 knocks_text_md lensm" @mouseover="lensHover()" @mouseleave="lensLeave()"></i></a> -->
    </div>
  </div>
    <div class = "row" v-if = "knockObject.index.has_pictures">

              <knocksimageviewer :gid = "gid+'_image_viewer_comment_'+knock"
            :sources = 'knockObject.index.images_specifications'
            :object_id = "knockObject.object_id"
            :user_id = "current_user"
            :created_at = "knockObject.created_at"
            :owner_object = "ownerObject"
            :knock_id = "knock"
            :owner_id = "knockObject.user_id"></knocksimageviewer>
    </div>
    
    <div class="row knocks_house_keeper" style="padding-right : 5px !important; padding-left : 5px !important;">
<!--       <span class="right knocks_text_dark since"> {{knockObject.time}} </span>
      <span class="left knocks_text_dark since"> {{knockObject.timedate}} </span> -->
    <knocksreactionstats 
    knocks_reactor_ul = "knocks_tinny_reactor_ul"
    toggle_same_repliers
    reactor_collapser_icon = "knocks_text_ms knocks-like knocks_dark_anchor"
    reply_initial_class = "btn btn-floating knocks_super_tiny_floating_btn right knocks_side_padding knocks_noshadow_ps  knocks_text_dark transparent"
    reactor_initial_class = "btn btn-floating knocks_reaction_trigger knocks_super_tiny_floating_btn knocks_noshadow_ps knocks_text_dark transparent"
    bar_classes ="transparent" 
    :parent_date = "knockObject.created_at"
    :reply_scope="[ gid + '_reply_scope']"
    parent_type = "comment" 
    :show_reply_on_mount = "show_reply_on_mount"
    :gid = "gid+'_reaction_stats'" 
    :toggle_object_id = "knockObject.object_id"
    :object_id = "knockObject.object_id">
    </knocksreactionstats>

<!--       <knocksreactionstats
      knocks_reactor_ul = "knocks_tinny_reactor_ul"
      reactor_collapser_icon = "knocks_text_ms knocks-like"
      reply_initial_class = "btn btn-floating knocks_super_tiny_floating_btn right knocks_side_padding knocks_color_kit knocks_btn_color_kit"
      reactor_initial_class = "btn btn-floating knocks_reaction_trigger knocks_super_tiny_floating_btn  knocks_btn_color_kit knocks_color_kit"
      bar_classes ="knocks_color_kit_light" 
      :gid = "gid+'_reaction_stats'" 
      :reply_scope="[ gid + '_reply_scope']"
      parent_type = "comment"
      toggle_same_repliers
      :show_reply_on_mount = "false"
      :parent_date = "knockObject.created_at"
      :object_id = "knockObject.object_id"></knocksreactionstats> -->
           <knocksreply
    replier_message = "Reply here"
    :scope= "[ gid + '_reply_scope']"
    :error_at="[]"
    :parent_id = "knockObject.id"
    :object_id = "knockObject.object_id"
    submit_at = "reply/create"
    :recorder_upload_data = "{ user : current_user , index : {}}"
    :player_show_options = "false"
    :show_on_mount = "show_reply_on_mount"
    :post_at = "current_user"
    parent_type = "comment"
    success_at = "done"
    success_msg = "yess"
    toggle_parent_type = "comment"


    :gid = "gid+'_reply'"></knocksreply>
    </div>


   <div class = "knocks_light_color_kit row  knocks_standard_border_radius" 
   style=" width : 95%; float : right; margin-right : 5px !important; margin-bottom: 4px;" v-if ="comments != null && comments.length > 0">
     <div class = "row knocks_house_keeper">
     <a v-if = "comments != null && showKey < comments.length && showKey != 0" @click = "increaseRang()" 
     class = "  knocks_side_padding knocks_text_sm knocks_text_anchor knocks_pointer" style = "margin-left:2px;">
       <span class = "knocks-chat-2"></span> See Older Replies
     </a>
     <a v-if = "comments != null && showKey < comments.length && showKey == 0" @click = "increaseRang()" 
     class = "knocks_side_padding knocks_text_sm knocks_text_anchor knocks_pointer" style = "margin-left:2px;">
       <span class = "knocks-chat-2"></span> Show Replies
     </a>
     <span class = "grey-text right knocks_text_sm knocks_side_padding" v-if = "comments != null && comments.length > 0">
     {{showKey+'/'+comments.length}} Replies</span>
     </div>
     <div class="" v-for = "(com , index) in comments"  v-if = "comments != null && comments.length > 0" > 
     <knockschildreply 
     v-if="inRange(index)" 
     :gid= "gid+'_comment_'+index"
     :knock="com" 
     :parent_comment = "knockObject.id"
     :parent_object_id = "knockObject.object_id"
     parent_type = "comment"
     :current_user="current_user" 
     replier_message = "Reply here" ></knockschildreply>
   </div>
   <div class = "row knocks_house_keeper" v-if = "comments != null && showKey != 0">
     <a v-if = "comments != null && showKey > 1" @click = "reduceRang()" 
     class = "knocks_tinny_padding knocks_text_sm  col knocks_text_anchor knocks_pointer" style = "margin-left:2px;">
       <span class = "knocks-chat-1"></span> See Less Replies
   </a>
   <a v-if = "comments != null && showKey != 0" @click = "showKey = 0" 
     class = "knocks_tinny_padding knocks_text_sm col knocks_text_anchor knocks_pointer" style = "margin-left:2px;">
       <span class = "knocks-chat-1"></span> Hide Replies
   </a>
   </div>
 </div>

   
  </div>
</transition>
  
  <!-- <div class="row" v-for = "(com , index) in knockObject.comments" v-if="knockObject.comments.length > 0">
    <knockschildreply  :gid= "gid+'_comment_'+index":comment="com" :current_user="current_user" parent_type = "comment"></knockschildreply>
  </div> -->
</div>
<div v-if = "knockObject != null && as_shortcut">
        <div class = "row knocks_house_keeper">
      <div class=" knocks_house user">
        <div class=" ">
          <!-- <center> -->
            <knocksuser
            class = "knocks_house_keeper"
hide_popover
           v-model = "ownerObject"
           image_container_class = "knocks_inline" 
           name_container_class = " knocks_inline"
           main_container = "row knocks_house_keeper"
          :user="knockObject.user_id" show_image>
            <template slot = "append_to_display_name" class = "" >

            </template>
          </knocksuser>
      </div>   
      </div>
      <div class="cnt row  knocks_house_keeper" style="border-radius :0px !important; border-bottom: 1px solid #ccc; background-color:rgba(192,192,192,0.1);" >
       
        <div class="row knocks_house_keeper  ">
          <span class = "">
          <span  
           @dblclick = "flowtext()"
           class="knocks_text_dark content " :id = "gid"></span>
         </span>
        </div>
        <div class="row knocks_house_keeper" v-if="bodyLen > 350" ><div v-if="bodyLen > 350" class="top"><a class="rdmore right" @click="rd();" href="javascript:void(0);" :id = "gid+'_readmore'">See more</a></div>
      </div>
      <div class="voice_pad knocks_house_keeper"   v-if = "knockObject.index.has_voices">
        <!--       <knocksplayer class="voice col s8" gid="noded" live :specifications = "{id : 1}" fill_from="vn/blob" meta = "vn/meta" :load_on_mount="false" :show_volume="true" v-if="knockObject.index.has_voices" :show_options="false"></knocksplayer> -->
        <knocksplayer
        :gid="gid+'_player'"
        initial_class ="btn btn-floating knocks_super_tiny_floating_btn knocks_color_kit knocks_btn_color_kit right"
        main_container = "row knocks_house_keeper"
        class="voice col s12 knocks_content_padding" style = "padding-bottom : 2px"
        :show_volume="true"
        buttons_container = "col knocks_house_keeper"
        :show_options="false"
        :specifications = "{id : knockObject.index.voices_specifications , user : current_user , object : knockObject.object_id }"
        full_back_loading
        :load_on_mount="false"></knocksplayer>
        
      </div>
        <a :href ="asset('cmnt/'+knock)" class = "knocks_text_sm"><static_message msg = "More Details"></static_message></a>
      <!-- <a class=" knocks_text_dark lens right" @click="flowtext()" href="#!"  ><i :id="gid+'_lns'" class="knocks-zoomin3 knocks_text_md lensm" @mouseover="lensHover()" @mouseleave="lensLeave()"></i></a> -->
    </div>
  </div>
</div>
<!-- <hr class="uk-divider-icon knocks_ultimate_house_keeper"> -->
</div>
</template>
<script>
export default {
data () {
return {
knockObject : null ,
address_url : null,
body : null ,
bodyLen : 0 ,
bodyText : '',
counter : 0,
counters : 0,
comments: null ,
maxRetrived : null ,
isFired : false ,
showKey : 0 ,
passedOnce : false , 
ownerObject : null ,
interest : false ,
userId : UserId  , 

isLoading : false , 
};
},
props:{
knock : {
type : Number,
required : true
},
current_user : {
type : Number ,
required : true ,
},

gid : {
type : String,
required : true
},
knock_type : {
type : String,
default : 'voice_note'
},
  as_shortcut : {
    type : Boolean , 
    default : false 
  },
  show_reply_on_mount : {
    type : Boolean , 
    default : false 
  }

},
computed : {
   commentsWatcher(){
    if(this.comments == null) return null;
    return this.comments.length - this.showKey;
   }
},
mounted(){
this.loadKnockData();
const vm = this;
console.log(vm.bodyLen);

   App.$on('knocksShowInterest' , (payloads)=>{
      if(vm.knockObject == null && !vm.as_shortcut) return;
      if(vm.interest) return;
      if(payloads.objectId == vm.knockObject.object_id && payloads.parentType == 'comment'){
        vm.interest = true;
        vm.retriveComments();
      }else return;
    });

       App.$on('knocks_refresh_posts_done' , ()=>{
      setTimeout( ()=>{
          if(vm.knockObject != null)
      if(vm.knockObject.id != vm.knock){
        //console.log(vm.knockObject.id+' << obid  decl>> '+vm.knock);   
        vm.knockObject = null;
        vm.comments = null;
        vm.loadKnockData(); 


      }
      } ,300)
    });

},
methods : {

  asset(url){
    return LaravelOrgin + url
  },

loadKnockData(){

      if(window.UserComments[this.knock] != undefined){
        
        this.knockObject = window.UserComments[this.knock];
          $('#'+this.gid).empty();
          this.knockObject.time = moment.tz(this.knockObject.created_at , moment.tz.guess() ).fromNow();
          this.knockObject.timedate = moment.tz(this.knockObject.created_at,  moment.tz.guess()).format('MMMM Do YYYY, h:mm a');
          //this.parentKnockOwner = UserKnocks[this.knockObject.post_id].user_id;
          setTimeout( ()=>{
            if(this.knockObject.body == null){
              $('#'+this.gid).remove();
              $('#'+this.gid+'_lns').remove();
            }else if(this.knockObject.body.length == 0 ){
               $('#'+this.gid).remove();
               $('#'+this.gid+'_lns').remove();
            } else
            {
            $('#'+this.gid).html(this.knockObject.body);
            this.bodyLen =  $('#'+this.gid).text().length;
            this .bodyText =  $('#'+this.gid).text();
            console.log(this.bodyLen);
            }          
          }, 400);          
          setTimeout(()=> this.datecalc()

           ,5000);
          setTimeout(()=> this.height()

           ,2000)
           if(this.knockObject.index.check_in != null  )this.address_url = this.knockObject.index.check_in.url;

           return;
          }


      
        
        const vm = this;
        axios({
          method : 'post' ,
          url : LaravelOrgin + 'retrive_comment' , 
          onDownloadProgress : ()=>{vm.isLoading = true;} , 
          data : { comment : vm.knock}
        }).then( (response)=>{
          vm.isLoading = false ;
          console.log(vm.knock+'  loaded');
          vm.knockObject = response.data;
          if(response.data == 'invalid'){
            vm.knockObject = null ;
            vm.$emit('invalid' , vm.knock);
            return;
          }else{
    
          vm.knockObject.index = (JSON.parse(vm.knockObject.index));
          window.UserComments[vm.knock] = vm.knockObject;
          vm.knockObject.time = null;
          vm.knockObject.timedate = null;
          //vm.parentKnockOwner = UserKnocks[vm.knockObject.post_id].user_id;

          
          setTimeout( ()=>{

            vm.knockObject.time = moment.tz( vm.knockObject.created_at.substring(0,18) , moment.tz.guess() ).fromNow();
            vm.knockObject.timedate = moment.tz(vm.knockObject.created_at.substring(0,18),  moment.tz.guess() ).format('MMMM Do YYYY, h:mm a');


            if(vm.knockObject.body == null){
              $('#'+vm.gid).remove();
              $('#'+vm.gid+'_lns').remove();
            }else if(vm.knockObject.body.length == 0 ){
               $('#'+vm.gid).remove();
               $('#'+vm.gid+'_lns').remove();
            } else
            {
            $('#'+vm.gid).html(vm.knockObject.body);
            vm.bodyLen =  $('#'+vm.gid).text().length;
            vm.bodyText =  $('#'+vm.gid).text();
            console.log(vm.bodyLen);
            }



             
      }, 400);
          
            
  setTimeout(()=> vm.datecalc()

   ,5000);
  setTimeout(()=> vm.height()

   ,2000)
      if(vm.knockObject.index.check_in != null  )vm.address_url = vm.knockObject.index.check_in.url;
          }
        vm.retriveComments();
          
           
        });

},
     retriveComments(){
        const vm = this;
        axios({
          method : 'post' , 
          url : LaravelOrgin + 'comment/replies' , 
          data : { knock : vm.knock , max : vm.maxRetrived }
        }).then( (response)=>{
          if(vm.comments == null)
          vm.comments = response.data;
          else{
            let i ;
            for(i = 0; i < response.data.length; i++){
              vm.comments.push(response.data[i])
            }
          }
          if(vm.comments.length > 0){
            vm.maxRetrived = Math.max.apply(null,vm.comments );
          }
          setTimeout( ()=>{ 
            if(vm.interest)
              vm.retriveComments(); 
          } , 10000);
        });
      },
rd(){
const vm = this

var readmore = $('.rdmore').text();
if(!$('#'+vm.gid).hasClass('knock_readmore_clicked')){
$('#'+vm.gid).css({
'height': 'auto'
});
$('#'+vm.gid).removeClass('animated jello');
$('#'+vm.gid).addClass('knock_readmore_clicked');
$('#'+vm.gid).removeClass('animated pulse');
$('#'+vm.gid).removeClass('animated shake');
$('#'+vm.gid).removeClass('animated rubberBand');
$('#'+vm.gid).addClass('animated fadeInDown');
$('#'+vm.gid+'_readmore').text('See less');
vm.counters = 1;
}else
{
$('#'+vm.gid).css({
'height': '7.4em'
});
$('#'+vm.gid+'_readmore').text('See More');
$('#'+vm.gid).removeClass('animated pulse');
$('#'+vm.gid).removeClass('knock_readmore_clicked');
$('#'+vm.gid).removeClass('animated rubberBand');
$('#'+vm.gid).removeClass('animated jello');
$('#'+vm.gid).removeClass('animated fadeInDown');
$('#'+vm.gid).addClass('animated shake');
vm.counters = 0;
}



},
flowtext(){
const vm = this
if(vm.counter == 0){
$('#'+vm.gid+'_lns').removeClass('knocks-zoomin3');
$('#'+vm.gid+'_lns').addClass('knocks-zoomout3');
$('#'+vm.gid).removeClass('animated shake');
$('#'+vm.gid).removeClass('animated fadeInDown');
$('#'+vm.gid).removeClass('animated jello');
$('#'+vm.gid).removeClass('animated rubberBand');
$('#'+vm.gid).addClass('flow-text');
$('#'+vm.gid).addClass('animated pulse');
$('.rdmore').addClass('flow-text');
vm.counter = 1;
console.log(vm.counter);
$('#'+vm.gid).css({
'line-height': '1.6em'
});
if(vm.bodyLen > 150)
$('#'+vm.gid).css({ 'height' : '7em'});

}
else
{
$('#'+vm.gid+'_lns').removeClass('knocks-zoomout3');
$('#'+vm.gid+'_lns').addClass('knocks-zoomin3');
$('#'+vm.gid).removeClass('animated shake');
$('#'+vm.gid).removeClass('animated fadeInDown');
$('.rdmore').removeClass('flow-text');
$('#'+vm.gid).removeClass('flow-text');
$('#'+vm.gid).removeClass('animated pulse');
$('#'+vm.gid).addClass('animated jello');
$('#'+vm.gid).addClass('animated rubberBand');
vm.counter = 0;
console.log(vm.counter);
$('#'+vm.gid).css({
'line-height': '1.3em'});
if(vm.bodyLen > 250){
$('#'+vm.gid).css({ 'height' : '7em'});
}
}

},
lensHover(){

$('.lensm').addClass('animated jello');
},
lensLeave(){

$('.lensm').removeClass('animated jello');

},
expiry(){
const vm = this;
var now = moment().format('YYYY-MM-DD hh:mm:ss');
var created = moment(vm.knockObject.created_at, 'YYYY-MM-DD hh:mm:ss').format();
var exp = moment(created).add(2,'days');
var expire = moment(exp).format();

var rule = moment().isSameOrAfter(expire);
return rule;
},
datecalc(){
const vm = this;
var now = moment();

var created = moment(vm.knockObject.created_at, 'YYYY-MM-DD hh:mm:ss').format();

},
checklens(){
const vm = this;
if (vm.counter == 1 && bodyLen <= 200)
return true
return false

},
height(){
const vm = this;
if(vm.bodyLen > 250)
{
$('#'+vm.gid).css({ 'height' : '7.4em'});
}else{
$('#'+vm.gid).css({ 'height' : 'auto'});
}
},
generateUrl(string){
return NodeOrgin +'vn/retrive/'+ this.current_user + '/'+this.knockObject.object_id+'/'+string;
},
  showRange(){
      return this.comments.length - this.showKey -1;
    },
    inRange(index){
      return index > this.showRange() ? true : false;
    },
    increaseRang(){
      if(this.comments.length - this.showKey > 5 ) {
        this.showKey += 5;
      }else{
         this.showKey += this.comments.length - this.showKey;
        } 
    },
    reduceRang(){
      if( this.showKey -  5 < 1) {
        this.showKey = 1;
      }else{
         this.showKey -= 5 ;
        } 
    },
    tickSeen(){
      if(this.passedOnce) return ;
      this.passedOnce = true;
      if(this.knockObject != null && this.knockObject.index.seen[this.current_user] != undefined) return ;
      const vm = this;
      axios({
        url : LaravelOrgin + 'post/seen' , 
        method : 'post' ,
        data : {knock : vm.knock} 
      });
    },
    hasSeen(){
      return this.knockObject != null && this.knockObject.index.seen[this.current_user] != undefined ? true : false;
    },


}



}


</script>
<style lang="css" scoped>
.panel{
//border: 1px solid transparent;
//border-radius: 15px;
//padding: 1rem;
padding-bottom: 0;
}
.voice_pad{
//margin-left: -8%;
//margin-top: -2%;
}
.player{
background-color: rgba(192,192,192,0.1);
border-radius: 15px;
//margin-left: -2% !important;
width: 70% !important;
}
.reactor{
//margin-top: -6%;
//margin-right: 2%;
}

.opcty{
color :  #01579b !important;
//margin-top: -2%;
}
.since{
}
.rdmore{
//margin-top: -2%;
//margin-right: 6%;
}
.cnt{
//background-color:rgba(192,192,192,0.1);
border-radius: 15px;
//margin-top: -6% !important;
height: 40% !important;
}

.lens{
//margin-right: 1% !important;
//margin-top: 1%;
}
.user{
//margin-top: -3%;
//margin-left: -3%;
}
.footer{
//margin-bottom: -3%;
}
.privacy{
background-color: ;
}
.content{
  //width: 100%;
  overflow: hidden;
  //height: 7.4em;
  line-height: 1.3em;
  word-wrap: break-word;
  word-break: break-all;
  //margin-left: 3%;
  //border-radius: 15px;
  //padding: 2%;
  //margin-top: -5% !important;

}
</style>