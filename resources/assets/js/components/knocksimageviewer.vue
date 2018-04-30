<template>
<div class = "col s12 knocks_house_keeper">
  <knocksretriver
  v-if = "sourcesList.length > 0"
  url = "object/hide"
  :xdata = "{ blob : sourcesList[currentIndex] }"
  prevent_on_mount
  @success = "confirmHide($event)"
  :scope = "['blob_ignore_'+gid]"></knocksretriver>
  <knocksretriver
  v-if = "sourcesList.length > 0"
  url = "knock/delete"
  :xdata = "{ blob : sourcesList[currentIndex] }"
  prevent_on_mount
  @success = "confirmDelete($event)"
  :scope = "['blob_delete_'+gid]"></knocksretriver>
  <div v-if = "entrance == 'default'" class = "uk-position-relative uk-visible-toggle uk-light" @mouseover="hoverFlag()" uk-slideshow = "animation:scale; min-height: 300; max-height: 300">
    <ul class = "uk-slideshow-items animated zoomIn" style = "height : 300px;">
      <li v-for = "(src , index) in sourcesList" v-loading = "mediaLoading[index]">
        <div class="uk-position-cover uk-animation-kenburns uk-animation-reverse uk-transform-origin-center-left" uk-parallax="blur: 2; sepia: 20; bgy: -400;">
          <img class = "knocks_standard_border_radius uk-vertical-align-middle white z-depth-1"
          @load = "imageLoaded(index)"
          v-if = "inCarouselRange(index)" :src="generateUrl(src)" @dblclick="viewportOpen()" uk-cover>
        </div>
        <div v-if ="!unquoted" @click = "viewportOpen()"
          class="uk-overlay uk-overlay-primary uk-position-bottom uk-text-center uk-transition-slide-bottom"
          uk-parallax="viewport: 0.5">
          <span  @click = "viewportOpen()" class = "knocks_pointer">
            <static_message msg = "tap to show"></static_message>
          </span>
          <h3 class="uk-margin-remove knocks_language_font" uk-parallax="viewport: 0.5" v-if="sourcesList.length > 1 && owner_object != null">
          <span class= "knocks-pictures3"></span> {{sourcesList.length+' photos by '+owner_object.name}}
          </h3>
          <h3 class="uk-margin-remove knocks_language_font" uk-parallax="viewport: 0.5" v-if="sourcesList.length == 1 && owner_object != null">
          <span class= "knocks-pictures3"></span> {{sourcesList.length+' photo by '+owner_object.name}}
          </h3>
          <imagequote v-if = "!unquoted" :gid = "gid" :object_id = "object_id" :blob_token = "src"></imagequote>
        </div>
      </li>
    </ul>
    <a class="uk-position-center-left uk-position-small uk-hidden-hover" href="#" uk-slidenav-previous uk-slideshow-item="previous"></a>
    <a class="uk-position-center-right uk-position-small uk-hidden-hover" href="#" uk-slidenav-next uk-slideshow-item="next"></a>
  </div>
  <a v-if = "entrance == 'custom'" @click = "viewportOpen()">
    <slot name = "entrance"></slot>
  </a>
  <knocksloader :gid="gid+'_loader'" v-if = "isLoading"></knocksloader>
  <div :id="'knocks_image_port_'+gid" class="uk-modal-full" uk-modal v-if = "modalFire  && sourcesList.length > 0">
    <div class="uk-modal-dialog knocks_dark_blured_bg" style="max-height : 100vh !important; min-height : 100vh !important; overflow : auto !important;">
      <div v-if = "viewPortMode"> 
      <button class="uk-modal-close-full uk-close-large transparent" type="button" uk-close  @click = "viewportClose()"></button>
      <knocksprivacyadjustments :scope = "[gid+'_privacy_trigger']" hide_trigger class = "" v-model = "privacy_setting"></knocksprivacyadjustments>
      <div class = "row">
        <div v-loading = "mediaLoading[currentIndex]" 
         :class = "[{ 'animated slideOutUp knocks_hidden' : !showImagePart }, { 'animated. slideInDown' : showImagePart }]"
        class = "col l8 s12 " :id = "gid+'_iv_swipping_port'" >
          <button class = "knocks_switch_button knocks_switch_button_left" @click = "switchImg(getPrevIndex())" v-if ="sourcesList.length > 1" :id ="gid+'_knocks_switch_button_left'">
          <span class = "knocks-chevron-left3 knocks_text_light knocks_text_lg"></span>
          </button>
          <button class = "knocks_switch_button knocks_switch_button_right " @click = "switchImg(getNextIndex())" v-if ="sourcesList.length > 1" :id = "gid+'_knocks_switch_button_right'">
          <span class = "knocks-chevron-right3 knocks_text_light knocks_text_lg"></span>
          </button>
          <center><div  v-loading = "mediaLoading[currentIndex] || avoidClash" >
            <img :src="generateUrl(sourcesList[currentIndex])" class = "knocks_image_port_child  animated pulse " :id = "gid+'_show_origin'" @load="handleHeight(currentIndex)">
          </div></center>
        </div>
        <div  class = "col l4 s12  white  animated slideInRight" :id = "gid+'_reacting_zone'" style="max-height : 100vh !important; min-height : 100vh !important; overflow : auto !important;">
          <div class = "row knocks_house_keeper">
            <div class = "col s12" style="padding: 55px 0 5px 0px !important;">

              <div class = "col s12 knocks_house_keeper hide-on-large-only show-on-medium-and-down">
              <el-tooltip  placement="bottom" effect="light">
              <span slot = "content">
                <span class = " grey-text text-darken-3"  :class = "[{ 'knocksapp-circle-chevron-up' : !showImagePart }, { 'knocksapp-circle-chevron-down' : showImagePart }]"></span>
                <static_message msg=  "Toggle The Image."></static_message>
              </span>
              <a @click="toggleImagePart()" class = "center knocks_text_ms grey-text text-darken-3">
                <center><span class = "" :class = "[{ 'knocksapp-circle-chevron-up' : !showImagePart }, { 'knocksapp-circle-chevron-down' : showImagePart }]"></span></center>
              </a>
              </el-tooltip>   
              </div>


              <el-tooltip  placement="bottom" effect="light">
              <span slot = "content">
                <span class = "knocks-locked4 yellow-text text-darken-3"></span>
                <static_message msg=  "Choose your privacy setting."></static_message>
              </span>
              <a @click="triggerPrivacyModal()" class = "amber lighten-4 white-text knocks_side_margins darken-2 btn-floating knocks_super_tiny_floating_btn knocks_noshadow_ps knocks_borderless">
                <center><span class = "knocks-locked4"></span></center>
              </a>
              </el-tooltip>   
              <el-tooltip  placement="bottom" effect="light">
              <span slot = "content">
                <span class = "knocks-menu8 grey-text text-darken-3"></span>
                <static_message msg=  "More."></static_message>
              </span>
              <a class='dropdown-button transparent right'  :data-activates="gid+'_options_dropdown'">
                <i class=" knocks_icon knocks-menu8 knocks_text_md grey-text text-darken-3"></i>
              </a>
              </el-tooltip>
              <el-tooltip  placement="bottom" effect="light" v-if = "hasNextPorts">
              <span slot = "content">
                <span class = "knocksapp-square-arrow-right grey-text text-darken-3"></span>
                <static_message msg=  "Next Port."></static_message>
              </span>
              <a class='right '  style="margin-right : 7px;" v-if = "hasNextPorts" @click = "switchToNextPort()" >
                <i class="  knocksapp-square-arrow-right knocks_text_md grey-text text-darken-3"></i>
              </a>
              </el-tooltip>
              <el-tooltip  placement="bottom" effect="light" v-if = "hasPrevPorts">
              <span slot = "content">
                <span class = "knocksapp-square-arrow-left grey-text text-darken-3"></span>
                <static_message msg=  "Pervious Port."></static_message>
              </span>
              <a class=' right'  style="margin-right : 7px;"  @click = "switchToPrevPort()" v-if = "hasPrevPorts" >
                <i class="  knocksapp-square-arrow-left knocks_text_md grey-text text-darken-3"></i>
              </a>
              </el-tooltip>
              <!-- Dropdown Structure -->
              <ul :id="gid+'_options_dropdown'" class='dropdown-content'>
                <li  v-if = "ownerObject != null && ownerObject.thatsMe">
                  <a  @click = "deletePost()">
                    <span class = "knocks-pencil9 knocks_icon_border red-text"></span>
                    <static_message msg = "Delete" classes="red-text"></static_message>
                  </a>
                </li>
                <li class="divider"></li>
                <li>
                  <a @click = "hidePost()">
                    <span class = "knocks-minus-circle2 knocks_icon_border orange-text text-lighten-1"></span>
                    <static_message msg = "Hide this time" classes= "orange-text text-lighten-1"></static_message>
                  </a>
                </li>
                <li>
                  <a @click = "hideAlways()">
                    <span class = "knocks-trash5 red-text text-accent-2 knocks_icon_border"></span>
                    <static_message msg = "Hide always" classes="red-text text-accent-2"></static_message>
                  </a>
                </li>
              </ul>
            </div>
            <knocksuser :user="owner_id" main_container = "col s12 knocks_house_keeper " v-model = "ownerObject"></knocksuser>
          </div>
          <div v-if = "!avoidClash" class = "animated fadeIn ">
            <br/>
            <imagequote :gid = "gid" :object_id = "object_id" :blob_token = "sourcesList[currentIndex]"
            classes = "  knocks_text_dark knocks_text_ms"
            class = "animated slideInDown "></imagequote>
            <div class="ui divider"></div>
            <knocksimagestates
            :gid = "gid+'_states'"
            v-if = "owner_object != null"
            :scope = "[gid + '_state_scope']"
            :candy = "owner_object.kid"
            :owner_object = "owner_object"
            :knock_id = "knock_id"
            :comments_to_show = "comments_to_show"
            :token = "sourcesList[currentIndex]"></knocksimagestates>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
