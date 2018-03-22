<template>


      <div :class = "main_container" :id = "gid" class = " "  >
      <div class = "  knocks_color_kit_light knocks_gray_border knocks_ragular_border row knocks_xs_padding ">
                    <!-- LEVEL ONE -->
    <div v-loading = "submitButton.isLoading" >
    <div class = "row knocks_house_keeper" style = "margin-top : 1px !important; padding : 5px !important;" >
      <div class = " col s7 m9 knocks_house_keeper">
        <span class = "knocks-knocks grey-text text-lighten-2 knocks_text_ms animated fadeIn" v-if = "userSuggestions.length == 0 && tagged.length == 0"></span>
        <static_message classes = "text-lighten-2  grey-text  knocks_text_ms fadeIn" msg = "Who's There!" v-if = "userSuggestions.length == 0 && tagged.length == 0"></static_message>
        <div @click="spliceFromTagged(i)" v-for = "(x , i) in tagged" v-if = "alreadyTagged(x)"  >
     
           <knocksuser :user="x" as_chip show_image name_class = "knocks_color_kit" hide_text_info
           main_container =  "animated bounceInLeft knocks_color_kit knocks_inline right" >
           </knocksuser>  
         
       </div>
       <div @click="pushToTagged(x , i)" v-for = "(x , i) in userSuggestions" class = "knocks_inline" v-if = "!alreadyTagged(x)">
     
           <knocksuser name_class = "knocks_text_anchor knocks_text_ms knocks_text_bold" :user="x" as_chip show_image  v-model = "suggestions[i]" main_container =  "animated bounceInUp" ></knocksuser>  
         
       </div>
      </div>
      <div class = "col right knocks_house_keeper">
 
             <knockspopover>
            <template slot = "container">
            <a :class = "[maps_classes , option_classes ]" v-if = "!draggingMode" :data-target="gid+'_location_modal'" class="btn modal-trigger">
              <span :class = "[maps_icon]" ></span>
            </a>
            </template>
    <span slot = "content"  class = "knocks_tooltip animated flipInX" >
              <span :class = "maps_icon"></span>
              <static_message msg = "Check in"></static_message>
            </span>
    </knockspopover>

          <knockspopover v-if = "!draggingMode">
            <template slot="container">
               <a :class = "[maps_classes , option_classes ]" class="btn" >
                <span :class = "[uploader_icon]" @click="triggerUploader()" v-if = "!draggingMode"></span>
                <span :class = "[uploader_back_icon]" @click="triggerUploader()" v-if = "draggingMode"></span>
              </a>
            </template>
             <span slot = "content"  class = "knocks_tooltip animated flipInX" >
              <span :class = "uploader_icon"></span>
              <static_message msg = "Upload files"></static_message>
            </span>
          </knockspopover>

           <knockspopover v-if = "draggingMode">
            <template slot="container">
               <a :class = "[maps_classes , option_classes ]" class="btn" >
                <span :class = "[uploader_icon]" @click="triggerUploader()" v-if = "!draggingMode"></span>
                <span :class = "[uploader_back_icon]" @click="triggerUploader()" v-if = "draggingMode"></span>
              </a>
            </template>
             <span slot = "content"  class = "knocks_tooltip animated flipInX" >
              <span :class = "uploader_back_icon"></span>
              <static_message msg = "Back"></static_message>
            </span>
          </knockspopover>
          
           <knocksprivacysetter 
            trigger_class = "modal-trigger amber lighten-4 white-text knocks_side_margins darken-2 btn-floating knocks_super_tiny_floating_btn knocks_noshadow_ps knocks_borderless "
           :gid = "gid+'_privacy_setter'" 
           v-model = "privacy_setting" class  = "right">
             <template slot = "trigger">
               <span class = "knocks-locked4"></span>
             </template>
             <template slot="modal_header">
               <span class = "knocks_text_dark knocks_text_md knocks_text_bold"><span class = "knocks-lockedheart knocks_text_dark"></span>    
                How do you want the world to see this ?  
                <hr/>
               </span>
             </template>
             <span slot = "content"  class = "knocks_tooltip animated flipInX" >
                Privacy
            </span>

          </knocksprivacysetter>
       </div>
    </div>
     <transition enter-active-class="animated fadeIn" leave-active-class="animated fadeOut">
        <div class = "row knocks_house_keeper" v-if = "locationResult != null">
      <p class="knocks_text_sm blue-text"> <i class=" knocks-location3 blue-text"></i>
                    {{locationResult.address_components[0].long_name}}
      </p>
    </div>
  </transition>

    <!--LEVEL TWO -->


    <div :class = "[input_container , {'knocks_hidden': draggingMode}]"   
    contenteditable = "true" 
    class = "knocks_language_follower white" data-text="Enter text here..." :id = "gid+'_input'" v-model = "bodyContent" @input = "constructInput()">

    </div>
  </div>
    <knocksmultipleuploader :gid = "gid+'_file_uploader'" v-model  = "uploader" :scope = "scope"></knocksmultipleuploader>


    <!--Level Three-->


        
        <div :class = "options_bar_class" class = "" style = "margin-top:4px; margin-bottom:0px">
   
          <div class = "col s9 knocks_house_keeper">
                    <div :class = "recorder_container">
          <knocksrecorder
          @recognition="addRecognitionContent($event)"
          @record_reset="addRecognitionContent('')"
          v-model = "recorder"
          :class = "{'knocks_hidden' : submitButton.isLoading}"
          main_container = "knocks_house_keeper"
          :upload_data= "recorder_upload_data"
          :gid = "gid+'_recorder'"
          :upload_on_finish = "recorder_upload_on_finish"
          :recorder_container = "recorder_record_buttons_container"
          :player_container = "recorder_player_container"
          :scope = "scope"
          :player_initial_class = "player_initial_class"
          :player_play_class = "player_play_class"
          :player_pause_class = "player_pause_class"
          :player_icon_play_class = "player_icon_play_class"
          :player_icon_pause_class = "player_icon_pause_class"
          :player_volume_off_class = "player_volume_off_class"
          :player_volume_low_class = "player_volume_low_class"
          :player_volume_high_class = "player_volume_high_class"
          :player_timer_classes = "player_timer_classes"
          :player_runtime_classes = "player_runtime_classes"
          :player_main_container = "player_main_container"
          :player_buttons_container = "player_buttons_container"
          :player_sniper_container = "player_sniper_container"
          :player_timer_container = "player_timer_container"
          :player_show_timer = "player_show_timer"
          :player_options_container = "player_options_container"
          :player_show_options = "player_show_options"
          :player_runtime_container = "player_runtime_container"
          :player_show_runtime = "player_show_runtime"
          :player_volume_container = "player_volume_container"
          :player_show_volume = "player_show_volume"
          :player_volume_icon_grid = "player_volume_icon_grid"
          :player_volume_sniper_container = "player_volume_sniper_container"
          >
      </knocksrecorder>
          </div>
        </div>
   

        <div :class="btn_container_class">
          <knockspopover>
            <template slot = "container">
              <knocksbutton
              :scope = "scope"
              :gid = "gid+'_btn'"
              :submit_on = "[scope+'_final_submit']"
              :disable_placeholder = "btn_disable_placeholder"
              :icon = "btn_icon"
              :submit_at = "submit_at"
              :success_at = "success_at"
              :error_at = "error_at" 
              v-model = "submitButton"
              :success_msg= "success_msg"
              :submit_data = "{ submit_object : submitObject }"
              :error_class = "btn_error_class"
              :success_class = "btn_success_class"
              :button_classes = "btn_classes"
              :label_classes = "btn_label_classes"
              @knocks_submit_accepted = "resetKnock()"
              :materialize_feedback = "false"
              button_classes = " el-button knocks_color_kit knocks_el_round_btn knocks_btn_color_kit  knocks_right knocks_noshadow_ps knocks_borderless">
              </knocksbutton>
            </template>
            <span slot = "content"  class = "knocks_tooltip animated flipInX" style="margin-top: 20px !important;" >
              <span :class="btn_icon" class = " animated zoomInRight"></span>
              <static_message msg = "Publish"></static_message>
            </span>
          </knockspopover>
       
       </div>
       
       </div>
      </div>



          
      

  <!-- Modal Structure -->
          <div :id="gid+'_map_modal'" class="modal modal-fixed-footer  ">
            <div class="modal-content  ">
              <h4>Modal Header</h4>
              <input id="pac-input" class="controls" type="text" placeholder="Search Box">
              <div :id="gid+'_map_holder'" class = "knocks_map_holder"></div>
            </div>
            <div class="modal-footer">
              <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat ">Agree</a>
            </div>
          </div>

          <div :id="gid+'_location_modal'" class="modal modal-fixed-footer knocks_color_kit_light_active">
            <div class="modal-content">
              <h4>
                <span class = "knocks-location10 red-text"></span>
                <static_message msg = "Search for your location." classes ="red-text"></static_message>
              </h4>

            <knocksinput
            placeholder="search"
            v-model = "searchLocation"
            el_follower
            :mat_follower=  "false"
            @input="searchForNearby()"
            :gid = "gid+'_location_searchbar'"
            icon_class = "teal-text lighten-3"
            knocksclass="knocks_teal_input" icon = "knocks-search6" >
            </knocksinput>
              
            </div>
            <div class="modal-footer knocks_color_kit_light_active">
              <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat red-text">
                <static_message msg = "Cancel"></static_message>
                <span class = "knocks-location-arrow-outline"></span>
              </a>
              <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat red-text" :class = "[{'disabled' : locationResult == null}]">
                <static_message msg = "OK"></static_message>
                <span class = "knocks-location-arrow-outline"></span>
              </a>
            </div>
          </div>


		   </div>
