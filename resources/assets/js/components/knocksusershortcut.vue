      <!-- <div class = "white animated zoomIn knocks_regular_shadow z-depth-5 knocks_standard_border_radius knocks_gray_border knocks_bit_left knocks_popover" slot = "content" style="min-width:200px; width:300px" v-if ="!hide_popover">


             
      </div> -->

<template>
  <div v-if = "userObject != null" >

    <div :class = "main_container" v-if = "!as_chip && !as_result && !as_report && !as_name" >

   <div v-if="show_image">
        <el-popover
        v-if = "!hide_popover"
      ref="userpopover"
      width = "400"
      placement="top-start"
      @show = "updateBalloonsTimer()"
      @hide="runBalloonsTimer()"
      popper-class = "knocks_house_keeper"
      trigger="hover">
      <div class = "row knocks_house_keeper">
        <div class = "col s4 knocks_house_keeper">
           <img :src = "asset('media/avatar/compressed/'+user)" :class = "[{'knocks_user_profile_scope' : thatsMe}]">
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
           <div class = "col s12" v-if ="userObject.gender != null && userObject.gender != undefined && userObject.gender == 'male'" >
             <span class = "knocks-male2"></span><span><static_message msg = "Male"></static_message></span>
           </div>
           <div class = "col s12" v-if ="userObject.gender != null && userObject.gender != undefined && userObject.gender == 'female'" >
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
             
             <knockspopover>
              <template slot = "container">
                 <el-button type = "primary" round icon = " knocks-plus-circle knocks_icon" class ="knocks_left_button"></el-button>
              </template>
              <span slot = "content"  class = "knocks_tooltip animated flipInX" >
              <span class = "knocks-plus-circle"></span>
              <static_message msg = "Add To My People"></static_message>
            </span>
            </knockspopover>

            <knockspopover>
              <template slot = "container">
                  <el-button type = "success" round icon = " knocks-chat10 knocks_icon" class = "knocks_center_button"></el-button>
              </template>
              <span slot = "content"  class = "knocks_tooltip animated flipInX" >
              <span class = "knocks-chat10"></span>
              <static_message msg = "Start Chatting"></static_message>
            </span>
            </knockspopover>

            <knockspopover>
              <template slot = "container">
                 <el-button type = "danger" round icon = " knocks-blocked3 knocks_icon " class ="knocks_right_button"></el-button>
              </template>
              <span slot = "content"  class = "knocks_tooltip animated flipInX" >
              <span class = "knocks-blocked3"></span>
              <static_message msg = "Block"></static_message>
            </span>
            </knockspopover>


               

           
         </div>
          
        </div>
            
         
      </div>
    </el-popover>
     
      <a :href = "userUrl" v-popover:userpopover>
        <img :src = "asset('media/avatar/compressed/'+user)" :class = "[knocks_avatar_classes, {'knocks_user_profile_scope' : thatsMe}]" v-if = "!hide_image">
        <div :class = "name_container_class" class="" v-if ="!hide_text_info">
        <a :class = "name_class" :href = "userUrl"  v-if="userObject && !hide_name"> {{ displayName }}</a><slot name = "append_to_display_name"></slot><br/>
         <a :class = "username_class" :href = "userUrl" v-if="userObject != null && show_username" style = "display:block"> {{'@'+userObject.username}} </a>
        </div>
      </a>

    
   </div>
  
  </div>
  <div class="chip" :class="main_container" contenteditable="false" v-if="as_chip">
     <!-- <knocksimgframeless v-model = "pp" fill_from="pp/blob" :specifications="userSpecifications" :show_container = "false"
       :scope = "['profile_picture_handler']" ></knocksimgframeless> -->
       <img :src = "asset('media/avatar/compressed/'+user)" :class = "{'knocks_user_profile_scope' : thatsMe}" >
       <span :class = "name_class" :href = "userUrl"  v-if="userObject && !hide_text_info"  > {{displayName}} </span>
       <slot name = "append"></slot>
  </div>



    <div  :class="main_container" contenteditable="false" v-if="as_report">

            <div class = "row knocks_house_keeper knocks_text_dark">
           <div class = "col s12" style="margin-top : -10px;">
            <span class = "knocks-user4"></span>
             <static_message msg = "Name : "></static_message>
             <span v-if ="userObject.first_name != null && userObject.first_name != undefined" >{{userObject.first_name}} </span>
             <span v-if ="userObject.middle_name != null && userObject.middle_name != undefined" >{{userObject.middle_name}} </span>
             <span v-if ="userObject.last_name != null && userObject.last_name != undefined" >{{userObject.last_name}} </span>
           </div>
           <div class = "col s12" v-if ="userObject.gender != null && userObject.gender != undefined && userObject.gender == 'male'" >
             <span class = "knocks-male2"></span><span><static_message msg = "Male"></static_message></span>
           </div>
           <div class = "col s12" v-if ="userObject.gender != null && userObject.gender != undefined && userObject.gender == 'female'" >
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

  <div v-if = "as_name">



    <el-popover
      ref="userpopover"
      width = "400"
      placement="top-start"
      @show = "updateBalloonsTimer()"
      @hide="runBalloonsTimer()"
      popper-class = "knocks_house_keeper"
      trigger="hover">
      <div class = "row knocks_house_keeper">
        <div class = "col s4 knocks_house_keeper">
           <img :src = "asset('media/avatar/compressed/'+user)"  :class = "[{'knocks_user_profile_scope' : thatsMe}]">
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
           <div class = "col s12" v-if ="userObject.gender != null && userObject.gender != undefined && userObject.gender == 'male'" >
             <span class = "knocks-male2"></span><span><static_message msg = "Male"></static_message></span>
           </div>
           <div class = "col s12" v-if ="userObject.gender != null && userObject.gender != undefined && userObject.gender == 'female'" >
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
             
             <knockspopover>
              <template slot = "container">
                 <el-button type = "primary" round icon = " knocks-plus-circle knocks_icon" class ="knocks_left_button"></el-button>
              </template>
              <span slot = "content"  class = "knocks_tooltip animated flipInX" >
              <span class = "knocks-plus-circle"></span>
              <static_message msg = "Add To My People"></static_message>
            </span>
            </knockspopover>

            <knockspopover>
              <template slot = "container">
                  <el-button type = "success" round icon = " knocks-chat10 knocks_icon" class = "knocks_center_button"></el-button>
              </template>
              <span slot = "content"  class = "knocks_tooltip animated flipInX" >
              <span class = "knocks-chat10"></span>
              <static_message msg = "Start Chatting"></static_message>
            </span>
            </knockspopover>

            <knockspopover>
              <template slot = "container">
                 <el-button type = "danger" round icon = " knocks-blocked3 knocks_icon " class ="knocks_right_button"></el-button>
              </template>
              <span slot = "content"  class = "knocks_tooltip animated flipInX" >
              <span class = "knocks-blocked3"></span>
              <static_message msg = "Block"></static_message>
            </span>
            </knockspopover>


               

           
         </div>
          
        </div>
            
         
      </div>
    </el-popover>


        <span  v-popover:userpopover :class = "main_container">
       
        
        <span :class = "name_class" :href = "userUrl"  v-if="userObject && !hide_name"> {{ displayName }}</span>
        <slot name = "append_to_display_name"></slot>

        </span>
         
        </div>


    




  <div v-if = "as_result">
    <div class = "row">
      <div class = "">
           <img :src = "asset('media/avatar/compressed/'+user)" :class = "[knocks_avatar_classes,{'knocks_user_profile_scope' : thatsMe}]">
      </div>
      <div class = "">
         <div  class="" v-if ="!hide_text_info">
        <div class = "right">     
         <knocksuseractions v-if = "show_accept_shortcut"
         :extras = "extras"
         :user="user" 
         :start_as = "userObject" 
         :show_accept_shortcut = "show_accept_shortcut">  
         </knocksuseractions>
       </div>
  

        <a :class = "name_class" :href = "userUrl"  v-if="userObject && !hide_name"> {{ displayName }}</a><slot name = "append_to_display_name"></slot><br/>
        <a :class = "username_class" :href = "userUrl" v-if="userObject != null && show_username" style = "display:flex"> {{'@'+userObject.username}} </a>
       </div>
      <div class = "right">     
         <knocksuseractions v-if = "!show_accept_shortcut"
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
</template>

