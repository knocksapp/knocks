<template>
  <div :id="gid+'_parent'" :class = "parent_class" :style = "parent_style">
       <button :id="gid+'_toggler'" :class = "btn_class+` knocks_collapse_toggler`" @click="togglePicker()" >
         <span>{{btn_label}}</span>
         <span :class = "[btn_icon , chevron_classes]" ></span>
         <span class = "animated jello knocks-chevron-down3 " :class = "chevron_classes" v-if="!isFired"></span>
         <span class = "animated jello knocks-chevron-up3 knocks_text_dark" :class = "chevron_classes"  v-else></span>
       </button>
      <div class = " knocks_collapse knocks_hidden"  :id="gid+'_dropdown'">
        <div style="max-width : 280px">
        <div v-if = "pickedIcon.length > 0 && show_selections" class = "knocks_fixed_top">
          <div class="chip valign-wrapper animated slideInUp"  v-for="(picon,index) in pickedIcon" >
             <span  :class = " 'knocks_text_ms knocks_text_dark_active knocks-' + picon.class" ></span>
             <span  @click = "closeIcon(picon.class,index)"class="knocks-close "></span>
           </div>
         </div>
        <!-- <input placeholder="Search .." id="px-icon_search" type="text" class="knocks_input_ps"  @input="updateValue()"  > -->
         <!-- <el-input placeholder="Please input" v-model="searchValue"  class="input-with-select"> -->


          <el-select v-model="categorySelect" slot="prepend" placeholder="Select" style = "width : 100% !important">
            <el-option  label="All" value="" ></el-option>
            <el-option v-for = "cat in categories" :key = "cat" :label="cat" :value="cat" ></el-option>
          </el-select>

          <!-- <el-button slot="append" icon="el-icon-search"></el-button> -->
        <!-- </el-input> -->

        <div class="center" v-for = "catig in categories" style="max-width : 280px; overflow : hidden; ">

          <div class="center" v-if="( searchValue.length  == 0 || isMatched(catig , searchValue)) && (categorySelect == catig || categorySelect == '' )" >
              <h5 class="ui horizontal divider header transparent" style="margin: 5px 0; " >
                <i   :class = " `icon_picker_icon knocks_icon-px animated  rubberBand knocks-`+emoji_icon(catig) " ></i>
            <span v-if = "categorySelect == catig || categorySelect == '' "
             class = "knocks_text_dark_active">{{catig}}
            </span>
          </h5>

          </div>
         <div class="center col s12">
          <a  v-for="icn in iconsObject" class = "col knocks_house_keeper"
          v-if="(isMatched(icn.label,searchValue) || searchValue.length  == 0 || isMatched(icn.category , searchValue)) && (icn.category == catig && (categorySelect == '' || categorySelect == catig))"

              @click="emitValue(icn)">
              <i   :class = " ` icon_picker_icon knocks_icon-px animated knocks_text_md rubberBand knocks-`+icn.class " >
              </i>
            </a>

        </div>
        </div>

      </div>
      </div>
     </div>

