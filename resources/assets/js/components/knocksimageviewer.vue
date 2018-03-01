<template>
	<div class = "col s12 knocks_house_keeper">

<!--     <div class="carousel carousel-slider center" :id = "gid+'_outter_carousel'" data-indicators="true" style="max-height : 300px;" @mouseover="hoverFlag()">
    <a class="carousel-item uk-vertical-align" v-for = "(src , index) in sources" >
      <img class = "knocks_standard_border_radius uk-vertical-align-middle white z-depth-1" v-if = "inCarouselRange(index)" :src="generateUrl(src)" @dblclick="openViewPort()">
    </a>
     <div class="carousel-fixed-item center">
      <a class="btn waves-effect white grey-text darken-text-2 knocks_standard_border_radius" @click = "openViewPort()">
        <span class = "knocks-pictures3"></span> 
        {{sources.length}}
    </a>
    </div>
  </div> -->
  <div class = "uk-position-relative uk-visible-toggle uk-light" @mouseover="hoverFlag()" uk-slideshow = "animation:scale; min-height: 300; max-height: 300">
    <ul class = "uk-slideshow-items animated zoomIn" style = "height : 300px;">
      <li v-for = "(src , index) in sources" v-loading = "mediaLoading[index]">
        <div class="uk-position-cover uk-animation-kenburns uk-animation-reverse uk-transform-origin-center-left" uk-parallax="blur: 2; sepia: 20; bgy: -400;">
         <img class = "knocks_standard_border_radius uk-vertical-align-middle white z-depth-1" 
         @load = "imageLoaded(index)"
         v-if = "inCarouselRange(index)" :src="generateUrl(src)" @dblclick="openViewPort()" uk-cover>
       </div>
         <div v-if ="!unquoted"
          class="uk-overlay uk-overlay-primary uk-position-bottom uk-text-center uk-transition-slide-bottom" @click = "openViewPort()" 
         uk-parallax="viewport: 0.5">
                <h3 class="uk-margin-remove knocks_language_font" uk-parallax="viewport: 0.5" v-if="sources.length > 1 && owner_object != null">
                  <span class= "knocks-pictures3"></span> {{sources.length+' photos by '+owner_object.name}}
                </h3>
                <h3 class="uk-margin-remove knocks_language_font" uk-parallax="viewport: 0.5" v-if="sources.length == 1 && owner_object != null">
                  <span class= "knocks-pictures3"></span> {{sources.length+' photo by '+owner_object.name}}
                </h3>
                <!-- <p class="uk-margin-remove">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p> -->
                <imagequote v-if = "!unquoted" :gid = "gid" :object_id = "object_id" :blob_token = "src"></imagequote>
         </div>
      </li>
    </ul>
       <a class="uk-position-center-left uk-position-small uk-hidden-hover" href="#" uk-slidenav-previous uk-slideshow-item="previous"></a>
       <a class="uk-position-center-right uk-position-small uk-hidden-hover" href="#" uk-slidenav-next uk-slideshow-item="next"></a>
  </div>


    <!-- <a @click = "openViewPort()" class = "col s12 valign-wrapper " style="height:200px; width: 200px"> -->
