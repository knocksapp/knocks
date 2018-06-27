<template>
<transition   name="custom-classes-transition" enter-active-class="animated zoomInDown" leave-active-class="animated zoomOutUp">
  <div :class = "main_container" :id = "gid" class = " " v-if= "showState && is_auth" style="margin-bottom : 2px !important;">
    <slot name = "top"></slot>
    <div class = "    col s12 knocks_house_keeper ">
      <!-- LEVEL ONE -->
      <transition enter-active-class = "animated fadeInUp" leave-active-class = "animated fadeOutDown">
        <div class = "col s12 knocks_house_keeper" style = "margin-top : 1px !important; padding : 0px !important;"
          :class =  "[{'knocks_hidden' :!hasAContent} , { hasAContent :'animated slideInUp'}]">
          <div class = "col s1 l2 left">
            <knocksprivacyadjustments trigger_class = " amber-text  transparent darken-2 btn-floating knocks_btn_floating_sm   knocks_noshadow_ps knocks_borderless " class = "right" v-model = "privacy_setting" ></knocksprivacyadjustments>
          </div>
          <div class = " col l10 s10">
            <span class = "knocks-knocks grey-text knocks_tinny_side_padding text-lighten-2  animated fadeIn" v-if = "userSuggestions.length == 0 && tagged.length == 0"></span>
            <static_message classes = "text-lighten-2  grey-text  fadeIn" :msg = "replier_message" v-if = "userSuggestions.length == 0 && tagged.length == 0"></static_message>
            <div @click="spliceFromTagged(i)" v-for = "(x , i) in tagged" v-if = "alreadyTagged(x)"  >
              
              <knocksuser :user="x" as_chip show_image name_class = "knocks_color_kit" hide_text_info
              main_container =  "animated bounceInLeft knocks_color_kit knocks_inline right knocks_smooth_transition" >
              </knocksuser>
              
            </div>
            <div @click="pushToTagged(x , i)" v-for = "(x , i) in userSuggestions" class = "knocks_inline" v-if = "!alreadyTagged(x)">
              
              <knocksuser :user="x" as_chip show_image  v-model = "suggestions[i]" main_container =  "animated bounceInUp" ></knocksuser>
              
            </div>
          </div>
        </div>
      </transition>
      
      <!--LEVEL TWO -->
      <div class = "">
        <div class = "">
          <div class ="white col s10 knocks_house_keeper knocks_standard_border_radius" style="margin-top : 1px !important;"
            :class = "[{'knocks_theme_active_border':focused},{'knocks_pink_border' : !focused}]">
            <static_message msg = "Type here.." v-model = "ceaPlaceholder" class = "knocks_hidden"></static_message>
            <div
              :class = "[input_container , {'col s12':focused}, {'col m8 s6':!focused}]" v-if="!draggingMode"
              contenteditable = "true" @focus = "focused = true" @blur = "focused = false"
              class = "knocks_language_follower white knocks_ce_watch_align" :data-text="ceaPlaceholder" :id = "gid+'_input'" v-model = "bodyContent" @input = "constructInput()">
            </div>
            
            <!--Level Three-->
            
            <div :class = "options_bar_class" class = "knocks_house_keeper" style = "margin-top:4px; margin-bottom:0px">
              <transition >
                <div
                  :class = "[
                  {'knocks_hidden':focused} ,
                  {'animated fadeIn' : !focused},
                  {'col' : !focused && !hasImages && ( uploader === null || uploader.regularFiles === undefined || uploader.regularFiles.length == 0 )} ,
                  {'col s12' : !focused && (hasImages || !( uploader === null || uploader.regularFiles === undefined || uploader.regularFiles.length == 0 )) } ,
                  ]" class = " right">
                  <knocksmultipleuploader @change = "showInterest()" :gid = "gid+'_file_uploader'" v-model  = "uploader" :scope = "scope"></knocksmultipleuploader>
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
                  <knocksrecorder
                  v-if = "!draggingMode"
                  
                  @recognition="addRecognitionContent($event)"
                  @record_reset="addRecognitionContent('')"
                  v-model = "recorder"
                  hide_player
                  main_container = "knocks_house_keeper knocks_inline"
                  :upload_data= "recorder_upload_data"
                  :gid = "gid+'_recorder'"
                  :record_button_on_stop = "option_classes"
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
                  timer_right
                  >
                  </knocksrecorder>
                  
                </div>
              </transition>
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
            :disabled = "!hasAContent"
            :icon = "btn_icon"
            v-model = "button"
            :submit_at = "submit_at"
            :success_at = "success_at"
            :error_at = "error_at"
            :success_msg= "success_msg"
            :submit_data = "{ submit_object : submitObject }"
            :error_class = "btn_error_class"
            :success_class = "btn_success_class"
            :button_classes = "btn_classes"
            :label_classes = "btn_label_classes"
            @knocks_submit_accepted = "resetKnock()"
            hide_success_msg
            :materialize_feedback = "false"
            button_classes = " el-button knocks_color_kit btn-floating knocks_tiny_floating_btn  knocks_btn_color_kit  knocks_right knocks_noshadow_ps knocks_borderless">
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
    </div>
    
    
    <!-- Modal Structure -->
    <div :id="gid+'_map_modal'" class="modal modal-fixed-footer ">
      <div class="modal-content">
        <h4>Modal Header</h4>
        <input id="pac-input" class="controls" type="text" placeholder="Search Box">
        <div :id="gid+'_map_holder'" class = "knocks_map_holder"></div>
      </div>
      <div class="modal-footer">
        <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat ">Agree</a>
      </div>
    </div>
    <div :id="gid+'_location_modal'" class="modal modal-fixed-footer">
      <div class="modal-content">
        <h4>Modal Header</h4>
        <knocksinput
        placeholder="search"
        v-model = "searchLocation"
        @input="searchForNearby()"
        :gid = "gid+'_location_searchbar'"
        icon_class = "teal-text lighten-3"
        knocksclass="knocks_teal_input" icon = "knocks-search12" >
        </knocksinput>
      </div>
      <div class="modal-footer">
        <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat ">Agree</a>
      </div>
    </div>
  </div>
