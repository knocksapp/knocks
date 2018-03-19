<template>
<div>
  <!-- Lazy Retriver Begins ========================================================================-->
  <knocksretriver
  :xdata = "{ q : user }"
  v-model=  "lazyRetriver"
  v-if = "lazy_user"
  @success="saveLazySource($event.response)"
  url = "user/info/lazy"></knocksretriver>
  <!-- Lazy Retriver Ends =============================================================================-->
  <!-- Regular Retriver Begins ========================================================================-->
  <knocksretriver
  :xdata = "{ q : user }"
  v-model=  "regularRetriver"
  v-if = "!lazy_user"
  prevent_on_mount
  :scope = "['regular_user_retriver' , 'user_retriver_'+user]"
  @success="initialize($event.response)"
  url = "user/info"></knocksretriver>
  <!-- Regular Retriver Ends ============================================================================-->
  <div v-if = "regularRetriver != null || lazyRetriver != null" >
    <knocksloaderbar class = "col s12 animated fadeIn" v-if = "regularRetriver.loading"></knocksloaderbar>
    <knocksloaderbar class = "col s10 animated fadeIn" v-if = "regularRetriver.loading"></knocksloaderbar>
    <!-- Popover Begins =================================================================================-->
    <el-popover
    v-if = "!hide_popover && userObject != null"
    ref="userpopover"
    width = "400"
    placement="top-start"
    @show = "updateBalloonsTimer()"
    @hide="runBalloonsTimer()"
    popper-class = "knocks_house_keeper"
    trigger="hover">
    <div class = "row knocks_house_keeper">
      <div class = "col s4 knocks_house_keeper">
        <knocksimg :src = "asset('media/avatar/compressed/'+user)" :classes = "[{'knocks_user_profile_scope' : thatsMe}]"></knocksimg>
      </div>
      <div class = "col s8 knocks_house_keeper">
        <div class = "row knocks_text_dark">
          <div class = "col s12">
            <span  :href = "userUrl"  v-if="userObject"  > {{ displayName }}</span>
          </div>
          <div class = "col s12">
            <a  :href = "userUrl" v-if="userObject != null && show_username"> {{'@'+userObject.username}} </a>
          </div>
        </div>
        <div class = "row knocks_text_dark">
          <div class = "col s12" style="margin-top : -10px;">
            <span class = "knocks-user4"></span>
            <span v-if ="userObject.first_name != null && userObject.first_name != undefined" >{{userObject.first_name}} </span>
            <span v-if ="userObject.middle_name != null && userObject.middle_name != undefined" >{{userObject.middle_name}} </span>
            <span v-if ="userObject.last_name != null && userObject.last != undefined" >{{userObject.last_name}} </span>
          </div>
          <div class = "col s12" v-if ="userObject.gender != null && userObject.gender != undefined && userObject.gender.toLowerCase() == 'male'" >
            <span class = "knocks-male2"></span><span><static_message msg = "Male"></static_message></span>
          </div>
          <div class = "col s12" v-if ="userObject.gender != null && userObject.gender != undefined && userObject.gender.toLowerCase() == 'female'" >
            <span class = "knocks-female2"></span><span><static_message msg = "Female"></static_message></span>
          </div>
          <div class = "col s12" v-if ="userObject.birthdate != null && userObject.birthdate != undefined" >
            <span class = "knocks-birthday-cake"></span> <span> {{ birthDate(userObject.birthdate) }}</span>
          </div>
          <div class = "col s12" v-if ="userObject.email != null && userObject.email != undefined" >
            <span class = "knocks-email3"></span> <span> {{ userObject.email }}</span>
          </div>
        </div>
        <div class = "col s12">
        </div>
      </div>
    </div>
    </el-popover>
    <!-- Popover Ends =======================================================================================-->
    <!-- Default Presentation Begins ========================================================================-->
    <div v-if = "onDefaultView && userObject != null" :class = "[main_container]">
      <div v-if = "!hide_popover">
        <knocksimg  v-popover:userpopover 
        :src = "asset('media/avatar/compressed/'+user)" :classes = "[knocks_avatar_classes, {'knocks_user_profile_scope' : thatsMe}]" v-if = "!hide_image">
        </knocksimg>
        <div :class = "name_container_class" class="" v-if ="!hide_text_info">
          <a :class = "name_class" :href = "userUrl" v-popover:userpopover v-if="userObject && !hide_name"> {{ displayName }}</a>
          <slot name = "append_to_display_name"></slot>
          <br/>
          <a :class = "username_class" v-popover:userpopover :href = "userUrl" v-if="userObject != null && show_username" style = "display:block"> {{'@'+userObject.username}} </a>
        </div>
      </div>
      <div v-else>
        <knocksimg :src = "asset('media/avatar/compressed/'+user)" :classes = "[knocks_avatar_classes, {'knocks_user_profile_scope' : thatsMe}]" v-if = "!hide_image">
        </knocksimg>
        <div :class = "name_container_class" class="" v-if ="!hide_text_info">
          <a :class = "name_class" :href = "userUrl"  v-if="userObject && !hide_name"> {{ displayName }}</a><slot name = "append_to_display_name"></slot><br/>
          <a :class = "username_class" :href = "userUrl" v-if="userObject != null && show_username" style = "display:block"> {{'@'+userObject.username}} </a>
        </div>
      </div>
    </div>
    <!--Default Presentation Ends ========================================================================-->
    <!--Chips Presentation Begins ========================================================================-->
    <div class="chip" :class="main_container" contenteditable="false" v-if="as_chip">
      <knocksimg :src = "asset('media/avatar/compressed/'+user)" :classes = "{'knocks_user_profile_scope' : thatsMe}" ></knocksimg>
      <span :class = "name_class" :href = "userUrl"  v-if="userObject && !hide_text_info"  > {{displayName}} </span>
      <slot name = "append"></slot>
    </div>
    <!--Chips Presentation Ends ========================================================================-->
    <!--Label Presentation Begins ========================================================================-->
    <div class="ui image label"  contenteditable="false" v-if="as_label" :class = "label_classes">
      <knocksimg :src = "asset('media/avatar/compressed/'+user)" :classes = "{'knocks_user_profile_scope' : thatsMe}" ></knocksimg>
       {{displayName}}
      <slot name = "append"></slot>
    </div>
    <!--Label Presentation Ends ========================================================================-->
    <!--Report Presentation Begins =====================================================================-->
    <div  :class="main_container" contenteditable="false" v-if="as_report && userObject != null">
      <div class = "row knocks_house_keeper knocks_text_dark">
        <div class = "col s12">
          <span class = "knocks-user14" v-if ="userObject.gender != null && userObject.gender != undefined && userObject.gender.toLowerCase() == 'female'" ></span>
          <span class = "knocks-user12" v-if ="userObject.gender != null && userObject.gender != undefined && userObject.gender.toLowerCase() == 'male'" ></span>
          <span class = "knocks-user-outline"  v-if ="userObject.gender == null || userObject.gender == undefined "></span>
          <static_message msg = "Name : "></static_message>
          <span v-if ="userObject.first_name != null && userObject.first_name != undefined" >{{userObject.first_name}} </span>
          <span v-if ="userObject.middle_name != null && userObject.middle_name != undefined" >{{userObject.middle_name}} </span>
          <span v-if ="userObject.last_name != null && userObject.last_name != undefined" >{{userObject.last_name}} </span>
        </div>
        <div class = "col s12" v-if ="userObject.gender != null && userObject.gender != undefined && userObject.gender.toLowerCase() == 'male'" >
          <span class = "knocks-male2"></span><span><static_message msg = "Male"></static_message></span>
        </div>
        <div class = "col s12" v-if ="userObject.gender != null && userObject.gender != undefined && userObject.gender.toLowerCase() == 'female'" >
          <span class = "knocks-female2"></span><span><static_message msg = "Female"></static_message></span>
        </div>
        <div class = "col s12" v-if ="userObject.birthdate != null && userObject.birthdate != undefined" >
          <span class = "knocks-birthday-cake"></span>
          <static_message msg = "Birthdate : "></static_message>
          <span> {{ birthDate(userObject.birthdate) }}</span>
        </div>
        <div class = "col s12" v-if ="userObject.email != null && userObject.email != undefined" >
          <span class = "knocks-email3"></span>
          <static_message msg = "Email : "></static_message>
          <span> {{ userObject.email }}</span>
        </div>
      </div>
    </div>
    <!--Report Presentation Ends =======================================================================-->
    <!--Name Presentation Begins =======================================================================-->
    <div v-if = "userObject != null && as_name">
      <div v-if = "!hide_popover">
        <span  v-popover:userpopover :class = "main_container">
          <span :class = "name_class" :href = "userUrl"  v-if="userObject && !hide_name"> {{ displayName }}</span>
          <slot name = "append_to_display_name"></slot>
        </span>
      </div>
      <div v-else>
        <span  :class = "main_container">
          <span :class = "name_class" :href = "userUrl"  v-if="userObject && !hide_name"> {{ displayName }}</span>
          <slot name = "append_to_display_name"></slot>
        </span>
      </div>
    </div>
    <!--Name Presentation Ends =======================================================================-->
    <!--URL Presentation Begins =======================================================================-->
    <div v-if = "userObject != null && as_url">
      <a v-if = "!hide_popover" :href = "userUrl">
        <span  v-popover:userpopover :class = "main_container">
          <span :class = "name_class" :href = "userUrl"  v-if="userObject && !hide_name"> {{ displayName }}</span>
          <slot name = "append_to_display_name"></slot>
        </span>
      </a>
      <a v-else :href = "userUrl">
        <span  :class = "main_container">
          <span :class = "name_class" :href = "userUrl"  v-if="userObject && !hide_name"> {{ displayName }}</span>
          <slot name = "append_to_display_name"></slot>
        </span>
      </a>
    </div>
    <!--URL Presentation ENDS =========================================================================-->
    <!--Result Presentation Begins ===================================================================-->
    <div v-if = "as_result && userObject != null">
      <div :class = "main_container">
        <knocksimg :src = "asset('media/avatar/compressed/'+user)" :classes = "[knocks_avatar_classes,{'knocks_user_profile_scope' : thatsMe}]"></knocksimg>
        <div class = "">
          <div  class="">
            <div class = "col" v-if = "!hide_text_info">
              <a :class = "name_class" :href = "userUrl"  v-if="userObject && !hide_name"> {{ displayName }}</a><slot name = "append_to_display_name"></slot><br/>
              <a :class = "username_class" :href = "userUrl" v-if="userObject != null && show_username" style = "display:flex"> {{'@'+userObject.username}} </a>
            </div>
            <div :class = "user_actions_container">
              <knocksuseractions v-if = "show_accept_shortcut"
              :extras = "extras"
              :user="user"
              :start_as = "userObject"
              :show_accept_shortcut = "show_accept_shortcut">
              </knocksuseractions>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--Name Presentation Begins =======================================================================-->
    <!--CallBack Presentation Begins ===================================================================-->
    <div v-if = "as_callback && userObject != null" class = "row knocks_house_keeper" :class = "[callback_container]">
      <a @click = "emitClick()" :class = "[main_container]">
        <knocksimg :src = "asset('media/avatar/compressed/'+user)" :classes = "[knocks_avatar_classes,{'knocks_user_profile_scope' : thatsMe}]"></knocksimg>
        <span :class ="[name_class]" >{{ displayName }}</span>
        <slot name = "append"></slot>
        <span v-if = "userObject.chatStatus && !clashProp" class="right uk-badge" :class = "[{'red' : !calcStatus} , {'green' : calcStatus}]">{{userObject.chatStatus}}
        </span>
        <slot name = "preppend"></slot>
      </a>
    </div>
    <!--CallBack Presentation Ends =====================================================================-->
  </div>
