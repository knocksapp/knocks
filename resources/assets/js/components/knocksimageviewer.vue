<template>
<div class = "col s12 knocks_house_keeper">
  <div class = "uk-position-relative uk-visible-toggle uk-light" @mouseover="hoverFlag()" uk-slideshow = "animation:scale; min-height: 300; max-height: 300">
    <ul class = "uk-slideshow-items animated zoomIn" style = "height : 300px;">
      <li v-for = "(src , index) in sources" v-loading = "mediaLoading[index]">
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
          <h3 class="uk-margin-remove knocks_language_font" uk-parallax="viewport: 0.5" v-if="sources.length > 1 && owner_object != null">
          <span class= "knocks-pictures3"></span> {{sources.length+' photos by '+owner_object.name}}
          </h3>
          <h3 class="uk-margin-remove knocks_language_font" uk-parallax="viewport: 0.5" v-if="sources.length == 1 && owner_object != null">
          <span class= "knocks-pictures3"></span> {{sources.length+' photo by '+owner_object.name}}
          </h3>
          <imagequote v-if = "!unquoted" :gid = "gid" :object_id = "object_id" :blob_token = "src"></imagequote>
        </div>
      </li>
    </ul>
    <a class="uk-position-center-left uk-position-small uk-hidden-hover" href="#" uk-slidenav-previous uk-slideshow-item="previous"></a>
    <a class="uk-position-center-right uk-position-small uk-hidden-hover" href="#" uk-slidenav-next uk-slideshow-item="next"></a>
  </div>
  <knocksloader :gid="gid+'_loader'" v-if = "isLoading"></knocksloader>
  <div :id="'knocks_image_port_'+gid" class="uk-modal-full" uk-modal v-if = "modalFire">
    <div class="uk-modal-dialog knocks_dark_blured_bg" style="max-height : 100vh !important; min-height : 100vh !important; overflow : auto !important;">
      <button class="uk-modal-close-full uk-close-large transparent" type="button" uk-close  @click = "viewportClose()"></button>
      <div class = "row">
      <div v-loading = "mediaLoading[currentIndex]" class = "col l8 s12 " :id = "gid+'_iv_swipping_port'">

        <button class = "knocks_switch_button knocks_switch_button_left" @click = "switchImg(getPrevIndex())" :id ="gid+'_knocks_switch_button_left'">
        <span class = "knocks-chevron-left3 knocks_text_light knocks_text_lg"></span>
        </button>
        <button class = "knocks_switch_button knocks_switch_button_right " @click = "switchImg(getNextIndex())" :id = "gid+'_knocks_switch_button_right'">
        <span class = "knocks-chevron-right3 knocks_text_light knocks_text_lg"></span>
        </button>
       <center><div>
          <img :src="generateUrl(sources[currentIndex])" class = "knocks_image_port_child  animated pulse " :id = "gid+'_show_origin'" @load="handleHeight(currentIndex)">
       </div></center>
      </div>
      <div  class = "col l4 s12  white  animated slideInRight" style="max-height : 100vh !important; min-height : 100vh !important; overflow : auto !important;">
        <knockspopover class = "right">
        <template slot = "container">

        </template>
        <span slot = "content"  class = "knocks_tooltip animated flipInX" >
          <span class = "knocks-x-circle"></span>
          <static_message msg = "Close"></static_message>
        </span>
        </knockspopover>
        <br/>
        <div class = "row knocks_house_keeper">
          <knocksuser :user="owner_id" main_container = "col s12 knocks_house_keeper "></knocksuser>
        </div>
        <div v-if = "!avoidClash" class = "animated fadeIn ">
         <br/>
          <imagequote :gid = "gid" :object_id = "object_id" :blob_token = "sources[currentIndex]" 
          classes = "  knocks_text_dark knocks_text_ms"
          class = "animated slideInDown "></imagequote>
           <div class="ui divider"></div>

          <knocksimagestates
          :gid = "gid+'_states'"
          :created_at = "created_at"
          v-if = "owner_object != null"
          :scope = "[gid + '_state_scope']"
          :candy = "owner_object.kid"
          :owner_object = "owner_object"
          :knock_id = "knock_id"
          :token = "sources[currentIndex]"></knocksimagestates>
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
    }

  },
  data () {
    return {

    	isLoading : false ,
    	viewPortMode : false ,
    	currentIndex : 0 ,
      isHovered : true ,
      carouselHover : false ,
      mediaLoading : [] ,
      avoidClash : false ,
      modalFire : false ,

    }
  },
  computed : {
  	len(){
  		return this.sources.length;
  	}
  },
  mounted(){
    //Initialize media Loading
    let ld ;
    for(ld in this.sources)
      this.mediaLoading[ld] = true;
    $(document).ready(function(){
      $('.carousel').carousel();
    });

     const vm = this;
  	//this.retriveImages();
  	$(document).ready(function(){
      vm.reviseHeight();
  	//	$('.knocks_image_port_child').css({ 'margin-top' : ($($(this).parent()).height()-$(this).height())/2+ ' px' });
  	});
    $(window).resize(function(){
      vm.reviseHeight();
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
    const vm = this;
    if(!this.modalFire) this.modalFire = true;
    this.viewPortMode = true
     setTimeout(()=>{
      UIkit.modal( $('#knocks_image_port_'+this.gid)).show(); 
      this.reviseHeight();
      this.listenForSwips();
    },200)
     

    },
    viewportClose(){
      this.viewPortMode = false
      UIkit.modal( $('#knocks_image_port_'+this.gid)).hide();
    },
    listenForSwips(){
      const vm = this;
       $('#'+vm.gid+'_iv_swipping_port').swipe( {
        //Generic swipe handler for all directions
        swipe:function(event, direction, distance, duration, fingerCount, fingerData) {
          console.log(direction); console.log(distance)
          if(direction == 'left') vm.switchImg(vm.getPrevIndex());
          if(direction == 'right') vm.switchImg(vm.getNextIndex());
          if(direction == 'up' || direction == 'down') vm.viewportClose();
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
      this.avoidClash = true;
    	this.currentIndex = index;
  		setTimeout(()=>{ 
        this.avoidClash = false 
        this.reviseHeight()
         $('.knocks_image_port_child').removeClass('animated pulse');
        $('.knocks_image_port_child').addClass('animated pulse');
      } ,200);
        
      
      

  	},
    toggleHoverMode(){
      this.isHovered = true;
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