</div>
</template>

<script>
export default {

  name: 'knocksimageviewer',
  props : {
  	gid : {
  		type : String ,
  		required : true 
  	},
  	object_id : {
  		type : Number , 
  		required : true ,
  	},
  	sources : {
  		type : Array ,
  		default : null
  	},
  	fill_from : {
  		type : String , 
  		default : 'media/image/retrive'
  	},
    entrance : {
      type : String ,
      default : 'default'
    },
  	user_id : {
  		type : Number , 
  		default : null 
  	},
    owner_id : {
      type : Number ,
      required : true
    },
    owner_object : {
      type : Object , 
      default : null
    },
    unquoted : {
      type : Boolean , 
      default : false 
    },
    created_at : {
      type : String , 
      default : ''
    },
    knock_id : {
      type : Number , 
      required : true ,
    },
    scope : {
      type : Array , 
      default : null ,
    },     
    comments_to_show : {
      type : Array , 
      default : null
     },

  },
  data () {
    return {

    	isLoading : false ,
    	viewPortMode : false ,
    	currentIndex : 0 ,
      isHovered : false ,
      carouselHover : false ,
      mediaLoading : [] ,
      avoidClash : false ,
      modalFire : false ,
      privacy_setting : null ,
      ownerObject : null ,
      sourcesList : [] ,
      viewersStack : window.ImageViewerStack ,
      showImagePart : true , 

    }
  },
  computed : {
  	len(){
  		return this.sourcesList.length;
  	},
     hasPrevPorts(){
      return this.currentPortIndex < 1 ? false : true
    },
    hasNextPorts(){
      return this.currentPortIndex < this.viewersStack.length-1 ? true : false
    },
    currentPortIndex(){
      return this.viewersStack.indexOf(this.gid);
    }
  },
  mounted(){
    //Initialize media Loading
    this.sourcesList = this.sources
    let ld ;
    for(ld in this.sourcesList)
      this.mediaLoading[ld] = true;
    $(document).ready(function(){
      $('.carousel').carousel();
    });
    
     const vm = this;
  	//this.retriveImages();

    //Adding SourcesList remotly
     App.$on('new_picture_uploaded' , (payloads)=>{
      if(vm.scope == null) return ;
      let i ;
      for(i = 0 ; i < payloads.scope.length ; i++){
        if(vm.scope.indexOf(payloads.scope[i]) != -1){
          vm.sourcesList.splice(0 , 0 , payloads.id);
        }
      }
     });


     App.$on('knocksImageViewerGlobalClose' , (payloads)=>{
      if(!vm.viewPortMode) return;
      if(payloads.gid != vm.gid){
        vm.viewportClosePerm()
      }
     });

     App.$on('knocksImageViewerGlobalOpen' , (payloads)=>{
      if(payloads.gid == vm.gid){
        vm.viewportOpen()
      }
     });




  	$(document).ready(function(){
      vm.reviseHeight();
  	//	$('.knocks_image_port_child').css({ 'margin-top' : ($($(this).parent()).height()-$(this).height())/2+ ' px' });
  	});
    $(window).resize(function(){
      vm.reviseHeight();
      if( $(window).width()  > 900 ){
        vm.showImagePart = true;
        vm.reviseHeight()
      }
    })
    $('body').keyup(function(e){
       var code = e.keyCode || e.which;
       if(vm.viewPortMode && code === 27){
        vm.viewPortMode = false;
       }
       else if(vm.viewPortMode && (code === 39 || code === 38)){
         e.preventDefault();
        vm.switchImg(vm.getNextIndex());
       }
       else if(vm.viewPortMode && (code === 37 || code === 40)){
         e.preventDefault()
        vm.switchImg(vm.getPrevIndex());

       }
    })
  },
  methods : {
    viewportOpen(){
      if(this.sourcesList.length == 0) return;
    if(window.ImageViewerStack.indexOf(this.gid) == -1 ){
      if(window.ImageViewerStack[window.ImageViewerStack.length -1] != this.gid){
        window.ImageViewerStack.push(this.gid);
        this.viewersStack = window.ImageViewerStack
      }
    }
    const vm = this;
    if(!this.modalFire) this.modalFire = true;
    this.viewPortMode = true
     setTimeout(()=>{
      UIkit.modal( $('#knocks_image_port_'+this.gid)).show(); 
      this.reviseHeight();
      this.listenForSwips();

       $('.dropdown-button').dropdown({
      inDuration: 300,
      outDuration: 225,
      constrainWidth: false, // Does not change width of dropdown to that of the activator
      hover: false, // Activate on hover
      gutter: 0, // Spacing from edge
      belowOrigin: false, // Displays dropdown below the button
      alignment: 'left', // Displays dropdown with edge aligned to the left of button
      stopPropagation: false // Stops event propagation
    }
  );

    },200)
     

    },
    toggleImagePart(){
      this.showImagePart = !this.showImagePart ; 
      this.reviseHeight();
    },
    viewportClose(){
      this.viewPortMode = false
      UIkit.modal( $('#knocks_image_port_'+this.gid)).hide();
      App.$emit('knocksImageViewerGlobalClose' , { gid : this.gid });
    },
    viewportClosePerm(){
       UIkit.modal( $('#knocks_image_port_'+this.gid)).hide();
      this.viewPortMode = false
      
    },
    listenForSwips(){
      const vm = this;
       $('#'+vm.gid+'_iv_swipping_port').swipe( {
        //Generic swipe handler for all directions
        swipe:function(event, direction, distance, duration, fingerCount, fingerData) {
            
          if(direction == 'left') vm.switchImg(vm.getPrevIndex());
          if(direction == 'right') vm.switchImg(vm.getNextIndex());
          if( ( direction == 'down' ) && distance > ( $(window).height() * 70 / 100 ) ) vm.viewportClose();
        },
        //Default is 75px, set to 0 for demo so any distance triggers swipe
         threshold:0
      });
    },
    imageLoaded(src){
      console.log('src loaded #'+src);
      this.mediaLoading[src] = false;
      let temp = this.mediaLoading;
      this.mediaLoading = [];
      this.mediaLoading = temp;
    },
    hoverFlag(){
      if(this.carouselHover) return;
      if(!this.carouselHover) {
        this.carouselHover = true;
        setTimeout( ()=>{$('.carousel').carousel();}, 1000);
      }

    },
    inCarouselRange(index){
      if(index == 0) return true;
      return this.carouselHover ;
    },
  	generateUrl(source){
  		return LaravelOrgin+this.fill_from+'/'+source
  	},
  	openViewPort(){

  		this.viewPortMode = true;
      const vm = this;
      $('body').css({ 'overflow' : 'hidden'});
      setTimeout( ()=>{
        $(function() {      
      //Enable swiping...
      $('#'+vm.gid+'_iv_swipping_port').swipe( {
        //Generic swipe handler for all directions
        swipe:function(event, direction, distance, duration, fingerCount, fingerData) {
          if(direction == 'left') vm.switchImg(vm.getPrevIndex());
          if(direction == 'right') vm.switchImg(vm.getNextIndex());
        },
        //Default is 75px, set to 0 for demo so any distance triggers swipe
         threshold:0
      });
    });
      } , 500);
      
  
  	},
  	closeViewPort(){
  		this.viewPortMode = false;
      $('body').css({'overflow' : 'inherit'})
  	},
  	handleHeight(src){
      const vm = this;
  		this.imageLoaded(src);
  	 $(document).ready(function(){
  	    	//alert($('knocks_image_port_child').height());

  		// $('.knocks_image_port_child').css
  		// ({ 'margin-left' : ($('.knocks_img_viewport_viewer').width() - $('.knocks_image_port_child').width()) /2+ 'px'});
      vm.reviseHeight();
  		// $('.knocks_image_port_child').css
  		// ({ 'max-height' : ($('.knocks_img_viewport').height()) + 'px'});
  		// $('.knocks_image_port_child').removeClass('animated pulse').addClass('animated pulse'); 		
  		// $(window).resize(function(){
	  	// 	$('.knocks_image_port_child').css
	  	// 	({ 'margin-left' : ($('.knocks_img_viewport_viewer').width() - $('.knocks_image_port_child').width()) /2+ 'px'});
	  	// 	 $('.knocks_image_port_child').css
	  	// 	({ 'margin-top' : ($('.knocks_img_viewport').height() - $('.knocks_image_port_child').height()) /2+ 'px'});
	  	// 	$('.knocks_image_port_child').css
	  	// 	({ 'max-height' : ($('.knocks_img_viewport').height()) + 'px'});
	  	// 	$('.knocks_image_port_child').removeClass('animated pulse').addClass('animated pulse');
  		// });

  	});
  	},
    reviseHeight(){
      //let images = document.getElementsByClassName('knocks_image_port_child');
      let image = $('#'+this.gid+'_show_origin')
      if($(window).height() >= image.height() && $(window).width() > 900)
       $(image).css
      ({ 'margin-top' : ($(window).height() - image.height()) /2+ 'px'});
     let switcherRight , switcherLeft ;
     if($(window).width() < 900){
       switcherRight = document.getElementById(this.gid+'_knocks_switch_button_right');
        $(switcherRight).css
        ({ 'top' : (image.height() - 35 ) / 2 + 'px'});

       switcherLeft = $('#'+this.gid+'_knocks_switch_button_left');
        $(switcherLeft).css
        ({ 'top' :  (image.height() - 35 ) / 2 + 'px'});
      }else{
         switcherRight = document.getElementById(this.gid+'_knocks_switch_button_right');
        $(switcherRight).css
        ({ 'top' : ($(window).height() - 35 ) / 2 + 'px'});

       switcherLeft = $('#'+this.gid+'_knocks_switch_button_left');
        $(switcherLeft).css
        ({ 'top' :  ($(window).height() - 35 ) / 2 + 'px'});
      }
    },
  	getNextIndex(){
  		return this.currentIndex + 1 == this.len ? 0 : this.currentIndex+1 ;
  	},
  	getPrevIndex(){
  		return this.currentIndex == 0 ? this.len-1 : this.currentIndex-1;
  	},
  	switchImg(index){
      if(this.sourcesList.length < 2) return ;
      this.mediaLoading[index] = true;
      this.avoidClash = true;
    	this.currentIndex = index;
  		setTimeout(()=>{ 
        this.avoidClash = false 
        this.reviseHeight()
         $('.knocks_image_port_child').removeClass('animated pulse');
        $('.knocks_image_port_child').addClass('animated pulse');
      } ,200);
        
      
      

  	},
    triggerPrivacyModal(){
      App.$emit('knocksPrivacyAdjustmentsTrigger', { scope : [this.gid+'_privacy_trigger'] , state : true} )
    },
    toggleHoverMode(){
      this.isHovered = true;
    },
    switchToPrevPort(){
        App.$emit('knocksImageViewerGlobalClose' , { gid : this.gid });
            setTimeout( ()=>{
        App.$emit('knocksImageViewerGlobalOpen' , { gid :  this.viewersStack[this.currentPortIndex -1 ] })
      } , 300);
    },
    switchToNextPort(){
      App.$emit('knocksImageViewerGlobalClose' , { gid : this.gid });
      setTimeout( ()=>{
        console.log(this.viewersStack[this.currentPortIndex + 1 ])
        App.$emit('knocksImageViewerGlobalOpen' , { gid :  this.viewersStack[this.currentPortIndex + 1 ] })
      } , 300);
      
    },



     hidePost(){
      this.hiddenNow = true;
      setTimeout( ()=>{ this.knockObject = null ;  }, 1000);
     },
     hideAlways(){
      this.isLoading = true;
      App.$emit('knocksRetriver' , {scope : ['knock_ignore_'+this.gid ]});
     },
     deletePost(){
      this.isLoading = true;
      App.$emit('knocksRetriver' , {scope : ['knock_delete_'+this.gid ]});
     },
     confirmHide(e){
      this.isLoading = false;
      if(e.response == 'done'){
        this.hidePost();
      }
     },
    confirmDelete(e){
      this.isLoading = false;
      if(e.response == 'done'){
        this.hidePost();
      }


  }
}
}
</script>

