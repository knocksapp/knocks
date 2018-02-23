<template>
<div class = "row">
  <div class="file-field input-field col s9" :id = "`knocks_input_file_parent_`+gid">
    <a @click = "cancelSelection()" class="red circle" v-if = "result != null">
      <span class="badge red-text"><span class = "knocks-close"></span></span>
    </a>
    <div class="col s12 btn knocks_file_upload valign-wrapper " :id = "gid+`_container`" >
      <span class = " knocks_valign plus_sign_fu  knocks_large_icon"
      :class = "[{'knocks-plus-outline':result == null} , { 'knocks-pencil9' : result != null} ]"></span>
      <knocksloaderprogress classes="animated slideInDown" :ref="loadingProgress" v-if="isLoading" :width="loadingProgress"></knocksloaderprogress>
      <input :id="gid" type="file" :accept="accepts" @change = "construct()" @focus ="clear()" class = "">
    </div>
    <div class="file-path-wrapper">
      <input class="file-path validate knocks_hidden " type="text" >
    </div>
    
    <div class = " col s12 knocks_hidden" style= "max-height : 300px; z-index : 1" :id = "`knocks_upload_port_`+gid" >
    </div>
    
  </div>
  <div class = " col s3 "  v-if = "cropAvailable">
    <knockspopover>
    <template slot = "container">
    <button
    class = "btn knocks_color_kit knocks_btn_color_kit knocks_small_button knocks_regular_border knocks_standard_border_radius knocks_color_kit wave-effect knocks_inline tooltipped"
    @click="cropRes()" v-if="!cropMode && crop" >
    <span class = "knocks-crop5 knocks_text_dark knocks_inline knocks_text_light" ></span>
    </button>
    </template>
    <span slot = "content"  class = "knocks_tooltip animated flipInX" v-if="!cropMode && crop"  >
      <span class = "knocks-crop5"></span>
      <static_message msg = "Crop"></static_message>
    </span>
    </knockspopover>
    <knockspopover>
    <template slot = "container">
    <button
    class = "btn knocks_color_kit knocks_btn_color_kit knocks_small_button knocks_regular_border knocks_standard_border_radius knocks_color_kit wave-effect knocks_inline" @click="upload()"
    v-if="!cropMode && special_submit" >
    <span class = "knocks-upload10 knocks_text_dark knocks_inline knocks_text_light   " ></span>
    </button>
    </template>
    <span slot = "content"  class = "knocks_tooltip animated flipInX" v-if="!cropMode && special_submit">
      <span class = "knocks-upload10"></span>
      <static_message msg = "Upload"></static_message>
    </span>
    </knockspopover>
    <knockspopover>
    <template slot = "container">
    <button
    class = "btn knocks_color_kit knocks_btn_color_kit knocks_small_button knocks_regular_border knocks_standard_border_radius knocks_color_kit wave-effect knocks_inline " @click="cropExcute()" v-if = "cropMode">
    <span class = "knocks-checkmark3 knocks_text_dark knocks_inline knocks_text_light   " ></span>
    </button>
    </template>
    <span slot = "content"  class = "knocks_tooltip animated flipInX" @click="cropExcute()"  v-if = "cropMode">
      <span class = "knocks-checkmark3"></span>
      <static_message msg = "Apply"></static_message>
    </span>
    </knockspopover>
    <knockspopover>
    <template slot = "container">
    <button
    class = "btn knocks_color_kit knocks_btn_color_kit knocks_small_button knocks_regular_border knocks_standard_border_radius knocks_color_kit wave-effect knocks_inline " @click="cancelCrop()" v-if = "cropMode">
    <span class = "knocks-cancel knocks_text_dark knocks_inline knocks_text_light   " ></span>
    </button>
    </template>
    <span slot = "content"  class = "knocks_tooltip animated flipInX" @click="cancelCrop()" v-if = "cropMode">
      <span class = "knocks-cancel"></span>
      <static_message msg = "Cancel"></static_message>
    </span>
    </knockspopover>
  </div>
</div>
</template>