</template>
<script>
export default {
  props:{
      btn_class : {
        type : String ,
        default : ''
      } ,
      show_selections : {
        type : Boolean ,
        default : true
      },
      btn_class : {
        type : String ,
        default : ''
      },
      btn_label :{
        type : String ,
        default : ''
      },
      btn_icon : {
        type : String ,
        default : ''
      },
      gid :{
        type : String ,
        required : true
      },
      collapse_align : {
        type : String ,
        default :'right'
      },
      parent_class : {
        type : String ,
        default : ''
      },
      parent_style : {
        type : String ,
        default : ''
      },
      show_selection_header : {
        type : Boolean ,
        default : true ,
      },
      chevron_classes :{
        type : String ,
        default : 'knocks_text_dark'
      }

  },
  mounted(){
    const vm = this;
    $('.knocks_collapse_toggler').click(function(){
      $('.knocks_collapse').slideToggle();
      // $('.knocks_collapse').removeClass('animated slideOutUp');
      // $('.knocks_collapse').addClass('animated slideInDown');
      $('.knocks_full_wrapper').show();
    });
    $('.knocks_full_wrapper').click(function(){
      $('.knocks_collapse').slideUp();
      // $('.knocks_collapse').removeClass('animated slideInDown');
      // $('.knocks_collapse').addClass('animated slideOutUp');
      $('.knocks_full_wrapper').hide();
      vm.isFired = false;

    });
    $('.icon_picker_icon').hover(function(){
      $(this).removeClass('rubberBand');
      $(this).addClass('swing');
    });
    $('.icon_picker_icon').mouseleave(function(){
      $(this).removeClass('swing');
      $(this).addClass('rubberBand');
    });
    //Bounding Collapser
    //Button height
    var toggler = document.getElementById(vm.gid+'_toggler');
    var collapse = document.getElementById(vm.gid+'_dropdown');
    var windowWidth = $(window).innerWidth();
    var togglerHeight = toggler.offsetHeight;
    var togglerWidht = toggler.offsetWidth;
    var collapseWidth = collapse.offsetWidth;
    var togglerPosition = toggler.getBoundingClientRect();
    // $(collapse).css({'margin-left' :  - 280 + $(toggler).innerWidth() +'px' , 'margin-top' : $(toggler).innerHeight() +'px' });
    $(collapse).css({'margin-left' :  - 280 + $(toggler).innerWidth()});
    // if(vm.collapse_align == 'right' )
    // $(collapse).css({'right' :  windowWidth - togglerPosition.right +'px'});
    // if(vm.collapse_align == 'left')
    // $(collapse).css({'left' : togglerPosition.left });



  },
  computed:{

  },
  data(){
    return{
      value : '',
      isFired : false ,
      categories : [ 'Emoji' , 'Hands' , 'Brands' ,
       'Numbers' , 'Sports', 'Transport','Devices','Food',
       'Signs','Science','weather','tools'],
      pickedIcon : [] ,
      categorySelect : '' ,
      searchValue : '',

      iconsObject : [
        //tools
       { class : "health2" , label : 'health' , category : 'tools'},
        { class : "suitcase2" , label : 'suitcase' , category : 'tools'},
        { class : "suitcase3" , label : 'suitcase' , category : 'tools'},
        { class : "suitcase4" , label : 'suitcase' , category : 'tools'},
        { class : "picture2" , label : 'picture' , category : 'tools'},
        { class : "pictures" , label : 'picture' , category : 'tools'},
        { class : "pictures2" , label : 'picture' , category : 'tools'},
        { class : "watch6" , label : 'watch' , category : 'tools'},
        { class : "thermometer" , label : 'thermometer' , category : 'tools'},
        { class : "watch7" , label : 'watch' , category : 'tools'},
        { class : "alarmclock" , label : 'alarmclock' , category : 'tools'},
        { class : "time3" , label : 'time' , category : 'tools'},
        { class : "time4" , label : 'time' , category : 'tools'},
        { class : "wallet" , label : 'wallet' , category : 'tools'},
        { class : "position" , label : 'position' , category : 'tools'},
        { class : "basket2" , label : 'basket' , category : 'tools'},
        { class : "tie" , label : 'tie' , category : 'tools'},
        { class : "graduate" , label : 'graduate' , category : 'tools'},
        { class : "3dglasses" , label : '3dglasses' , category : 'tools'},
        { class : "moneybag" , label : 'moneybag' , category : 'tools'},
        { class : "tools" , label : 'tools' , category : 'tools'},
        { class : "brush5" , label : 'brush' , category : 'tools'},
        { class : "paint" , label : 'paint' , category : 'tools'},
        { class : "equalizer" , label : 'equalizer' , category : 'tools'},
        { class : "calculator" , label : 'calculator' , category : 'tools'},
        { class : "stats2" , label : 'statstics' , category : 'tools'},
        { class : "stats3" , label : 'statstics' , category : 'tools'},
        { class : "auction" , label : 'acution' , category : 'tools'},
        { class : "hourglass2" , label : 'hourglass' , category : 'tools'},
        { class : "abacus" , label : 'abacus' , category : 'tools'},
        { class : "scissors5" , label : 'scissors' , category : 'tools'},
        { class : "dollar2" , label : 'dollar' , category : 'tools'},
        { class : "dollar3" , label : 'dollar' , category : 'tools'},
        { class : "coins" , label : 'coins' , category : 'tools'},
        { class : "safe" , label : 'safe' , category : 'tools'},
        { class : "piano" , label : 'piano' , category : 'tools'},
        { class : "barcode3" , label : 'barcode' , category : 'tools'},
        { class : "barcode4" , label : 'barcode' , category : 'tools'},
        { class : "badge" , label : 'badge' , category : 'tools'},
        { class : "bagde2" , label : 'badge' , category : 'tools'},
        { class : "ticket4" , label : 'ticket' , category : 'tools'},
        { class : "ticket5" , label : 'ticket' , category : 'tools'},
        { class : "ticket6" , label : 'ticket' , category : 'tools'},
        { class : "cone2" , label : 'cone' , category : 'tools'},
        { class : "shipping" , label : 'shipping' , category : 'tools'},
        { class : "anchor6" , label : 'anchor' , category : 'tools'},
        { class : "magnet3" , label : 'magnet' , category : 'tools'},
        { class : "bulb" , label : 'bulb' , category : 'tools'},
        { class : "stack" , label : 'stack' , category : 'tools'},
        { class : "shower" , label : 'shower' , category : 'tools'},
        //emojis
        { class : "flashed-face2 amber-text darken-1" , label : 'flashed' , category : 'Emoji' },
        { class : "flashed-face4 amber-text darken-1" , label : 'flashed' , category : 'Emoji'},
        { class : "flashed-face-glasses2 amber-text darken-1" , label : 'flashed' , category : 'Emoji'},
        { class : "face-missing-moth2 amber-text darken-1" , label : 'missing' , category : 'Emoji'},
        { class : "neutral-face2 amber-text darken-1" , label : 'neutral' , category : 'Emoji'},
        { class : "sad-face2 amber-text darken-1" , label : 'sad' , category : 'Emoji'},
        { class : "face-open-mouth2 amber-text darken-1" , label : 'open mouth' , category : 'Emoji'},
        { class : "face-open-mouth4 amber-text darken-1" , label : 'open mouth' , category : 'Emoji'},
        { class : "winking-face2 amber-text darken-1" , label : 'winking' , category : 'Emoji'},
        { class : "laughing-face2 amber-text darken-1" , label : 'laughing' , category : 'Emoji'},
        { class : "laughing-face4 amber-text darken-1" , label : 'laughing' , category : 'Emoji'},
        { class : "smirking-face2 amber-text darken-1" , label : 'smirking' , category : 'Emoji'},
        { class : "stubborn-face2 amber-text darken-1" , label : 'stubborn' , category : 'Emoji'},
        { class : "neutral-face4 amber-text darken-1" , label : 'neutral' , category : 'Emoji'},
        { class : "sad-face4 amber-text darken-1" , label : 'sad' , category : 'Emoji'},
        { class : "smiling-face4 amber-text darken-1" , label : 'smiling' , category : 'Emoji'},
        { class : "smiling-face-eyebrows2 amber-text darken-1" , label : 'smiling' , category : 'Emoji'},
        { class : "grinning-face-eyebrows2 amber-text darken-1" , label : 'grinning' , category : 'Emoji'},
        { class : "sad-face-eyebrows2 amber-text darken-1" , label : 'sad' , category : 'Emoji'},
        { class : "angry-face2 red-text accent-4" , label : 'angry' , category : 'Emoji'},
        { class : "worried-face2 amber-text darken-1" , label : 'worried' , category : 'Emoji'},
        { class : "winking-face4 amber-text darken-1" , label : 'winking' , category : 'Emoji'},
        { class : "angry-face-eyebrows2 amber-text darken-1" , label : 'angry' , category : 'Emoji'},
        { class : "grinning-face2 amber-text darken-1" , label : 'grinning' , category : 'Emoji'},
        { class : "sad-face6 amber-text darken-1" , label : 'sad' , category : 'Emoji'},
        { class : "grinning-face-eyebrows4 amber-text darken-1" , label : 'grinning' , category : 'Emoji'},
        { class : "face-stuck-out-tongue2 amber-text darken-1" , label : 'stuck tongue' , category : 'Emoji'},
        { class : "kissing-face2 amber-text darken-1" , label : 'kissing' , category : 'Emoji'},
        { class : "grinning-face-teeth2 amber-text darken-1" , label : 'grinning' , category : 'Emoji'},
        { class : "worried-face-teeth2 amber-text darken-1" , label : 'worried' , category : 'Emoji'},
        { class : "angry-face-teeth2 amber-text darken-1" , label : 'angry' , category : 'Emoji'},
        { class : "grinning-face-teeth4 amber-text darken-1" , label : 'grinning' , category : 'Emoji'},
        { class : "face-open-mouth-eyebrows2 amber-text darken-1" , label : 'open mouth' , category : 'Emoji'},
        { class : "face-open-mouth-eyebrows4 amber-text darken-1" , label : 'open mouth' , category : 'Emoji'},
        { class : "unamused-face-tightly-closed-eyes2 amber-text darken-1" , label : 'unamused' , category : 'Emoji'},
        { class : "sad-face--tightly-closed-eyes2 amber-text darken-1" , label : 'sad' , category : 'Emoji'},
        { class : "kissing-face4 amber-text darken-1" , label : 'kissing' , category : 'Emoji'},
        { class : "face-closed-meyes2 amber-text darken-1" , label : 'closed eyes' , category : 'Emoji'},
        { class : "amused-face2 amber-text darken-1" , label : 'amused' , category : 'Emoji'},
        { class : "amused-face-closed-eyes2 red-text accent-4" , label : 'amused' , category : 'Emoji'},
        { class : "amused-face-closed-eyes4 amber-text darken-1" , label : 'amused' , category : 'Emoji'},
        { class : "face-closed-eyes-open-mouth2 amber-text darken-1" , label : 'closed eyes' , category : 'Emoji'},
        { class : "face-closed-eyes-open-mouth4 amber-text darken-1" , label : 'closed eyes' , category : 'Emoji'},
        { class : "face-closed-eyes-open-mouth6 amber-text darken-1" , label : 'closed eyes' , category : 'Emoji'},
        { class : "laughing-face6 amber-text darken-1" , label : 'laughing' , category : 'Emoji'},
        { class : "smiling-face6 amber-text darken-1" , label : 'smiling' , category : 'Emoji'},
        { class : "grinning-face4 amber-text darken-1" , label : 'grinning' , category : 'Emoji'},
        { class : "sad-face8 amber-text darken-1" , label : 'sad' , category : 'Emoji'},
        { class : "sad-face10 amber-text darken-1" , label : 'sad' , category : 'Emoji'},
        { class : "sad-face12 amber-text darken-1" , label : 'sad' , category : 'Emoji'},
        { class : "sad-face-closed-eyes2 amber-text darken-1" , label : 'sad' , category : 'Emoji'},
        { class : "smiling-face8 amber-text darken-1" , label : 'smiling' , category : 'Emoji'},
        { class : "astonished-face2 amber-text darken-1" , label : 'astonished' , category : 'Emoji'},
        { class : "astonished-face4 amber-text darken-1" , label : 'astonished' , category : 'Emoji'},
        { class : "face-moustache" , label : 'moustache' , category : 'Emoji'},
        { class : "face-moustache3" , label : 'moustache' , category : 'Emoji'},
        { class : "face-glasses" , label : 'glasses' , category : 'Emoji'},
        { class : "face-sunglasses" , label : 'sun glasses' , category : 'Emoji'},
        { class : "smirking-face-sunglasses" , label : 'smirking' , category : 'Emoji'},
        { class : "marvin" , label : 'marvin' , category : 'Emoji'},
        { class : "pacman2" , label : 'pacman' , category : 'Emoji'},
        { class : "transformers" , label : 'transformers' , category : 'Emoji'},
        { class : "skeletor" , label : 'skeletor' , category : 'Emoji'},
        { class : "spaceinvaders" , label : 'space invaders' , category : 'Emoji'},
        { class : "pig" , label : 'pig' , category : 'Emoji'},
        { class : "music5" , label : 'music' , category : 'Emoji'},
        { class : "heart5" , label : 'heart' , category : 'Emoji'},
        { class : "lockedheart" , label : 'heart' , category : 'Emoji'},
        { class : "heart9" , label : 'heart' , category : 'Emoji'},
        { class : "heart10" , label : 'heart' , category : 'Emoji'},
        { class : "heart11" , label : 'heart' , category : 'Emoji'},
        { class : "star12" , label : 'star' , category : 'Emoji'},
        { class : "trash5" , label : 'trash' , category : 'Emoji'},
        { class : "key11" , label : 'key' , category : 'Emoji'},
        { class : "search12" , label : 'search' , category : 'Emoji'},
        { class : "like" , label : 'like' , category : 'Emoji'},
        { class : "heart13" , label : 'heart' , category : 'Emoji'},
        { class : "heart13" , label : 'heart1' , category : 'Emoji', style : '#b30000' },
        //Hands
        { class : "thumbsup2" , label : 'thumb up' , category : 'Hands'},
        { class : "thumbsdown2" , label : 'thumb down' , category : 'Hands'},
        { class : "pointer2" , label : 'pointer' , category : 'Hands'},
        { class : "pointer3" , label : 'pointer' , category : 'Hands'},
        { class : "pointer4" , label : 'pointer' , category : 'Hands'},
        { class : "pointer5" , label : 'pointer' , category : 'Hands'},
        { class : "thumb-up2" , label : 'thumb up' , category : 'Hands'},
        { class : "thumb-down2" , label : 'thumb down' , category : 'Hands'},
        { class : "thumb-down4" , label : 'thumb down' , category : 'Hands'},
        { class : "two-fingers-swipe-left2" , label : 'swipe left' , category : 'Hands'},
        { class : "two-fingers-swipe-right2" , label : 'swipe right' , category : 'Hands'},
        { class : "two-fingers-swipe-up2" , label : 'swipe up' , category : 'Hands'},
        { class : "three-fingers-double-tap2" , label : 'tap' , category : 'Hands'},
        { class : "two-fingers-resize-out2" , label : 'resize out' , category : 'Hands'},
        { class : "two-fingers-resize-in2" , label : 'resize in' , category : 'Hands'},
        { class : "two-fingers-rotate2" , label : 'rotate' , category : 'Hands'},
        { class : "one-finger-swipe-left2" , label : 'swipe left' , category : 'Hands'},
        { class : "one-finger-swipe-right2" , label : 'swipe right' , category : 'Hands'},
        { class : "middle-finger2" , label : 'middle finger' , category : 'Hands'},
        { class : "rock-n-roll2" , label : 'rock n roll' , category : 'Hands'},
        //Signs

        { class : "arrow-up8" , label : 'up' , category : 'Signs'},
        { class : "arrow-down8" , label : 'down' , category : 'Signs'},
        { class : "arrow-right8" , label : 'right' , category : 'Signs'},
        { class : "arrow-left8" , label : 'left' , category : 'Signs'},
        { class : "arrow-top-right" , label : 'right' , category : 'Signs'},
        { class : "arrow-top-left" , label : 'left' , category : 'Signs'},
        { class : "arrow-bottom-right" , label : 'right' , category : 'Signs'},
        { class : "arrow-bottom-left" , label : 'left' , category : 'Signs'},
        { class : "refresh8" , label : 'refresh' , category : 'Signs'},
        { class : "contract" , label : 'contract' , category : 'Signs'},
        { class : "enlarge4" , label : 'enlarge' , category : 'Signs'},
        { class : "checkmark6" , label : 'checkmark' , category : 'Signs'},
        { class : "checkmark7" , label : 'checkmark' , category : 'Signs'},
        { class : "checkmark8" , label : 'checkmark' , category : 'Signs'},
        { class : "cancel5" , label : 'cancel' , category : 'Signs'},
        { class : "cancel6" , label : 'cancel' , category : 'Signs'},
        { class : "cancel7" , label : 'cancel' , category : 'Signs'},
        { class : "plus7" , label : 'plus' , category : 'Signs'},
        { class : "plus8" , label : 'plus' , category : 'Signs'},
        { class : "minus7" , label : 'minus' , category : 'Signs'},
        { class : "minus8" , label : 'minus' , category : 'Signs'},
        { class : "notice" , label : 'notice' , category : 'Signs'},
        { class : "notice2" , label : 'notice' , category : 'Signs'},
        { class : "warning9" , label : 'warning' , category : 'Signs'},
        { class : "davidstar" , label : 'davidstar' , category : 'Signs'},
        { class : "cross3" , label : 'cross' , category : 'Signs'},
        { class : "moonandstar" , label : 'moonandstar' , category : 'Signs'},
        { class : "yingyang" , label : 'yingyang' , category : 'Signs'},



       //weather
       { class : "lightning6" , label : 'lightning' , category : 'weather'},
       { class : "lightning7" , label : 'lightning' , category : 'weather'},
       { class : "lightning8" , label : 'lightning' , category : 'weather'},
       { class : "lightning4" , label : 'lightning' , category : 'weather'},
       { class : "lightning5" , label : 'lightning' , category : 'weather'},
       { class : "wind-turbine" , label : 'turbine' , category : 'weather'},
       { class : "wind-turbine2" , label : 'turbine' , category : 'weather'},
       { class : "snowflake2" , label : 'snow flake' , category : 'weather'},
       { class : "snowflake3" , label : 'snow flake' , category : 'weather'},
       { class : "snow" , label : 'snow' , category : 'weather'},
       { class : "rain3" , label : 'rain' , category : 'weather'},
       { class : "cloudy3" , label : 'cloudy' , category : 'weather'},
       { class : "cloudy4" , label : 'cloudy' , category : 'weather'},
       { class : "cloudy5" , label : 'cloudy' , category : 'weather'},
       { class : "cloudy6" , label : 'cloudy' , category : 'weather'},
       { class : "moon9" , label : 'moon' , category : 'weather'},
       { class : "sun9" , label : 'sun' , category : 'weather'},
       { class : "cloud7" , label : 'cloud' , category : 'weather'},
       { class : "cloud8" , label : 'cloud' , category : 'weather'},
       { class : "rainy3" , label : 'rainy' , category : 'weather'},
       { class : "rainy4" , label : 'rainy' , category : 'weather'},
       { class : "windy4" , label : 'windy' , category : 'weather'},
       { class : "windy5" , label : 'windy' , category : 'weather'},
       { class : "snowy4" , label : 'snowy' , category : 'weather'},
       { class : "snowy5" , label : 'snowy' , category : 'weather'},
       { class : "weather5" , label : 'weather' , category : 'weather'},
       { class : "Celsius" , label : 'celsius' , category : 'weather'},
       { class : "Fahrenheit" , label : 'fahrenheit' , category : 'weather'},

       //Sports
       {class: "football5" , label : 'american football' , category : 'Sports'},
       {class: "eightball" , label : '8ball' , category : 'Sports'},
       {class: "bowling" , label : 'bowling' , category : 'Sports'},
       {class: "bowling-ball" , label : 'bowling' , category : 'Sports'},
       {class: "bowlingpin" , label : 'bowling' , category : 'Sports'},
       {class: "basketball3" , label : 'basketball' , category : 'Sports'},
       {class: "soccer" , label : 'soccer' , category : 'Sports'},
       {class: "tennis-ball" , label : 'tennis' , category : 'Sports'},
       {class: "billiard-ball2" , label : 'billiard' , category : 'Sports'},
       {class: "soccer-ball" , label : 'soccer' , category : 'Sports'},
       {class: "baseball-set2" , label : 'baseball' , category : 'Sports'},
       {class: "trophy-one2" , label : 'trophy' , category : 'Sports'},
       {class: "trophy8" , label : 'trophy' , category : 'Sports'},
       {class: "trophy9" , label : 'trophy' , category : 'Sports'},


       //Devices
       {class: "phone14" , label : 'phone' , category : 'Devices'},
       {class: "phone15" , label : 'phone' , category : 'Devices'},
       {class: "phone16" , label : 'phone' , category : 'Devices'},
       {class: "mobile6" , label : 'mobile' , category : 'Devices'},
       {class: "ipod3" , label : 'ipod3' , category : 'Devices'},
       {class: "monitor4" , label : 'monitor' , category : 'Devices'},
       {class: "laptop7" , label : 'laptop' , category : 'Devices'},
       {class: "modem" , label : 'modem' , category : 'Devices'},
       {class: "speaker3" , label : 'speaker' , category : 'Devices'},
       {class: "hdd" , label : 'hdd' , category : 'Devices'},
       {class: "server2" , label : 'server' , category : 'Devices'},
       {class: "keyboard7" , label : 'keyboard' , category : 'Devices'},
       {class: "mouse5" , label : 'mouse' , category : 'Devices'},
       {class: "cd2" , label : 'cd' , category : 'Devices'},
       {class: "floppy2" , label : 'floppy' , category : 'Devices'},
       {class: "hardware" , label : 'hardware' , category : 'Devices'},
       {class: "usb5" , label : 'usb' , category : 'Devices'},
       {class: "cord2" , label : 'cord' , category : 'Devices'},
       {class: "socket2" , label : 'socket' , category : 'Devices'},
       {class: "socket3" , label : 'socket' , category : 'Devices'},
       {class: "printer11" , label : 'printer' , category : 'Devices'},
       {class: "camera17" , label : 'camera' , category : 'Devices'},
       {class: "film9" , label : 'film' , category : 'Devices'},
       {class: "uniF8F4" , label : 'uniF84' , category : 'Devices'},
       {class: "camera18" , label : 'camera' , category : 'Devices'},
       {class: "movie2" , label : 'movie' , category : 'Devices'},
       {class: "tv7" , label : 'tv' , category : 'Devices'},
       {class: "camera19" , label : 'camera' , category : 'Devices'},
       {class: "camera20" , label : 'camera' , category : 'Devices'},
       {class: "microphone9" , label : 'microphone' , category : 'Devices'},
       {class: "radio6" , label : 'radio' , category : 'Devices'},
       {class: "cassette2" , label : 'cassette' , category : 'Devices'},
       {class: "headphone" , label : 'headphone' , category : 'Devices'},
       {class: "broadcast" , label : 'broadcast' , category : 'Devices'},
       {class: "broadcast3" , label : 'broadcast' , category : 'Devices'},
       {class: "calculator7" , label : 'calculator' , category : 'Devices'},
       {class: "gamepad3" , label : 'gamepad' , category : 'Devices'},
       {class: "gamepad4" , label : 'gamepad' , category : 'Devices'},


       //Brands
       { class : "brand6" , label : 'amazon' , category : 'Brands'},
       { class : "brand8" , label : 'android' , category : 'Brands'},
       { class : "brand9" , label : 'apple' , category : 'Brands'},
       { class : "brand14" , label : 'jack wolfskin' , category : 'Brands'},
       { class : "brand71" , label : 'facebook' , category : 'Brands'},
       { class : "brand60" , label : 'drpbox' , category : 'Brands'},
       { class : "brand87" , label : 'microsoft office' , category : 'Brands'},
       { class : "brand88" , label : 'gmail' , category : 'Brands'},
       { class : "brand96" , label : 'google+' , category : 'Brands'},
       { class : "brand100" , label : '' , category : 'Brands'},
       { class : "brand91" , label : 'google' , category : 'Brands'},
       { class : "brand101" , label : 'gulp' , category : 'Brands'},
       { class : "brand115" , label : 'instagram' , category : 'Brands'},
       { class : "brand277" , label : 'vimo' , category : 'Brands'},
       { class : "brand276" , label : 'viber' , category : 'Brands'},
       { class : "brand128" , label : 'mongo' , category : 'Brands'},
       { class : "brand130" , label : 'kik' , category : 'Brands'},
       { class : "brand62" , label : 'ebay' , category : 'Brands'},
       { class : "brand59" , label : '' , category : 'Brands'},
       { class : "brand107" , label : '' , category : 'Brands'},
       { class : "brand135" , label : 'laravel' , category : 'Brands'},
       { class : "brand144" , label : '' , category : 'Brands'},
       { class : "brand152" , label : 'massenger' , category : 'Brands'},
       { class : "brand171" , label : '' , category : 'Brands'},
       { class : "brand222" , label : 'skype' , category : 'Brands'},
       { class : "brand227" , label : 'snapchat' , category : 'Brands'},
       { class : "brand229" , label : 'soundcloud' , category : 'Brands'},
       { class : "brand250" , label : 'tedx' , category : 'Brands'},
       { class : "brand265" , label : 'tumblr' , category : 'Brands'},
       { class : "brand280" , label : 'visa' , category : 'Brands'},
       { class : "brand286" , label : 'microsoft' , category : 'Brands'},
       { class : "brand290" , label : 'xbox' , category : 'Brands'},
       { class : "brand297" , label : 'youtube' , category : 'Brands'},
       { class : "knocks" , label : 'Knocks' , category : 'Brands'},


       //Science
    //   { class : "lab5" , label : 'lab' , category : 'Science'},
       { class : "thermometer5" , label : 'thermometer' , category : 'Science'},
       { class : "thermometer6" , label : 'thermometer' , category : 'Science'},
       { class : "thermometer-low" , label : 'thermometer' , category : 'Science'},
       { class : "thermometer-low2" , label : 'thermometer' , category : 'Science'},
       { class : "thermometer-quarter2" , label : 'thermometer' , category : 'Science'},
       { class : "thermometer-half2" , label : 'thermometer' , category : 'Science'},
       { class : "thermometer-half3" , label : 'thermometer' , category : 'Science'},
       { class : "lab3" , label : 'lab' , category : 'Science'},
       { class : "radioactive" , label : 'radioactive' , category : 'Science'},
       { class : "male" , label : 'male' , category : 'Science'},
       { class : "female" , label : 'female' , category : 'Science'},
       { class : "atom3" , label : 'atom' , category : 'Science'},
       { class : "globe5" , label : 'globe' , category : 'Science'},
       { class : "globe6" , label : 'globe' , category : 'Science'},
  //     { class : "campus16" , label : 'campus' , category : 'Science'},


       //Numbers

       { class : "number11" , label : '1' , category : 'Numbers'},
       { class : "number12" , label : '2' , category : 'Numbers'},
       { class : "number13" , label : '3' , category : 'Numbers'},
       { class : "number14" , label : '4' , category : 'Numbers'},
       { class : "number15" , label : '5' , category : 'Numbers'},
       { class : "number16" , label : '6' , category : 'Numbers'},
       { class : "number17" , label : '7' , category : 'Numbers'},
       { class : "number18" , label : '8' , category : 'Numbers'},
       { class : "number19" , label : '9' , category : 'Numbers'},
       { class : "number20" , label : '0' , category : 'Numbers'},




       //Food
       { class : "drink3" , label : 'drink' , category : 'Food'},
       { class : "drink4" , label : 'drink' , category : 'Food'},
       { class : "drink5" , label : 'drink' , category : 'Food'},
       { class : "drink6" , label : 'drink' , category : 'Food'},
       { class : "coffee5" , label : 'coffee' , category : 'Food'},
       { class : "mug3" , label : 'mug' , category : 'Food'},
       { class : "icecream" , label : 'icecream' , category : 'Food'},
       { class : "cake3" , label : 'cake' , category : 'Food'},
       { class : "cup" , label : 'cup' , category : 'Food'},
       { class : "food" , label : 'food' , category : 'Food'},


       //Transport
       { class : "car2" , label : 'car' , category : 'Transport'},
       { class : "bike" , label : 'bike' , category : 'Transport'},
       { class : "truck3" , label : 'truck' , category : 'Transport'},
       { class : "bus2" , label : 'bus' , category : 'Transport'},
       { class : "bike2" , label : 'bike' , category : 'Transport'},
       { class : "plane3" , label : 'plane' , category : 'Transport'},
       { class : "rocket3" , label : 'rocket' , category : 'Transport'},
       { class : "stop10" , label : 'stop' , category : 'Transport'},
       { class : "navigation3" , label : 'navigation' , category : 'Transport'}


      ]
    }
  },



  methods:{
    closeIcon(val,ind)
    {
      this.pickedIcon.splice(ind,1);
        this.$emit('input' , this.pickedIcon);
    },
    // updateValue(){
    //   this.value = document.getElementById('px-icon_search').value;
    // },
    emitValue(val){

      this.pickedIcon.push(val);
        this.$emit('input' , this.pickedIcon);
        this.notifi({ icon : val.class , name : val.label });
        //Materialize.toast(' You have added  <span class = "knocks-'+val.class+'"></span>  '+val.label, 3000, 'rounded');


    },
    isMatched(userInput, matchWith) {
            return matchWith.includes(userInput)
           },
           togglePicker(){
             if(this.isFired){
               this.isFired = false;
               $('.knocks_full_wrapper').hide();
             }else {
               this.isFired = true;
               $('.knocks_full_wrapper').show();
             }
           },
           notifi(object) {

         const h = this.$createElement;
        this.$message({
          showClose: true,
          message: h('p', null, [
            h('span', { class : 'knocks_text_ms knocks_text_dark'}, 'You Have Added '+object.name +' '),
            h('i', {  class : ' knocks-'+object.icon+' knocks_icon knocks_text_md knocks_text_dark' })
          ])
        });

      },

      emoji_icon(cat){
      if (cat == "Emoji" )
      return "smiling-face";
      else if (cat == "Hands")
      return "high-five";
      else if (cat == "Brands")
      return "knocks";
      else if (cat == "Numbers")
      return "calculator3";
      else if (cat == "Sports")
      return "checkered-flag2";
      else if (cat == "Transport")
      return "subway";
      else if (cat == "Devices")
      return "desktop";
      else if (cat == "Food")
      return "spoon-knife";
      else if (cat == "Signs")
      return "map-signs";
      else if (cat == "Science")
      return "lab3";
      else if (cat == "weather")
      return "cloud24";
      else if (cat == "tools")
      return "tools";

      }




  }



}
</script>
<style lang="scss" scoped>

</style>
