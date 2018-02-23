<template>

<div>
  <transition    name="custom-classes-transition" enter-active-class="animated fadeIn" leave-active-class="animated fadeOut">
  <div class=" ":class = "{'knocks_color_kit_light knocks_gray_border knocks_standard_border_radius panel' : !as_shortcut}">

  <transition    name="custom-classes-transition"  enter-active-class="animated fadeIn" leave-active-class="animated fadeOut">
  
    <center><knocksloader :gid= "gid+'_knock_loading_span'" v-if = "knockObject == null" ></knocksloader></center>
  
  </transition>

  <div v-if = "knockObject != null && knock_type == 'normal' && !as_shortcut" class=" panel knocks_color_kit_light ">
    <knocksuser  image_container_class = "knocks_inline" name_container_class = " knocks_inline" :user="knockObject.user_id" show_image>
    </knocksuser>
    <div class="knocks_text_dark content " :id = "gid" @dblclick = "flowtext()"></div>
    <!-- <a  class="rdmore right" :id = "gid+'_readmore'" @click="rd();" href="javascript:void(0);">See more</a> -->
    <p class="right knocks_text_dark">{{knockObject.time}}</p>
  </div>
  <div v-if="knock_type == 'voice_note' && knockObject != null && !as_shortcut"  @mouseover = "tickSeen()">
        <div :id = "'knocks_date'+knockObject.numericDate"  class="section scrollspy knocks_house_keeper">

 <!--    <div class="col s12  knocks_house_keeper"  style="max-height:20px; padding-bottom:2px !important;"
    v-if = "!expiry() || knockObject.exceptions || knockObject.index.check_in != null && knockObject != null">
    
      <span v-if="!expiry() && !hasSeen()" class="new badge left knocks_tinny_badge" ></span>
      <span v-if="knockObject.exceptions" class="badge sec left knocks_tinny_badge" data-badge-caption="Secured"><i class="knocks-eye-off"></i></span>
    </div> -->
    
    <div class="row user knocks_house_keeper" style="" >
      <div class="col s6 knocks_house_keeper">
        <knocksuser
           v-model = "ownerObject"
           image_container_class = "knocks_inline" 
           name_container_class = " knocks_inline"
          :user="knockObject.user_id" show_image>
            <template slot = "append_to_display_name" class = "" v-if = "!expiry() || knockObject.exceptions || knockObject.index.check_in != null && knockObject != null">
              <span v-if="!expiry() && !hasSeen()" class="knocks_mp_top_margin new badge knocks_tinny_badge " ></span>
               <span v-if="knockObject.exceptions" class="knocks_mp_top_margin badge sec knocks_tinny_badge " data-badge-caption="Secured"><i class="knocks-eye-off"></i></span>
            </template>
          </knocksuser>
      </div>
      <div class="col s6 ">
       <div class = "col s9">
             <a class="knocks_text_dark knocks_mp_top_margin" :href="address_url" v-if="knockObject.index.check_in != null">
        <p class="right knocks_text_sm opcty"> <i class="knocks_text_dark knocks-location3 opcty"></i>
         {{knockObject.index.check_in.address_components[0].long_name}}
        </p>
        </a>
       </div>

        <div class = "col s3">
           <el-dropdown trigger="click" class = "right">
      <span class="el-dropdown-link">
        <knockspopover>
      <template slot = "container">
        <i class=" knocks_icon knocks-more-horizontal knocks_text_anchor knocks_text_dark knocks_text_lmd"></i>
      </template>
       <span slot = "content"  class = "knocks_tooltip animated flipInX left" >
        <span class = "knocks-more-horizontal "></span>
        <static_message msg = "More Options"></static_message> 
      </span>
      </knockspopover>
      </span>
      <el-dropdown-menu slot="dropdown">
        <el-dropdown-item v-if="userId == knockObject.user_id">
         <div>
          <span class = "knocks-trashcan4 knocks_icon_border blue-text"></span>
          <static_message msg = "Edit" classes="blue-text"></static_message>
        </div>
        </el-dropdown-item>
         <el-dropdown-item v-if="userId == knockObject.user_id">
         <div>
          <span class = "knocks-pencil9 knocks_icon_border red-text"></span>
          <static_message msg = "Delete" classes="red-text"></static_message>
        </div>
        </el-dropdown-item>
        <el-dropdown-item v-if = "ownerObject != null && !ownerObject.thatsMe" >
         <div class ="teal-text text-accent-4">
          <span class = "knocks-star3 knocks_icon_border  teal-text text-accent-4"></span>
          <static_message msg = "See" classes="teal-text text-accent-4"></static_message> {{ownerObject.name}} 
          <static_message msg = "first" classes="teal-text text-accent-4"></static_message>
        </div>
        </el-dropdown-item>
        <el-dropdown-item>
         <div>
          <span class = "knocks-minus-circle2 knocks_icon_border orange-text text-lighten-1"></span>
          <static_message msg = "Hide this time" classes= "orange-text text-lighten-1"></static_message>
        </div>
        </el-dropdown-item>
        <el-dropdown-item>
         <div>
          <span class = "knocks-trash5 red-text text-accent-2 knocks_icon_border"></span>
          <static_message msg = "Hide always" classes="red-text text-accent-2"></static_message>
        </div>
        </el-dropdown-item>
        <el-dropdown-item>
         <div>
          <span class = "knocks-shield4 knocks_icon_border  deep-orange-text text-accent-3"></span>
          <static_message msg = "Report" classes="deep-orange-text text-accent-3"></static_message>
        </div>
        </el-dropdown-item>
      </el-dropdown-menu>
    </el-dropdown>
   </div>
      
      
         
      </div>
      
    </div>
    <div class="col s12 cnt  knocks_house_keeper">

      <div class="row knocks_house_keeper">
        <div  class="knocks_text_dark content knocks_content_padding" :id = "gid" @dblclick = "flowtext()"></div>
      </div>
      <div class="row knocks_house_keeper"  v-if="bodyLen > 350" ><div class="top">
        <a class="rdmore right" :id="gid+'_readmore'" style="padding-left : 0.2 rem !important; padding-right : 0.2 rem !important;"  @click="rd();" href="javascript:void(0);">See more</a></div>
    </div>
    <div class="voice_pad"   v-if = "knockObject.index.has_voices">