</template>
       <!-- <a :class = "[maps_classes , option_classes ]" :data-target="gid+'_map_modal'" class="btn modal-trigger"><span :class = "[maps_icon]" @click="triggerMaps"></span></a> -->
   <!--        <div class = "col s2">
             <knockspopover>
            <template slot = "container">
            <a :class = "[maps_classes , option_classes ]" v-if = "!draggingMode" :data-target="gid+'_location_modal'" class="btn modal-trigger">
              <span :class = "[maps_icon]" ></span>
            </a>
            </template>
    <span slot = "content"  class = "knocks_tooltip animated flipInX" >
              <span :class = "maps_icon"></span>
              <static_message msg = "Check in"></static_message>
            </span>
    </knockspopover>

          <knockspopover v-if = "!draggingMode">
            <template slot="container">
               <a :class = "[maps_classes , option_classes ]" class="btn" >
                <span :class = "[uploader_icon]" @click="triggerUploader()" v-if = "!draggingMode"></span>
                <span :class = "[uploader_back_icon]" @click="triggerUploader()" v-if = "draggingMode"></span>
              </a>
            </template>
             <span slot = "content"  class = "knocks_tooltip animated flipInX" >
              <span :class = "uploader_icon"></span>
              <static_message msg = "Upload files"></static_message>
            </span>
          </knockspopover>

           <knockspopover v-if = "draggingMode">
            <template slot="container">
               <a :class = "[maps_classes , option_classes ]" class="btn" >
                <span :class = "[uploader_icon]" @click="triggerUploader()" v-if = "!draggingMode"></span>
                <span :class = "[uploader_back_icon]" @click="triggerUploader()" v-if = "draggingMode"></span>
              </a>
            </template>
             <span slot = "content"  class = "knocks_tooltip animated flipInX" >
              <span :class = "uploader_back_icon"></span>
              <static_message msg = "Back"></static_message>
            </span>
          </knockspopover>
          </div> -->