</div>
</template>
<script>
export default {
  name: 'knocksusershortcut',
  props : {
    user : {
      type : Number , 
      required : true ,
    } , 
    lazy_user : {
      type : Boolean , 
      default : false ,
    },
    callback_container : {
      type : String , 
      default : 'knocks_gray_on_hover knocks_standard_border_radius'
    },
    image_container_class : {
      type : String ,
      default : 'col s3' 
    },
    name_container_class : {
      type : String ,
      default : 'col s9' 
    },
    main_container : {
       type : String , 
       default : 'row' 
    },
    name_class : {
      type : String ,
      default : 'knocks_text_anchor  knocks_text_bold knocks_tinny_side_padding'
    },
    username_class : {
      type : String ,
      default : 'knocks_text_xs knocks_text_bold knocks_tinny_side_padding'
    },
    label_classes : {
      type : [Array , Object , String ],
      default : 'blue knocks_inline'
    },
    knocks_avatar_classes : {
      type : String , 
      default : 'knocks_avatar knocks_house_keeper col '
    },
    user_actions_container : {
      type : String , 
      default : 'right'
    },
    show_image : {
      type : Boolean ,
      default : true 
    } ,
    show_username : {
      type : Boolean ,
      default : true 
    } ,
    show_accept_shortcut : {
      type : Boolean , 
      default : true 
    }, 
    hide_username : {
      type : Boolean , 
      default : false 
    },
    hide_name : {
      type : Boolean , 
      default : false 
    },
    hide_text_info : {
      type : Boolean ,
      default : false 
    },
    hide_popover : {
      type : Boolean , 
      default : false ,
    },
    hide_image : {
      type : Boolean , 
      default : false ,
    },
    as_chip : {
      type : Boolean , 
      default : false 
    },
    as_result : {
      type : Boolean , 
      default :  false 
    },
    as_report : {
      type : Boolean , 
      default :  false 
    },
    as_name : {
      type : Boolean , 
      default : false ,
    },
    as_callback : {
      type : Boolean , 
      default : false ,
    },
    as_url : {
      type : Boolean ,
      default : false 
    },
    as_label : {
      type : Boolean , 
      default : false ,
    },
    extras : {
      type : Object , 
      default : null,
    },
  },
  data () {
    return {
      lazyRetriver : null , 
      regularRetriver : null ,
      userObject : null ,
      displayName : '' ,
      userUrl : '#' ,
      fullName : '' , 
      clashProp : false ,
      calcStatus : false ,
    }
  },
  mounted(){
    if(!this.isKnown()){
      App.$emit('knocksRetriver' , { scope : ['user_retriver_'+this.user] } );
    }else this.initialize(window.UsersObject[this.user]);
    //Reacting on events
        const vm = this;
    //Update data globally
    App.$on('knocksUserDataUpdated' , (payloads)=>{
      if(payloads.user == vm.user){
        vm.initialize(payloads.update);
      }
    })
    App.$on('KnocksContentChanged' , ()=>{
      if(vm.userObject == null) return;
      setTimeout(()=>{
        if(vm.userObject != null && vm.userObject.id != vm.user){    
          if(UsersObject[vm.user] != undefined){
            vm.initialize(window.UsersObject[vm.user]);
          }else {
              vm.userObject = null ;
              App.$emit('knocksRetriver' , { scope : ['user_retriver_'+vm.user] } );
          }
        }
      },300);
    });
    App.$on('knocksUserResetContent' , (id)=>{
      if(id == vm.user){
         vm.initialize(window.UsersObject[vm.user]);
      }
    });
    App.$on('knocksUserKeyUpdate' , (payloads)=>{
      if(payloads.user == vm.user){
        if(vm.userObject !== null){
        let i ; 
        for(i = 0 ; i < payloads.patch.length; i++){
          vm.userObject[payloads.patch[i].key] = payloads.patch[i].value
        }
        vm.initialize(vm.userObject);
      }else{
        vm.holdOnChanges(payloads);
      }
    }
    });
  },
  computed : {
    thatsMe(){
      return this.user == window.UserId ? true : false ;
    },
    onDefaultView(){
       let arr = [
         this.as_chip , 
         this.as_report , 
         this.as_result , 
         this.as_callback , 
         this.as_name ,
         this.as_url ,
         this.as_label , 
       ] , i ;
       for (i = 0; i < arr.length; i++)
        if(arr[i])  return false;
        return true;
    }
  },
  methods : {
    isKnown(){
      return window.UsersObject[this.user] === undefined ? false : true ;
    },
    holdOnChanges(payloads){
      setTimeout(()=>{
        if(this.userObject !== null){

        let i ; 
        for(i = 0 ; i < payloads.patch.length; i++){
          this.userObject[payloads.patch[i].key] = payloads.patch[i].value
        }
        this.initialize(this.userObject);
        }else this.holdOnChanges();
      },500)
    },
    isGlobalyAuth(){
      return window.UserId === undefined || window.UserId === null || window.UserId.length === 0 ? false : true;
    },
    saveLazySource(e){
      return true ;
    },
    initialize(remoteObject){
      this.userObject = null ;
      this.userObject = remoteObject;
      this.getDisplayName();
      this.getFullName();
      this.formatChatStatus();
      this.userUrl = this.asset(this.userObject.username);
      this.userObject.userUrl = this.userUrl;
      this.userObject.compressedAvatarUrl = this.asset('media/avatar/compressed/'+this.user);
      this.userObject.avatarUrl = this.asset('media/avatar/'+this.user);
      this.userObject.avatarClasses = this.knocks_avatar_classes;
      this.userObject.name = this.displayName ; 
      this.userObject.fullName = this.fullName ;
      this.userObject.thatsMe = this.thatsMe ;
      this.$emit('input' , this.userObject);
      window.UsersObject[this.user] = this.userObject;
    },
    asset(url){
      return LaravelOrgin + url ;
    },
    getDisplayName(){
      if(!this.userObject) null;
      if(this.userObject.display_name === undefined) null;
      if(this.userObject.display_name.length == 0) return this.first_name;
      let i, temp = [];
      for(i = 0; i < this.userObject.display_name.length; i++){
        if(this.userObject[ this.userObject.display_name[i] ] !== undefined){
          if(this.userObject.display_name[i] == 'nickname' && this.userObject.display_name.length > 1)
            temp.push('('+this.userObject[this.userObject.display_name[i]] + ')')
         else temp.push(this.userObject[this.userObject.display_name[i]])
        }
      }
      this.displayName = temp.join(' ');
    },
    getFullName(){
      if(!this.userObject) null;
      let arr = [
      'first_name' , 
      'last_name' ,
      'middle_name' , 
      'nickname' , 
      'username'
      ];
      let i, temp = [];
      for(i = 0; i < arr.length; i++){
        if(this.userObject[ arr[i] ] !== undefined){
          temp.push(this.userObject[arr[i]])
        }
      }
      this.fullName = temp.join(' ');
    },
    birthDate(bd){
      return moment(bd , 'YYYY-MM-DD').format('D MMM YYYY');
    },
    updateBalloonsTimer(){
      if(this.extras != null && this.extras.hover_id != undefined){
        App.$emit('knocksStopBallonTimer' , (this.extras.hover_id));
      }else return;
    },
    runBalloonsTimer(){
      if(this.extras != null && this.extras.hover_id != undefined){
        App.$emit('knocksTurnOnBallonTimer',(this.extras.hover_id));
      }else return;
    },
    formatChatStatus(){
      this.clashProp = true ;
      if(this.userObject == null) this.userObject.chatStatus = '';
      if(this.userObject.status !== undefined && this.userObject.last_seen !== undefined ){
        if(this.status == 'offline'){
          this.clashProp = false ;
           this.userObject.chatStatus  = 'offline';
           return;
        }
        if(this.userObject.status == 'online' && this.userObject.last_seen == null ) {
          this.clashProp = false ; 
          this.userObject.chatStatus = ' ';
          return;
        }
        this.clashProp = false ;
        let offset = new Date().getTimezoneOffset();
        let finalDate = moment(this.userObject.last_seen).subtract(offset ,'m');
        if(this.userObject.chatStatus = moment().diff(finalDate , 'minutes') < 3) { 
          this.calcStatus = true;
          this.userObject.chatStatus = ' '; 
          return;
        }else{
          this.clashProp = false ;
          this.calcStatus = false;
          this.userObject.chatStatus = this.formatLastSeen(finalDate);
        }
      }else this.userObject.chatStatus =  this.userObject.status || 'offline';
    },
    formatLastSeen(d){
      let current = moment();
       if(current.diff(d , 'minutes') < 60) return  current.diff(d , 'minutes') + 'M';
      if(current.diff(d , 'hours') < 24) return  current.diff(d , 'hours') + 'H';
      if(current.diff(d , 'days') < 30) return  current.diff(d , 'days') + 'D';
      if(current.diff(d , 'months') < 12) return  current.diff(d , 'months') + 'MTH';
     return  current.diff(d , 'years') + 'Y';
    },
    emitClick(){ this.$emit('callback_click') ; } ,
  }
}
</script>
<style lang="css" scoped>
</style>