<!--       <knocksplayer class="voice col s8" gid="noded" live :specifications = "{id : 1}" fill_from="vn/blob" meta = "vn/meta" :load_on_mount="false" :show_volume="true" v-if="knockObject.index.has_voices" :show_options="false"></knocksplayer> -->
 <knocksplayer
  :gid="gid+'_player'"
  main_container = "row knocks_house_keeper"
  class="voice col 12 knocks_house_keeper"
  :show_volume="true"
  buttons_container = "col"
  :show_options="false"
  :specifications = "{id : knockObject.index.voices_specifications , user : current_user , object : knockObject.object_id }"
  full_back_loading
  :load_on_mount="false"></knocksplayer>

    
  </div>

    <!-- <a class="knocks_text_dark lens right" @click="flowtext()" href="#!"  ><i :id="gid+'_lns'" class="knocks-zoomin3 knocks_text_md lensm" @mouseover="lensHover()" @mouseleave="lensLeave()"></i></a> -->
    </div>
  <div class = "row knocks_house_keeper" v-if = "knockObject.index.has_pictures" >
  <knocksimageviewer :gid = "gid+'_image_viewer'"
   :sources = 'knockObject.index.images_specifications'
   :object_id = "knockObject.object_id"
   :user_id = "current_user"
   :owner_object = "ownerObject"
   :owner_id = "knockObject.user_id"></knocksimageviewer>
  </div>
  <div class = "row knocks_house_keeper">
    <knocksfileviewer :file="file" v-if = "knockObject.index.has_files == true" :key="file" v-for = "file  in knockObject.index.files_specifications"  >
   </knocksfileviewer>
  </div>
  
  <div class="row knocks_house_keeper"  style="padding-right : 5px !important; padding-left : 5px !important;">
