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
  <el-button class=" " 
  :loading = "isLoading" 
  :disabled = "disabled" 
  :plain = "plain"
  :circle = "circle"
  :size = "size" 
  :round = "rounded"
  :type = "type"
  :class = "[lang_alignment, button_classes]" 
  @click = "construct()">
    <i :class = "buttonIcon" v-if="!isLoading"></i>

        <static_message :msgid="place_holder" :class="label_classes" v-if = "placeholder == null && !disable_placeholder">
        </static_message>
        <static_message :msg="placeholder" :class="label_classes" v-else-if = "placeholder != null && !disable_placeholder" >
        </static_message>
  </el-button>
</el-tooltip>
</template>

<script>
export default {
  props : {
    icon : {
      type : String ,
      default : ''
    } ,

    align : {
      type : String ,
      default : 'left'
    } ,
    button_classes : {
      type : String ,
      default : ''
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
    timeout : {
      type : Number ,
      default : 10000
    },
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
      type : [String , Array , Object ,Number ] ,
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
    disabled : {
    	type : Boolean ,
    	default : false
    },
    type : {
    	type : String ,
    	default : 'info'
    },
    size : {
      type : String ,
      default : 'default'
    },
    rounded : {
      type : Boolean ,
      default : false
    },
    circle : {
      type : Boolean , 
      default : false 
    },
    plain : {
      type : Boolean , 
      default : false 
    },
    computed_response : {
      type : Boolean ,
      default : false
    },
    precondition : {
      type : Boolean , 
      default : null
    },

  } ,
  data : function(){
    return {
      lang_alignment : document.querySelector('meta[name="lang_alignment"]').getAttribute('content') ,
      errorsStack : [],
      isLoading : false ,
      hasTryAgain : false
    }
  },
  computed : {
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

    App.$on('knocks_input_status' , function(status){
      if(!status) vm.errorsStack.push(1);
    });

    App.$on('knocksFinalSubmit' , (payload)=>{
      if(vm.scope == null || !vm.scope || payload.scope === undefined || payload.scope == null) return
      let tar;
        for(tar = 0 ; tar < payload.scope.length ; tar++){
        if(vm.scope && payload.scope[tar])
        if(vm.scope.indexOf(payload.scope[tar]) != -1){
          if(vm.submit_flag && vm.errorsStack.length == 0){
            vm.submit();
            return ;
          }
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
    this.emit()

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
      this.$emit('knocks_button_clicked');
      if(!this.validate) return;
      this.errorsStack = [],
      App.$emit('knocks_submit' , this.scope);
      if(this.errorsStack.length == 0 && (this.precondition == true || this.precondition == null)){
        this.$emit('knocks_stack_passed');
        if(this.submit_flag)
           if(this.submit_on == null){
            this.isLoading = true;
            this.submit();
           }
      }else{
        this.elementCategoryNotify({ type : 'error' , msg : this.validation_error , title : 'Warining' });
        this.$emit('knocks_stack_failed');
        console.log(this.errorsStack);
      }
    },
     emit(){
      this.$emit('input' ,
        {
          isLoading : this.isLoading ,
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
            console.warn('%cKnocksApp Warning, There is no internet connection, This is only working because the current host is under development.','font-size:18px;color:#922459;font-family:monospace')
          }else{
             this.actualLoading = false;
             this.isLoading = false
             this.hasTryAgain = true
             return
          }
      }
      this.emit()
      this.hasTryAgain = false
      console.log(this.submit_data);
      App.$emit('knocks_submit_passed');
      const vm = this;
      axios
      ({
          method:'post',
          url:LaravelOrgin+vm.submit_at,
          timeout : vm.timeout,
          data : vm.submit_data ,
          onDownloadProgress: function (progressEvent) {
            vm.isLoading = true;
            vm.emit()
          },
      })
      .then(function(response) {
        vm.hasTryAgain = false
        vm.isLoading = false;
        vm.emit()
        vm.networkHasErrors = false ;
        vm.networkErrors = null ;
        if(vm.reset_on_submit)App.$emit('knocks_input_reset' , vm.scope);
        var temp = response.data;
        if((temp == vm.success_at && vm.success_at != null) || vm.computed_response && !vm.isAnError(temp) ){
          if(vm.materialize_feedback)
            vm.elementCategoryNotify({ type : 'success' , msg : vm.success_msg , title : 'success' });
            //Materialize.toast(vm.success_msg, 3000, 'rounded');
          if(vm.reset_on_success){
            App.$emit('knocks_input_reset' , vm.scope);
          }
          vm.$emit('knocks_submit_accepted' , {submit_data : vm.submit_data , response : temp});
          return true;
        }else{
          vm.$emit('knocks_submit_rejected' , { response : temp , submit_data : vm.submit_data });
          var i ;
          for( i = 0; i < vm.error_at.length ; i++ ){
            if(vm.error_at[i].res == temp){
              if(vm.materialize_feedback)
                vm.elementCategoryNotify({ type : 'error' , msg : vm.error_at[i].msg , title : 'Warining' });
              return false;
            }//else vm.elementCategoryNotify({ type : 'error' , msg : vm.error_at[i].msg , title : 'Warining' });
          }
        }
      }).catch((err)=>{
         vm.networkHasErrors = true ;
        vm.networkErrors = err.response ;
        vm.hasTryAgain = true
        vm.emit()
        vm.$emit('knocks_submit_error' , err);
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
        vm.isLoading = false ;
        if(window.navigator.onLine !== undefined && !window.navigator.onLine){
          vm.elementCategoryNotify({ type : 'error' , msg : 'There is no internet connection' , title : 'Warining' })
          vm.actualLoading = false;
          return
      }
      });
    }

  }
}
</script>

<style lang="css">
</style>
