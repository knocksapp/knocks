<template>
  <el-tooltip>
    <div slot = "content">
      <div v-if = "hasTryAgain">
        <i class="material-icons" :class = "buttonIcon" v-if="!isLoading"></i>
        <span :class="label_classes" v-if = "placeholder != null">Try Again</span>
      </div>
      <div v-else>
        <i class="material-icons" :class = "buttonIcon" v-if="!isLoading"></i>
        <span  :class="label_classes" v-if = "placeholder != null">{{placeholder}}</span>
      </div>
    </div>
  <button class=" " :id = "gid" @mouseover = "isHovered = true; emit()" @mouseleave = "isHovered = false; emit()"
  :class = "buttonClasses" @click = "construct()" :disabled = "isLoading || disabled">
    <i class="material-icons" :class = "buttonIcon" v-if="!isLoading"></i>
    <knocksloader size = "small" v-if="isLoading"></knocksloader>
        <static_message :msgid="place_holder" :class="label_classes" v-if = "placeholder == null && !disable_placeholder">
        </static_message>
        <static_message :msg="placeholder" :class="label_classes" v-else-if = "placeholder != null && !disable_placeholder" >
        </static_message>
  </button>
</el-tooltip>
</template>

<script>
export default {
  props : {
    icon : {
      type : [String , Array , Object] ,
      default : ''
    } ,
    gid : {
      type :String ,
      required : true
    },

    align : {
      type : String ,
      default : 'left'
    } ,
    button_classes : {
      type : [String , Array , Object] ,
      default : 'waves-effect waves-light btn knocks_btn knocks_color_kit knocks_text_md'
    },
    place_holder : {
      type : Number ,
      default : null ,
    } ,
    placeholder : {
      type : String ,
      default : null ,
    },
    disable_placeholder : {
      type : Boolean ,
      default : false ,
    },
    label_classes : {
      type : String ,
      default : ''
    },
    knocksclass : {
      type : String ,
      default : ''
    },
    success_class : {
      type : String ,
      default : 'knocks_input_success '
    } ,
    error_class : {
      type : String ,
      default : 'knocks_input_error animated shake'
    } ,
    submit_flag : {
      type : Boolean ,
      default : true,
    } ,
    submit_at : {
      type : String ,
      default : null
    } ,
    submit_data : {
      type : Object ,
      default:null
    },
    success_at:{
      type: String ,
      default : null,
    } ,
    success_msg : {
      type : String ,
      default : ''
    },
    error_at : {
      type : Array ,
      default : null ,
    } ,
    scope : {
      type : Array ,
      default : null
    } ,
    reset_on_success : {
      type : Boolean ,
      default : false ,
    },
    reset_on_submit : {
      type : Boolean ,
      default : false ,
    },
    submit_on : {
      type : Array ,
      default : null
    },
    hover_class : {
      type : String ,
      default : 'animated rubberBand'
    },
    leave_class : {
      type : String ,
      default : 'animated bounce'
    },
    validation_error : {
      type : String ,
      default : ''
    },
    connection_error : {
      type : String ,
      default : ''
    },
    validate : {
      type : Boolean ,
      default : true
    },
    materialize_feedback : {
      type : Boolean ,
      default : true
    },
    computed_response : {
      type : Boolean ,
      default : false
    },
    precondition : {
      type : Boolean ,
      default : null
    },
    disabled : {
      type : Boolean ,
      default : false ,
    },
    hide_success_msg : {
      type : Boolean ,
      default : false
    },
    no_tryagain : {
      type : Boolean ,
      default : false 
    }


  } ,
  data : function(){
    return {
      lang_alignment : document.querySelector('meta[name="lang_alignment"]').getAttribute('content') ,
      errorsStack : [],
      isLoading : false ,
      isHovered : false ,
      response : null ,
      networkHasErrors : false ,
      networkErrors : null ,
      actualLoading : false ,
      hasTryAgain : false
    }
  },
  computed : {
    buttonClasses(){
      let array = [];
      array.push(this.lang_alignment);
       if(this.isLoading) array.push('animated pulse');
      if(this.isHovered) array.push(this.hover_class);
      else array.push(this.leave_class);
      array.push(this.button_classes);
      if(this.disabled || this.isLoading) array.push('disabled');
      return array;

      // [lang_alignment, {'disabled animated pulse': isLoading} , {hover_class , isHovered} ,{ 'disabled' : disabled } , button_classes]
    },
    buttonIcon(){
      let arr = []
      if(!this.hasTryAgain) arr.push(this.icon)
      if(this.hasTryAgain) arr.push('el-icon-refresh')
      if(!this.disable_placeholder && this.align == 'right') arr.push('right')
      if(!this.disable_placeholder && this.align == 'left') arr.push('left')
      return arr;
    }
  },
  mounted(){
    const vm = this;
    this.emit();

    App.$on('knocks_input_status' , function(status){
      if(!status) vm.errorsStack.push(1);
    });

    App.$on('knocksFinalSubmit' , (payload)=>{
      if(vm.scope == null || !vm.scope || payload.scope === undefined || payload.scope == null) return
      let tar;
        for(tar = 0 ; tar < payload.scope.length ; tar++){
        if(vm.scope && payload.scope[tar])
        if(vm.scope.indexOf(payload.scope[tar]) != -1){
          if(vm.submit_flag && vm.errorsStack.length == 0 && !vm.actualLoading){
            vm.submit();
            return ;
          }
        }
      }
    });

     App.$on('knocksButtonRemoteClick' , (payload)=>{
      if(vm.scope == null || !vm.scope || payload.scope === undefined || payload.scope == null) return
      let tar;
        for(tar = 0 ; tar < payload.scope.length ; tar++){
        if(vm.scope && payload.scope[tar])
        if(vm.scope.indexOf(payload.scope[tar]) != -1){
          console.log('matched remote click')
          vm.construct()
          return
        }
      }
    });

      App.$on('knocksButtonVirtualStop' , (payload)=>{
        if(vm.scope == null) return
      let tar;
        for(tar = 0; tar <  payload.scope.length; tar++){
        if(vm.scope.indexOf(payload.scope[tar]) != -1){
          vm.isLoading = false ;
          if( !vm.no_tryagain && (payload.tryAgain === undefined || payload.tryAgain == true) ){
            vm.hasTryAgain = true
          }
          vm.emit();
          return ;
        }
      }
    });

          App.$on('knocks_presubmit' , (scope)=>{
            if(scope != null){
              let i;
              if(vm.scope == null) return;
              for(i = 0; i < scope.length; i++){
                if(vm.scope.indexOf(scope[i]) != -1){
                 vm.construct();
                 return;
                }
              }
              return;
           }else if(scope == null && vm.scope == null){
           vm.construct();
           }
          });

          App.$on('knocksClearGlobalErrorStack' , ()=>{
            vm.errorsStack = [];
          });

    // $('#'+this.gid).hover(function(){
    //   $($(this).find('span')).addClass(vm.hover_class);
    //   $(this).addClass(vm.hover_class);
    // });
    // $('#'+this.gid).mouseleave(function(){
    //   $($(this).find('span')).removeClass(vm.hover_class);
    //    $(this).removeClass(vm.hover_class);
    // });
  },
  methods:{
    construct(){
      if(this.isLoading || this.disabled) return;
      this.$emit('knocks_button_clicked' , this.scope);
      if(!this.validate) return;
      this.errorsStack = [],
      console.log('%cknocks_submit_from '+this.scope , "font-size : 14px")
      App.$emit('knocks_submit' , this.scope);
      if(this.errorsStack.length == 0 && (this.precondition == true || this.precondition == null)){
        this.$emit('knocks_stack_passed');
        if(this.submit_flag)
           if(this.submit_on == null){
            this.submit();
           }else{
            this.isLoading = true ;
            this.emit();
           }
      }else{
        if(this.materialize_feedback)
        Materialize.toast('<span class="knocks_text_danger">'+this.validation_error+'</span>');
        else this.elementCategoryNotify({ type : 'error' , msg : this.validation_error , title : 'Warining' });
        this.$emit('knocks_stack_failed');
        //console.log(this.errorsStack);
      }
    },
    emit(){
      this.$emit('input' ,
        {
          isLoading : this.isLoading ,
          isHovered : this.isHovered ,
          response  : this.response ,
          networkErrors : this.networkHasErrors ,
          networkHasErrors :  this.networkErrors ,
          submit : this.construct , 
          finalSubmit : this.submit , 
          reset : this.reset
        });
    },
    reset(){
      this.isLoading = false 
       if( !this.no_tryagain && (arguments[0] === undefined || arguments[0] === true) ){
            this.hasTryAgain = true
        }
    },
    elementCategoryNotify(notificationObject) {
      this.$notify({
        title: notificationObject.title,
        message: notificationObject.msg,
        type: notificationObject.type
      });
    },
    isAnError(res){
      if(this.error_at == null) return false ;
      let err ;
      for(err in this.error_at){
        if(this.error_at[err].res == res)
          return true;
      }
      return false ;
    },
    submit(){
      if(window.navigator.onLine !== undefined && !window.navigator.onLine){
          this.elementCategoryNotify({ type : 'error' , msg : 'There is no internet connection' , title : 'Warining' })
          if(window.location.hostname == 'knocks.dev'){
            console.warn('%cThere is no internet connection, This is only working because the App is under development.','font-size:18px;color:red;font-family:monospace')
          }else{
             this.actualLoading = false;
             this.isLoading = false
             this.hasTryAgain = true
             return
          }
      }
      if(this.actualLoading) {console.log('prevent extra s'); return; }
      this.actualLoading = true;
      this.hasTryAgain = false
      //console.log(this.submit_data);
      App.$emit('knocks_submit_passed');
      const vm = this;
      this.emit();
      axios
      ({
          method:'post',
          url:LaravelOrgin+vm.submit_at,
          timeout : 10000,
          data : vm.submit_data ,
          onDownloadProgress: function (progressEvent) {
            vm.isLoading = true;
            vm.emit();
          },
          onUploadProgress: function (progressEvent) {
            vm.isLoading = true;
            vm.emit();
          },
      })
      .then(function(response) {
        vm.isLoading = false;
        vm.actualLoading = true;
        vm.response = response.data;
        vm.emit();
        // vm.$emit('input' , response.data);
        if(vm.reset_on_submit)App.$emit('knocks_input_reset' , vm.scope);
        var temp = response.data;
        vm.networkHasErrors = false ;
        vm.networkErrors = null ;
        if((temp == vm.success_at && vm.success_at != null) || vm.computed_response && !vm.isAnError(temp) ){
          if(vm.materialize_feedback && !vm.hide_success_msg)
             Materialize.toast(vm.success_msg, 3000, 'rounded');
           else if(!vm.hide_success_msg) vm.elementCategoryNotify({ type : 'success' , msg : vm.success_msg , title : 'success' });
          if(vm.reset_on_success){
            App.$emit('knocks_input_reset' , vm.scope);
          }
          vm.$emit('knocks_submit_accepted' , {submit_data : vm.submit_data , response : temp});
          vm.actualLoading = vm.isLoading = false
          return true;
        }else{
          vm.$emit('knocks_submit_rejected' , {  response : response.data , submit_data : vm.submit_data });
          vm.isLoading = vm.actualLoading = false
          var i ;
          for( i = 0; i < vm.error_at.length ; i++ ){
            if(vm.error_at[i].res == temp){
              if(vm.materialize_feedback)
                Materialize.toast('<span class="knocks_text_danger">'+vm.error_at[i].msg+'</span>', 3000, 'rounded');
              else vm.elementCategoryNotify({ type : 'error' , msg : vm.error_at[i].msg , title : 'Warining' });
              return false;
            }
          }
        }


      }).catch((err)=>{
        vm.networkHasErrors = true ;
        vm.networkErrors = err.response ;

        //handle error
        let msg = '';
        if(vm.networkErrors.status == 404){
          msg = "Whoops, Seems like you're lost, try to refresh your page, otherwise kindly report us about it so we can fix it."
        }

        if(vm.networkErrors.status == 500){
          msg = "Whoops, Seems like something went wrong, try to refresh your page, otherwise kindly report us about it so we can fix it."
        }

        if(vm.networkErrors.status == 402){
          msg = "Some fields are not completed, please complete them first and try again."
        }

        if(vm.networkErrors.status == 401){
          msg = "Whoops, Your session has expired, please refresh your page and try again."
        }




        vm.$emit('knocks_submit_error');
        vm.elementCategoryNotify({ type : 'error' , msg : msg , title : 'Warining' })
        vm.isLoading = vm.actualLoading = false ;
        if(window.navigator.onLine !== undefined && !window.navigator.onLine){
          vm.elementCategoryNotify({ type : 'error' , msg : 'There is no internet connection' , title : 'Warining' })
        }

        if(!vm.no_tryagain){
          vm.hasTryAgain = true
        }

      });
    }

  }
}
</script>

<style lang="css">
</style>