<!--     <span class="right knocks_text_dark since"> {{knockObject.time}} </span>
    <span class="left knocks_text_dark since"> {{knockObject.timedate}} </span> -->
    <knocksreactionstats 
    knocks_reactor_ul = "knocks_tinny_reactor_ul"
    reactor_collapser_icon = "knocks_text_ms knocks-like knocks_dark_anchor"
    reply_initial_class = "btn btn-floating knocks_super_tiny_floating_btn right knocks_side_padding knocks_noshadow_ps  knocks_text_dark transparent"
    reactor_initial_class = "btn btn-floating knocks_reaction_trigger knocks_super_tiny_floating_btn knocks_noshadow_ps knocks_text_dark transparent"
    bar_classes ="knocks_color_kit_light" 
    :parent_date = "knockObject.created_at"
    :reply_scope="[ gid + '_reply_scope']"
    parent_type = "knock" 
    :gid = "gid+'_reaction_stats'" 
    :object_id = "knockObject.object_id">
    </knocksreactionstats>
       <knocksreply 
   :replier_message = "replier_message"
   :scope= "[ gid + '_reply_scope']" 
   :error_at="[]"
   show_on_mount
   :object_id = "knockObject.object_id"
   :parent_id = "knockObject.id"
   submit_at = "comment/create"
   :recorder_upload_data = "{ user : current_user , index : {}}"
   :player_show_options = "false"
   :post_at = "current_user"
   parent_type = "knock"
   success_at = "done"
   success_msg = "yess"
    toggle_parent_type = "knock"
   :gid = "gid+'_reply'"></knocksreply>
  </div>
   <div class = "knocks_color_kit_light_active row knocks_down_border_radius knocks_house_keeper knocks_gray_top_border" v-if ="comments != null && comments.length > 0">
     <div class = "row knocks_house_keeper">
       <a v-if = "comments != null && showKey < comments.length && showKey > 0" @click = "increaseRang()" 
     class = "knocks_side_padding knocks_text_sm knocks_text_anchor knocks_pointer" style = "margin-left:2px;">
       <span class = "knocks-chat-2"></span> See More Comments
     </a>
     <a v-if = "comments != null && showKey < comments.length && showKey < 1" @click = "increaseRang()" 
     class = "knocks_side_padding knocks_text_sm knocks_text_anchor knocks_pointer" style = "margin-left:2px;">
       <span class = "knocks-chat-2"></span> Show Comments
     </a>
     <span class = "grey-text right knocks_text_sm knocks_side_padding" v-if = "comments != null && comments.length > 0">{{showKey+'/'+comments.length}} Comments</span>
     </div>
<!--      <div class="" v-for = "(com , index) in comments_to_show"  v-if = "comments_to_show != null && comments.length > 0" > 
     <knockscomment  
     v-if="!notInMountedComments(com)" 
     :gid= "gid+'_comment_on_scope_'+index"
     :knock="com" 
     :current_user="current_user" 
     replier_message = "Reply here" >
     </knockscomment>
     </div> -->
     <div class="" v-for = "(com , index) in comments"  v-if = "comments != null && comments.length > 0" > 
     <knockscomment  
     v-if="inRange(index)" 
     :gid= "gid+'_comment_'+index"
     :knock="com" 
     :current_user="current_user" 
     replier_message = "Reply here" ></knockscomment>
   </div>
   <div class = "col s12 knocks_house_keeper">
      <a v-if = "comments != null && showKey > 1" @click = "reduceRang()" 
     class = "knocks_tinny_padding knocks_text_sm  knocks_text_anchor knocks_pointer" style = "margin-left:2px;">
       <span class = "knocks-chat-1"></span> See Less Comments
     </a>
     <a v-if = "comments != null && showKey > 0" @click = "showKey = 0" 
     class = "knocks_tinny_padding knocks_text_sm right  knocks_text_anchor knocks_pointer" style = "margin-left:2px;">
       <span class = "knocks-chat-1"></span> Hide All Comments
     </a>
   </div>
 </div>
 
 </div>
   </div>
   <div v-if = "as_shortcut && knockObject != null "  class = "row"style="border-bottom : 1px solid #ccc">

            <knocksuser
            class = "knocks_house_keeper"
            hide_popover
           v-model = "ownerObject"
           image_container_class = "knocks_inline" 
           name_container_class = " knocks_inline"
          :user="knockObject.user_id" show_image>
            <template slot = "append_to_display_name" class = "" v-if = "!expiry() || knockObject.exceptions || knockObject.index.check_in != null && knockObject != null">
              <span v-if="!expiry() && !hasSeen()" class="knocks_mp_top_margin new badge knocks_tinny_badge " ></span>
               <span v-if="knockObject.exceptions" class="knocks_mp_top_margin badge sec knocks_tinny_badge " data-badge-caption="Secured"><i class="knocks-eye-off"></i></span>
            </template>
          </knocksuser>

      

     <div class="col s12 cnt  knocks_house_keeper">

      <div class="row knocks_house_keeper">
        <div  class="knocks_text_dark content knocks_content_padding" :id = "gid" @dblclick = "flowtext()"></div>
      </div>
      <div class="row knocks_house_keeper"  v-if="bodyLen > 350" ><div class="top">
        <a class="rdmore right" :id="gid+'_readmore'" style="padding-left : 0.2 rem !important; padding-right : 0.2 rem !important;"  @click="rd();" href="javascript:void(0);">See more</a></div>
    </div>
    <div class="voice_pad"   v-if = "knockObject.index.has_voices">