<script>
export default {
  props : {
    accepts : {
      type : String ,
      default : ''
    },
    gid : {
      type : String ,
      required : true,
    },
    valid_ex : {
      type : Array ,
      default : null ,
    },
    crop : {
      type : Boolean ,
      default : false ,
    },
    gid : {
      type : String ,
      default : ''
    },
    upload_at : {
      type : String ,
      required : true 
    },
    upload_data : {
      type : Object ,
      required : true ,
    },
    success_at : {
      type : String ,
      default : ''
    },
    error_ar : {
      type : Array ,
      default : null
    } , 
    callback_event : {
      type : String ,
      default : null ,
    },
    callback_payloads : {
      type : Object ,
      default : null
    },
    special_submit : {
      type : Boolean ,
      default : false ,
    },
    scope : {
      type : Array , 
      default : null
    }
  } ,
   data(){
    return {
      isValid : false ,
      isFired : false ,
      isLoading : false ,
      loadingProgress : '' ,
      source : '',
      basic : null,
      result : null,
      cropAvailable : false ,
      cropMode : false ,
      errorMessages : [] ,
      errorsBus : [],
      recieved_data : null , 
      fileType : null ,
    }
  },
  mounted(){
    const vm = this ;
    this.$on('cropAvailable' , ()=>{ vm.cropAvailable = true;});
      App.$on('errorsMessageBusLoaded' , function(errorsMessageBus){
            vm.bindErrorBus(errorsMessageBus);
          });

      App.$on('knocks_submit' , function(scope){
            if(scope != null || scope == vm.scope){
              if(vm.scope == scope){
               vm.isFired = true;
               App.$emit('knocks_input_status' , vm.isValid);
              }
           }
          });
          App.$on('knocks_submit_passed' , function(){
            vm.upload();
          });
          App.$on('knocks_input_reset' , function(scope){
            if(scope == null || vm.scope == scope){
              $('#'+vm.gid).val('');
              vm.$emit('input','');
              vm.isFired = false ;
            }
          });



    $(document).ready(function(){
      $('.knocks_file_upload').css({'height' : $('.knocks_file_upload').width()});
      setTimeout(function(){
        var p = $($('body').find('.knocks_valign')).css
        ({'margin-top' : ($('.knocks_valign').parent().height()/2)-($('.knocks_valign').height()/2) });
      },500);
      $('.knocks_valign').removeClass('knocks_hidden').addClass('animated bounce');
    });




    //Prepare Node CSRF Layer


  },
  methods : {
    construct(){
      const vm = this;
      if(!this.isFired) this.isFired = true ;

      //File validation
      var node = document.getElementById(this.gid);
      if(node.length == 0){
         document.getElementById(vm.gid+'_container').style.backgroundImage = 'none';
        if(vm.is_required){
          vm.isValid = false;
          return;
        }else {
          vm.isValid = true;
          return;
      }}
      if(node.files && node.files[0])
      if(this.valid_ex.indexOf(node.files[0].type) == -1){
         this.isValid = false;
        vm.fileType = node.files[0].type ;
         console.log(node.files[0].type);
         return;
      }
      vm.isValid = true ;
      if(node.files && node.files[0]){
        var fr = new FileReader();
        fr.onprogress = function(data){
          if (data.lengthComputable) {
                vm.isLoading = true;
                var progress = parseInt( ((data.loaded / data.total) * 100), 10 );
                vm.loadingProgress = ''+progress;
            }
        }
        fr.onload = function (e) {
            
            App.$emit('refreshMatListeners');
            vm.isLoading = false;
              vm.source = e.target.result;
              document.getElementById(vm.gid+'_container').style.backgroundImage = 'url('+vm.source+')';
      
              $('#'+vm.gid+'_container').addClass('animated jello');
              vm.result = vm.source ;

              vm.$emit('cropAvailable');
              
            }
             fr.readAsDataURL(node.files[0]);
             
            }
        },
      cropRes(){

        const vm = this ;
        $($('body').find('#'+vm.gid+'_container')).addClass('bounceOut');
         $($('body').find('#knocks_upload_port_'+vm.gid)).removeClass('knocks_hidden')
         .removeClass('bounceOut').addClass('animated bounceIn');
         $($('body').find('#knocks_upload_port_'+vm.gid)).css({'position' : 'absolute' , 'top' : 1+'px'});
         vm.basic = new Croppie( document.getElementById('knocks_upload_port_'+vm.gid ), {
                     enableExif: true,
    viewport: {
        width: 200,
        height: 200,
        type: 'circle'
    },
    boundary: {
        width: 300,
        height: 300
    }
                });

         
                vm.basic.bind({
                  url : vm.source , 
                  //orientation : 4
                });



                vm.cropMode = true;    
                App.$emit('refreshMatListeners');     
      },
      cropExcute(){
        const vm = this ;
        this.basic.result('canvas' ).then(function(blob) {
          vm.result = blob;

          //Update the button background
          document.getElementById(vm.gid+'_container').style.backgroundImage = 'url('+vm.result+')';
          vm.cropAvailable = false;
          vm.cancelCrop();
          vm.cropAvailable = true;
          App.$emit('refreshMatListeners');
        });
      },
      clear(){
        $('#knocks_upload_port_'+this.gid).empty();
      },
      cancelCrop(){
        const vm = this;
        this.clear();
        this.cropMode = false ;
        App.$emit('refreshMatListeners');
        $($('body').find('.tooltipped')).tooltip({delay : 50});
         $($('body').find('#knocks_upload_port_'+vm.gid)).removeClass('bounceIn')
         .addClass('bounceOut').addClass('knocks_hidden');
        $($('body').find('#'+vm.gid+'_container')).removeClass('bounceOut knocks_hidden').addClass('bounceIn');
        
      },
      cancelSelection(){
        const vm = this;
        document.getElementById(vm.gid+'_container').style.backgroundImage = 'none';
        vm.cropAvailable = false ;
        vm.result = null ;
        vm.source = null ;
        vm.isValid = false ;
        $('#'+vm.gid).val('');
      },
      upload(){
         if($('#'+this.gid).val().length == 0) return;
        this.recieved_data = this.upload_data;
        this.recieved_data['blob'] = this.result;
        //this.recieved_data['_csrf'] = NodeCsrf ;
        console.log(this.recieved_data);

        const vm = this;
        let mType =  document.getElementById(this.gid).files[0].type;

        let compressed ;
        this.result = this.result.replace('data:image/png;base64,' , '');
        let cBlob = B64toBlob(this.result.replace('data:'+mType+';base64,' ,'') , mType );
        console.log(cBlob); 

        new ImageCompressor(cBlob, {
          quality: 0.6,
           maxHeight : 300  , 
           maxWidth : 300 ,

          success(result) {
            console.log(result);
            //Bring it back to base64
            var reader = new FileReader();
           reader.readAsDataURL(result); 
           reader.onloadend = function() {
               let base64data = reader.result;                
               //console.log(base64data);

                axios({
                  method : 'POST' ,
                  url : LaravelOrgin+vm.upload_at ,
                  data : { 
                    object : { 
                        compressed : base64data.replace('data:'+mType+';base64,' ,'') 
                      , blob : vm.recieved_data.blob.replace('data:'+mType+';base64,' ,'')
                      , extension :  mType 
                    }  
                  } ,
                  onDownloadProgress : function(data){
                    vm.isLoading = true ;
                    if (data.lengthComputable) {
                        vm.isLoading = true;
                        var progress = parseInt( ((data.loaded / data.total) * 100), 10 );
                        vm.loadingProgress = ''+progress;
                    }
                  },
                  onUploadProgress : function(data){
                    vm.isLoading = true ;
                    if (data.lengthComputable) {
                        vm.isLoading = true;
                        var progress = parseInt( ((data.loaded / data.total) * 100), 10 );
                        vm.loadingProgress = ''+progress;
                    }
                  }
                }).then(function(response){
                  vm.isLoading = false;
                  var temp = response.data;
                  if(temp == vm.success_at){
                     App.$emit('new_picture_uploaded' , {scope : vm.scope , blob : vm.result });
                          vm.$emit('knocks_file_uploaded' );
                        Materialize.toast(vm.success_msg, 3000, 'rounded');
                        vm.cancelSelection();
                        if(vm.callback_event != null){
                          App.$emit(vm.callback_event , vm.callback_payloads);
                        }
                      return true;
                  }else{
                    var i ;
                    for( i = 0; i < vm.error_at.length ; i++ ){
                      if(vm.error_at[i].res == temp){
                        Materialize.toast('<span class="knocks_text_danger">'+vm.error_at[i].msg+'</span>', 3000, 'rounded');
                        return false;
                      }else Materialize.toast('<span class="knocks_text_danger">'+vm.error_at[i].msg+'</span>', 3000, 'rounded');
                    }
                  }
                });




           }
          },
          error(e) {
            console.log(e.message);
          },
        });

        return ;





      },
      bindErrorBus(errorsMessageBus){
            this.errorsBus = [
              { message_id : errorsMessageBus[0]  , icon : 'knocks-alert-circle' , prefix : null , postfix : null},
              { message_id : errorsMessageBus[8]   , icon : 'knocks-alert-circle' , prefix : null , postfix : this.min},
            ];
          },
  },
}
</script>

<style lang="css">

</style>
