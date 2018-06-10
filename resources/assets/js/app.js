/**.
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
 //app.js

require('axios'); //AJAX XHR Performer.
require('vue');   //Front End Framework.
require('materialize-css'); //Front/JS/CSS Framework based on JS/CSS.
require('croppie'); //Image Processing JS Based Library
require('cropperjs')
require('google-maps'); //Google Maps API
require('pnotify');  //Notifier JS Based Library.

require('vue-popperjs');
require('countries-list');

window.lamejs = require("lamejs");
window.BlobToArrayBuffer = require("blob-to-arraybuffer");


import countries from 'countries-list'
window.Countries = countries;

import Croppie from 'croppie'
import 'croppie/croppie.css'
//require( 'semantic-ui/dist/semantic.min.js' )


window.axios = require('axios');   //AXIOS >> AJAX XHR Performer.
window.Vue = require('vue');      //Front End Framework.
window.moment = require('moment');   //TimeDate JS Library.
require('moment-timezone');
window.GoogleMapsLoader = require('google-maps');   //Google Maps API.
window.currentUserLanguage = document.querySelector('meta[name="user_lang"]').getAttribute('content'); //Meta Collector (User Language).
window.currentUserLanguageFont = document.querySelector('meta[name="lang_font"]').getAttribute('content'); //Meta Collector (User Language Font Family).
window.currentUserLanguageAlignment = document.querySelector('meta[name="lang_alignment"]').getAttribute('content'); //Meta Collector (User Language Font Alignment).
window.NodeOrgin = 'http://127.0.0.1:3000/'; //NodeJS Requests Orgin %/  in Axsios XHR url no need to specify the root, eg: (url : NodeOrgin + 'parent_x/child_y') /%
window.LaravelOrgin = window.location.protocol + '//'+ window.location.hostname  +'/' ; //Same as NodeOrgin but scopes Laravel this time.
window.PNotify = require('pnotify'); //Notifier JS Based Library.
window.UsersObject = {}; //Empty Object to be contacting knocksuser component, applying dynamic programming, and machine learning approach.
window.UserAxios = {};
window.ImgBlobs = {}; //Empty Object to be contacting knockspreview, knocksframelesspreview components, applying dynamic programming, and machine learning approach.
window.UserCircles = {}; //Empty Object to be contacting circles data, applying dynamic programming, and machine learning approach.
window.UserId = document.querySelector('meta[name="user"]').getAttribute('content');

window.StaticMessages = {};
window.ErrorMessageBus = [];
window.sessionType = document.querySelector('meta[name="session-type"]').getAttribute('content');
window.WindowWidth = $(window).width();
window.DocumentWidth = $(document).width();
window.WindowHeight = $(window).innerHeight();
window.UserKnocks = {};
window.UserComments = {};
window.UserReplies = {};
window.UserGroups = {};
window.LaravelCSRF = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
window.KnocksRecorderFired = false;
window.UserCirclesList = [];
window.AllLangs = null;
window.Cropper = require('cropperjs');
window.CurrentHref = window.location.href;
window.ImageViewerStack = [] ;
window.FontsAlignment = { left : 'titillium' , right : 'cairo' }
window.UserMainCircle = window.sessionType == 'user' ? parseInt(document.querySelector('meta[name="main_circle"]').getAttribute('content')) : -1;

//Packages Configration
GoogleMapsLoader.KEY = 'AIzaSyAtO8ZPlOkAAlV6oxGu-dD_ghyk9obCOXk'; //Google maps api configuration >> Key.
GoogleMapsLoader.LIBRARIES = ['geometry', 'places'];  //Google maps api configuration >> Libraries.
window.axios.defaults.headers.common =
{             //Axios Default Headers.
  'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),  //Laravel CSRF Token.
  'X-Requested-With': 'XMLHttpRequest' ,    //XHR Type.
  'KNOCKS-USER' : window.UserId ,
  'KNOCKS-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),  //Laravel CSRF Token.

};

Window.UserNavigator = null;


//WINDOW METHODS

window.hoverIcon = function(node){
  $(node).removeClass('rubberBand');
  $(node).addClass('swing');
  if($(node).hasClass('tooltipped')){
    $(node).tooltip({delay: 50});
  }
}
window.leaveIcon = function(node){
  $(node).removeClass('swing');
  $(node).addClass('rubberBand');
}








$(document).ready(function(){

  $('.knocks_language_follower').css({'text-align' : window.currentUserLanguageAlignment , 'font-family' : window.currentUserLanguageFont});

   $(".button-collapse").sideNav();


  $($('body').find('.knocks_valign')).css
        ({'margin-top' : ($('.knocks_valign').parent().height()/2)-($('.knocks_valign').height()/2) });


   ///Resize Actions

   $(window).resize(function(){
      window.WindowWidth = $(window).width();
      window.DocumentWidth = $(document).width();
      window.WindowHeight = $(window).innerHeight();
    });
});

//GLOBAL METHODS
window.Asset = (url)=>{
  return window.LaravelOrgin + url ;
}
window.ExsistsInUsersObject = (index)=>{
  return window.UsersObject[index]== undefined ? false : true ;
}
window.ExsistsInImgBlobs = (index)=>{
  return window.ImgBlobs[JSON.stringify(index)]== undefined ? false : true ;
}
window.ExistInObject = (object,key) =>{
  return object[key] == undefined ? true : false ;
}
window.KnocksVerticalAlign = ()=>{
    $($('body').find('.knocks_valign')).css
        ({'margin-top' : ($('.knocks_valign').parent().height()/2)-($('.knocks_valign').height()/2) });
}
window.UserCirclesLength = ()=>{
  let counter , circle ;
  counter = 0;
  for( circle in window.UserCircles)
    counter++;
  return counter;
}
window.ExistsInStaticMessages = (key)=>{
  return StaticMessages[key] == undefined ? false : true;
}
window.GetTranslationByWord = (word)=>{
        if(ExistsInStaticMessages(word)) return StaticMessages[word];
        var translation = '';
        $.ajax({
        async: false,
        url: window.location.protocol + '//' + window.location.hostname + ':'+window.location.port+'/gtrans',
        type : 'POST',
        data : {language : window.currentUserLanguage, word : word , _token : document.querySelector('meta[name="csrf-token"]').getAttribute('content')} ,
        success: function(data) {
             translation = data;
             window.StaticMessages[word] = translation;
        }});
        return translation;
}
window.MigaNumber = (num)=>{
  if(num/10000000 > 1) return window.TrimExtraZeros((num/10000000).toFixed(2))+'M';
  if(num/1000 > 1) return window.TrimExtraZeros((num/1000).toFixed(1))+'K';
  return num;
}
window.TrimExtraZeros = (num)=>{
  return num % 1 == 0 ? parseInt(num) : num ;
}

window.TextAlignWeight = (text)=>{
  let rightChars =  ["ة", "ج", "ح", "خ", "ه", "ع", "غ", "ف", "ق", "ث", "ص", "ض", "ش", "س", "ي", "ب", "ل", "ا", "ت", "ن", "م", "ك", "و", "ر", "ز", "د", "ذ", "ط", "ظ", "ئ", "أ", "إ", "ؤ", "آ"];
  let i , splitted = text.split('') , rightCounter = 0 , len = splitted.length , leftCounter = len ;
  for(i = 0 ; i < len; i++){
    if(rightChars.indexOf(splitted[i]) != -1){
      rightCounter++;
      leftCounter--;
    }
  }
  return { right : rightCounter , left : leftCounter , max : Math.max(leftCounter , rightCounter) == leftCounter ? 'left' : 'right' }
}




require('jquery-touchswipe');




import HTML from 'vue-html' //Secondery Compiler for VUE instances.
import ElementUI from 'element-ui'  //Front/JS/CSS Framework based on JS/CSS/VUE.
import locale from 'element-ui/lib/locale'
import enLocale from 'element-ui/lib/locale/lang/en'  //Local language to avoid chinees typography for Element-UI.
import VuePopper from 'vue-popperjs';

import VueCircle from 'vue2-circle-progress'
// Vue.component('vue-circle', require('vue2-circle-progress'));


// import Vuetify from 'vuetify'

import ImageCompressor from '@xkeshi/image-compressor';

window.ImageCompressor = require('@xkeshi/image-compressor');
require('b64-to-blob');
window.B64toBlob = require('b64-to-blob');


// Vue.use(Vuetify)

Vue.use(HTML) //Usage Scope to contact between both of VUE and VUE-HTML.
Vue.use(ElementUI)  //Usage Scope to contact between both of VUE and Element-UI.
Vue.use(VuePopper)

locale.use(enLocale)

window.UIkit = require('uikit')
import UIkit from 'uikit';
import Icons from 'uikit/dist/js/uikit-icons';

// loads the Icon plugin
UIkit.use(Icons);

//components can be called from the imported UIkit reference



//Element-UI Components
import {
  Pagination,
  Dialog,
  Autocomplete,
  Dropdown,
  DropdownMenu,
  DropdownItem,
  Menu,
  Submenu,
  MenuItem,
  MenuItemGroup,
  Input,
  InputNumber,
  Radio,
  RadioGroup,
  RadioButton,
  Checkbox,
  CheckboxGroup,
  Switch,
  Select,
  Option,
  OptionGroup,
  Button,
  ButtonGroup,
  Table,
  TableColumn,
  DatePicker,
  TimeSelect,
  TimePicker,
  Popover,
  Tooltip,
  Breadcrumb,
  BreadcrumbItem,
  Form,
  FormItem,
  Tabs,
  TabPane,
  Tag,
  Tree,
  Alert,
  Slider,
  Icon,
  Row,
  Col,
  Upload,
  Progress,
  Spinner,
  Badge,
  Card,
  Rate,
  Steps,
  Step,
  Carousel,
  Scrollbar,
  CarouselItem,
  Collapse,
  CollapseItem,
  Cascader,
  ColorPicker,
  Loading,
  MessageBox,
  Message,
  Notification
} from 'element-ui'
//VUE Usage Scope for Element-UI Components
Vue.use(Pagination)
Vue.use(Dialog)
Vue.use(Autocomplete)
Vue.use(Dropdown)
Vue.use(DropdownMenu)
Vue.use(DropdownItem)
Vue.use(Menu)
Vue.use(Submenu)
Vue.use(MenuItem)
Vue.use(MenuItemGroup)
Vue.use(Input)
Vue.use(InputNumber)
Vue.use(Radio)
Vue.use(RadioGroup)
Vue.use(RadioButton)
Vue.use(Checkbox)
Vue.use(CheckboxGroup)
Vue.use(Switch)
Vue.use(Select)
Vue.use(Option)
Vue.use(OptionGroup)
Vue.use(Button)
Vue.use(ButtonGroup)
Vue.use(Table)
Vue.use(TableColumn)
Vue.use(DatePicker)
Vue.use(TimeSelect)
Vue.use(TimePicker)
Vue.use(Popover)
Vue.use(Tooltip)
Vue.use(Breadcrumb)
Vue.use(BreadcrumbItem)
Vue.use(Form)
Vue.use(FormItem)
Vue.use(Tabs)
Vue.use(TabPane)
Vue.use(Tag)
Vue.use(Tree)
Vue.use(Alert)
Vue.use(Slider)
Vue.use(Icon)
Vue.use(Row)
Vue.use(Col)
Vue.use(Upload)
Vue.use(Progress)
Vue.use(Spinner)
Vue.use(Badge)
Vue.use(Card)
Vue.use(Rate)
Vue.use(Steps)
Vue.use(Step)
Vue.use(Carousel)
Vue.use(Scrollbar)
Vue.use(CarouselItem)
Vue.use(Collapse)
Vue.use(CollapseItem)
Vue.use(Cascader)
Vue.use(ColorPicker)

Vue.use(Loading.directive)

Vue.prototype.$loading = Loading.service
Vue.prototype.$msgbox = MessageBox
Vue.prototype.$alert = MessageBox.alert
Vue.prototype.$confirm = MessageBox.confirm
Vue.prototype.$prompt = MessageBox.prompt
Vue.prototype.$notify = Notification
Vue.prototype.$message = Message



Vue.component('example', require('./components/Example.vue'));
Vue.component('knocksinput', require('./components/knocksInput.vue'));
Vue.component('knockselinput', require('./components/knockselinput.vue'));
Vue.component('knocksfileupload', require('./components/knocksfileinput.vue'));
Vue.component('knockscoveruploader', require('./components/knockscoveruploader.vue'));
Vue.component('knocksdatepicker', require('./components/knocksdatepicker.vue'));
Vue.component('knocksbutton', require('./components/knocksbutton.vue'));
Vue.component('static_message', require('./components/static_message.vue'));
Vue.component('knocksloader', require('./components/loader.vue'));
Vue.component('knocksloaderbar', require('./components/knocksloaderbar.vue'));
Vue.component('knocksloaderprogress', require('./components/knocksprogressbarindecator.vue'));
Vue.component('knockscollection', require('./components/collection.vue'));
Vue.component('knocksexpandeder', require('./components/knocksexpandedli.vue'));
Vue.component('knocksiconpicker', require('./components/knocksiconpicker.vue'));
Vue.component('selector', require('./components/selector.vue'));
Vue.component('knocksnotification', require('./components/knocks_notifications.vue'));
Vue.component('knocksuser', require('./components/knocksusershortcut.vue'));
Vue.component('knocksrecorder', require('./components/knocksrecorder.vue'));
Vue.component('knocksplayer', require('./components/knocksplayer.vue'));
Vue.component('knocksimg', require('./components/knockspreview.vue'));
Vue.component('knocksimgframeless', require('./components/knocksframelesspreview.vue'));
Vue.component('knocksviewcircle', require('./components/viewer.vue'));
Vue.component('knocksreactor', require('./components/knocksreactor.vue'));
Vue.component('knock', require('./components/knock.vue'));
Vue.component('knocksmultipleuploader', require('./components/knocksmultipleuploader.vue'));
Vue.component('knocksimageeditor', require('./components/knocksimageeditor.vue'));
Vue.component('knockscirclechip', require('./components/knockscirclechip.vue'));
Vue.component('knocksmultipleswitch', require('./components/knocksmultipleswitch.vue'));
Vue.component('knocksprivacysetter', require('./components/knocksprivacysetter.vue'));
Vue.component('knockspopover', require('./components/knockspopover.vue'));
Vue.component('knocksimageviewer', require('./components/knocksimageviewer.vue'));
Vue.component('knocksaddcircle', require('./components/knocksaddcircle.vue'));
Vue.component('knockscircleseditor', require('./components/knockscircleseditor.vue'));
Vue.component('knocksknock', require('./components/knocksknock.vue'));
Vue.component('knockscomment', require('./components/knockscomment.vue'));
Vue.component('knockschildreply', require('./components/knockschildreply.vue'));
Vue.component('knocksreply', require('./components/knocksreply.vue'));
Vue.component('knocksreactionstats', require('./components/knocksreactionstats.vue'));
Vue.component('knockstaps', require('./components/knockstaps.vue'));
Vue.component('imagequote', require('./components/imagequote.vue'));
Vue.component('knocksfileviewer', require('./components/knocksfileviewer.vue'));
Vue.component('knocksballon', require('./components/knocksballon.vue'));
Vue.component('knocksuseractions', require('./components/knocksuseractions.vue'));
Vue.component('knocksquickaddcircle', require('./components/knocksquickaddcircle.vue'));
Vue.component('knockselbutton', require('./components/knockselbutton.vue'));
Vue.component('knocksknockinjector', require('./components/knocksknockinjector.vue'));
Vue.component('knocksusercareers', require('./components/knocksusercareers.vue'));
Vue.component('knocksusereducation', require('./components/knocksusereducation.vue'));
Vue.component('knocksuserhigheducation', require('./components/knocksuserhigheducation.vue'));
Vue.component('knocksuserhobby', require('./components/knocksuserhobby.vue'));
Vue.component('knocksusersport', require('./components/knocksusersport.vue'));
Vue.component('knocksuserabout', require('./components/knocksuserabout.vue'));
Vue.component('knocksretriver', require('./components/knocksretriver.vue'));
Vue.component('knocksvoicerecognition', require('./components/knocksvoicerecognition.vue'));
Vue.component('knockscroppie', require('./components/knockscroppie.vue'));
Vue.component('knocksuseraboutedit', require('./components/knocksuseraboutedit.vue'));
Vue.component('knocksusersportedit', require('./components/knocksusersportedit.vue'));
Vue.component('knocksuserhobbyedit', require('./components/knocksuserhobbyedit.vue'));
Vue.component('knocksusereducationedit', require('./components/knocksusereducationedit.vue'));
Vue.component('knocksusercareeredit', require('./components/knocksusercareeredit.vue'));
Vue.component('knocksuseraboutdelete', require('./components/knocksuseraboutdelete.vue'));
Vue.component('knocksgroupcreation', require('./components/knocksgroupcreation.vue'));
Vue.component('knocksgroupslist', require('./components/knocksgroupslist.vue'));
Vue.component('knockspagesearch', require('./components/knockspagesearch.vue'));
Vue.component('knocksgroupmembers', require('./components/knocksgroupmembers.vue'));
Vue.component('knocksimg', require('./components/knocksimg.vue'));
Vue.component('knockschattingzone', require('./components/knockschattingzone.vue'));
Vue.component('knocksconversation', require('./components/knocksconversation.vue'));
Vue.component('knocksmessagesender', require('./components/knocksmessagesender.vue'));
Vue.component('knocksgroupshortcut', require('./components/knocksgroupshortcut.vue'));
Vue.component('knocksgroupjoining', require('./components/knocksgroupjoining.vue'));
Vue.component('knocksgroupmemberdelete', require('./components/knocksgroupmemberdelete.vue'));
Vue.component('knocksgrouppictures', require('./components/knocksgrouppictures.vue'));
Vue.component('knocksgroupfiles', require('./components/knocksgroupfiles.vue'));
Vue.component('knocksgroupvoices', require('./components/knocksgroupvoices.vue'));
Vue.component('knocksrightbar', require('./components/knocksrightbar.vue'));
Vue.component('knocksprivacyadjustments', require('./components/knocksprivacyadjustments.vue'));
Vue.component('knocksgroupsettings', require('./components/knocksgroupsettings.vue'));
Vue.component('knocksuserinfo', require('./components/knocksuserinfo.vue'));
Vue.component('knocksgroupmemberposition', require('./components/knocksgroupmemberposition.vue'));
Vue.component('knockshashtag', require('./components/knockshashtag.vue'));
Vue.component('knocksusercircles', require('./components/knocksusercircles.vue'));
Vue.component('knocksquickcircleadder', require('./components/knocksquickcircleadder.vue'));
Vue.component('knockshashtagchip', require('./components/knockshashtagchip.vue'));
Vue.component('knocksimagestates', require('./components/knocksimagestates.vue'));
Vue.component('knocksuserinfodelete', require('./components/knocksuserinfodelete.vue'));
Vue.component('knocksphotocomments', require('./components/knocksphotocomments.vue'));
Vue.component('knocksusergenralinfo', require('./components/knocksusergenralinfo.vue'));
Vue.component('knocksdepimgviewer', require('./components/knocksdepimgviewer.vue'));
Vue.component('knockscirclemembers', require('./components/knockscirclemembers.vue'));
Vue.component('knockscollapse', require('./components/knockscollapse.vue'));
Vue.component('knocksmediaobject', require('./components/knocksmediaobject.vue'));
Vue.component('knocksshowkeys', require('./components/knocksshowkeys.vue'));
Vue.component('knocksrecordermpeg', require('./components/knocksrecordermpeg.vue'));
Vue.component('knocksvoicecommands', require('./components/knocksvoicecommands.vue'));
Vue.component('knocksquickaddress', require('./components/knocksquickaddress.vue'));
Vue.component('knocksaddressviewer', require('./components/knocksaddressviewer.vue'));
Vue.component('knockseldatepicker', require('./components/knockseldatepicker.vue'));
Vue.component('knockselselect', require('./components/knockselselect.vue'));
Vue.component('knocksusersuggestions', require('./components/knocksusersuggestions.vue'));
Vue.component('knocksusersettings', require('./components/knocksusersettings.vue'));
Vue.component('knockswatchmywindow', require('./components/knockswatchmywindow.vue'));
Vue.component('knocksblockuser', require('./components/knocksblockuser.vue'));
Vue.component('knocksblockuserlist', require('./components/knocksblockuserlist.vue'));
Vue.component('knocksverifyuser', require('./components/knocksverifyuser.vue'));
Vue.component('knockstips', require('./components/knockstips.vue'));
Vue.component('knocksshowdevice', require('./components/knocksshowdevice.vue'));
Vue.component('knocksdateviewer', require('./components/knocksdateviewer.vue'));
Vue.component('knockseditcirclename', require('./components/knockseditcirclename.vue'));
Vue.component('knockswelcomeslider', require('./components/knockswelcomeslider.vue'));
Vue.component('knocksforgotmypassword', require('./components/knocksforgotmypassword.vue'));
Vue.component('knockssitemap', require('./components/knockssitemap.vue'));
Vue.component('knocksmeganumber', require('./components/knocksmeganumber.vue'));





 window.App = new Vue();
 new Vue({
  el: '#app',
  $validates: true,
  data: {

    /* CORE DATA BEGINS */

    //Erros messages bus as we dont need to load the error messages more than once
    errorsMessageBus : [],
    //At every submit the global error stack would be saved here.
    errorStack : {},
    //The ballons global object
    ballons : null ,
    /* Saves when was the last notifications for update so
       the next request will only search from that date.
    */
   lastBallonsUpdate : null ,
   //As we need to figure out the users browser, we keep it in user navigator
    userNavigator : '' ,
    //The CSRF Token for Node layer
    nodeCsrf : null ,
    //Loaded Users data
    loadedUsers : {} ,
    //User Session Type
    sessionType : document.querySelector('meta[name="session-type"]').getAttribute('content'),
    //Current Address
    currentHref : window.location.href ,
    //Current Pathname
    currentPathName : window.location.pathname,

    currentIndex : null ,

    currentKnocks : null ,

    auth : parseInt(UserId) ,

    maxRetrived : null ,
    minRetrived : null ,
    lastIndex  : null ,
    loadingKnocks : false ,
    balloonsLooper : true ,

    sideBarSearchLanguage : currentUserLanguage ,
   /* CORE DATA ENDS */



   /*Developers Zone */
   //Dictionary
   languages : null ,
   staticMessages : null ,
   wordAdderSelector : 'en' ,

   wordAdderInput :  '' ,
   addNewWordRes : null ,
   allMessgesBodyInput : '' ,
   allMessgesLanguageInput : '' ,
   langFilters : [] ,
   staticMessagesIdFilter : [] ,
   showStaticMessagesTable : true ,
   staticMessagesLanguageQuery : '' ,
   staticMessagesBodyQuery : '' ,
   staticMessagesIdQuery : 0 ,
   collectMessagesLoading : false ,
   staticMessagesLanguageTranslate : '' ,
   staticMessagesBodyTranslate  : '' ,
   staticMessagesIdTranslate  : 0 ,
   TranslateMessagesLoading : false ,
   TranslateMessagesRes : null ,
   devStage : 'Knocks Data' ,



   //Knocks Data
   resetKnocksLoading : false ,
   resetKnocksRes : null ,
   resetKnocksDialog : false ,
   resetAllDialog : false ,
   reinstallDialog : false ,
   //DOM & Components

   //Knockstaps
   knocksTapsDevModel : null ,
   usersCount : 100 ,
   knocksTapsDevOptions : [ { icon : 'knocks-male2' , label : 'Male' , static : true , value : 'Male'} ,
                            { icon : 'knocks-female2' , label : 'Female' , static : true , value : 'Female'} ,
                            { label : 'Other' , static : true , value : 'Other'}
                          ],
    knocksTapsDevMultiple : true ,
    knocksTapsDevDefineIndex : 5 ,
    knocksTapsDevDefineZero : true ,
    knocksTapsDevOptionsIcons : [] ,
    knocksTapsDevOptionsLabels : [] ,
    knocksTapsDevOptionsValues : [] ,
    knocksTapsDevOptionsStatic : [] ,
    knocksTapsDevRadioReset : false ,
    knocksTapsDevIsRequired : false ,

    userTest : null ,
    authModel : null ,
    profileModel : null ,

   /* Developers Zone End */

    recorder : null ,
    //Register
    first_name : '' ,
    last_name : '' ,
    middle_name : '',
    nickname : '' ,
    username : '' ,
    birthdate : '' ,
    birthdateIsFired: false ,
    gender : '' ,
    email : '' ,
    password : '' ,
    password_confirmation : '',
    stageNumber : 1 ,
    fileup : null ,
    pp : null ,
    contacts : null,
    sinstiveTrigger : false ,
    slideShow : 1,
    slidesCount : document.getElementsByClassName('knocks_slideshow_element').length,
    showProfileUploader : false ,
    loginStage : false,
    lowerTrigger : null ,
    loggedIn : true ,
    profileUserObject : null ,

    uploadGroupPic : true,

    //Login

    username_login : 'username' ,
    password_login : 'password123123',



    //Document

    //Survey

    q1 : 'yes' ,
    q2 : [] ,
    q2o : '' ,
    q3 : '3' ,
    q4 : 10 ,
    q5 : '2' ,
    q6 : [] ,
    q6o : [] ,
    q6i : '' ,
    q7 : 2 ,
    q8 : 2 ,
    q9 : [] ,
    q10 : 'yes' ,
    q11 : '2' ,
    q12 : '2' ,
    q13 : '2' ,

    q14 : 'yes' ,
    q15 : 'yes' ,
    q16 : '2',
    q17 : '2' ,
    q18 : '2' ,
    q19o : '',

   qv : 'first',
   qp : 'yes',
   harry : 1,
   fantastic : '',

   //Survey Analysis

   retrivedAnswers : null ,
   lastAnswerUpdate : null ,
   answersPatch : null ,
   answersObject : {} ,
   userAnswers : null ,
   answersCorrected : false ,
   mainCircle : -1 ,


    windowWidth : $(window).width(),


  },


  computed: {
    formateMySqlDate(){
      return moment(this.birthdate).format('YYYY-MM-DD');
    },
    hasDate(){
      return this.birthdate.length == 0 ? false : true;
    },

    validDate(){
      if(!this.hasDate) return false ;
      if(this.formateMySqlDate == 'Invalid date') return false ;
      let year = parseInt(moment(this.formateMySqlDate).format('YYYY'));
      let currentYear = parseInt(moment().format('YYYY'));
      if(currentYear - year < 5) return false ;
      return true;

    },

    surveyStepOneValid(){
      return this.surveyQ2isValid && this.surveyQ6isValid && this.surveyQ9isValid ? true : false;
    },
    surveyQ2isValid(){
      if(this.q1 == 'yes') return true;
      return this.q2.length == 0 && this.q2o.length == 0 ? false : true;
    },
    surveyQ6isValid(){
      if(this.q1 == 'no') return true;
      return this.q6.length == 0 && this.q6o.length == 0 ? false : true;
    },
    surveyQ9isValid(){
      if(this.q1 == 'no') return true;
      return this.q9.length == 0 ? false : true;
    },

    passwordComplixty(){
      if(this.password.length == 0) return{ percentage :  0 , status : 'exception' } ;
      let score = 100;
      // if(
      //   this.password.includes(this.first_name) || this.password.includes(this.last_name) ||
      //   this.password.includes(this.middle_name) || this.password.includes(this.nickname)
      //   ) score -= 30;
        if(this.password.length < 8)
          score -= 30;
        if(this.password.match(/^(?=.*[a-zA-Z])(?=.*[0-9])/) == null)
          score -= 30;
        //return score;
        if(score != 100)
          return { percentage :  score , status : 'exception' } ;
        else return { percentage :  score , status : 'success' }
    }
  },
  watch :{

  },

  //Mounted Method
  mounted() {
    moment.lang(currentUserLanguage)
    this.slideShowTrigger();
    this.profileIndex();
      const vm = this;

      if(this.currentPathName == '/user/login' || this.currentPathName == '/user/logout'  )
        this.loginStage = true;

      App.$on('refreshMatListeners' , function(){
        $($('body').find('.tooltipped')).tooltip({delay : 50});
        $('.tooltipped').tooltip({delay : 50});
      });

      this.getuserCircles();

      this.getNotifications();

      //sthis.answersPatch();




     //Get User Browser


     if(typeof InstallTrigger !== 'undefined')
      Window.UserNavigator = 'firefox' ;

    if(!!window.chrome && !!window.chrome.webstore)
      Window.UserNavigator = 'chrome' ;
    if(sessionType == 'user'){
      window.UserMainCircle = parseInt(document.querySelector('meta[name="main_circle"]').getAttribute('content'));
      this.mainCircle = window.UserMainCircle
    }


    $(document).ready(function(){

      $('.knocks_input_watch_align').change(function(){
        $(this).css({ 'text-align' : window.TextAlignWeight($(this).val()).max  , 'font-family' : FontsAlignment[window.TextAlignWeight($(this).val()).max]})
      })
      $('.knocks_input_watch_align').keyup(function(){
        $(this).css({ 'text-align' : window.TextAlignWeight($(this).val()).max  , 'font-family' : FontsAlignment[window.TextAlignWeight($(this).val()).max]})
      })
      $('.el-input__inner').change(function(){
        $(this).css({ 'text-align' : window.TextAlignWeight($(this).val()).max  , 'font-family' : FontsAlignment[window.TextAlignWeight($(this).val()).max]})
      })
      $('.el-input__inner').keyup(function(){
        $(this).css({ 'text-align' : window.TextAlignWeight($(this).val()).max  , 'font-family' : FontsAlignment[window.TextAlignWeight($(this).val()).max]})
      })
      $('.knocks_ce_watch_align').change(function(){
        $(this).css({ 'text-align' : window.TextAlignWeight($(this).text()).max  , 'font-family' : FontsAlignment[window.TextAlignWeight($(this).text()).max]})
      })
      $('.knocks_ce_watch_align').keyup(function(){
        $(this).css({ 'text-align' : window.TextAlignWeight($(this).text()).max  , 'font-family' : FontsAlignment[window.TextAlignWeight($(this).text()).max]})
      })
      $($('body').find('.tooltipped')).tooltip({delay : 50});

      $(window).resize(function(){
        vm.windowWidth = $(window).width();
      });

      //Load More Knocks Position
      // $(window).scroll(function(){
      //   if(window.scrollY > ($('#knockknock').height()) + 100){
      //     $('#knocks_load_more_knocks_btn').css({
      //       'position' : 'fixed' ,
      //       'z-index' : '2000' ,
      //       'top' : '80px' ,
      //       'left' : WindowWidth/2 - ($('#knocks_load_more_knocks_btn').width()) ,
      //       'margin-left' : '2.5rem'
      //     });
      //   }else{
      //      $('#knocks_load_more_knocks_btn').css({'position' : 'inherit'});
      //   }
      // });




    }) ;

    App.$on('knocksWatchAligns' , ()=>{
      $('.knocks_input_watch_align').change(function(){
        $(this).css({ 'text-align' : window.TextAlignWeight($(this).val()).max  , 'font-family' : FontsAlignment[window.TextAlignWeight($(this).val()).max]})
      })
      $('.knocks_input_watch_align').keyup(function(){
        $(this).css({ 'text-align' : window.TextAlignWeight($(this).val()).max  , 'font-family' : FontsAlignment[window.TextAlignWeight($(this).val()).max]})
      })
      $('.el-input__inner').change(function(){
        $(this).css({ 'text-align' : window.TextAlignWeight($(this).val()).max  , 'font-family' : FontsAlignment[window.TextAlignWeight($(this).val()).max]})
      })
      $('.el-input__inner').keyup(function(){
        $(this).css({ 'text-align' : window.TextAlignWeight($(this).val()).max  , 'font-family' : FontsAlignment[window.TextAlignWeight($(this).val()).max]})
      })
      $('.knocks_ce_watch_align').change(function(){
        $(this).css({ 'text-align' : window.TextAlignWeight($(this).text()).max  , 'font-family' : FontsAlignment[window.TextAlignWeight($(this).text()).max]})
      })
      $('.knocks_ce_watch_align').keyup(function(){
        $(this).css({ 'text-align' : window.TextAlignWeight($(this).text()).max  , 'font-family' : FontsAlignment[window.TextAlignWeight($(this).text()).max]})
      })
      $($('body').find('.tooltipped')).tooltip({delay : 50});
    })

    App.$on('profile_uploader_status_changed' , (state)=>{
      vm.setPorfileTrigger(state);
      if(state == false ) {vm.lowerTrigger = null; return }
      $('.drag-target').click();
      vm.lowerTrigger = 'profile_uploader';
      setTimeout( ()=>{$('body , html').animate({scrollTop : $('#knocks_homepage_lower_area').offset().top-100} , 'slow');}, 200);
    });

    App.$on('cover_uploader_status_changed' , (state)=>{
      vm.setPorfileTrigger(state);
      if(state == false ) {vm.lowerTrigger = null; return }
      $('.drag-target').click();
      vm.lowerTrigger = 'cover_uploader';
      setTimeout( ()=>{$('body , html').animate({scrollTop : $('#knocks_homepage_lower_area').offset().top-100} , 'slow');}, 200);
    });

    App.$on('new_picture_uploaded' , (payloads)=>{

      //PP
      if(payloads.scope[0] == 'profile_picture_handler'){
        console.log('gate 1')
        vm.setPorfileTrigger(false);
       vm.lowerTrigger = null ;
       setTimeout(()=>{
       if(document.querySelectorAll('.knocks_user_profile_scope').length > 0){
        console.log('gate 2')
         let images = document.querySelectorAll('.knocks_user_profile_scope') ;
         let i ;
          console.log('gate 2 '+i)
         for(i = 0 ; i < images.length; i++)
          images[i].src =payloads.blob;
       }
       $('body , html').animate({scrollTop : 0} , 'slow');
       },500);
      }else if(payloads.scope[0] == 'cover_picture_handler'){

       vm.lowerTrigger = null ;
       setTimeout(()=>{
       if(document.querySelectorAll('.knocks_user_cover_scope').length > 0){
         let images = document.querySelectorAll('.knocks_user_cover_scope') ;
         let i ;
         for(i = 0 ; i < images.length; i++)
          images[i].src =payloads.blob;
       }
       $('body , html').animate({scrollTop : 0} , 'slow');
       },500);
      }else if(payloads.scope[0] == 'group_picture_handler'){

       vm.lowerTrigger = null ;
       setTimeout(()=>{
       if(document.querySelectorAll('.knocks_group_avatar_scope').length > 0){
         let images = document.querySelectorAll('.knocks_group_avatar_scope') ;
         let i ;
         for(i = 0 ; i < images.length; i++)
          images[i].src =payloads.blob;
       }
       $('body , html').animate({scrollTop : 0} , 'slow');
       },500);
      }

    });
    App.$on('circle_adder_status_changed' , (state)=>{
      if(state == false ) {vm.lowerTrigger = null; return }
      $('.drag-target').click();
      vm.lowerTrigger = 'circle_adder' ;
      setTimeout( ()=>{$('body , html').animate({scrollTop : $('#knocks_homepage_lower_area').offset().top-100} , 'slow');}, 200);
    });

    App.$on('knocksRequestCirclesRefresh' , ()=>{
      vm.getuserCircles();
    });


    App.$on('logged_out' , ()=>{
      vm.loggedIn = false;
    });

    App.$on('KnocksAddBallon', (payloads)=>{
      if(this.ballons == null) this.ballons = [];
      this.ballons.push(payloads.ballon);
    });

    $('.carousel.carousel-slider').carousel({
    fullWidth: true,
    indicators: true
  });



   this.gender = this.getTranslation('Male');



   //Developers On Mount
   this.collectLanguages();
   //this.collectMessages();
  },


  //Methods

  methods: {
    hashAnswers(){
     this.lastAnswerUpdate = this.retrivedAnswers.response.last_update;
     if(this.retrivedAnswers.response.answers.length > 0){
      this.answersPatch = this.retrivedAnswers.response.answers;
      let i, j, k, l, m;
      for(k in this.answersObject){
        for(l in this.answersObject[k]){
          this.answersObject[k][l] = 0
        }
      }
      for(i in this.answersPatch){
        for(j in this.answersPatch[i]){
          if( this.answersObject[ j ] == undefined){
            this.answersObject[j] = { total : 0 , 0 : 0 ,1 : 0 , 2 : 0 , 3 : 0 , 4 : 0 , 5 : 0 , 6 : 0};
          }
          if(Array.isArray(this.answersPatch[i][j])){
            for(m in this.answersPatch[i][j]){
              if(this.answersObject[j][this.answersPatch[i][j][m]] == undefined){
                this.answersObject[j][this.answersPatch[i][j][m]] = 1;
                this.answersObject[j].total++;
              }else{
                this.answersObject[j][this.answersPatch[i][j][m]]++;
                this.answersObject[j].total++;
              }
            }
          }else{
            if(this.answersObject[j][this.answersPatch[i][j]] == undefined){
              this.answersObject[j][this.answersPatch[i][j]] = 1;
              this.answersObject[j].total++;
            }else{
              this.answersObject[j][this.answersPatch[i][j]]++;
              this.answersObject[j].total++;
            }
          }
        }
      }

     }
    },
    correctAnswers(){
      if(this.userAnswers.response == 'no_answers'){
        this.answersCorrected = false ;
        return
      }else{
        this.answersCorrected = true;
        if(this.userAnswers.response.age > 12){
            this.q1 = this.userAnswers.response.answers.q1;
            this.q2 = this.userAnswers.response.answers.q2;
            this.q2o = this.userAnswers.response.answers.q20;
            this.q3 = this.userAnswers.response.answers.q3;
            this.q4 = this.userAnswers.response.answers.q4;
            this.q5 = this.userAnswers.response.answers.q5;
            this.q6 = this.userAnswers.response.answers.q6;
            this.q6o = this.userAnswers.response.answers.q6o;
            this.q6i = this.userAnswers.response.answers.q6i;
            this.q7 = this.userAnswers.response.answers.q7;
            this.q8 = this.userAnswers.response.answers.q8;
            this.q9 = this.userAnswers.response.answers.q9;
            this.q10 = this.userAnswers.response.answers.q10;
            this.q11 = this.userAnswers.response.answers.q11;
            this.q12 = this.userAnswers.response.answers.q12;
            this.q13 = this.userAnswers.response.answers.q13;
            this.q14 = this.userAnswers.response.answers.q14;
            this.q15 = this.userAnswers.response.answers.q15;
            this.q16 = this.userAnswers.response.answers.q16;
            this.q17 = this.userAnswers.response.answers.q17;
            this.q18 = this.userAnswers.response.answers.q18;
            this.q19o = this.userAnswers.response.answers.q19o;
        }
      }
    },
    asset(url){
      return LaravelOrgin + url;
    },
    addSocialNetwork(){
      if(this.q6o.indexOf(this.q6i) == -1){
        this.q6o.push(this.q6i)
      }else{
        this.elementNotify({title : 'Failed' , msg : 'You have already added '+this.q6i+' once.'});
      }
    },
    setCoverTrigger(state){
      App.$emit('cover_uploader_status_changed' , state);
    },
    setProfileTrigger(state){
      App.$emit('profile_uploader_status_changed' , state);
    },
    setCircleAdderTrigger(state){
      App.$emit('circle_adder_status_changed' , state);
    },
    goToSettings(){
      window.location.href = Asset('user/settings')
    },
    logout(){
      this.closeSideBar();
      this.elementNotify({title : 'Logged out' , msg : 'See you again, Bye! '});
        setTimeout(()=>{ window.location.href = LaravelOrgin+'user/logout' },1500);
    },
    coverExtended(){
       return this.asset('media/cover/'+UserId);
    },
    retrivePosts(){
      if(this.sessionType == 'guest' || this.sessionType == 'dev' || parseInt(this.UserId)==-1) return;
      // this.currentKnocks = [];
      // let key;
      // for(key in window.UserKnocks){
      //   this.currentKnocks.push(parseInt(key));
      //   this.currentKnocks.sort().reverse();
      // }
      const vm = this;
      axios({
        method : 'post',
        data : { limits : {max : vm.maxRetrived , min : vm.minRetrived , last_index : vm.lastIndex} },
        url : LaravelOrgin + 'user/posts' ,
         onDownloadProgress: function (progressEvent) {
          vm.loadingKnocks = true;
        },
        onUploadProgress: function (progressEvent) {
          vm.loadingKnocks = true;
        },
      }).then((response)=>{

        let assign = response.data.knocks;
        // if(assign.length > 10){
        //   assign.splice(10,assign.length-11);
        // }
        let i;
        if(vm.currentKnocks == null) vm.currentKnocks = [];
        for(i = 0; i < assign.length; i++){
          if(vm.currentKnocks.indexOf(assign[i]) == -1){
            vm.currentKnocks.push(assign[i])
            vm.currentKnocks = vm.currentKnocks.sort().reverse();
          }
        }
        vm.lastIndex = response.data.last_index;
        vm.minRetrived = Math.min.apply(null,vm.currentKnocks);
        vm.maxRetrived = Math.max.apply(null,vm.currentKnocks );
        vm.loadingKnocks = false;
        App.$emit('knocks_refresh_posts_done');
        vm.currentKnocks = vm.currentKnocks.sort().reverse();
        console.log(vm.currentKnocks);
        console.log (vm.currentKnocks[vm.currentKnocks.length-1]);
        // setTimeout( ()=>{
        //   vm.retriveNewerPosts();
        // } , 5000);
        //console.log(assign);
        //setTimeout( ()=>{ this.retrivePosts()}, 5000);

      });
    },
   formatToOffset(date){
    let offset = new Date().getTimezoneOffset();
      return moment(date).subtract(offset ,'m');
    },
   fromNowDate(date){
      date = this.formatToOffset(date);
      return date == null ? '' : moment(date).fromNow();
    },
    fromNowDateAsync(date){
      date = this.formatToOffset(date);
      setTimeout(()=>{this.fromNowDateAsync()} , 10000);
      return date == null ? '' : moment(date).fromNow();
    },
    detailsDate(date){
      date = this.formatToOffset(date);
      return date == null ? '' : moment(date).format('MMMM Do YYYY, h:mm a');
    },
      retriveOlderPosts(){
      if(this.sessionType == 'guest' || parseInt(this.UserId)==-1) return;
      // this.currentKnocks = [];
      // let key;
      // for(key in window.UserKnocks){
      //   this.currentKnocks.push(parseInt(key));
      //   this.currentKnocks.sort().reverse();
      // }
      const vm = this;
      axios({
        method : 'post',
        data : {  min : vm.minRetrived  },
        url : LaravelOrgin + 'user/posts/older' ,
         onDownloadProgress: function (progressEvent) {
          vm.loadingKnocks = true;
        },
        onUploadProgress: function (progressEvent) {
          vm.loadingKnocks = true;
        },
      }).then((response)=>{
        let assign = response.data.knocks;
        // if(assign.length > 10){
        //   assign.splice(10,assign.length-11);
        // }
        let i;
        if(vm.currentKnocks == null) vm.currentKnocks = [];
        for(i = 0; i < assign.length; i++){
          if(vm.currentKnocks.indexOf(assign[i]) == -1){
            vm.currentKnocks.push(assign[i])
           // vm.currentKnocks = vm.currentKnocks.sort().reverse();
          }
        }
        vm.minRetrived = Math.min.apply(null,vm.currentKnocks);
        vm.loadingKnocks = false;
        App.$emit('knocks_refresh_posts_done');
        //vm.currentKnocks = vm.currentKnocks.sort().reverse();
        console.log(vm.currentKnocks);
        console.log (vm.currentKnocks[vm.currentKnocks.length-1]);
        //console.log(assign);
        //setTimeout( ()=>{ this.retrivePosts()}, 5000);

      });
    },
      retriveNewerPosts(){
      if(this.sessionType == 'guest' || parseInt(this.UserId)==-1) return;
      // this.currentKnocks = [];
      // let key;
      // for(key in window.UserKnocks){
      //   this.currentKnocks.push(parseInt(key));
      //   this.currentKnocks.sort().reverse();
      // }
      const vm = this;
      axios({
        method : 'post',
        data : {  max : vm.maxRetrived  },
        url : LaravelOrgin + 'user/posts/newer' ,
         onDownloadProgress: function (progressEvent) {
          vm.loadingKnocks = true;
        },
        onUploadProgress: function (progressEvent) {
          vm.loadingKnocks = true;
        },
      }).then((response)=>{
        let assign = response.data.knocks;
        // if(assign.length > 10){
        //   assign.splice(10,assign.length-11);
        // }
        let i;
        if(vm.currentKnocks == null) vm.currentKnocks = [];
        for(i = 0; i < assign.length; i++){
          if(vm.currentKnocks.indexOf(assign[i]) == -1){
            vm.currentKnocks.splice(0,0,assign[i]);
            //vm.currentKnocks.push(assign[i])

            //vm.currentKnocks = vm.currentKnocks.sort().reverse();
          }
        }
        vm.maxRetrived = Math.max.apply(null,vm.currentKnocks);
        vm.loadingKnocks = false;
        App.$emit('knocks_refresh_posts_done');
        //vm.currentKnocks = vm.currentKnocks.sort().reverse();
        console.log(vm.currentKnocks);
        console.log (vm.currentKnocks[vm.currentKnocks.length-1]);
        //console.log(assign);
        //setTimeout( ()=>{ this.retriveNewerPosts()}, 5000);

      });
    },
       retrivePostsFromScratch(){
      // this.currentKnocks = [];
      // let key;
      // for(key in window.UserKnocks){
      //   this.currentKnocks.push(parseInt(key));
      //   this.currentKnocks.sort().reverse();
      // }
      const vm = this;
      axios({
        method : 'post',
        data : { limits : {max : null , min : null , last_index : null} },
        url : LaravelOrgin + 'user/posts' ,
         onDownloadProgress: function (progressEvent) {
          vm.loadingKnocks = true;
        },
        onUploadProgress: function (progressEvent) {
          vm.loadingKnocks = true;
        },
      }).then((response)=>{
        let assign = response.data.knocks;
        // if(assign.length > 10){
        //   assign.splice(10,assign.length-11);
        // }
        let i;
        if(vm.currentKnocks == null) vm.currentKnocks = [];
        for(i = 0; i < assign.length; i++){
          if(vm.currentKnocks.indexOf(assign[i]) == -1){
            vm.currentKnocks.push(assign[i])
            vm.currentKnocks = vm.currentKnocks.sort().reverse();
          }
        }
        vm.lastIndex = response.data.last_index;
        vm.minRetrived = Math.min.apply(null,vm.currentKnocks);
        vm.maxRetrived = Math.max.apply(null,vm.currentKnocks );
        vm.loadingKnocks = false;
        App.$emit('knocks_refresh_posts_done');
        vm.currentKnocks = vm.currentKnocks.sort().reverse();
        console.log(vm.currentKnocks);
        console.log (vm.currentKnocks[vm.currentKnocks.length-1]);
        //console.log(assign);
        //setTimeout( ()=>{ this.retrivePosts()}, 5000);

      });
    },
    getuserCircles(){
      if(sessionType != 'user') return;
      const vm = this;
      axios({
          method : 'post' ,
          url : LaravelOrgin + 'get_circles' ,

        }).then( (response)=>{
          UserCirclesList = response.data;
          App.$emit('KnocksGlogbalCirclesList');
        }).catch((err)=>{ console.log(err); });
    },
    clearErrorStack(){
      this.errorStack = {};
      App.$emit('knocksClearGlobalErrorStack');
    },
    elementNotify(notificationObject) {
      this.$notify({
        title: notificationObject.title,
        message: notificationObject.msg,
        dangerouslyUseHTMLString: true,
      });
    },
    elementCategoryNotify(notificationObject) {
      this.$notify({
        title: notificationObject.title,
        message: notificationObject.msg,
        type: notificationObject.type
      });
    },
    clearLowerTrigger(){
      this.lowerTrigger = null;
      // this.clearErrorStack();
    },
    generateElementString(elementObject){
      return $('<'+elementObject.name+' class = "'+ elementObject.classes+'" >'+elementObject.content+'</'+elementObject.name+'>').html();
    },
    // setPorfileTrigger(state){
    //   this.showProfileUploader = state;
    // },
    setPorfileTrigger(state){
      this.showProfileUploader = state;
    },
    profileIndex(){
      if(window.UserId >= 0){
        this.currentIndex =  parseInt(document.querySelector('meta[name="pp_index"]').getAttribute('content'));
        if(this.currentIndex == -1) this.showProfileUploader = true;
      }
    },
    assit(url){
      return LaravelOrgin + url;
    },
    logInUser(){
      this.loginStage = null ;
      setTimeout( ()=>{
        window.location.href = LaravelOrgin + 'home' ;
      } , 2000);
    },
    handleRejectedLogins(e){

    },
    submitSurvey(){

      this.stageSwitch(5);
      this.elementCategoryNotify({ type : 'success' , msg : 'Thanks for your time', title : 'Success' });
    },
    slideShowTrigger(){
      if(this.sessionType != 'guest') return;
      setInterval( ()=>{
        if(this.slidesCount == this.slideShow)
          this.slideShow = 1 ;
        else this.slideShow++;
      } ,15000);
    },
    stageIcon(stage , icon){
      return this.stageNumber < stage ? ' '+icon+' knocks_text_light knocks_icon' : ' '+icon+' knocks_text_success knocks_icon' ;
    },
    stageIconDark(stage , icon){
      return this.stageNumber < stage ? ' '+icon+' knocks_text_dark knocks_icon' : ' '+icon+' knocks_text_success knocks_icon' ;
    },
    unboundSinstive(){
      this.sinstiveTrigger = false ;
    },
    boundSinstive(){
      this.sinstiveTrigger = true ;
    },
    stageSwitch(stage){
      this.stageNumber = (stage);
      $('body , html').animate({scrollTop : 0} , 'slow');
    },
    triggerStages(){
      this.errorStack = {};
      this.loginStage = !this.loginStage;
      this.stageNumber = 1;
      //this.clearErrorStack();
    },
    getTranslationById(id){
        var translation = '';
        $.ajax({
        async: false,
        url: window.location.protocol + '//' + window.location.hostname + ':'+window.location.port+'/gettrans',
        type : 'POST',
        data : {language : window.currentUserLanguage, id : id , _token : document.querySelector('meta[name="csrf-token"]').getAttribute('content')} ,
        success: function(data) {
             translation = data;
        }});
        return translation;
   },
   getTranslation(word){
       if(window.StaticMessages[word] != undefined) return StaticMessages[word];
        var translation = '';
        $.ajax({
        async: false,
        url: window.location.protocol + '//' + window.location.hostname + ':'+window.location.port+'/gtrans',
        type : 'POST',
        data : {language : window.currentUserLanguage, word : word , _token : document.querySelector('meta[name="csrf-token"]').getAttribute('content')} ,
        success: function(data) {
             translation = data;
             StaticMessages[word] = translation;
        }});
        return translation;
    },
    getNotifications(){
      if(this.sessionType != 'user') return;
      const vm = this;
      setTimeout( ()=>{
         axios({
        url : window.location.protocol+'//'+window.location.hostname+':'+window.location.port+'/get_notification' ,
        method : 'post' ,
        timeout : 10000


      }).then(function(response){
        if(response.data.length == 0){
           setTimeout(function(){ if(vm.balloonsLooper) vm.getNotifications()},10000);
         }else{
        if(vm.ballons == null) vm.ballons = [];
        var j , i , pushFlag;
        for( j = 0 ; j < response.data.length; j++){
          pushFlag = true;
          for(i =0; i < vm.ballons.length; i++){
            if(response.data[j].id == vm.ballons[i].id)
              pushFlag = false;
          }
          if(pushFlag){
            response.data[j].index = JSON.parse(response.data[j].index);
            vm.ballons.push(response.data[j]);
          }
        }
        App.$emit('knocksBallonsUpdate' , {patch : vm.ballons})
        App.$emit('knocks_refresh_posts_done');
         setTimeout(function(){ if(vm.balloonsLooper) vm.getNotifications()},10000);
      }
      }).catch(()=>{ vm.balloonsLooper = false ; });
      }, 500);

    } ,
    updatePoped(){
      var i ;
      const vm = this ;
      var obj = [];
      for(i = 0; i < this.ballons.length; i++){
        if(this.ballons[i].id != null )
        obj.push(this.ballons[i].id);
      }

      axios({
        url : window.location.protocol+'//'+window.location.hostname+':'+window.location.port+'/update_notifications',
        method : 'post' ,
        timeout : 10000 ,
        data : { obj : obj }
      }).then((response) => {
        vm.lastBallonsUpdate = response.data;
        setTimeout(function(){ if(vm.balloonsLooper) vm.getNotifications()},10000);
      }).catch(()=>{ vm.balloonsLooper = false ; });
    },tellme(){console.log('typing right there')},


    //DEVELOPERS METHODS
    //Collect LAngauges
    collectLanguages(){
      const vm = this;
      axios({
        url : LaravelOrgin+'dev/all_langs' ,
        method : 'post'
      }).then((response)=>{
        vm.languages = response.data;
        window.AllLangs = response.data;
        let filter ;
        for(filter in response.data)
          vm.langFilters.push({ text : response.data[filter].display_name , value : response.data[filter].name })
      });
    } ,
    collectMessages(){
      this.staticMessages = [] ;
      this.staticMessagesIdFilter = [];
      const vm = this;
      axios({
        url : LaravelOrgin+'dev/all_msgs' ,
        method : 'post' ,
        onDownloadProgress : ()=>{ vm.collectMessagesLoading = true; },
        onUploadProgress : ()=>{ vm.collectMessagesLoading = true; },
        data : {
          language : vm.staticMessagesLanguageQuery , body : vm.staticMessagesBodyQuery , id : vm.staticMessagesIdQuery
        }
      }).then((response)=>{
        vm.collectMessagesLoading = false;
        vm.staticMessages = response.data;
        let filter ;
        for(filter in response.data)
          vm.staticMessagesIdFilter.push(response.data[filter].id)
          vm.staticMessagesIdFilter = vm.staticMessagesIdFilter.sort();
        for(filter in vm.staticMessagesIdFilter)
          vm.staticMessagesIdFilter[filter] = { text : vm.staticMessagesIdFilter[filter] , value : vm.staticMessagesIdFilter[filter]  }
      });
    } ,

     translateMessageDev(){
      if(this.staticMessagesLanguageTranslate.length == 0)
        {this.elementNotify({ title : 'Invalid Operation' , msg: 'The language is messing'});  return;}
      if(this.staticMessagesBodyTranslate.length == 0)
        {this.elementNotify({ title : 'Invalid Operation' , msg: 'The Body is messing'});  return;}
      if(this.staticMessagesIdTranslate.length == 0)
        {this.elementNotify({ title : 'Invalid Operation' , msg: 'The ID is messing'});  return;}
      const vm = this;
      axios({
        url : LaravelOrgin+'dev/translate' ,
        method : 'post' ,
        onDownloadProgress : ()=>{ vm.TranslateMessagesLoading = true; },
        onUploadProgress : ()=>{ vm.TranslateMessagesLoading = true; },
        data : {
          language : vm.staticMessagesLanguageTranslate , body : vm.staticMessagesBodyTranslate , id : vm.staticMessagesIdTranslate
        }
      }).then((response)=>{
        vm.TranslateMessagesLoading = false;
        vm.TranslateMessagesRes = response.data;
        vm.collectMessages();
      });
    } ,

    translateForceMessageDev(){
      if(this.staticMessagesLanguageTranslate.length == 0)
        {this.elementNotify({ title : 'Invalid Operation' , msg: 'The language is messing'});  return;}
      if(this.staticMessagesBodyTranslate.length == 0)
        {this.elementNotify({ title : 'Invalid Operation' , msg: 'The Body is messing'});  return;}
      if(this.staticMessagesIdTranslate.length == 0)
        {this.elementNotify({ title : 'Invalid Operation' , msg: 'The ID is messing'});  return;}
      const vm = this;
      axios({
        url : LaravelOrgin+'dev/translate/force' ,
        method : 'post' ,
        onDownloadProgress : ()=>{ vm.TranslateMessagesLoading = true; },
        onUploadProgress : ()=>{ vm.TranslateMessagesLoading = true; },
        data : {
          language : vm.staticMessagesLanguageTranslate , body : vm.staticMessagesBodyTranslate , id : vm.staticMessagesIdTranslate
        }
      }).then((response)=>{
        vm.TranslateMessagesLoading = false;
        vm.TranslateMessagesRes = response.data;
        vm.collectMessages();
      });
    } ,

      resetKnocks(){
      const vm = this;
      axios({
        url : LaravelOrgin+'dev/trunc/knocks' ,
        method : 'post' ,
        onDownloadProgress : ()=>{ vm.resetKnocksLoading = true; },
        onUploadProgress : ()=>{ vm.resetKnocksLoading = true; },
      }).then((response)=>{
        vm.resetKnocksLoading = false;
        vm.resetKnocksRes = response.data;
        vm.resetKnocksDialog = false;
        if(response.data == 'done') vm.elementNotify({title : 'Success' , msg : 'Ballons, Reactions, Blobs, Comments, Knocks tables has been truncated.'})
      }).catch((err)=>{vm.resetKnocksLoading=false;vm.elementNotify({title : 'Internal Server Error' , msg : 'Check your browser Dev tools > Network'})});
    } ,

    resetUsers(){
      const vm = this;
      axios({
        url : LaravelOrgin+'dev/trunc/users' ,
        method : 'post' ,
        onDownloadProgress : ()=>{ vm.resetKnocksLoading = true; },
        onUploadProgress : ()=>{ vm.resetKnocksLoading = true; },
      }).then((response)=>{
        vm.resetKnocksLoading = false;
        vm.resetKnocksRes = response.data;
        vm.resetKnocksDialog = false;
        if(response.data == 'done') vm.elementNotify({title : 'Success' , msg : 'Ballons, Reactions, Blobs, Comments, Knocks tables has been truncated.'})
      }).catch((err)=>{vm.resetKnocksLoading=false;vm.elementNotify({title : 'Internal Server Error' , msg : 'Check your browser Dev tools > Network'})});
    } ,
    reboundInitialData(){
      const vm = this;
      axios({
        url : LaravelOrgin+'dev/db/reinstall' ,
        method : 'post' ,
        onDownloadProgress : ()=>{ vm.resetKnocksLoading = true; },
        onUploadProgress : ()=>{ vm.resetKnocksLoading = true; },
      }).then((response)=>{
        vm.resetKnocksLoading = false;
        vm.resetKnocksRes = response.data;
        vm.resetKnocksDialog = false;
        if(response.data == 'done') vm.elementNotify({title : 'Success' , msg : 'Langauages and Presets inserted successfully'})
      }).catch((err)=>{vm.resetKnocksLoading=false;vm.elementNotify({title : 'Internal Server Error' , msg : 'Check your browser Dev tools > Network'})});
    },

    addNewWord(){
      const vm = this;
      axios({
        url : LaravelOrgin+'dev/new_word' ,
        method : 'post',
        data : {language : vm.wordAdderSelector , body : vm.wordAdderInput}
      }).then((response)=>{
        vm.addNewWordRes = response.data;
      });
    },
    formatter(row, column) {
        return row.language;
      },
      filterTag(value, row) {
        return row.language === value;
      },
      filterId(value, row) {
        return row.id === value;
      },
      onSwipeLeft(){
        console.log('left');
      }
   }
});
new Vue({
  el : '#footer'
});
window.NavInstance = new Vue({
  el : '#knocks_nav_vue',
  data : {

  currentIndex : null ,
  showProfileUploader : false ,
  sidebarSearch : '' ,
  sidebarSearchControllers : {} ,
  sidebarSearchFocus : false ,
  sidebarSeachLoading: false ,
  sidebarSearchResult : null ,
  rightSideBarMainTabs : 'chat' ,
  showSidebarGroupKey : 3 ,
  showSidebarKnockKey : 3 ,
  showSidebarUserKey : 3 ,
  sidebarXHRCancelToken : null ,
  sidebarXHRSource : null ,

  showRightSideBar : true ,
  sideBarSearchLanguage : currentUserLanguage ,
  sidebarSearchTaps : 'users' ,
  sidebarSearchRecognition : {loading : false , speaking : false , result : ''},
  searchTypingMode : false ,
  searchTypingResults : [] ,
  },
  mounted(){
  const vm = this ;

  //Right Sidebar

  App.$on('logoutGlobal' , ()=>{
    vm.logout()
  });

  $(document).ready(function(){
    if(WindowWidth < 900){
    vm.showRightSideBar = false;
  }



  // $(window).resize(function(){
  //   if(WindowWidth < 900){
  //     vm.showRightSideBar = true ;
  //   }else{
  //     vm.showRightSideBar = false ;
  //   }
  // });
  });


  // $(document).on('#sidebar_search_box' , function(){
  //   vm.sidebarSearchFocus = true;
  //    console.log('f');
  //   $('#sidebar_contents').slideUp( 200 , function(){
  //     $('#sidebar_head').slideUp(200);
  //     $('#sidebar_search_results').slideDown(200);
  //   });
  // });

  $(document).on('focus' , '#sidebar_search_box > input' , function(){
    vm.sidebarSearchFocus = true;
     console.log('f');
    $('#sidebar_contents').slideUp( 200 , function(){
      $('#sidebar_head').slideUp(200);
      $('#sidebar_search_results').slideDown(200);
    });
  });
  $(document).on('click' , '#app' , function(){
    if(vm.sidebarSearchFocus == true){
      vm.sidebarSearchFocus = false;
      $('#sidebar_head').slideDown(200 ,function(){
        $('#sidebar_contents').slideDown(200);
        $('#sidebar_search_results').slideUp(200);
      });
    }else return;
  });

    $(document).on('click' , '#sidebar_search_back' , function(){
    console.log('b');
    vm.sidebarSearchFocus = false;
    $('#sidebar_head').slideDown(200 ,function(){
      $('#sidebar_contents').slideDown(200);
      $('#sidebar_search_results').slideUp(200);
    });
  });


  },
  methods : {

    updateSearchQuery(q){
      this.sidebarSearchControllers.update(q)
      this.searchTypingMode = false
      this.sidebarRunSearch()
    },
    asset(url){
      return LaravelOrgin + url;
    },
    pp(){
      return this.asset('media/avatar/compressed/'+UserId);
    },
    coverPhoto(){
       return this.asset('media/cover/compressed/'+UserId);
    },
    coverExtended(){
       return this.asset('media/cover/'+UserId);
    },
    submitSearch(){
      $('#knocks_sidebar_search_form').submit();
    },
    sidebarRunSearch(){

      if(this.sidebarSearch.length == 0) return;
      const vm = this;
      //if(vm.sidebarSeachLoading)
      //vm.sidebarXHRSource.cancel('Operation canceled by the user.');
     // vm.sidebarXHRCancelToken = axios.CancelToken;
     // vm.sidebarXHRSource = vm.sidebarXHRCancelToken.source();
      vm.sidebarSeachLoading = true;
      axios({
        url : LaravelOrgin + '/search/main' ,
        method : 'post' ,
        // cancelToken: vm.sidebarXHRSource.token ,
        onDownloadProgress : ()=> { vm.sidebarSeachLoading = true; } ,
        data : {q : vm.sidebarSearch}
      }).then((res)=>{
        vm.sidebarSeachLoading = false ;
        let lastRes = vm.sidebarSearchResult;
        App.$emit('KnocksContentChanged');
        App.$emit('knocks_refresh_posts_done');
        setTimeout(()=>{
          vm.sidebarSearchResult = null;
           vm.sidebarSearchResult = res.data;
           if(vm.sidebarSearchResult.users.length > vm.sidebarSearchResult.groups.length && vm.sidebarSearchResult.users.length > vm.sidebarSearchResult.knock.length )
            vm.sidebarSearchTaps = 'users';
             if(vm.sidebarSearchResult.knock.length > vm.sidebarSearchResult.groups.length && vm.sidebarSearchResult.knock.length > vm.sidebarSearchResult.users.length )
            vm.sidebarSearchTaps = 'knock';
            if(vm.sidebarSearchResult.groups.length > vm.sidebarSearchResult.users.length && vm.sidebarSearchResult.groups.length > vm.sidebarSearchResult.knock.length )
            vm.sidebarSearchTaps = 'groups';
        } , 200);

      }).catch(()=>{ vm.sidebarSeachLoading = false });
    },
    closeSideBar(){
      $('.drag-target').click()
    },
    toggleGroupCreator(flag){
      this.closeSideBar();
      App.$emit('knocksGroupCreationToggle' , {toggle : flag})
    },
    runVoiceSearch(e){
      this.sidebarSearch = e;
      this.sidebarRunSearch();

    },
    showSidebarGroupRange(){
         return this.showSidebarGroupKey ;
      },
      inSidebarGroupRange(index){
        return index < this.showSidebarGroupRange() ? true : false;
      },
      showSidebarKnockRange(){
           return this.showSidebarKnockKey ;
        },
        inSidebarKnockRange(index){
          return index < this.showSidebarKnockRange() ? true : false;
        },
        showSidebarUserRange(){
             return this.showSidebarUserKey ;
          },
          inSidebarUserRange(index){
            return index < this.showSidebarUserRange() ? true : false;
          },

    plusNumber(input){
      return input > 9 ? '+9' : input;
    },
    isSmallWindow(){
      return WindowWidth < 900 ? true : false ;
    },
    searchFocus(){
         this.sidebarSearchFocus = true;
    },
    searchBlur(){
         this.sidebarSearchFocus = false;
    },
    sidebarFocus(){
      const vm = this;
      vm.sidebarSearchFocus = true;
     console.log('f');
    $('#sidebar_contents').slideUp( 200 , function(){
      $('#sidebar_head').slideUp(200);
      $('#sidebar_search_results').slideDown(200);
    });

    },
    sidebarBlur(){

    },
    logout(){
      this.closeSideBar();
      App.$emit('logged_out' );
      setTimeout(()=>{ window.location.href = LaravelOrgin+'user/logout' },1500);

    },
    setCoverTrigger(state){
      App.$emit('cover_uploader_status_changed' , state);
    },
    setProfileTrigger(state){
      App.$emit('profile_uploader_status_changed' , state);
    },
    setCircleAdderTrigger(state){
      App.$emit('circle_adder_status_changed' , state);
    },
    goToSettings(){
      window.location.href = Asset('user/settings')
    },
    profileIndex(){
      if(window.UserId >= 0){
        this.currentIndex =  parseInt(document.querySelector('meta[name="pp_index"]').getAttribute('content'));
        if(this.currentIndex == -1) this.showProfileUploader = true;
      }
    },
  }});