</transition>
</template>

<script>
export default {
  name: 'knocksreply',
  props : {
  	gid : {
  		type : String , 
  		required : true
  	},
  	parent_id :{
  		type : Number , 
  		required : true 
  	},
    object_id : {
      type : Number , 
      required : true
    },
  	main_container : {
  		type : String , 
  		default : 'row knocks_smooth_transition knocks_house_keeper knocks_standard_border_radius' ,
  	},
  	input_container : {
  		type : String , 
  		default : 'knocks_content_reply_continer '
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
  		default : 'knocks_options_bar col m4 s6 knocks_tinny_top_padding'
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
  		default : 'knocks-send3 knocks_text_light knocks_custom_margin_left'
  	},
  	btn_disable_placeholder : {
  		type : Boolean , 
  		default : true 
  	},
  	btn_container_class : {
  		type : String ,
  		default : 'right'
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
  		default : 'knocks_inline knocks_house_keeper'
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
  		default : 'knocks_inline'
  	},
  	recorder_player_container : {
  		type : String , 
  		default : ' knocks_house_keeper'
  	},
    options_bar_class : {
      type : String , 
      default : ''
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
      default : 'btn btn-floating knocks_tiny_floating_btn  transparent pink-text darken-1 knocks_noshadow_ps'
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
     replier_message : {
      type : String , 
      default : ''
     },
     show_on_mount : {
      type : Boolean , 
      default : false 
     },



  	// Recorder player props 

  	//knocks_player_props
  	player_initial_class : {
  		type :String ,
  		default : 'btn btn-floating knocks_tiny_floating_btn pink darken-1 right'
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
  		default : 'knocks-play5 animated jello'
  	},
  	player_icon_pause_class : {
  		type :String ,
  		default : 'knocks-pause4 animated rubberBand'
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
    toggle_parent_type : {
      type : String , 
      default : null
    },
    toggle_object_id : {
      type : Number , 
      default : null
    },
    is_auth : {
      type : Boolean ,
      default : parseInt(window.UserId) > 0
    }

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
      showState : false ,
      interest : false ,
      imagesQuotes : [] ,
      recorderResponded : false ,
      mfuResponded : false ,
      hasRecord : false ,
      hasFiles : false ,
      hasImages : false ,
      textContent : {text : '' , voice : ''} ,
      finalTextBody : '' ,
      focused : false ,
      ceaPlaceholder : '' ,
      button : {}
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

    hasAContent(){
      return (
       ( this.bodyContent == null || this.bodyContent.length == 0 ) && 
       ( this.uploader == null || this.uploader.regularFiles.length == 0 || this.uploader.images.length == 0 )
       && this.locationResult == null && 
       (this.recorder == null || !this.recorder.hasRecord)
      ) ? false : true;
    }
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
    this.showState = this.show_on_mount ;
    setTimeout( ()=>{
      if(this.showState)
        this.watchMyDom();
      } ,300);
    $('#'+this.gid+'_map_modal').modal();
    $('#'+this.gid+'_location_modal').modal();

    // App.$on('knocks_submit' , (scope)=>{
    //   let tar;
    //   for(tar in scope){
    //     if(vm.scope.indexOf(scope[tar]) != -1){
    //       if(!vm.hasFiles && !vm.hasRecord){
    //         setTimeout(()=>{vm.submitFormat();} ,200);
    //         setTimeout(()=>{App.$emit('knocksFinalSubmit', {scope : vm.scope});},300);
    //       }
    //     }
    //   }
    // });
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
    App.$on('knocksMediaQueryLogged' , (payload)=>{
      let tar ;
      for(tar = 0 ; tar < payload.scope.length; tar++){
        console.log('mediaQueryRecieved');
        console.log(payload);
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
    });    App.$on('knocksMultipleUploaderDragging' , (state)=>{
      vm.draggingMode = state;
    });
    //Toggle Reply
    App.$on('knocksReplyState' , (payloads)=>{
      if(payloads.scope == vm.scope && payloads.type == vm.toggle_parent_type){
        vm.showState = payloads.state ;
      }
      if(payloads.type == vm.toggle_parent_type && payloads.scope != vm.scope && payloads.relatives){
        vm.showState = false;
      }

    });

    App.$on('KnocksReplyMention' , (payloads)=>{
       if(payloads.scope == vm.scope && payloads.type == vm.toggle_parent_type){
        setTimeout(()=>{
          vm.pushToTaggedById(payloads.user, payloads.userObject);
        },700);
        
      }
    });
    App.$emit('knocksWatchAligns');
  },
  methods : {
  	constructInput(){
  		this.getTokens();
  		this.searchForUsers();
      this.reverseCheck();
      this.checkForTags();
      this.getThebodyContent();
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
  			data : {q : vm.tokens[(vm.tokens.length) -1] , parent_id : vm.parent_id , parent_type : vm.parent_type}
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
      
      // this.tagsPositions.push({ 
      //   user : user ,
      //   position : currentLen - ( this.taggedPeople.length * 129 + counter + (this.tokens[this.tokens.length - 1].length) )});
      this.getThebodyContent();
    },
    pushToTaggedById(user , object){

      if(this.tagged.indexOf(user) != -1) return;
      if(this.suggestions.indexOf(user) == -1) this.suggestions.push(object);
      let index = this.suggestions.length-1;
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
      
      // this.tagsPositions.push({ 
      //   user : user ,
      //   position : currentLen - ( this.taggedPeople.length * 129 + counter + (this.tokens[this.tokens.length - 1].length) )});
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
    showInterest(){
      if(this.interest) return;
      this.interest = true;
      App.$emit('knocksShowInterest' , { objectId : this.object_id , parentType : this.toggle_parent_type });
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
        has_files : this.hasFiles , 
        files_specifications : filesTokens , 
        has_videos : this.hasRecord , 
        videos_specifications : [] ,
        has_voices : this.hasRecord ,
        voices_specifications : this.recordToken ,
        seen : 0 , 
        feelings : [] , 
        text : this.finalTextBody , 
        post_id : this.parent_id ,
        check_in : this.locationResult ,
        tags : this.tagged ,
        privacy_setting : this.privacy_setting , 
      }
      console.log(JSON.stringify(res))
      this.submitObject = res;
      setTimeout(()=>{ 
        App.$emit('knocksFinalSubmit', {scope : this.scope}); 
        console.log("%c knocks final submit from "+this.scope , "font-size : 15px; font-color : blue")
       },300);
      return res;
    },
   prepareSubmit(){
      if(!(this.recorderResponded && this.mfuResponded)) return;
      if(!this.hasFiles && !this.hasImages && (this.bodyContent == null || this.bodyContent.length == 0) && this.locationResult == null && !this.hasRecord){
        this.notifiError();
        return;
      }
      this.submitFormat();
    },
    watchMyDomKeeper(){
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

    watchMyDom(){
      const vm = this;
      if(this.is_auth){
      if(vm.parent_type != 'timelinephoto'){
      document.getElementById(this.gid+'_input').onpaste = function(){
      vm.watchMyDomKeeper();
      vm.watchMyDomKeeper();
    }
    }
    $(document).on('keyup' , '#'+this.gid+'_input' , function(){
      vm.watchMyDomKeeper();
      vm.watchMyDomKeeper();
      //$('#knockknock_input').focus;
    });

    $(document).on('change' , '#'+this.gid+'_input' , function(){
      vm.watchMyDomKeeper();
      vm.watchMyDomKeeper();
      //$('#knockknock_input').focus;
    });
     $(document).on('focus' , '#'+this.gid+'_input' , function(){
      vm.focused = true;
      if(!vm.interest)
      vm.showInterest();
     });
       $(document).on('blur' , '#'+this.gid+'_input' , function(){
        vm.focused = false;
        vm.watchMyDomKeeper();
        vm.watchMyDomKeeper();
    });
     }

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
      this.$emit('knocks_reply_done');
      $('#'+this.gid+'_input').empty()
      $('#'+this.gid+'_input').blur()
      this.notifi();
      App.$emit('knocks_refresh_posts');
     // if(!this.show_on_mount) this.showState = false ;
     // App.$emit('knocksReplyState' , {scope : this.scope , type : this.toggle_parent_type , state : false});
      //sconsole.log('reset '+this.gid)
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
            h('span', { class : 'knocks_text_ms knocks_text_dark'}, 'There is no content in your comment'),
            h('i', {  class : ' knocks-warning7 knocks_icon knocks_text_md red-text' })
          ])
        });
      
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
.knocks_custom_margin_left{ margin-left: -3px; }
</style>


