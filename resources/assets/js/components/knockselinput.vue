<template>
<div class = "row ">
  <div class = "">
    
       <el-input  
        @focus="addFocus()"
        @blur="removeFocus()"
        @keyup.enter = "submit()"
        @change="construct($event)"
        v-model = "elinput"
       :id = "gid">
         <template :slot = "labelPosition">
         <i v-if="!isLoading" class="material-icons prefix " :class = "iconClasses"></i>
        <static_message :msgid="place_holder" :class="labelClasses" v-if = "placeholder == null && !disable_placeholder"></static_message>
        <static_message :msg="placeholder" :class="labelClasses" v-else-if = "placeholder != null && !disable_placeholder" ></static_message>
      </template>
      </el-input>

  
  </div>
  <div class = "userInput2" :class = "lang_alignment">
    <ul v-if = " isFired  && !isValid" >
      <li v-for= "errors in errorsStack" class = "animated slideInDown " :class ="icon_error">
        <span :class = 'errorsBus[errors].icon'></span>
        <span v-if ="errorsBus[errors].prefix !== null">{{errorsBus[errors].prefix}}</span>
        <!-- <static_message :msgid = "errorsBus[errors].message_id" parent_class="knocks_inline"></static_message> -->
        <static_message  :msg="errorsBus[errors].message_id"></static_message>
        <span v-if ="errorsBus[errors].postfix !== null">{{errorsBus[errors].postfix}}</span>
      </li>
    </ul>
<!--     <ul v-if = " isFired  && !isValid" >
      <li v-if="hasError(0)" class = "animated slideInDown " :class ="icon_error" >
        <span :class = "is_required_icon"></span>
        <static_message :msg= "is_required_msg"></static_message>
      </li>

      <li v-if="hasError(1)" class = "animated slideInDown " :class ="icon_error" >
        <span :class = "is_required_icon"></span>
        <static_message :msg= "is_numeric_msg"></static_message>
      </li>

      <li v-if="hasError(2)" class = "animated slideInDown " :class ="icon_error" >
        <span :class = "is_required_icon"></span>
        <static_message :msg= "max_value_msg"></static_message>
      </li>

      <li v-if="hasError(3)" class = "animated slideInDown " :class ="icon_error" >
        <span :class = "is_required_icon"></span>
        <static_message :msg= "min_value_msg"></static_message>
      </li>

      <li v-if="hasError(4)" class = "animated slideInDown " :class ="icon_error" >
        <span :class = "is_required_icon"></span>
        <static_message :msg= "max_length_msg"></static_message>
      </li>

      <li v-if="hasError(5)" class = "animated slideInDown " :class ="icon_error" >
        <span :class = "is_required_icon"></span>
        <static_message :msg= "min_length_msg"></static_message>
      </li>

      <li v-if="hasError(6)" class = "animated slideInDown " :class ="icon_error" >
        <span :class = "is_required_icon"></span>
        <static_message :msg= "regex_bus_msg"></static_message>
      </li>

      <li v-if="hasError(7)" class = "animated slideInDown " :class ="icon_error" >
        <span :class = "is_required_icon"></span>
        <static_message :msg= " check_live_msg"></static_message>
      </li>

      <li v-if="hasError(9)" class = "animated slideInDown " :class ="icon_error" >
        <span :class = "is_required_icon"></span>
        <static_message :msg= "samilarity_msg"></static_message>
      </li>
    </ul> -->
    <slot></slot>
  </div>
</div>
</template>

