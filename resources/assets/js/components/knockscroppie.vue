<template>
<div class = "row" :id="gid+'_parent_div'"> 
  <span :id="gid+'_croppieContainer'" :class = "[{'knocks_hidden' : !cropping}]"></span>
  <div v-loading = "isLoading" class="file-field input-field col s12" :id = "`knocks_input_file_parent_`+gid" :class = "[{'animated jello ' : cropping == null} , {'knocks_hidden' : cropping}]">
    <div class="col s12 btn knocks_file_upload valign-wrapper " :id = "gid+`_container`" >
      <span class = " knocks_valign plus_sign_fu  knocks_large_icon"
      :class = "[{'knocks-plus-outline':croppieElm == null} , { 'knocks-pencil9' : croppieElm != null} ]"></span>
      <input :id="gid+'_fileItem'" type="file" :accept="accepts" @change = "bindCroppie($event)">
    </div>
  </div>
  <div class = "col s12">
    <center>
    <div class="ui buttons" v-if = "cropping">
      <button @click="crop()" :class = "[ { 'knocks_hidden' : !cropping}]" class="ui button positive">
      <el-tooltip placement="bottom">
      <div slot="content"><static_message msg = "Crop"></static_message></div>
      <span class = "knocks-checkmark8"></span>
      </el-tooltip>
      </button>
      <div class="or" data-text="OR"></div>
      <button  @click="cancel()" :class = "[ { 'knocks_hidden' : !cropping}]" class="ui button negative">
      <el-tooltip placement="bottom">
      <div slot="content"><static_message msg = "Cancel"></static_message></div>
      <span class = "knocks-close"></span>
      </el-tooltip>
      </button>
    </div>
    <div class="ui buttons" v-if = "cropping">
      <button @click="rotate(-90)" :class = "[ { 'knocks_hidden' : !cropping}]" class="ui button violet">
      <el-tooltip placement="bottom">
      <div slot="content"><static_message msg = "Rotate Left"></static_message></div>
      <span class = "knocks-rotate"></span>
      </el-tooltip>
      </button>
      <div class="or" data-text="OR"></div>
      <button  @click="rotate(90)" :class = "[ { 'knocks_hidden' : !cropping}]" class="ui button purple">
      <el-tooltip placement="bottom">
      <div slot="content"><static_message msg = "Rotate Right"></static_message></div>
      <span class = "knocks-rotate2"></span>
      </el-tooltip>
      </button>
    </div>
    <div class = "knocks_fair_bounds animated bounceIn" v-if = "cropped != null && !cropping">
      <button @click = "upload()" v-loading = "isLoading" class="waves-effect waves-light btn knocks_standard_border_radius knocks_color_kit knocks_btn_color_kit knocks_noshadow_ps ">
      <static_message msg = "Upload"></static_message>
      <span class = "knocks-cloud-upload5"></span>
      </button>
        <button @click = "bindCroppie(bindEvent)" :disabled ="isLoading" v-if = "bindEvent != null"  class="waves-effect waves-light btn knocks_standard_border_radius knocks_color_kit knocks_btn_color_kit knocks_noshadow_ps ">
      <static_message msg = "Edit"></static_message>
      <span class = "knocks-pencil9"></span>
      </button>
    </div>
    </center>
  </div>
</div>
</template>

