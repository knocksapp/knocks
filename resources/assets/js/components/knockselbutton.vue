<template>
  <el-button class=" " 
  :loading = "isLoading" 
  :disabled = "disabled" 
  :plain = "plain"
  :circle = "circle"
  :size = "size" :round = "rounded"
  :type = "type"
  :class = "[lang_alignment, button_classes]" @click = "construct()">
    <i :class = "[icon , {right: !disable_placeholder && align == 'right'} ,
    {left: !disable_placeholder && align == 'left'} , {center : disable_placeholder}]" v-if="!isLoading"></i>

        <static_message :msgid="place_holder" :class="label_classes" v-if = "placeholder == null && !disable_placeholder">
        </static_message>
        <static_message :msg="placeholder" :class="label_classes" v-else-if = "placeholder != null && !disable_placeholder" >
        </static_message>
  </el-button>
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
          this.actualLoading = false;
          return
      }
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
          },
      })
      .then(function(response) {
        vm.isLoading = false;
        vm.$emit('input' , response.data);
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
        vm.$emit('knocks_submit_error' , err);
        Materialize.toast('<span class="knocks_text_danger">'+vm.connection_error+'</span>', 3000, 'rounded');
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