<script>
    export default {
        props : {
          icon : {
            type : String ,
            default : null
          } ,
          gid : {
            type : String ,

          } ,
          autocomplete_input : {
            type : String , 
            default : 'off' 
          },
          place_holder : {
            type : Number ,
            default : null,
          } ,
          placeholder : {
            type : String ,
            default : null 
          },
          disable_placeholder: {
            type : Boolean , 
            default : false 
          },
          knocksclass : {
            type : String ,
            default : 'knocks_input_ps'
          } ,
          type : {
            type : String ,
            default : 'text'
          },
          value : String,
         disabled : {
           type : Boolean ,
           default : false ,
         } ,
         unsubmitable : {
          type : Boolean , 
          default : false
         },
         submit_scope : {
          type : Array , 
          default : null 
         },
         is_required : {
           type : Boolean ,
           default : false
         } ,
         is_numeric : {
           type : Boolean ,
           default : null
         },
         max_limit : {
           type : Boolean ,
           default : false
         } ,
         min_limit : {
           type : Boolean ,
           default : false
         } ,
         max : {
           type : Number ,
           default : undefined ,
         },
         min : {
           type : Number ,
           default : undefined ,
         },
         max_len_limit : {
           type : Boolean ,
           default : false
         } ,
         min_len_limit : {
           type : Boolean ,
           default : false
         } ,
         max_len : {
           type : Number ,
           default : undefined ,
         },
         min_len : {
           type : Number ,
           default : undefined ,
         },
         match : {
           type : Boolean ,
           default : false
         },
         regex : {
           type : String ,
           default : undefined ,
         } ,
         regex_example :{
           type : String ,
           default : null ,
         },
         check_live : {
           type : Boolean ,
           default : false ,
         } ,
         check_at : {
           type : String ,
           default : null
         } ,
         check_invalid_at :{
           type : String ,
           defualt : null
         },
         check_valid_at :{
           type : String ,
           defualt : null
         },
         autocomplete : {
           type : Boolean ,
           default : false
         } ,
         autocomplete_from : {
           type : String ,
           default : null
         } ,
         autocomplete_start : {
           type : Number ,
           default : 2
         },
         autocomplete_max_results : {
           type : Number ,
           default : 10
         },
         success_class : {
           type : String ,
           default : 'knocks_input_success '
         } ,
         error_class : {
           type : String ,
           default : 'knocks_input_error animated pulse'
         } ,

        custom_error : {
          type : Object ,
          default : null
        } ,
        icon_class : {
          type : String ,
          default : ''
        },
        icon_focus : {
          type : String ,
          default : ''
        },
        icon_success : {
          type : String ,
          default : 'teal-text'
        },
        icon_error : {
          type : String ,
          default : 'knocks_text_error'
        },
        scope : {
          type : Array ,
          default : null
        },
        same_as : {
          type : String , 
          default : null
        } , 
        same_as_name : {
          type : String , 
          default : ''
        },
        reference : {
          type : String , 
          default : ''
        },
        mat_follower : {
          type : Boolean , 
          default : true 
        },
        el_follower : {
          type : Boolean , 
          default : false 
        },
        check_live_prefix_msg : {
          type : String , 
          default : '' ,
        },

        ////Errors Messages
        is_required_msg : {
          type : String ,
          default : 'This field is required.' , 
        },
        is_numeric_msg : {
          type : String ,
          default : 'This field expects a numeric value.' , 
        },
        max_value_msg : {
          type : String ,
          default : 'The maximum value for this field is' , 
        },
        min_value_msg : {
          type : String ,
          default : 'The minimum value for this field is' , 
        },
        max_length_msg : {
          type : String ,
          default : 'The maximum length for your value shouldn\'t pass' , 
        },
        min_length_msg : {
          type : String ,
          default : 'The minimum length for your value shouldn\'t be less than' , 
        },
        regex_bus_msg : {
          type : String , 
          default : 'This field expects another formula'
        },
        check_live_msg : {
          type : String ,
          default : 'This value is not available' , 
        },
       samilarity_msg : {
          type : String ,
          default : 'This value should be the same as' , 
        },
        ////Errors Icons
        is_required_icon : {
          type : String ,
          default : 'knocks-alert-circle' , 
        },
        is_numeric_icon : {
          type : String ,
          default : 'knocks-alert-circle' , 
        },
        max_value_icon : {
          type : String ,
          default : 'knocks-alert-circle' , 
        },
        min_value_icon : {
          type : String ,
          default : 'knocks-alert-circle' , 
        },
        max_length_icon : {
          type : String ,
          default : 'knocks-alert-circle' , 
        },
        min_length_icon : {
          type : String ,
          default : 'knocks-alert-circle' , 
        },
        regex_bus_icon : {
          type : String , 
          default : 'knocks-alert-circle' , 
        },
        check_live_icon : {
          type : String ,
          default : 'knocks-alert-circle' , 
        },
       samilarity_icon : {
          type : String ,
          default : 'knocks-alert-circle' , 
        },
        start_as : {
          type : [String , Number, Array , Object] ,
          default : null
        },

    


        },

        data : function(){
          return {
            lang_alignment : document.querySelector('meta[name="lang_alignment"]').getAttribute('content') ,
            lang_font : document.querySelector('meta[name="lang_font"]').getAttribute('content') ,
            user_language : document.querySelector('meta[name="user_lang"]').getAttribute('content') ,
            knocks_focus : 'knocks_input_ps' ,
            spanClass : 'knocks_text_dark',
            inners : '' ,
            focus : false,
            isFired : false ,
            isLoading : false ,
            errorsStack : [],
            checkResult : false ,
            autoCompleteResults : null ,
            inputClassObject : '' ,
            errorMessages : [] ,
            errorsBus : [],
            submitScope : null ,
            elinput : '' ,

          }
        },

        computed :{
          labelPosition(){
            if(this.lang_alignment == 'right') return 'append';
            if(this.lang_alignment == 'left') return 'prepend';
          },
          isValid(){
            if(!this.isFired) return false;

            if(this.is_required == true)
            if(!this.pushOrPop(this.notEmpty(),8)) return false;

            if(this.is_numeric != undefined && this.is_numeric != null)
            if(!this.pushOrPop(this.is_numericValid(),1)) return false;

            if(this.max != undefined && this.max != null)
            if(!this.pushOrPop(this.maxValid(),2)) return false;

            if(this.min != undefined && this.min != null)
            if(!this.pushOrPop(this.minValid(),3)) return false;

            if(this.max_len != undefined && this.max_len != null)
            if(!this.pushOrPop(this.max_lenValid(),4)) return false;

            if(this.min_len != undefined && this.min_len != null)
            if(!this.pushOrPop(this.min_lenValid(),5)) return false;

            if(this.regex != undefined && this.regex != null)
            if(!this.pushOrPop(this.regexValid(),6)) return false;

            
            if(this.same_as != null)
            if(!this.pushOrPop(this.sameAs(),9)) return false;  


            if(this.check_live){
              this.checkLive();
              if(!this.pushOrPop(this.checkResult,7)) return false ;
            }
            return true;

          },
          inputClasses(){
            var classes = [ this.knocksclass ];
            classes.push(this.scope);
            if(this.lang_alignment == 'right') classes.push('knocks_text_right');
            if(this.focus) classes.push('knocks_input_focus');
            if(this.autocomplete) classes.push('autocomplete');
            if(this.isValid) classes.push(this.success_class);
            if(!this.isValid && this.isFired) classes.push(this.error_class);
            //classes.push(this.knocksclass);

            return classes;
          } ,
          iconClasses(){
            var classes = [ this.icon ];
            if(!this.isFired) classes.push(this.icon_focus);
            if(this.focus) classes.push(this.icon_focus);
            if(this.isValid) classes.push(this.icon_success);
            if(!this.isValid && this.isFired) classes.push(this.icon_error);
            else classes.push(this.icon_class);
            return classes;
          } ,
          labelClasses(){
            var classes = [];
            if(!this.isFired) classes.push(this.icon_focus);
            if(this.focus) classes.push(this.icon_focus);
            if(this.isValid) classes.push(this.icon_success);
            if(!this.isValid && this.isFired) classes.push(this.icon_error);
            if(this.lang_alignment == 'right')classes.push('knocks_almost_right');
            classes.push(this.icon_class);
            return classes;
          }


        },
        mounted() {
          
          const vm = this;

          // App.$on('errorsMessageBusLoaded' , function(errorsMessageBus){
          //   vm.bindErrorBus(errorsMessageBus);
          // });
          // if (window.ErrorMessageBus.length > 0){
          //   this.bindErrorBus(window.ErrorMessageBus);
          // }
          if(this.start_as != null){
            this.elinput = this.start_as;
            this.$emit('input' , this.elinput);
            this.$emit('change' , this.elinput);
          }
          this.bindErrorBus();
          if(!this.unsubmitable)
            this.submitScope = this.submit_scope == null ? this.scope : this.submit_scope;

          App.$on('knocks_submit' , (scope)=>{
            if(scope != null){
              let i;
              if(vm.scope == null) return;
              for(i = 0; i < scope.length; i++){
                if(vm.scope.indexOf(scope[i]) != -1){
                 vm.isFired = true;
                 App.$emit('knocks_input_status' , vm.isValid);
                 return;
                }
              }
              return;
           }else if(scope == null && vm.scope == null){
            vm.isFired = true;
            App.$emit('knocks_input_status' , vm.isValid);
           }
          });
          $('#'+this.gid+'>input').keyup(function(e){
            if(e.which == 13)
              vm.submit();
          })
        App.$on('knocks_input_reset' , function(scope){
            if(scope != null){
            let i;
            if(vm.scope == null) return;
            for(i = 0; i < scope.length; i++){
              if(vm.scope.indexOf(scope[i]) != -1){
                $('#'+vm.gid).val('');
            var parentNode = $('#'+vm.gid).parent();
            var label = $(parentNode).find('label');
            $(label).removeClass('active');
            vm.$emit('input','');
            vm.$emit('change','');
            vm.elinput = '' ; 
            vm.isFired = false ;
               return;
              }
            }
            return;
           }else if(scope == null && vm.scope == null){
            vm.isFired = true;
            App.$emit('knocks_input_status' , vm.isValid);
           }
            // if(scope == null || vm.scope == scope){
            //   //$('#'+vm.gid).val('');
            //   //vm.$emit('input' , event.target.$ref);
            //   $('#'+vm.gid).val('');
            //   var parentNode = $('#'+vm.gid).parent();
            //   var label = $(parentNode).find('label');
            //   $(label).removeClass('active');
            //   vm.$emit('input','');
            //   $('#'+vm.gid).val('');
            //   vm.isFired = false ;
            // }
          });
          // this.errorsBus =  [
          //   { message_id : null , icon : 'knocks-alert-circle' , prefix : null , postfix : null},
          //   { message_id : this.errorMessages[1]  , icon : 'knocks-alert-circle' , prefix : null , postfix : null},
          //   { message_id : this.errorMessages[2]  , icon : 'knocks-alert-circle' , prefix : null , postfix : this.min},
          //   { message_id : this.errorMessages[3]  , icon : 'knocks-alert-circle' , prefix : null , postfix : this.min},
          //   { message_id : this.errorMessages[4]  , icon : 'knocks-alert-circle' , prefix : null , postfix : this.max_len},
          //   { message_id : this.errorMessages[5]  , icon : 'knocks-alert-circle' , prefix : null , postfix : this.min_len},
          //   { message_id : this.errorMessages[6]  , icon : 'knocks-alert-circle' , prefix : null , postfix : null},
          //   { message_id : this.errorMessages[7]  , icon : 'knocks-alert-circle' , prefix : null , postfix : null},
          //   { message_id : this.errorMessages[0]  , icon : 'knocks-alert-circle' , prefix : null , postfix : null},
          // ] ;
        },
        methods : {
          removeFocus(){
            //this.knocks_focus = 'knocks_input_ps';
            //this.spanClass = 'knocks_text_dark';
            this.focus = false;
            if(!this.isFired) this.isFired = true;
            this.$emit('blur');
          },
          addFocus(){
            this.$emit('focus');
            //this.knocks_focus = 'knocks_input_focus';
            //this.spanClass = 'knocks_text_dark_active';
            this.focus = true;
            
          },
          submit(){
            console.log('submig')
            if(this.unsubmitable) return;
            App.$emit('knocks_presubmit' , this.submitScope);
          },
          construct(event){
            
            if(!this.isFired) this.isFired = true;
            const vm = this;
            this.$emit(`input`, this.elinput);
            this.$emit(`change`, this.elinput);
            if(!this.isFired) this.isFired = true;
            if(this.autocomplete){
              this.autoComplete();
            }
          },
          notEmpty(){
            return this.elinput == null || this.elinput == "" || this.elinput.length == 0 ? false : true ;
          } ,
          is_numericValid(){
            return isNaN(this.elinput) != this.is_numeric ? true : false ;
          },
          maxValid(){
            return this.elinput <= this.max ? true : false;
          },
          minValid(){
            return this.elinput >= this.min ? true : false;
          },
          max_lenValid(){
            return this.elinput.length <= this.max_len ? true : false;
          },
          min_lenValid(){
            return this.elinput.length >= this.min_len ? true : false;
          },
          regexValid(){
            var match = this.elinput.match(this.regex);
            if(match == null) return false ;
            else return true;
          },
          sameAs(){
            return this.elinput == this.same_as ? true : false ;
          },
          pushOrPop(method,errorNum){
            if(method == true && this.errorsStack.length == 0){
              return true;
            } else if (method == true && this.errorsStack != 0){
              this.errorsStack.pop();
              return true;
            }else if (method == false && this.errorsStack.length == 0){
              this.errorsStack.push(errorNum);
              return false;
            }else if(method == false && this.errorsStack.length != 0)
              return false;
          },
          checkLive(){
            const vm = this;
            axios
            ({
                method:'post',
                url:window.location.protocol + '//' + window.location.hostname + ':'+window.location.port+'/'+vm.check_at,
                responseType:"text",
                timeout : 10000,
                data : {q : this.elinput},
                onDownloadProgress: function (progressEvent) {
                  vm.isLoading = true;
                },
            })
            .then(function(response) {
                vm.isLoading = false;
                if(response.data == vm.check_invalid_at){
                  vm.checkResult = false ;
                }else if (response.data == vm.check_valid_at){
                  vm.checkResult = true ;
                }else vm.checkResult = false;
            });
          },
          hasError(errorId){
            return this.errorsStack.indexOf(errorId) == -1 ? false : true;
          },
          autoComplete(){
            if(this.elinput.length < this.autocomplete_start) return;
            const vm = this;
            axios
            ({
                method:'post',
                url:LaravelOrgin+vm.autocomplete_from,
                timeout : 10000,
                data : {q : this.elinput},
                onDownloadProgress: function (progressEvent) {
                  vm.isLoading = true;
                },
            })
            .then(function(response) {
              vm.isLoading = false;
              vm.$emit('autocomplete' , response.data)
            });
          },
          bindErrorBus(){

            // this.errorsBus = [
            //   { message_id : errorsMessageBus[0]  , icon : 'knocks-alert-circle' , prefix : null , postfix : null},
            //   { message_id : errorsMessageBus[1]   , icon : 'knocks-alert-circle' , prefix : null , postfix : this.min},
            //   { message_id : errorsMessageBus[2]   , icon : 'knocks-alert-circle' , prefix : null , postfix : this.min},
            //   { message_id : errorsMessageBus[3]   , icon : 'knocks-alert-circle' , prefix : null , postfix : this.min_len},
            //   { message_id : errorsMessageBus[4]   , icon : 'knocks-alert-circle' , prefix : null , postfix : this.max_len},
            //   { message_id : errorsMessageBus[5]   , icon : 'knocks-alert-circle' , prefix : null , postfix : null},
            //   { message_id : errorsMessageBus[6]   , icon : 'knocks-alert-circle' , prefix : null , postfix : ' '+this.regex_example},
            //   { message_id : errorsMessageBus[7]   , icon : 'knocks-alert-circle' , prefix : null , postfix : this.check_live_msg},
            //   { message_id : errorsMessageBus[0]   , icon : 'knocks-alert-circle' , prefix : null , postfix : null},
            //   { message_id : errorsMessageBus[9]   , icon : 'knocks-alert-circle' , prefix : null , postfix : ' '+this.same_as_name},
            // ];
             this.errorsBus = [
              { message_id : this.is_required_msg  , icon : 'knocks-alert-circle' , prefix : null , postfix : null},
              { message_id : this.is_numeric_msg   , icon : 'knocks-alert-circle' , prefix : null , postfix : null },
              { message_id : this.max_value_msg  , icon : 'knocks-alert-circle' , prefix : null , postfix : this.max},
              { message_id : this.min_value_msg   , icon : 'knocks-alert-circle' , prefix : null , postfix : this.min},
              { message_id : this.max_length_msg  , icon : 'knocks-alert-circle' , prefix : null , postfix : this.max_len},
              { message_id : this.min_length_msg  , icon : 'knocks-alert-circle' , prefix : null , postfix : this.min_len},
              { message_id : this.regex_bus_msg   , icon : 'knocks-alert-circle' , prefix : null , postfix : ' '+this.regex_example},
              { message_id : this.check_live_msg   , icon : 'knocks-alert-circle' , prefix : null , postfix : this.check_live_msg},
              { message_id : this.is_required_msg    , icon : 'knocks-alert-circle' , prefix : null , postfix : null},
              { message_id : this.samilarity_msg  , icon : 'knocks-alert-circle' , prefix : null , postfix : ' '+this.same_as_name},
            ];
          },

        }
    }
</script>