<script>
export default {

  name: 'knockscroppie',

  props: {
    gid : {
      type : String , 
      default : 'knocks_croppie'
    },
    accepts : {
      type : String ,
      default : 'image/*'
    },
    boundary : {
      type : Object , 
      default (){
        return { width : 300 , height : 300}
      }
    } ,
    viewport : {
      type : Object , 
      default (){
        return { width : 280 , height : 280}
      }, 
    },
    aspect_ratio : {
      type : Number , 
      default : 1 , 
    },
    upload_at : {
      type : String ,
      required : true 
    },
    upload_data : {
      type : Object ,
      default : null ,
    },
    success_at : {
      type : String ,
      default : ''
    },
    success_msg : {
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
  },

  data () {
    return {
    	  croppieElm: null,
        cropped: null,
        cropping : false ,
        lastCropUrl : null ,
        isLoading : false ,
        bindEvent : null , 
        aspectPort : { width : 0 , height : 0} ,
        fullPort :  { width : 0 , height : 0} ,

    }
  },
  mounted () {
    const vm = this ;
    $(document).ready(function(){
      vm.aspectPort.width = $('#'+vm.gid+'_parent_div').width()*3/4;
      vm.aspectPort.height = vm.aspectPort.width * vm.aspect_ratio ;
      vm.fullPort.width = $('#'+vm.gid+'_parent_div').parent().width();
      vm.fullPort.height = vm.fullPort.width * vm.aspect_ratio ;

      $('.knocks_file_upload').css({'height' : vm.fullPort.height });
      setTimeout(function(){
        var p = $($('body').find('.knocks_valign')).css
        ({'margin-top' : ($('.knocks_valign').parent().height()/2)-($('.knocks_valign').height()/2) });
      },500);
      $('.knocks_valign').removeClass('knocks_hidden').addClass('animated bounce');

 
    });

     

    



  },
  methods : {
  	 bindCroppie (event) {

      
     // destroy croppie

     const vm = this;
     if(document.getElementById(vm.gid+"_fileItem").value == "") return;
     this.bindEvent = event;
     vm.cropping = true ;
     document.getElementById(vm.gid+'_croppieContainer').innerHTML = ''
     if(vm.croppieElm) this.croppieElm.destroy()

     // create new element for croppie
     var div = document.createElement(vm.gid+"_div")
     document.getElementById(vm.gid+'_croppieContainer').append(div)
     this.croppieElm = new Croppie(div, {
         boundary: vm.fullPort,
         viewport: vm.aspectPort,
         enableOrientation: true,
     })

     this.croppieElm.bind({
         url: window.URL.createObjectURL(event.target.files[0]),
         zoom: 0.1
     })
 },
 notifi() {
        const vm = this;
        const h = this.$createElement;
        this.$message({
          message: h('p', null, [
            h('span', { class : 'knocks_text_ms knocks_text_dark'},  vm.success_msg ),
            h('i', {  class : ' knocks-check knocks_icon knocks_text_md green-text' })
          ])
        });
      
      },
      notifiError(errorMsg) {
            
         const h = this.$createElement;
        this.$message({
          message: h('p', null, [
            h('span', { class : 'knocks_text_ms knocks_text_dark'}, errorMsg),
            h('i', {  class : ' knocks-warning7 knocks_icon knocks_text_md red-text' })
          ])
        });
      
      },

 crop() {
     let options = {
         type: 'base64',
         size: 'viewport',
         format: 'jpeg',
         circle: false
     }
     let vm = this

     this.croppieElm.result(options).then(function (output) {
         vm.cropped = output
         vm.cropping = false ;

         document.getElementById(vm.gid+'_container').style.backgroundImage = 'url('+vm.cropped+')';

     });
 },
 rotate(rotationAngle) {
     this.croppieElm.rotate(rotationAngle);
 },
 cancel(){
  this.cropping = false ;
  if(this.croppieElm) this.croppieElm.destroy()
  this.croppieElm = null;
 },
 upload(){
  const vm = this ;



  //Validation
  if(vm.cropped == null) return;
  this.isLoading = true;
  let mType = 'image/jpeg';
   let cBlob = B64toBlob(this.cropped.replace('data:'+mType+';base64,' ,'') , mType );
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



                let ob = {
                  object : { 
                              compressed : base64data.replace('data:'+mType+';base64,' ,'') 
                            , blob : vm.cropped.replace('data:'+mType+';base64,' ,'')
                            , extension :  mType 
                          }  ,
                  externals : vm.upload_data

                }


                axios({
                  method : 'POST' ,
                  url : LaravelOrgin+vm.upload_at ,
                  data : ob , 
                    
                      onUploadProgress: function (progressEvent) {
                        vm.isLoading = true;
                      },
                      onDownloadProgress: function (progressEvent) {
                        vm.isLoading = true;
                      },
                  

                }).then(function(response){
                  vm.isLoading = false;
                  var temp = response.data;
                  if(temp == vm.success_at){
                     App.$emit('new_picture_uploaded' , { blob : vm.cropped , scope : vm.scope });
                          vm.$emit('knocks_file_uploaded' );
                        vm.notifi();
                        vm.cropped = null;
                       vm.cancel();
                        if(vm.callback_event != null){
                          App.$emit(vm.callback_event , vm.callback_payloads);
                        }
                      return true;
                  }else{
                    var i ;
                    for( i = 0; i < vm.error_at.length ; i++ ){
                      if(vm.error_at[i].res == temp){
                        vm.notifiError(vm.error_at[i]);
                        return false;
                      }else  vm.notifiError(vm.error_at[i].msg);
                    }
                  }
                }).catch(()=>{
                   vm.notifiError('Upload was not completed, please check your internet connection and try again.');
                });




           }
          },
          error(e) {



                          let ob = {
                  object : { 
                              compressed : null
                            , blob : vm.cropped.replace('data:'+mType+';base64,' ,'')
                            , extension :  mType 
                          }  ,
                  externals : vm.upload_data

                }
                  axios({
                  method : 'POST' ,
                  url : LaravelOrgin+vm.upload_at ,
                  data : ob ,
                      onUploadProgress: function (progressEvent) {
                        vm.isLoading = true;
                      },
                      onDownloadProgress: function (progressEvent) {
                        vm.isLoading = true;
                      },
                  

                }).then(function(response){
                  vm.isLoading = false;
                  var temp = response.data;
                  if(temp == vm.success_at){
                     App.$emit('new_picture_uploaded' , { blob : vm.cropped , scope : vm.scope });
                          vm.$emit('knocks_file_uploaded' );
                        vm.notifi();
                        vm.cropped = null;
                       vm.cancel();
                        if(vm.callback_event != null){
                          App.$emit(vm.callback_event , vm.callback_payloads);
                        }
                      return true;
                  }else{
                    var i ;
                    for( i = 0; i < vm.error_at.length ; i++ ){
                      if(vm.error_at[i].res == temp){
                        vm.notifiError(vm.error_at[i]);
                        return false;
                      }else  vm.notifiError(vm.error_at[i].msg);
                    }
                  }
                }).catch(()=>{
                   vm.notifiError('Upload was not completed, please check your internet connection and try again.');
                });
            
          },
        });

  }
  }
}
</script>

<style lang="css" scoped>
</style>