<style lang="css" scoped>
.uk-modal-full {
    padding: 0;
    background: none;
    z-index: 800000000000 !important;
}
.knocks_img_viewport{
	position: fixed !important ;
	top : 70px !important;
	width: 90% !important;
	height: calc(90% - 70px) !important;
	//background-color: white;
	left: 5% !important;
	border-radius: 15px ;
	z-index : 2000001 !important;
}

.knocks_black_wrapper{
    position: fixed !important ;
	top : 0 !important;
	width: 100% !important;
	height: 100% !important;
	background-color: rgba(0,0,0,0.8) !important;
	left: 0% !important;
	z-index : 2000000 !important;
}
.knocks_image_port_child{
	border-radius: 5px ;
	border: 0px solid transparent;
	opacity: 0.9;
	max-height: 80vh !important
}

.knocks_switch_button{
	position: absolute;
	top : calc(50% - 35px);
  height: 70px;
  width: 70px;
  //line-height: 70px;
  text-align: center;
	background-color: rgba(255,255,255,0.1);
	border-radius: 10px;
	border : 0px transparent;
	//padding: 2% !important;
	z-index: 2000003 !important;
}
.knocks_switch_button:hover{
  background-color: rgba(255,255,255,0.6);
}
.knocks_switch_button_left{
	left: 7px !important;
}
.knocks_switch_button_right{
	right: 7px !important;
}
@media only screen and (min-width : 800px) {
  .knocks_switch_button_right{
	right: calc(33.3% + 7px) !important;

}
.knocks_img_viewport_viewer{
	border-radius: 15px;
}
}
@media only screen and (max-width : 801px) {
  .knocks_switch_button_right{
	right: 7px !important;
}
.knocks_img_viewport_viewer{
	border-radius: 15px;

}
}
.half_hover_wrapper{
  position: fixed ; 
  height: 100%;
  width: 50%;
  top:0;
  left: 50%;
}

.knocks_img_viewport_content{
	height: 100% !important;
  background-color: #fff;
  margin-left: 0.5% !important;
  width: 24.5% !important;
  border-radius: 15px;
}
.knocks_img_viewport_viewer{
	background-color: black;
	height: 100%;
	border-radius: 15px;
}
.knocks_left_img_port_colser{
  position: absolute;
  background-color: rgba(255,255,255,0.1);
  border-radius: 5px;
  border : 0px transparent;
  z-index: 2000003 !important;
  padding : 2px;
}

</style>