<!--       <knocksplayer class="voice col s8" gid="noded" live :specifications = "{id : 1}" fill_from="vn/blob" meta = "vn/meta" :load_on_mount="false" :show_volume="true" v-if="knockObject.index.has_voices" :show_options="false"></knocksplayer> -->
 <knocksplayer
  :gid="gid+'_player'"
  main_container = "row knocks_house_keeper"
  class="voice col 12 knocks_house_keeper"
  :show_volume="true"
  buttons_container = "col"
  :show_options="false"
  :specifications = "{id : knockObject.index.voices_specifications , user : current_user , object : knockObject.object_id }"
  full_back_loading
  :load_on_mount="false"></knocksplayer>

    
  </div>
   <a :href ="asset('knock/'+knock)" class = "knocks_text_sm"><static_message msg = "More Details"></static_message></a>
     
   </div>
 </div>
</div>
</transition>


</div>
</template>

<script>

export default {
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
     replier_message : {
      type : String , 
      default : ''
     },
     comments_to_show : {
      type : Array , 
      default : null
     },
     interested : {
      type : Boolean , 
      default : false
     },
    as_shortcut : {
      type : Boolean , 
      default : false
     }

    
  },


  data () {
    return {
        knockObject : null ,
        address_url : null,
        body : null ,
        bodyLen : 0 , 
        bodyText : '',
        counter : 0,
        counters : 0,
        comments : null ,
        maxRetrived : null ,
        isFired : false ,
        showKey : 0 ,
        passedOnce : false , 
        ownerObject : null ,
        interest : false ,
        userId : UserId 
    }; 
},
  computed : {
   commentsWatcher(){
    if(this.comments == null) return null;
    return this.comments.length - this.showKey;
   }

  },
  mounted(){
    this.loadKnockData(); 
    if(this.comments_to_show != null){

      this.showKey = this.comments_to_show.length;
      this.comments = this.comments_to_show;
      
    }    
    const vm = this;
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
    
    App.$on('knocksShowInterest' , (payloads)=>{
      if(vm.knockObject == null || vm.as_shortcut) return;
      if(vm.interest) return;
      if(payloads.objectId == vm.knockObject.object_id && payloads.parentType == 'knock'){
        vm.interest = true;
        vm.retriveComments();
      }else return;
    });
   
    
    
    
  }, 
  methods : {
    asset(url){
      return LaravelOrgin+url;
    },
    toNumericDate(date){
      return moment(date).format('YYYYMMDD');
    },
    loadKnockData(){

      if(window.UserKnocks[this.knock] != undefined){
        console.log(this.knock+'  restored');
        this.knockObject = window.UserKnocks[this.knock];
          $('#'+this.gid).empty();
          this.knockObject.time = moment.tz(this.knockObject.created_at , moment.tz.guess() ).fromNow();
          this.knockObject.timedate = moment.tz(this.knockObject.created_at,  moment.tz.guess()).format('MMMM Do YYYY, h:mm a');
          this.knockObject.disDate = moment.tz(this.knockObject.created_at,  moment.tz.guess()).format('MMMM Do YYYY');
          this.knockObject.numericDate = this.toNumericDate(this.knockObject.created_at);
           if(this.interested){
              App.$emit('knocksShowInterest', { objectId : this.knockObject.object_id , parentType : 'knock'} );
            }
          this.$emit('input' , this.knockObject);
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
           this.retriveComments();
           return;
          }


      
        
        const vm = this;
        axios({
          method : 'post' ,
          url : LaravelOrgin + 'retrive_knock' , 
          data : { knock : vm.knock}
        }).then( (response)=>{
          console.log(vm.knock+'  loaded');
          vm.knockObject = response.data;
          if(response.data == 'invalid'){
            vm.knockObject = null ;
            return;
          }else{
    
          vm.knockObject.index = (JSON.parse(vm.knockObject.index));
          window.UserKnocks[vm.knock] = vm.knockObject;
          vm.knockObject.time = null;
          vm.knockObject.timedate = null;

           




          
          setTimeout( ()=>{

            vm.knockObject.time = moment.tz( vm.knockObject.created_at.substring(0,18) , moment.tz.guess() ).fromNow();
            vm.knockObject.timedate = moment.tz(vm.knockObject.created_at.substring(0,18),  moment.tz.guess() ).format('MMMM Do YYYY, h:mm a');
            vm.knockObject.disDate = moment.tz(vm.knockObject.created_at,  moment.tz.guess()).format('MMMM Do YYYY');
            vm.knockObject.numericDate = vm.toNumericDate(vm.knockObject.created_at);
            vm.$emit('input' , vm.knockObject);
              if(vm.interested){
              App.$emit('knocksShowInterest', { objectId : vm.knockObject.object_id , parentType : 'knock'} );
            }


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
      if(  vm.knockObject.index.check_in != null  )vm.address_url = vm.knockObject.index.check_in.url;
          }
          
            vm.retriveComments();
           
        }).catch((err)=>{ console.log(err); });
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
         $('#'+vm.gid).removeClass('animated fadeInDown');
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
         $('#'+vm.gid).removeClass('animated fadeInDown');
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
     retriveComments(){
        const vm = this;
        axios({
          method : 'post' , 
          url : LaravelOrgin + 'post/comments' , 
          data : { knock : vm.knock , max : vm.maxRetrived }
        }).then( (response)=>{
          if(vm.comments == null)
          vm.comments = response.data;
          else{
            let i ;
            for(i = 0; i < response.data.length; i++){
              if(vm.comments_to_show != null){
                if(vm.notInMountedComments(response.data[i]))
                  if(vm.comments.indexOf(response.data[i]) == -1)
                   vm.comments.splice(vm.comments.length - vm.comments_to_show.length , 0 , response.data[i])
              }
              else if(vm.notInMountedComments(response.data[i]))
                     if(vm.comments.indexOf(response.data[i]) == -1)
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
      notInMountedComments(key){
        if(this.comments_to_show == null) return true;
        return this.comments_to_show.indexOf(key) == -1 ? true : false;
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
         }

     }
      
       
       
    }
     
    
</script>

<style lang="css" scoped>
/*.panel{
    border: 1px solid transparent;
    //border-radius: 15px;
    padding: 1rem;
    padding-bottom: 0;

}*/
.panel {
/*    border: 1px solid transparent;
    padding-top: 0.1rem;
    padding-bottom: 0rem;
    padding-right: 0.1rem;
    padding-left: 0.1rem;*/

}
.voice_pad{
  //margin-left: -8%;
  //margin-top: -2%;
}
.player{
    background-color: rgba(192,192,192,0.1);
    border-radius: 15px;
    margin-left: -2% !important;
    width: 70% !important;
}
.reactor{
     //margin-top: -6%;
    //margin-right: 2%;
}
.content{
  width: 100%;
  overflow: hidden;
  //height: 7.4em;
  line-height: 1.3em;
  word-wrap: break-word;
  word-break: break-all;
  //margin-left: 3%;
  //border-radius: 15px;
  padding: 0.3rem;
  //margin-top: -5% !important;
  padding-left: 0.7rem !important;
  padding-right: 0.7rem !important;

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
    background-color:rgba(192,192,192,0.1);
    /*border-radius: 15px;*/
    margin-top: -1rem !important;
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
</style>