<script>
export default {
props : {
	user : {
		type : Number ,
		required : true
	} ,
	show_image : {
		type : Boolean ,
		default : true 
	} ,
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
  show_username : {
    type : Boolean ,
    default : true 
  } , 
  as_chip : {
    type : Boolean , 
    default : false 
  }, knocks_avatar_classes : {
    type : String , 
    default : 'knocks_avatar knocks_house_keeper col '
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
  as_result : {
    type : Boolean , 
    default :  false 
  },
  as_report : {
    type : Boolean , 
    default :  false 
  },
  show_accept_shortcut : {
    type : Boolean , 
    default : false 
  },
  extras : {
    type : Object , 
    default : null,
  },
  hide_popover : {
    type : Boolean , 
    default : false ,
  },
    as_name : {
    type : Boolean , 
    default : false ,
  },
      hide_image : {
    type : Boolean , 
    default : false ,
  }
} ,
  data () {
    return {
    	userObject : null , 
      userUrl : '#',
      first_name : '' , 
      last_name : '',
      pp : null , 
      alreadyLoaded : false ,
      displayName : null,
      userSpecifications : null ,
      auth : parseInt(UserId) ,
    }
  } ,
  mounted(){
  	this.loadUserData();

    //setTimeout(()=>{this.loadUserData();},500);
    const vm = this;
    //Update data globally
    App.$on('knocksUserDataUpdated' , (payloads)=>{
      if(payloads.user == vm.user){
        vm.userObject = payloads.update;
        UsersObject[vm.user] = payloads.update;
      }
    })
    App.$on('KnocksContentChanged' , ()=>{
      if(vm.userObject == null) return;
      if(vm.userObject != vm.user){
        if(UsersObject[vm.user] != undefined){
          vm.reboundUser(); 
        }
      }
      setTimeout(()=>{
        if(vm.userObject != vm.user){        
          if(UsersObject[vm.user] != undefined){
            vm.reboundUser(); 
          }
        }
      },300);
    });
    App.$on('knocksUserResetContent' , (id)=>{
      if(id == vm.user){
         vm.reboundUser(); 
      }
    });
  },
  computed: {
     thatsMe(){
      return this.user == UserId ? true : false;
    },
  },
  methods : {
  	loadUserData(){
      if(window.UsersObject[this.user] != undefined){
        console.log(window.ExsistsInUsersObject(this.user));
          this.reboundUser();
        return;
      }
      let i = 0 ;
      let CancelToken = axios.CancelToken;
      let source = CancelToken.source();
      const vm = this;
      axios({
        method : 'post' ,
        cancelToken: source.token,
        url : LaravelOrgin+'user/info',
        data : {q : vm.user}
      }).then(function(response){
        if(response.data == 'invalid') return;
        vm.userObject = response.data;
        //vm.userObject.desplayName = JSON.parse(vm.userObject.display_name);
        //vm.$parent.loadedUsers[vm.user] = response.data;
        vm.userUrl = vm.asset(vm.userObject.username );
        vm.first_name = vm.userObject.first_name ;
        vm.last_name = vm.userObject.last_name ;
        $('.tooltipped').tooltip({delay: 50});
        vm.userObject.pp = vm.pp;
        vm.userObject.name = vm.userDisplayName(); 
        vm.userObject.thatsMe = vm.thatsMe;
        vm.$emit('input' , vm.userObject);
        vm.displayName = vm.userDisplayName(); 
        vm.userSpecifications = {id : vm.user , index : vm.userObject.profile_index};
        window.UsersObject[vm.user] = vm.userObject;
      });
      
  	},
    reboundUser(){
        this.userObject = UsersObject[this.user];
        this.alreadyLoaded = true ;
        this.userUrl = this.userObject.username ;
        this.first_name = this.userObject.first_name ;
        this.last_name = this.userObject.last_name ;
        this.displayName = this.userDisplayName(); 
        this.userSpecifications =  {id : this.user , index : this.userObject.profile_index};
        this.displayName = this.userObject.name;
        //this.userObject.name = this.userDisplayName(); 
        $('.tooltipped').tooltip({delay: 50});
        this.$emit('input' , this.userObject);
    },
    userDisplayName(){

        let displayName = this.userObject.display_name;
        if(displayName.length == 1 && displayName[0] == "nickname" && this.userObject.nickname != null){
          return this.userObject.nickname;
        }else{
          //TO BE EDITTED
          return this.first_name+' '+this.last_name;
        }
      
    },
    birthDate(bd){
      return moment(bd , 'YYYY-MM-DD').format('D MMM YYYY');
    },
    asset(value){
      return LaravelOrgin + value;
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
 

  }
}
</script>

<style lang="css" scoped>
</style>