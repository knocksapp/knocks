<template>
<div>
  <knocksretriver
  v-model=  "allcircles"
  url = "get_all_circles" 
  >
  </knocksretriver>
  
  <el-button v-if = "show_toggler" type="primary" @click="outerVisible = true" class="btncreate knocks_fair_bounds knocks_color_kit" style="border-color : #691a40 !important"><i class="knocks-group2"></i> Create Group</el-button>
  <el-dialog
  :visible.sync="outerVisible"
  width="80%"
  
  >
  
  <template slot="title" > <span class="knocks_text_dark" style="font-size : 30px;"><i class="knocks-group-outline"></i> Groups</span></template>
  <div >
    
    <div>
      
      <el-carousel  type="card" :autoplay="false" indicator-position  ="none" height="100px">
      <el-carousel-item v-for="(circle,index) in allcircles.response" :key="index" style="background-color : rgb(245,245,245) !important; border-radius : 35px !important; border: 1px solid #e7e7e7">
      <h3 class="animated fadeIn center knocks_text_dark" ><a @click="pushMembers(allcircles.response[index].id,allcircles.response[index].circle_name)" class="knocks_text_dark">
        <i v-for = "ic in JSON.parse(allcircles.response[index].thumbnail) " :class = "'knocks-'+ic.class" ></i>
       {{allcircles.response[index].circle_name}}</a></h3>
      
      </el-carousel-item>
      </el-carousel>
      <br/>
      <knocksinput el_follower :mat_follower =  "false"
      placeholder = "Group Name"
      gid = "groupname"
      icon = "knocks-group2"
      :is_required = "true"
      :scope = "['CreateGroup']"
      v-model = "group_name"
      ></knocksinput>
      <knocksinput el_follower :mat_follower =  "false"
      placeholder = "Group Category"
      gid = "groupname"
      icon = "knocks-grid8"
      :is_required = "true"
      :scope = "['CreateGroup']"
      v-model = "group_category"
      ></knocksinput>
      <transition enter-active-class="animated fadeIn" leave-active-class="animated fadeOut" >
      <div class="row" v-if = "flag == true">
        <h3  class="animated bounceIn knocks_text_dark">Members of {{circle_name}} :</h3>
 
        <div v-for="(user,index) in circle_members">
          <knocksuser class="animated bounceIn col knocks_fair_bounds" :user="user" :as_chip="true">
          <a slot="append" @click="removeMember(index)"><i class="red-text knocks-close"></i></a>
          </knocksuser>
        </div>
             </div>
             
         </transition>
         
         <transition enter-active-class="animated fadeIn" leave-active-class="animated fadeOut" >
             <div class="row" v-if = "flag2 == true">
              <hr>

        <h3  class="animated bounceIn knocks_text_dark">Other Members :</h3>
 
        <div v-for="(user,index) in retrivedFriends">
          <knocksuser class="animated bounceIn col knocks_fair_bounds" :user="user" :as_chip="true">
          <a slot="append" @click="removeMemberss(index)"><i class="red-text knocks-close"></i></a>
          </knocksuser>
        </div>

             </div>
         </transition>

             <transition  enter-active-class="animated fadeIn" leave-active-class="animated fadeOut">

             <div class="row" v-if = "flag1 == true">
              <hr>
        <h3  class="animated bounceIn knocks_text_dark">Suggestions :</h3>
                
        <div v-for="(user,index) in search_members">
          <knocksuser class="animated bounceIn col knocks_fair_bounds" :user="user" :as_chip="true" v-if = "thatsMe(user)">
          <a slot="append" @click="addToMembers(index)"><i class="green-text knocks-plus5"></i></a>
          </knocksuser>
        </div>
      </div>
    </transition>

              <knocksinput el_follower :mat_follower =  "false"
            placeholder = "Search Name"
            gid = "search"
            @change = "searchFriends()"
            icon = "knocks-search"
            :scope = "['CreateGroup']"
            v-model = "search"
            ></knocksinput>

      <div class="col s12 knocks_house_keeper">
        <h4 style="margin-top: 25px" class="row knocks_text_dark"><i class="knocks-lock7"></i> Group Privacy</h4>
            <knockstaps :multiple = "false"
    anchor_active_class = "knocks_anchor_color_kit_dark knocks_theme_border"
    anchor_regular_class = "knocks_anchor_color_kit_light "
    anchor_class = "btn knocks_theme_border knocks_noshadow_ps"
    :scope = "['group_create_taps ']"
    v-model="radio4" hide_labels_on_small

    :options = "[
    { icon : 'knocks-globe2' , label : 'Public' , static : true , value : 'public' } ,
    { icon : 'knocks-lock7' , label : 'Closed' , static : true , value : 'closed' } ,
    { icon : 'knocks-eye-off' , label : 'Secret' , static : true , value : 'secret' } ,
    
    ]" ></knockstaps>
    <p v-for = "tv in tapsvalues" :class = "[{'knocks_hidden' : radio4 != tv.value}]">
      <span :class = "tv.icon"></span>
      <static_message :msg = "tv.label"></static_message>
    </p>
      </div>
    </div>
  </div>
  
  <span slot="footer" class="dialog-footer">
    <knockselbutton
    placeholder="Create"
    class=" "
    style = "margin-bottom : 1rem"
    :error_at = []
    :precondition = "radio4.length > 0"
    :scope = "['CreateGroup']"
    validation_error = "You need to complete some fields"
    reset_on_success
    submit_at = "/create_group"
    success_msg = "You Created the group Succecfully."
    gid = "stage_one_net"
    @knocks_submit_accepted = "outerVisible = false"
    button_classes = "  fluid ui button knocks_color_kit knocks_anchor_color_kit_dark "
    success_at="done"
    :submit_data = " {name : group_name , category : group_category, preset : radio4 , normal_members : retrivedFriends, circle_members : circle_members} "
    >
    </knockselbutton>

  </span>
  </el-dialog>