<!--       <span style = "position: absolute; top: 140px; width:200px  "  v-if = "sources.length > 1 "
      class="knocks_text_lg knocks_blured_bg knocks_tinny_padding knocks center white-text ">+{{ sources.length -1 }}</span> -->
      <knocksloader :gid="gid+'_loader'" v-if = "isLoading"></knocksloader>
    <!--   <img :src = "generateUrl(sources[currentIndex])"  v-if="sources.length > 0 && !isLoading" class = "knocks_standard_border_radius" style="max-height:200px; max-width: 200px" />
    </a>   -->
		<a v-if = "viewPortMode" class = "knocks_black_wrapper" @click = "closeViewPort()">	

		</a>
     <transition 
        enter-active-class="animated zoomIn" 
        leave-active-class="animated zoomOut" >
			<div  class = "knocks_img_viewport row"  v-if = "viewPortMode">
       
				<div v-loading = "mediaLoading[currentIndex]" v-if = "viewPortMode" class = "col l9 s12 knocks_img_viewport_viewer" :id = "gid+'_iv_swipping_port'">
          <a class = "knocks_left_img_port_colser white-text" @click = "closeViewPort()">
            <span class = "knocks-x-circle knocks_text_ms"></span>
          </a>
          
					<button class = "knocks_switch_button knocks_switch_button_left" @click = "switchImg(getPrevIndex())"> 
						<span class = "knocks-chevron-left3 knocks_text_light knocks_text_lg"></span> 
					</button>
          
					<button class = "knocks_switch_button knocks_switch_button_right " @click = "switchImg(getNextIndex())"> 
						<span class = "knocks-chevron-right3 knocks_text_light knocks_text_lg"></span> 
					</button>
					
					<img :src="generateUrl(sources[currentIndex])" class = "knocks_image_port_child  animated pulse " @load="handleHeight(currentIndex)">
					
				</div>
      
				<transition 
        enter-active-class="animated slideInRight" 
        leave-active-class="animated slideOutLeft" 
        >
					<div v-if = "viewPortMode" class = "col m3 hide-on-med-and-down knocks_img_viewport_content animated slideInRight">
       <knockspopover class = "right">
            <template slot = "container">
               <button class = " knock_text_anchor knocks_borderless right" @click = "closeViewPort()">
                  <span class = "knocks-x-circle knocks_text_anchor knocks_text_md"></span>
                 </button>
            </template>
             <span slot = "content"  class = "knocks_tooltip animated flipInX" >
                    <span class = "knocks-x-circle"></span>
                    <static_message msg = "Close"></static_message>
              </span>
          </knockspopover>
          <div class = "row">
            <knocksuser :user="owner_id"></knocksuser>
          </div>
          <slot></slot>     
          </div>
				</transition>
       
				
			</div>
      </transition>	
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

  },
  data () {
    return {

    	isLoading : false ,
    	viewPortMode : false ,
    	currentIndex : 0 ,
      isHovered : true ,
      carouselHover : false ,
      mediaLoading : [] ,

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
  		$('.knocks_image_port_child').css({ 'margin-top' : ($($(this).parent()).height()-$(this).height())/2+ ' px' });
  	});
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
  		this.imageLoaded(src);
  	 $(document).ready(function(){
  	    	//alert($('knocks_image_port_child').height());

  		$('.knocks_image_port_child').css
  		({ 'margin-left' : ($('.knocks_img_viewport_viewer').width() - $('.knocks_image_port_child').width()) /2+ 'px'});
  		 $('.knocks_image_port_child').css
  		({ 'margin-top' : ($('.knocks_img_viewport').height() - $('.knocks_image_port_child').height()) /2+ 'px'});
  		$('.knocks_image_port_child').css
  		({ 'max-height' : ($('.knocks_img_viewport').height()) + 'px'});
  		$('.knocks_image_port_child').removeClass('animated pulse').addClass('animated pulse'); 		
  		$(window).resize(function(){
	  		$('.knocks_image_port_child').css
	  		({ 'margin-left' : ($('.knocks_img_viewport_viewer').width() - $('.knocks_image_port_child').width()) /2+ 'px'});
	  		 $('.knocks_image_port_child').css
	  		({ 'margin-top' : ($('.knocks_img_viewport').height() - $('.knocks_image_port_child').height()) /2+ 'px'});
	  		$('.knocks_image_port_child').css
	  		({ 'max-height' : ($('.knocks_img_viewport').height()) + 'px'});
	  		$('.knocks_image_port_child').removeClass('animated pulse').addClass('animated pulse');
  		});

  	});
  	},
  	getNextIndex(){
  		return this.currentIndex + 1 == this.len ? 0 : this.currentIndex+1 ;
  	},
  	getPrevIndex(){
  		return this.currentIndex == 0 ? this.len-1 : this.currentIndex-1;
  	},
  	switchImg(index){
  		this.currentIndex = index;
  		$('.knocks_image_port_child').removeClass('animated pulse');
  		//setTimeout(()=>{ $('.knocks_image_port_child').addClass('animated pulse');} ,200);

  	},
    toggleHoverMode(){
      this.isHovered = true;
    }
  }
}
</script>

<style lang="css" scoped>
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
	border-radius: 15px ;
	border: 0px solid transparent;
	opacity: 0.9;
	
}

.knocks_switch_button{
	position: absolute;
	top : 47%;
	background-color: rgba(255,255,255,0.1);
	border-radius: 10px;
	border : 0px transparent;
	padding: 2% !important;
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
	right: calc(25% + 7px) !important;

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