<script>
export default {
  name: 'knock',
  props : {
  	gid : {
  		type : String , 
  		required : true
  	},
  	main_container : {
  		type : String , 
  		default : 'row' ,
  	},
  	input_container : {
  		type : String , 
  		default : 'knocks_content_continer'
  	},
  	scope : {
  		type : Array ,
  		required : true ,
  	},
  	lower_container_class : {
  		type : String ,
  		default : 'row col s12'
  	},
  	options_bar_class : {
  		type : String ,
  		default : 'knocks_options_bar row knocks_tinny_top_padding'
  	},
  	btn_classes : {
  		type : String ,
  		default : ' right'
  	},
  	btn_placeholder : {
  		type : String , 
  		default : 'Publish'
  	},
  	btn_icon : {
  		type : String ,
  		default : 'knocks-paper-plane knocks_text_light'
  	},
  	btn_disable_placeholder : {
  		type : Boolean , 
  		default : true 
  	},
  	btn_container_class : {
  		type : String ,
  		default : 'col s2 right knocks_house_keeper'
  	},
  	btn_error_class : {
  		type : String , 
  		default : 'knocks_input_error animated shake'
  	},
  	btn_success_class : {
      type : String ,
      default : 'knocks_input_success '
    } ,
    btn_label_classes : {
    	type : String , 
    	default : 'knocks_text_sm'
    },
  	submit_at : {
  		type : String , 
  		required : true ,
  	},
  	success_at : {
  		type : String , 
  		default : ''
  	},
  	error_at : {
  		type : Array , 
  		default : []
  	},
  	success_msg : {
  		type : String , 
  		default : 'Done'
  	},
  	submit_data : {
  		type : Object ,
  		default : null
  	},
  	recorder_container : {
  		type : String , 
  		default : 'col s12 knocks_house_keeper'
  	},
  	recorder_upload_data : {
  		type : Object , 
  		default : null
  	},
  	recorder_upload_on_finish : {
  		type : Boolean , 
  		default : false
  	},
  	recorder_record_buttons_container : {
  		type : String , 
  		default : 'col s5 m4'
  	},
  	recorder_player_container : {
  		type : String , 
  		default : 'col s7 m8 knocks_house_keeper'
  	},
    options_bar_class : {
      type : String , 
      default : 'row'
    },
    maps_icon : {
      type : String , 
      default : 'knocks-location9'
    } , 
    uploader_icon : {
      type : String , 
      default : 'knocks-file8'
    },
    uploader_back_icon : {
      type : String , 
      default : 'knocks-chevron-thin-left'
    },
    option_classes : {
      type : String , 
      default : 'btn btn-floating knocks_super_tiny_floating_btn knocks_tiny_floating_btn  pink darken-1 knocks_noshadow_ps'
    },
    maps_classes : {
      type : String , 
      default :  ''
    },
    post_at : {
      type : Number , 
      required : true ,
    },
    parent_type : {
      type : String , 
      required : true ,
    },



  	// Recorder player props 

  	//knocks_player_props
  	player_initial_class : {
  		type :String ,
  		default : 'btn btn-floating knocks_tiny_floating_btn knocks_color_kit knocks_btn_color_kit right'
  	},
  	player_play_class : {
  		type :String ,
  		default : 'animated flipInX'
  	},
  	player_pause_class : {
  		type :String ,
  		default : 'animated flipInY'
  	},
  	player_icon_play_class : {
  		type :String ,
  		default : 'knocks-arrows2 animated jello'
  	},
  	player_icon_pause_class : {
  		type :String ,
  		default : 'knocks-pause-1 animated rubberBand'
  	},
  	player_volume_off_class : {
  		type : String ,
  		default : 'knocks-volume8 knocks_text_dark knocks_text right knocks_text_md animated flipInY'
  	},
  	player_volume_low_class : {
  		type : String ,
  		default : 'knocks-volume6 knocks_text_dark right knocks_text_md animated jello'
  	},
  	player_volume_high_class : {
  		type : String ,
  		default : 'knocks-volume7 knocks_text_dark_active right knocks_text_md animated rubberBand'
  	},
  	player_timer_classes : {
  		type : String ,
  		default : 'knocks_text_right knocks_text_dark_active'
  	},
  	player_runtime_classes : {
  		type : String ,
  		default : 'knocks_text_right knocks_text_dark'
  	},
    player_main_container : {
      type : String ,
      default : 'row knocks_house_keeper'
    },
    player_buttons_container : {
      type : String ,
      default : 'col s3'
    },
    player_sniper_container : {
      type : String ,
      default : 'col s7'
    },
    player_timer_container : {
      type : String ,
      default : 'col s2'
    },
    player_show_timer : {
      type : Boolean ,
      default : true
    },
    player_options_container : {
      type : String , 
      default : 'row knocks_house_keeper'
    },
    player_show_options : {
      type : Boolean ,
      default : true
    },
    player_runtime_container : {
      type : String , 
      default : 'timer_container'
    } , 
    player_show_runtime : {
      type : Boolean , 
      default : true
    },
    player_volume_container : {
      type : String , 
      default : 'col s5 push-s3'
    },
    player_show_volume : {
      type : Boolean , 
      default : true
    },
    player_volume_icon_grid : {
      type : String , 
      default : 'col s4'
    },
    player_volume_sniper_container : {
      type : String , 
      default : 'col s8'
    },


  },
  data () {
    return {

    	taggedPeople : [] ,
    	recorder : null ,
    	tokens : [],
    	userSuggestions : [] ,
      tagged : [] , 
      users : [] , 
      suggestions : [] , 
      mapsOn : false,
      lat : null ,
      lng : null ,
      searchLocation : null , 
      searchLat : null , 
      searchLang : null,
      locationResult : null ,
      uploader : null ,
      privacy_setting : null,
      bodyContent : '' , 
      tagsPositions : [],
      recordUploaded : false , 
      filesUploaded : false ,
      recordToken : null ,
      filesTokens : null ,
      submitObject : null ,
      draggingMode : false ,
      imagesQuotes : [] ,
      recorderResponded : false ,
      mfuResponded : false ,
      hasRecord : false ,
      hasFiles : false ,
      hasImages : false ,
      textContent : {text : '' , voice : ''} ,
      finalTextBody : '' ,
      submitButton :  { 
          isLoading : false , 
          isHovered : false , 
          response  : null , 
          networkErrors : null ,
          networkHasErrors :  false
        } , 

    }
  } , 
  computed : {


    usernameLens(){
      let user , counter ; 
      counter = 0;
      for(user in this.taggedPeople){
        this.counter += this.taggedPeople[user].username.length;
      }
      return counter;
    },
    // hasRecord(){
    //   return this.recorder === null ? false : true ;
    // },
    // hasFiles(){
    //   if(this.uploader === null) return false ;
    //   else 
    //     return this.uploader.images.length == 0 && this.uploader.regularFiles.length == 0  ? false : true;
    // },
  },
  mounted(){
    const vm = this;


    //Content Editable Behavior with BR 
    $('div[contenteditable]').keydown(function(e) {
    // trap the return key being pressed
    if (e.keyCode === 13) {
      // insert 2 br tags (if only one br tag is inserted the cursor won't go to the next line)
      document.execCommand('insertHTML', false, '<br><br>');
      // prevent the default behaviour of return key pressed
      return false;
    }
  });

    document.getElementById(this.gid+'_input').onpaste = function(){
      let childs = document.getElementById(vm.gid+'_input').children;
      let i;
      for(i = 0 ; i < childs.length; i++){
        if(!$(childs[i]).hasClass('chip') && childs[i].tagName != 'BR'){
          console.log(childs[i].tagName)
          console.log($(childs[i]).html()); console.log($(childs[i]).text())
          $(childs[i]).replaceWith($(childs[i]).text());
          console.log('watch');
        }
      }
      vm.watchMyDom();
          // $('#'+vm.gid+'_input').blur();
          // $('#'+vm.gid+'_input').focus();
    }
    $(document).on('keyup' , '#'+this.gid+'_input' , function(){
      let childs = document.getElementById(vm.gid+'_input').children;
      let i;
      for(i = 0 ; i < childs.length; i++){
        if(!$(childs[i]).hasClass('chip') && childs[i].tagName != 'BR'){
          console.log(childs[i].tagName)
         $(childs[i]).replaceWith($(childs[i]).text());
          console.log('watch');
        }
      }
      vm.watchMyDom();
          // $('#'+vm.gid+'_input').blur();
          // $('#'+vm.gid+'_input').focus();
    });

     $(document).on('mouseover' , '#'+this.gid+'_input' , function(){
      let childs = document.getElementById(vm.gid+'_input').children;
      let i;
      for(i = 0 ; i < childs.length; i++){
        if(!$(childs[i]).hasClass('chip') && childs[i].tagName != 'BR'){
          console.log(childs[i].tagName)
         $(childs[i]).replaceWith($(childs[i]).text());
          console.log('watch');
        }
      }
      vm.watchMyDom();
          // $('#'+vm.gid+'_input').blur();
          // $('#'+vm.gid+'_input').focus();
    });


    $(document).on('change' , '#'+this.gid+'_input' , function(){
      let childs = document.getElementById(vm.gid+'_input').children;
      let i;
      for(i = 0 ; i < childs.length; i++){
        if(!$(childs[i]).hasClass('chip') && childs[i].tagName != 'BR'){
          console.log(childs[i].tagName)
          $(childs[i]).replaceWith($(childs[i]).text());
          console.log('watch');
        }
      }
      vm.watchMyDom();
          // $('#'+vm.gid+'_input').blur();
          // $('#'+vm.gid+'_input').focus();
    });
      $(document).on('blur' , '#'+this.gid+'_input' , function(){
       let childs = document.getElementById(vm.gid+'_input').children;
       let i;
        for(i = 0 ; i < childs.length; i++){
          if(!$(childs[i]).hasClass('chip') && childs[i].tagName != 'BR'){
            console.log(childs[i].tagName)
            $(childs[i]).replaceWith($(childs[i]).text());
            console.log('watch');
          }
        }
        vm.watchMyDom();
       
    });
    $('#'+this.gid+'_map_modal').modal();
    $('#'+this.gid+'_location_modal').modal();

    // App.$on('knocks_submit' , (scope)=>{
    //   let tar;
    //   for(tar in scope){
    //     if(vm.scope.indexOf(scope[tar]) != -1){
    //       if(!vm.hasFiles && !vm.hasRecord){
    //         if(vm.bodyContent.length != 0 || vm.locationResult != null){
    //           setTimeout(()=>{vm.submitFormat();} ,300);
    //           setTimeout(()=>{App.$emit('knocksFinalSubmit', {scope : vm.scope});},300);
    //         }else{
    //           vm.notifiError();
    //         }
    //       }
    //     }
    //   }
    // });

    // App.$on('knocksMediaQueryLogged' , (payload)=>{
    //   console.log('mediaQueryRecieved');
    //   console.log(payload);
    //   let tar ;
    //   for(tar in payload.scope){
    //     if(vm.scope.indexOf(payload.scope[tar]) != -1){
    //       if(payload.query == 'record' && vm.hasRecord ){
    //         vm.recordToken = payload.token ; 
    //         vm.recordUploaded = true;
    //       }else if(payload.query == 'file'){
    //         vm.filesUploaded = true ;
    //         vm.filesTokens = payload.token;
    //         // vm.imagesQuotes = payload.quotes
    //       }
    //       vm.submitFormat();
    //       if(vm.hasRecord && vm.hasFiles && vm.recordUploaded && vm.filesUploaded){
    //         setTimeout(()=>{vm.submitFormat();} ,400);
    //         setTimeout(()=>{App.$emit('knocksFinalSubmit', {scope : vm.scope});},400);
    //       }else if(vm.hasRecord && !vm.hasFiles && vm.recordUploaded ){
    //         setTimeout(()=>{vm.submitFormat();} ,400);
    //         setTimeout(()=>{App.$emit('knocksFinalSubmit', {scope : vm.scope});},400);
    //       }else if(!vm.hasRecord && vm.hasFiles && vm.filesUploaded ){
    //         setTimeout(()=>{vm.submitFormat();} ,400);
    //         setTimeout(()=>{App.$emit('knocksFinalSubmit', {scope : vm.scope});},400);
    //       }
    //     }
    //   }
    // });
    App.$on('knocksMediaQueryLogged' , (payload)=>{
      console.log('mediaQueryRecieved');
      console.log(payload);
      let tar ;
      for(tar in payload.scope){
        if(vm.scope.indexOf(payload.scope[tar]) != -1){

          if(vm.recorderResponded && vm.mfuResponded) return;

          //Recorder State
          if(payload.query == 'record'){
            vm.hasRecord = payload.hasRecord ;
            vm.recorderResponded = true;
            if(payload.token != null) vm.recordToken = payload.token;
            if(vm.mfuResponded) vm.prepareSubmit();
          }
          //MFU State

          else if(payload.query == 'file'){
            vm.hasImages = payload.hasImages ;
            vm.hasFiles = payload.hasFiles ;
            vm.mfuResponded = true;
            if(payload.token != null) vm.filesTokens = payload.token;
            if(vm.recorderResponded) vm.prepareSubmit();
          }

          return;

        }
      }
    });
    App.$on('knocksMultipleUploaderDragging' , (state)=>{
      vm.draggingMode = state;
    });
  },
  methods : {
  	constructInput(){
  		this.getTokens();
  		this.searchForUsers();
      this.reverseCheck();
      this.checkForTags();
      this.getThebodyContent();
  	},
    prepareSubmit(){
      if(!(this.recorderResponded && this.mfuResponded)) return;
      if(!this.hasFiles && !this.hasImages && (this.bodyContent == null || this.bodyContent.length == 0) && this.locationResult == null && !this.hasRecord){
        this.notifiError();
        return;
      }
      this.submitFormat();
    },
  	getTokens(){

  		

      //Filter the externals

     
      this.tokens =  $('#'+this.gid+'_input').html().split(/ |&nbsp;/);
  	},
    getThebodyContent(){
      this.bodyContent =  $('#'+this.gid+'_input').html().split(/&nbsp;/).join('');
      
    },
  	searchForUsers(){
      if(this.tokens[this.tokens.length-1].length <= 2) { this.userSuggestions = []; return ;}
  		const vm = this;
      let CancelToken = axios.CancelToken;
      let source = CancelToken.source();
  		axios({
  			method : 'post' , 
        cancelToken: source.token,
  			url : window.LaravelOrgin + 'user/search',
  			data : {q : vm.tokens[(vm.tokens.length) -1]}
  		}).then( (response)=>{
  			vm.userSuggestions = response.data;

  		});
  	},
    pushToTagged(user , index){
      if(this.tagged.indexOf(user) != -1) return;
      this.taggedPeople.push(this.suggestions[index]);
      this.tagged.push(user);
      //Processing the current DOM
      let containerElement = document.getElementById(this.gid+'_input');

      let currentDom = containerElement.innerHTML;
      let splitter = currentDom.split(/&nbsp;| /);
      splitter.pop();
      splitter.push(
        '<a class = "chip knocks_tagged_user blue-text " href="'+LaravelOrgin+this.suggestions[index].username+'"  contenteditable = "false">'
        +'<img src="'+LaravelOrgin+'media/avatar/compressed/'+this.suggestions[index].id+'"> '
        +'<span class = "blue-text tagged_user_container" kid="'+this.suggestions[index].id+'" contenteditable = "false">'
        +this.suggestions[index].username+'</span>  '+'  </a> ');
      let newDom = splitter.join('  ');
      containerElement.innerHTML = newDom;
      $('#'+this.gid+'_input').focus();
      let range = document.createRange();
      let sel = window.getSelection();
      range.setStart(containerElement.childNodes[containerElement.childNodes.length-1], 0);
      range.collapse(true);
      sel.removeAllRanges();  
      sel.addRange(range);
      //this.reverseCheck();
      let userTt , counter ; 
      counter = 0;
      for(userTt in this.taggedPeople){
        counter = this.taggedPeople[userTt].username.length + counter ;
      }
      console.log(counter);
      let currentLen = $('#'+this.gid+'_input').html().split(/&nbsp;/).join('');
      currentLen = currentLen.split('').length;
      
      this.tagsPositions.push({ 
        user : user ,
        position : currentLen - ( this.taggedPeople.length * 129 + counter + (this.tokens[this.tokens.length - 1].length) )});
      this.getThebodyContent();
    },
    alreadyTagged(user){
      return this.tagged.indexOf(user) != -1 ? true : false ;
    },
    spliceFromTagged(user){
      let taggEquiv = this.tagged;
      this.tagged = [];
      setTimeout( ()=>{
      this.taggedPeople.splice(user,1);
      this.tagsPositions.splice(user , 1);
      taggEquiv.splice(user , 1);
      this.tagged = taggEquiv;
      this.reverseCheck();
    } ,200);


    },
    checkForTags(){
      let currentTags = document.getElementById(this.gid+'_input').getElementsByClassName('knocks_tagged_user');
      let i, j, k, flag;
      let toBeSliced = [];
      for(i = 0 ; i < this.tagged.length; i++){
        flag = false;
        for(j = 0; j < currentTags.length; j++){
          console.log($(currentTags[j].getElementsByClassName('tagged_user_container')[0]).text());
          if(this.taggedPeople[i].username == $($(currentTags[j]).find('.tagged_user_container')).text())
            flag = true ;        
        }
        if(flag == false){
          toBeSliced.push(i);
        }
      }
      console.log(toBeSliced);
      for(k = 0; k < toBeSliced.length; k++){
        this.spliceFromTagged(toBeSliced[k]);
      }

    },
    reverseCheck(){
      //Inverse Searching 
      let currentTags = document.getElementById(this.gid+'_input').getElementsByClassName('knocks_tagged_user');
      let i, j, k, flag, falseOnce;
      falseOnce = false;
      for(i = 0 ; i < currentTags.length; i++){
        flag = false;
        for(j = 0; j < this.tagged.length; j++){
          if(this.taggedPeople[j].username == $($(currentTags[i]).find('.tagged_user_container')).text())
            flag = true ;        
        }
        if(flag == false){
          falseOnce = true;
          //currentTags[i].classList.remove('blue-text');
          //currentTags[i].classList.remove('chip');
          let inner = $($(currentTags[i]).find('.tagged_user_container')).text();
          $(currentTags[i]).replaceWith(inner);
          //$('#'+this.gid+'_input').append();
          
          //currentTags[i].setAttribute('contenteditable' , true);
        }
      }
      if(falseOnce) this.searchForUsers();
    },
    triggerUploader(){
      App.$emit('knocksMultipleUploaderTrigger' , this.scope);
      this.draggingMode = !this.draggingMode;
    },
    searchForNearby(){
      const vm = this;
      GoogleMapsLoader.load(function(google) {
      var searchBox = new google.maps.places.SearchBox(document.getElementById(vm.gid+'_location_searchbar'));
      searchBox.addListener('places_changed', function() {
          var places = searchBox.getPlaces();
          if(places.length > 0)
          vm.locationResult = places[0]; 
          else vm.locationResult = null;
        });

    });
    },
    submitFormat(){
      let hasPictures , imagesTokens , quotes;
      if(this.filesTokens == null) hasPictures = false ;
      else if(this.filesTokens.images == undefined) hasPictures = false ;
      else if(this.filesTokens.images.length == 0) hasPictures = false ; else hasPictures = true;
    
      if(hasPictures == true) {
        imagesTokens = this.filesTokens.images; 
        // quotes = this.filesTokens.quotes;
      }else{
        imagesTokens = null 
        // quotes = null;
      }


      let hasFiles , filesTokens;
      if(this.filesTokens == null) hasFiles = false ;
      else if(this.filesTokens.files == undefined) hasFiles = false ;
      else if(this.filesTokens.files.length == 0) hasFiles = false ; else hasFiles = true;

      if(hasFiles == true) filesTokens = this.filesTokens.files; else filesTokens = null;

      console.log(this.filesTokens);



      let res =  {
        body : this.bodyContent , 
        at : this.post_at ,
        type : this.parent_type ,
        has_pictures : this.hasImages , 
        images_specifications : imagesTokens , 
        //images_quotes : quotes ,
        text : this.finalTextBody , 
        has_files : this.hasFiles , 
        files_specifications : filesTokens , 
        has_videos : this.hasRecord , 
        videos_specifications : [] ,
        has_voices : this.hasRecord ,
        voices_specifications : this.recordToken ,
        seen : 0 , 
        feelings : [] , 
        check_in : this.locationResult ,
        tags : this.tagged ,
        user_privacy : this.privacy_setting.user_privacy , 
        circle_privacy : this.privacy_setting.circle_privacy
      }
      this.submitObject = res;
      setTimeout(()=>{ App.$emit('knocksFinalSubmit', {scope : this.scope}); },300);
      return res;
    },
    resetKnock(){
      this.taggedPeople = [] ;
      this.recorder =null ;
      this.tokens =[];
      this.userSuggestions = [] ;
      this.tagged =[] ;
      this.users =[] ;
      this.suggestions =[] ;
      this.mapsOn =false;
      this.lat= null ;
      this.lng =null ;
      this.searchLocation =null ;
      this.searchLat =null ;
      this.searchLang = null;
      this.locationResult= null ;
      this.uploader =null ;
      this.bodyContent ='' ;
      this.tagsPositions =[];
      this.recordUploaded= false ;
      this.filesUploaded =false ;
      this.recordToken =null ;
      this.filesTokens =null ;
      this.submitObject =null ;
      this.draggingMode =false ;
      this.recorderResponded = false ;
      this.mfuResponded = false;
      this.textContent = {text : '' , voice : ''};
      this.finalTextBody = "";
      App.$emit('knocks_multiple_uploader_reset' , this.scope);
      $('#'+this.gid+'_input').empty()
      $('#'+this.gid+'_input').blur()
      this.notifi();
      App.$emit('knocks_refresh_posts');
    },
    notifi() {
            
         const h = this.$createElement;
        this.$message({
          message: h('p', null, [
            h('span', { class : 'knocks_text_ms knocks_text_dark'}, 'Success '),
            h('i', {  class : ' knocks-check knocks_icon knocks_text_md green-text' })
          ])
        });
      
      },
        notifiError() {
            
         const h = this.$createElement;
        this.$message({
          message: h('p', null, [
            h('span', { class : 'knocks_text_ms knocks_text_dark'}, 'There is no content in your knock'),
            h('i', {  class : ' knocks-warning7 knocks_icon knocks_text_md red-text' })
          ])
        });
      
      },
      watchMyDom(){
       const vm = this;
        this.updateTextContent();
       let childs = document.getElementById(vm.gid+'_input').children;
       let i;
        for(i = 0 ; i < childs.length; i++){
          if(!$(childs[i]).hasClass('chip') && childs[i].tagName != 'BR'){
            console.log(childs[i].tagName)
            $(childs[i]).replaceWith($(childs[i]).text());
            console.log('watch');
          }
        }
      },
      updateTextContent(){
      this.textContent.text= $('#'+this.gid+'_input').text();
      this.hashFinalTextContent();
    },
    addRecognitionContent(e){
      this.textContent.voice = e;
      this.hashFinalTextContent();
    },
    hashFinalTextContent(){
      this.finalTextBody = this.textContent.text+' '+this.textContent.voice.trim();
    },



    ////maps

    triggerMaps(){

        this.mapsOn = true;
        const vm = this;





        navigator.geolocation.getCurrentPosition(function(position) {
          let mapHolder = document.getElementById(vm.gid+'_map_holder');
          vm.lat = position.coords.latitude;
          vm.lng = position.coords.longitude;



          GoogleMapsLoader.load(function(google) {
            let map = new google.maps.Map(mapHolder, {
               center: {lat: vm.lat, lng: vm.lng},
                zoom: 8,
                scaleControl: true,
                streetViewControl: true,
                panControl: true,
                mapTypeControl: true,
                overviewMapControl: true,
                styles: [
                            {elementType: 'geometry', stylers: [{color: '#242f3e'}]},
                            {elementType: 'labels.text.stroke', stylers: [{color: '#242f3e'}]},
                            {elementType: 'labels.text.fill', stylers: [{color: '#746855'}]},
                            {
                              featureType: 'administrative.locality',
                              elementType: 'labels.text.fill',
                              stylers: [{color: '#d59563'}]
                            },
                            {
                              featureType: 'poi',
                              elementType: 'labels.text.fill',
                              stylers: [{color: '#d59563'}]
                            },
                            {
                              featureType: 'poi.park',
                              elementType: 'geometry',
                              stylers: [{color: '#263c3f'}]
                            },
                            {
                              featureType: 'poi.park',
                              elementType: 'labels.text.fill',
                              stylers: [{color: '#6b9a76'}]
                            },
                            {
                              featureType: 'road',
                              elementType: 'geometry',
                              stylers: [{color: '#38414e'}]
                            },
                            {
                              featureType: 'road',
                              elementType: 'geometry.stroke',
                              stylers: [{color: '#212a37'}]
                            },
                            {
                              featureType: 'road',
                              elementType: 'labels.text.fill',
                              stylers: [{color: '#9ca5b3'}]
                            },
                            {
                              featureType: 'road.highway',
                              elementType: 'geometry',
                              stylers: [{color: '#746855'}]
                            },
                            {
                              featureType: 'road.highway',
                              elementType: 'geometry.stroke',
                              stylers: [{color: '#1f2835'}]
                            },
                            {
                              featureType: 'road.highway',
                              elementType: 'labels.text.fill',
                              stylers: [{color: '#f3d19c'}]
                            },
                            {
                              featureType: 'transit',
                              elementType: 'geometry',
                              stylers: [{color: '#2f3948'}]
                            },
                            {
                              featureType: 'transit.station',
                              elementType: 'labels.text.fill',
                              stylers: [{color: '#d59563'}]
                            },
                            {
                              featureType: 'water',
                              elementType: 'geometry',
                              stylers: [{color: '#17263c'}]
                            },
                            {
                              featureType: 'water',
                              elementType: 'labels.text.fill',
                              stylers: [{color: '#515c6d'}]
                            },
                            {
                              featureType: 'water',
                              elementType: 'labels.text.stroke',
                              stylers: [{color: '#17263c'}]
                            }
                         ]
                });
             var marker = new google.maps.Marker({
              position: {lat: vm.lat, lng: vm.lng},
              map: map
            });

        var input = document.getElementById('pac-input');
        var searchBox = new google.maps.places.SearchBox(input);
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

        // Bias the SearchBox results towards current map's viewport.
        map.addListener('bounds_changed', function() {
          searchBox.setBounds(map.getBounds());
        });

        var markers = [];
        // Listen for the event fired when the user selects a prediction and retrieve
        // more details for that place.
        searchBox.addListener('places_changed', function() {
          var places = searchBox.getPlaces();

          if (places.length == 0) {
            return;
          }

          // Clear out the old markers.
          markers.forEach(function(marker) {
            marker.setMap(null);
          });
          markers = [];

          // For each place, get the icon, name and location.
          var bounds = new google.maps.LatLngBounds();
          places.forEach(function(place) {
            if (!place.geometry) {
              console.log("Returned place contains no geometry");
              return;
            }
            var icon = {
              url: place.icon,
              size: new google.maps.Size(71, 71),
              origin: new google.maps.Point(0, 0),
              anchor: new google.maps.Point(17, 34),
              scaledSize: new google.maps.Size(25, 25)
            };

            // Create a marker for each place.
            markers.push(new google.maps.Marker({
              map: map,
              icon: icon,
              title: place.name,
              position: place.geometry.location
            }));

            if (place.geometry.viewport) {
              // Only geocodes have viewport.
              bounds.union(place.geometry.viewport);
            } else {
              bounds.extend(place.geometry.location);
            }
          });
          map.fitBounds(bounds);
        });
            });
          }); 



          
                
       }
  	
  }
}
</script>

<style lang="css" scoped>
</style>