</div>
</template>

<script>
export default {

  name: 'knocksgroupcreation',
  props : {
    show_toggler : {
      type : Boolean ,
      default : false ,
    }
  },

  data () {
    return {
          outerVisible: false,
          innerVisible: false,
          radio4: '',
          state2: '',
          group_name:'',
          people : '',
          allcircles: Object,
          circle_id : '',
          allusers : null,
          search : '',
          all_members : [],
          retrivedFriends : [],
          circle_name : '',
          search_members : [],
          circle_members : [],
          circle_thumbnail:null,
          group_category : '',
          flag : false,
          flag1 : false,
          flag2 : false,
          tapsvalues : {
            public : { icon : 'knocks-globe2' , label : 'Public' , value : 'public' } ,
            closed : { icon : 'knocks-lock7' , label : 'Closed' , value : 'closed'} ,
            secret : { icon : 'knocks-eye-off' , label : 'Secret' , value : 'secret'} ,
          }

    }
  },
  mounted(){
    const vm = this;
    App.$on('knocksGroupCreationToggle' , (payloads)=>{
      vm.outerVisible = payloads.toggle ;
    })
 
    
  },
  methods:{
    thatsMe(id){
      return id == UserId ? true : false ;
    },

    getThumbnails(index){
     const vm = this;
     if(this.allcircles.response != null)
     return JSON.parse(this.allcircles.response[index].thumbnail)[0].class; else return '';
    },
    pushMembers(circle_id,circle_name){

      const vm = this;
      vm.circle_members = [];
      vm.circle_id = circle_id;
       axios({
           url : 'get_circle_members',
           method : 'post',
           data :{circle_id : vm.circle_id}
       }).then((response)=>{
            if(response.data != null)
            {
                 vm.circle_members = response.data;
                 let i = 0;
                 let j = 0;
                 let len = vm.retrivedFriends.length;
                 let len1 = vm.search.length;
                 console.log('here '+vm.search_members.length)
                 while(i < len)
                 {
                  if(vm.circle_members.indexOf(vm.retrivedFriends[i]) != -1){
                    vm.retrivedFriends.splice(i,1);
                    App.$emit('KnocksContentChanged');
                    i--;
 
                  }
                  len = vm.retrivedFriends.length;
                  i++;
                 }
                 while(j < len1)
                 {
                  if(vm.circle_members.indexOf(vm.search_members[i]) != -1){
                    vm.search_members.splice(i,1);

                    App.$emit('KnocksContentChanged');
                    j--;
 
                  }
                  len1 = vm.search_members.length;
                  j++;
                 }

                 vm.circle_name = circle_name

                if(vm.retrivedFriends == 0){
                  vm.flag2= false
                }
                if(vm.search_members == 0){
                  vm.flag1= false
                }
                 vm.flag = true;

            }
            
         
       });
    },
    removeMember(index){
        const vm = this;
        vm.circle_members.splice(index,1)
        App.$emit('KnocksContentChanged');
        if(vm.circle_members == 0){
          vm.flag = false
        }
    },
    removeMembers(index){
        const vm = this;
        vm.search_members.splice(index,1)
        App.$emit('KnocksContentChanged');
        if(vm.search_members == 0){
          vm.flag1= false
        }
    },
    removeMemberss(index){
        const vm = this;
        vm.retrivedFriends.splice(index,1)
        App.$emit('KnocksContentChanged');
        if(vm.retrivedFriends == 0){
          vm.flag2= false
        }
    },
    addToMembers(index){
        const vm = this;
        vm.retrivedFriends.push(vm.search_members[index]);
        vm.search_members.splice(index,1);
        App.$emit('KnocksContentChanged');
        vm.flag2 = true;
        if(vm.retrivedFriends  == 0){
          vm.flag2= false;
          
        }
        if(vm.search_members  == 0){
          vm.flag1= false;
          
        }

    },
     
      createFilter(queryString) {
        return (link) => {

          return (link.value.toLowerCase().indexOf(queryString.toLowerCase()) === 0);
        };
      },
      searchFriends(){
            const vm = this;

            if(this.search.length <= 2 ){
              this.search_members = [];
              vm.flag1 = false;
              return;
            }

            axios({
              method : 'post',
              url : 'user/search',
              data : {q : vm.search}
            }).then((response)=>{
              console.log(response.data);
                 let i;
                 for(i = 0; i < response.data.length; i++){
                   
                   if(vm.search_members.includes(response.data[i]) || vm.circle_members.includes(response.data[i]) || vm.retrivedFriends.includes(response.data[i])){
                    
                   }else{
                    vm.search_members = []
                    if(!vm.thatsMe(response.data[i]))
                    vm.search_members.push(response.data[i]);
                    vm.flag1 = true;
                    App.$emit('KnocksContentChanged');
                      

                   }
                 }
                
              
            });
            
          
           
      },
      loadAll() {
          const vm = this;
         return vm.allusers; 
      },
      handleSelect(item) {
        console.log(item);
      }

  }
}
</script>

<style lang="css" scoped>
.btncreate:focus{
  background-color: transparent !important;
}
</style>