<template lang="html">
  <div id="notifications">
<div>
</div>
  </div>
</template>
<script>
export default {
  props:{
   inputValue:{
     type : String,
     default : ''
   },
   ballon_type:{
     type : String,
     default : 'normal'
   },
   ballon_function:{
     type : String,
     default : 'normal'
   },
   user_name:{
     type : String,
     default: 'Hesham Ahmed'
   },
   image_url:{
     type :String,
     default :  window.location.protocol+'//'+window.location.hostname+':'+window.location.port+'/snaps/knocks.png'
   } ,
   user_url:{
     type : String,
     default : ''
   },
   text_value:{
     type:String,
     default : 'Text Here'
   },
   custom_animate:{
     type:String,
     default:'shake'
   },
   ballon_date:{
         type : String,
         default : ''
   },
   button_value:{
     type:String,
     default:'Button Name'
   },
   input_placeholder:{
     type:String,
     default:'Placeholder Here'
   },
   gid:{
     type:String,
     required:true
   },
   mute:{
     type : Boolean,
     default : false
   },
   url_reference:{
       type : String,
       default : window.location.protocol+'//'+window.location.hostname+':'+window.location.port+'/snaps/knocks.png'
   },
   reference_word:{
       type : String,
       default : 'post&apos;s'
   },
   user_url:{
       type : String,
       default : window.location.protocol+'//'+window.location.hostname+':'+window.location.port+'/snaps/knocks.png'
   },
   is_image : {
        type : Boolean,
        default : false
   },
   icon :{
         type : String,
         default : 'knocks-knocks'
   },
   closer:{
     type: Boolean,
     default: 'true'
   },
   show_user_name : {
        type : Boolean,
        default : true
   },
   title_value:{
    type : String,
    default : 'Knocks Noti.'
   },
  },
  computed:{
  },
  methods:{
    closing(){
      const vm = this
      var cls = '<div class = "col s2 right"><a class="close_noty knocks-close knocks_text_dark"></a></div>';
      if(vm.closer == true)
      return cls;
      return '<div class = "col s2"></div>'
    },
    //check for image or icon 
    checkImageOrIcon(){
      const vm = this
           if(vm.is_image)
                return '<img class="notimg responsive-img" style = "border-radius : 10px;"  src="'+vm.image_url+'"/>';
            else
                return '<span class = "knocks-'+vm.icon+'" style = "font-size : 35px"></span>';
      },
      showNameOrNot(){
           const vm = this
           if(vm.show_user_name)
            return '<a class="knocks_text_dark glowing" href = "'+vm.user_url+'">'+vm.user_name+'</a>';
          else
            return '<a class="knocks_text_dark glowing" href = "">'+vm.title_value+'</a>';
      },
    noty(){
    
    const vm = this
    //Mute Notification Or Not
     var vidId = document.getElementById('knocks_notification');
      if(vm.mute == true){}
      else{
      vidId.play();
      setTimeout(function () {
          vidId.pause();
      },3000);
    }
      switch(vm.ballon_type) {
    case 'replyable':
         var html =
        '<div class = "row">'+
        '<div><div class = "col s9">'+
        '<knocksinput gid = "ballon_button'+vm.gid+'" v-model = "invalue" icon="knocks-atom" placeholder="'+vm.input_placeholder+'" holder_class = "" :is_required = "false" scope = "search_word"></knocksinput>'+
        '</div><div class = "col s3"><knocksbutton submit_at = "glob" '+
        ' success_at = "search_id" '+
        ' success_msg = "" '+
        ' :error_at = "[]" '+
        'button_classes="col s12"'+
        ' gid = "ballon_button_'+vm.gid+'" '+
        ':disable_placeholder="true"'+
        ' scope = "search_word" '+
        ' icon = "knocks-search12" '+
        '></knocksbutton></div></div></div>';
        break;
    case 'global news':
         var html = '<div class = "row">'+
        '<div><div class = "col s9">'+
        '<knocksrecorder'+
        '</knocksrecorder>'+
        '</div></div></div>';
         break;
    default:
         var html = '<div></div>';
}
    
        var url = "";
      Vue.prototype.$appName
        $.get(url, function (data) {
          var res = Vue.compile(html)
            var a = this.$parent;
          window.Lol = new Vue({
            render: res.render,
            staticRenderFns: res.staticRenderFns,
            data : {
              invalue:'In Input Component'
          },
          mounted(){
            console.log(a.invalue);
            console.log(this.$root.invalue);
          }
          }).$mount('#media_lib_app')
         var r = this.$parent
       }.bind(this)); 
     
      
      var close = new PNotify({
    title:
    '<div class="row closing">'+vm.closing()+'</div>'+
    '<div class = "row knocks_house_keeper">'+
    '<div class = "col s4"><a href="'+vm.user_url+'"><img class="notimg responsive-img circle animated '+vm.image_animation+'"  src="'+vm.image_url+'"/></a></div>'+
    '<div class = "col s7"><span class="knocks_text_dark com">'+vm.showNameOrNot()+'</a></span></div>'+
    
    '</div><hr/>',
    text:   '<div class = "row">'+
    '<div class = "col s3">'+vm.checkImageOrIcon()+'</div>'+
    '<div class = "col s5 animated fadeIn">'+vm.text_value+'<a href="'+vm.url_reference+'"> '+vm.reference_word+'</a></div>'+
    '</div>'+
    '<span></span><div id="media_lib_app"></div>'+
    '<div class = "row">'+
    '<span class = "animated fadeIn knocks_text_dark right small date_ago">'+moment(vm.ballon_date , 'YYYY-MM-DD hh:mm:ss').startOf('hour').fromNow()+'</span></div>',
    addclass: 'custom animated '+vm.custom_animate,
    buttons:{
      closer : true,
      sticker : false
    },
    nonblock: {
        nonblock: false
    },
    confirm: {
      prompt: true
    },
    destroy: false
});
close.get().click(function(e) {
  if ($(e.target).is('.close_noty'))
    close.remove();
});
$('.close_noty').hover(function(){
    $(this).addClass('close_noty knocks-close animated tada knocks_text_dark"');
});
$('.close_noty').mouseleave(function(){
    $(this).removeClass('animated tada');
});
},
loader(){
   
  const vm = this;
//knocks notification sound
   var vidId = document.getElementById('knocks_notification');
      if(vm.mute == false){}
      else{
      vidId.play();
      setTimeout(function () {
          vidId.pause();
      },3000);
    }
  var cur_value = 1,
       progress;
       var loader = new PNotify({
              title: '<span class="knocks-user"></span>Knocks Progress',
              text: ' <div class="progress pink darken-1"><div class="determinate pink darken-4" style="width: 30%"></div>',
              //icon: 'fa fa-moon-o fa-spin',
              icon: 'fa fa-cog fa-spin',
              hide: false,
              addclass:'custom animated '+vm.custom_animate,
              buttons: {
                  closer: false,
                  sticker: false
              },
              history: {
                  history: false
              },
              before_open: function(notice) {
                  progress = notice.get().find("div.progress-bar");
                  progress.width(cur_value + "%").attr("aria-valuenow", cur_value).find("span").html(cur_value + "%");
                  // Pretend to do something.
                  var timer = setInterval(function() {
                      if (cur_value == 70) {
                          loader.update({
                              title: "Aligning discrete worms",
                              icon: "fa fa-circle-o-notch fa-spin"
                          });
                      }
                      if (cur_value == 80) {
                          loader.update({
                              title: "Connecting end points",
                              icon: "fa fa-refresh fa-spin"
                          });
                      }
                      if (cur_value == 90) {
                          loader.update({
                              title: "Dividing and conquering",
                              icon: "fa fa-spinner fa-spin"
                          });
                      }
                      if (cur_value >= 100) {
                          // Remove the interval.
                          window.clearInterval(timer);
                          loader.remove();
                          return;
                      }
                      cur_value += 1;
                      progress.width(cur_value + "%").attr("aria-valuenow", cur_value).find("span").html(cur_value + "%");
                  }, 65);
              }
          });
}
  },
  mounted(){
                 switch(this.ballon_function) {
    case 'normal':
        this.noty();
        break;
    case 'loader':
         this.loader();
        break;
    default:
        this.noty();
}
  },
  data(){
    return{
    }
  }
}
</script>
<style lang="css">
.ui-pnotify.custom .ui-pnotify-container {
background-color: #fff8dc !important;
background-image: none !important;
width: 105% !important;
color: #691a40;
border: none !important;
-moz-border-radius: 10px;
-webkit-border-radius: 10px;
border-radius: 10px;
}
.ui-pnotify.custom .ui-pnotify-icon {
float: left;
}
.notimg{
  height: 15%;
  width : 100%;
}
.com{
  font-size: 20px !important;
  margin-bottom: 10px !important;
  
}
.ui-pnotify-title > .str{
}
.ui-pnotify-container{
  background-color: #fff8dc !important;
  opacity: 0.7 !important;
}
.determinate{
   height: 10px !important;
   border-radius: 5px !important;
}
.progress{
  height: 10px !important;
  border-radius: 5px !important;
}
.date_ago{
  margin-right: 3% !important;
}
.date_panel{
  margin-top: 10% !important;
}
.closing{
  margin-bottom: -10% !important;
}
.glowing:hover{
  -webkit-stroke-width: 5.3px !important;
      -webkit-stroke-color: #691a40 !important;
      -webkit-fill-color: #691a40 !important;
      text-shadow: 1px 0px 20px #691a40 !important;
}
</style>