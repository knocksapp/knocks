<template lang="html">
<el-tabs @tab-click="handleClick" v-model="activeName" tab-position="left" class = "knocks_house_keeper">
<el-tab-pane name = "general">
<span class ="knocks_text_anchor" slot="label">
  <i class="knocks-user"></i>
  <static_message msg = "General" class = "hide-on-small-only"></static_message>
</span>
<knocksuser main_container = "row knocks_house_keeper" v-model = "userObject" :user="user" as_report></knocksuser>
<knocksusergenralinfo :user ="user"></knocksusergenralinfo>
</el-tab-pane>
<el-tab-pane name = "career" v-loading = "careerIsLoading">
<span class ="knocks_text_anchor" slot="label">
  <i class="knocks-suitcase3"></i>
  <static_message msg = "Career" class = "hide-on-small-only"></static_message>
</span>
<center v-if = "career != null &&  career.length == 0">
<span class = "knocks-alert-circle"></span>
<static_message msg = "Nothing to show here."></static_message>
</center>
 <!--  -->
<el-collapse accordion>
<el-collapse-item v-for="(com,index) in career" :key = "index"  :name="'career_'+index" v-if="career[index] != null && inCareerRange(index)" >
  <knocksusercareeredit
  :careerObject="com"
  v-if = "thatsMe"
  class="col right"
  @knocks_career_updated ="updateCareer($event , index)"
  >
</knocksusercareeredit>
<knocksuseraboutdelete
  :about_object="com"
  @knocks_about_deleted ="deleteCareer(index)"
  route="career"
  message="career"
  v-if = "thatsMe"
  class="col right"
  >
</knocksuseraboutdelete>
<span slot="title" class="knocks_text_md  ">{{com.works_at}}</span>
   <div class = "col s9">
     <ul >
  <li> <span class="knocks-home12"></span>   <static_message msg = "Works At"></static_message>  :  {{career[index].works_at}}</li>
  <li>  <span class="knocks-time4"></span>  <static_message msg= "Works Since"></static_message>  :  {{career[index].works_since}}</li>
  <li> <span class="knocks-time4"></span>   <static_message msg= "Works To"></static_message>  :  {{career[index].works_to}}</li>
  <li> <span class="knocks-tie"></span>   <static_message msg= "Works As"></static_message> :  {{career[index].works_as}}</li>
  <li > <span class="knocks-suitcase3"></span>  <static_message msg= "Major"></static_message>  :  {{career[index].works_what}}</li>
</ul>
   </div>
</el-collapse-item>
<el-collapse-item  v-if = "userObject != null && userObject.thatsMe">
  <span slot="title" class="knocks_text_md knocks_add_text ">
    <static_message msg= "Add a new job"></static_message>
  </span>
  <knocksusercareers
  @knocks_career_submited = "updateCareerAdd($event)"
  ></knocksusercareers>
 </el-collapse-item>
</el-collapse>
<div class="row">
<div v-if="career != null && career.length > 3 ">
<a v-if = "career != null && showCareerKey < career.length"
   @click = "increaseCareerRang()"
   class = "left knocks_side_padding knocks_text_sm knocks_text_anchor knocks_pointer" >
  <span class = "knocks-suitcase3"></span> See More
</a>
</div>
  <div v-if = "career != null && showCareerKey != 3 && career.length > 3">
<a v-if = "career != null && showCareerKey > 3 "
   @click = "reduceCareerRang()"
   class = "right knocks_side_padding knocks_text_sm knocks_text_anchor knocks_pointer">
  <span class = "knocks-suitcase3"></span> See Less
</a>
</div>
</div>
</el-tab-pane>


<el-tab-pane name = "education" v-loading = "educationIsLoading">
<span class ="knocks_text_anchor" slot="label">
  <i class="knocks-home7"></i>
  <static_message msg = "Education" class = "hide-on-small-only"></static_message>
</span>
<center v-if = "education != null &&  education.length == 0">
<span class = "knocks-alert-circle"></span>
<static_message msg = "Nothing to show here"></static_message>
</center>
<el-collapse accordion>
<el-collapse-item   v-if = "education[index] != null && inEducationRange(index)" v-for="(com,index) in education" :key = "index" :name="'education_'+index" >
  <knocksusereducationedit
  :educationObject="com"
  class="col right"
  v-if = "thatsMe"
 @knocks_education_updated = "updateEducationList($event , index)"
  >
</knocksusereducationedit>
<knocksuseraboutdelete
  :about_object="com"
  @knocks_about_deleted ="deleteEducation(index)"
  route="education"
  message="education"
  v-if = "thatsMe"
  class="col right"
  >
</knocksuseraboutdelete>
<span slot="title" class="knocks_text_md  ">{{com.study_at}}</span>
<ul >
  <li> <span class="knocks-home12"></span>   <static_message msg = "Study At"></static_message>  :  {{education[index].study_at}}</li>
  <li>  <span class="knocks-time4"></span>  <static_message msg= "Study Since"></static_message>  :  {{education[index].study_since}}</li>
  <li> <span class="knocks-time4"></span>   <static_message msg= "Study To"></static_message>  :  {{education[index].study_to}}</li>
  <li> <span class="knocks-certificate3"></span>   <static_message msg= "Grade"></static_message> :  {{education[index].grade}}</li>
  <li > <span class="knocks-document-certificate2"></span>  <static_message msg= "Certificate"></static_message>  :  {{education[index].study_what}}</li>
</ul>
</el-collapse-item>
<el-collapse-item   v-if = "userObject != null && userObject.thatsMe">
  <span slot="title" class="knocks_text_md knocks_add_text ">
    <static_message msg= "Add a new study"></static_message>
  </span>
  <knocksusereducation
@knocks_education_submited = "updateEducationAdd($event)"
  >
  </knocksusereducation>
 </el-collapse-item>
</el-collapse>
<div class="row">
<div v-if="education != null && education.length > 3 ">
<a v-if = "education != null && showEducationKey < education.length"
   @click = "increaseEducationRang()"
   class = "left knocks_side_padding knocks_text_sm knocks_text_anchor knocks_pointer" >
  <span class = "knocks-home12"></span> See More
</a>
</div>
  <div v-if = "education != null && showEducationKey != 3 && education.length > 3 ">
<a v-if = "education != null && showEducationKey > 3 "
   @click = "reduceEducationRang()"
   class = "right knocks_side_padding knocks_text_sm knocks_text_anchor knocks_pointer">
  <span class = "knocks-home12"></span> See Less
</a>
</div>
</div>
</el-tab-pane>

<el-tab-pane name = "high_education" v-loading = "higheducationIsLoading">
<span class ="knocks_text_anchor" slot="label">
  <i class="knocks-graduate"></i>
  <static_message msg = "High Education" class = "hide-on-small-only"></static_message>
</span>
<center v-if = "high_education != null &&  high_education.length == 0">
<span class = "knocks-alert-circle"></span>
<static_message msg = "Nothing to show here"></static_message>
</center>
<el-collapse accordion>
<el-collapse-item v-if = "high_education[index] != null && inHighEducationRange(index)" v-for="(com,index) in high_education" :key = "index" :name="'high_education_'+index">
  <knocksuseraboutedit
   class = "col right"
   v-if = "thatsMe"
  :highEducationObject="com"
   @knocks_high_education_updated = "updateHighEducationList($event , index)"
  >
</knocksuseraboutedit>
<knocksuseraboutdelete
  :about_object="com"
  @knocks_about_deleted ="deleteHighEducation(index)"
  route="high_education"
  message="high education"
  class="col right"
  v-if = "thatsMe"
  >
</knocksuseraboutdelete>
<span slot="title" class="knocks_text_md  ">{{com.study_at}}</span>
<ul >
  <li> <span class="knocks-home12"></span>   <static_message msg = "Study At"></static_message>  :  {{high_education[index].study_at}}</li>
  <li>  <span class="knocks-time4"></span>  <static_message msg= "Study Since"></static_message>  :  {{high_education[index].study_since}}</li>
  <li> <span class="knocks-time4"></span>   <static_message msg= "Study To"></static_message>  :  {{high_education[index].study_to}}</li>
  <li> <span class="knocks-certificate3"></span>   <static_message msg= "Grade"></static_message> :  {{high_education[index].grade}}</li>
  <li > <span class="knocks-document-certificate2"></span>  <static_message msg= "Certificate"></static_message>  :  {{high_education[index].study_what}}</li>
</ul>
</el-collapse-item>
<el-collapse-item  v-if = "userObject != null && userObject.thatsMe">
  <span slot="title" class="knocks_text_md knocks_add_text ">
    <static_message msg= "Add a new study"></static_message>
  </span>
  <knocksuserhigheducation
@knocks_high_education_submited = "updateHighEducationAdd($event)"
  ></knocksuserhigheducation>
 </el-collapse-item>
</el-collapse>
<div class="row">
<div v-if="high_education != null && high_education.length > 3 ">
<a v-if = "high_education != null && showHighEducationKey < high_education.length"
   @click = "increaseHighEducationRang()"
   class = "left knocks_side_padding knocks_text_sm knocks_text_anchor knocks_pointer" >
  <span class = "knocks-home12"></span> See More
</a>
</div>
  <div v-if = "high_education != null && showHighEducationKey > 3 && high_education.length > 3 ">
<a v-if = "high_education != null && showHighEducationKey > 3 "
   @click = "reduceHighEducationRang()"
   class = "right knocks_side_padding knocks_text_sm knocks_text_anchor knocks_pointer">
  <span class = "knocks-home12"></span> See Less
</a>
</div>
</div>
</el-tab-pane>
<el-tab-pane name = "hobby" v-loading = "hobbyIsLoading">
<span class ="knocks_text_anchor" slot="label">
  <i class="knocks-puzzle-piece"></i>
  <static_message msg = "Hobby" class = "hide-on-small-only"></static_message>
</span>
<center v-if = "hobby != null &&  hobby.length == 0">
<span class = "knocks-alert-circle"></span>
<static_message msg = "Nothing to show here"></static_message>
</center>
<el-collapse accordion>
<el-collapse-item v-for="(com,index) in hobby "v-if = "hobby[index] != null && inHobbyRange(index)" :key = "index" :name="'hobby_'+index">
  <knocksuserhobbyedit
  :hobbyObject="com"
  class="col right"
  @knocks_hobby_updated ="updateHobby($event , index)"
  v-if = "thatsMe"
  >
</knocksuserhobbyedit>
<knocksuseraboutdelete
  :about_object="com"
  @knocks_about_deleted ="deleteHobby(index)"
  route="hobby"
  message="hobby"
  class="col right"
  v-if = "thatsMe"
  >
</knocksuseraboutdelete>
<span slot="title" class="knocks_text_md  ">{{com.name}}</span>
<ul >
  <li> <span class="knocks-puzzle-piece"></span>   <static_message msg = "Name"></static_message>  :  {{hobby[index].name}}</li>
  <li v-if =" gethobbyURL(index)" >  <span class="knocks-globe8"></span>  <static_message msg= "URL"></static_message>  :  {{hobby[index].url}}</li>
</ul>
</el-collapse-item>
<el-collapse-item  v-if = "userObject != null && userObject.thatsMe">
  <span slot="title" class="knocks_text_md knocks_add_text ">
    <static_message msg= "Add a new hobby"></static_message>
  </span>
  <knocksuserhobby
@knocks_hobby_submited = "updateHobbyAdd($event)"
  ></knocksuserhobby>
 </el-collapse-item>
</el-collapse>
<div class="row">
<div v-if="hobby != null && hobby.length > 3">
<a v-if = "hobby != null && showHobbyKey < hobby.length"
   @click = "increaseHobbyRang()"
   class = "left knocks_side_padding knocks_text_sm knocks_text_anchor knocks_pointer" >
  <span class = "knocks-puzzle-piece"></span> See More
</a>
</div>
  <div v-if = "hobby != null && showHobbyKey > 3 && hobby.length > 3">
<a v-if = "hobby != null && showHobbyKey > 3 "
   @click = "reduceHobbyRang()"
   class = "right knocks_side_padding knocks_text_sm knocks_text_anchor knocks_pointer">
  <span class = "knocks-puzzle-piece"></span> See Less
</a>
</div>
</div>
</el-tab-pane>
<el-tab-pane name = "sport" v-loading = "sportIsLoading">
<span class ="knocks_text_anchor" slot="label">
  <i class="knocks-checkered-flag2"></i>
  <static_message msg = "Sports" class = "hide-on-small-only"></static_message>
</span>
<center v-if = "sport != null &&  sport.length == 0">
<span class = "knocks-alert-circle"></span>
<static_message msg = "Nothing to show here"></static_message>
</center>
<el-collapse accordion>
<el-collapse-item  v-if = "sport[index] != null && inSportRange(index)" v-for="(com,index) in sport" :key = "index" :name="'sport_'+index">
  <knocksusersportedit
  :sportObject="com"
  class = "col right"
  @knocks_sport_updated ="updateSport($event , index)"
  v-if = "thatsMe"
  >
</knocksusersportedit>
<knocksuseraboutdelete
  :about_object="com"
  @knocks_about_deleted ="deleteSport(index)"
  route="sport"
  v-if = "thatsMe"
  message="sport"
  class="col right"
  >
</knocksuseraboutdelete>
<span slot="title" class="knocks_text_md  ">{{com.name}}</span>
<ul >
  <li> <span class="knocks-checkered-flag2"></span>   <static_message msg = "Name"></static_message>  :  {{sport[index].name}}</li>
  <li v-if =" getsportURL(index)" >  <span class="knocks-globe8"></span>  <static_message msg= "URL"></static_message>  :  {{sport[index].url}}</li>
</ul>
</el-collapse-item>
<el-collapse-item  v-if = "userObject != null && userObject.thatsMe">
  <span slot="title" class="knocks_text_md knocks_add_text ">
    <static_message msg= "Add a new sport"></static_message>
  </span>
  <knocksusersport
@knocks_sport_submited = "updateSportAdd($event)"
  ></knocksusersport>
 </el-collapse-item>
</el-collapse>
<div class="row">
<div v-if=" sport != null && sport.length > 3">
<a v-if = "sport != null && showSportKey < sport.length"
   @click = "increaseSportRang()"
   class = "left knocks_side_padding knocks_text_sm knocks_text_anchor knocks_pointer" >
  <span class = "knocks-checkered-flag2"></span> See More
</a>
</div>
  <div v-if = "sport != null && showSportKey > 3 && sport.length > 3">
<a v-if = "sport != null && showSportKey > 3 "
   @click = "reduceSportRang()"
   class = "right knocks_side_padding knocks_text_sm knocks_text_anchor knocks_pointer">
  <span class = "knocks-checkered-flag2"></span> See Less
</a>
</div>
</div>
</el-tab-pane>
<!-- <el-tab-pane label="Config" name="second">Config</el-tab-pane>
<el-tab-pane label="Role" name="third">Role</el-tab-pane>
<el-tab-pane label="Task" name="fourth">Task</el-tab-pane> -->
</el-tabs>
</template>
<script>
export default {
  props : {
    user : {
      type : Number ,
      required : true
    }
  },
 data(){
  return{
    career : null,
    careerLoaded : false ,
    careerIsLoading: false ,
    activeName : 'general',
    education : null,
    educationLoaded : false,
    educationIsLoading:false,
    high_education : null,
    higheducationLoaded : false,
    higheducationIsLoading : false,
    hobby : null,
    hobbyLoaded : false,
    hobbyIsLoading : false,
    sport: null,
    sportLoaded: false,
    sportIsLoading: false,
    userObject : null ,
    showCareerKey : 3,
    showEducationKey : 3,
    showHighEducationKey : 3,
    showSportKey : 3,
    showHobbyKey : 3,
    thatsMe : false ,
  }
  },
  computed:{

  },
  mounted(){
    this.thatsMe = this.user == UserId ? true : false ;
  },
  methods:{
    updateHighEducationList(e , index){
      this.high_education[index] = e;
      let temp = this.high_education;
      this.high_education = null;
      setTimeout(()=>{
        this.high_education = temp;
      },500);
    },
    updateCareer(e , index){
      this.career[index] = e;
      let temp = this.career;
      this.career = null;
      setTimeout(()=>{
        this.career = temp;
      },500);
    },
    updateHobby(e , index){
      this.hobby[index] = e;
      let temp = this.hobby;
      this.hobby = null;
      setTimeout(()=>{
        this.hobby = temp;
      },500);
    },
    updateSport(e , index){
      this.sport[index] = e;
      let temp = this.sport;
      this.sport = null;
      setTimeout(()=>{
        this.sport = temp;
        console.log('ahah')
      },500);
    },
     updateEducationList(e , index){
        this.education[index] = e;
        let temp = this.education;
        this.education = null;
        setTimeout(()=>{
          this.education = temp;
        },500);
      },
      updateHobbyAdd(e)
      {
        this.hobby.push(e);
      },
      updateSportAdd(e)
      {
        this.sport.push(e);
      },
      updateEducationAdd(e)
      {
        this.education.push(e);
      },
      updateHighEducationAdd(e)
      {
        this.high_education.push(e);
      },
      updateCareerAdd(e)
      {
        this.career.push(e);
      },
      deleteCareer(index){
        this.career.splice(index,1);
      },
      deleteEducation(index){
        this.education.splice(index,1);
      },
      deleteHighEducation(index){
        this.high_education.splice(index,1);
      },
      deleteHobby(index){
        this.hobby.splice(index,1);
      },
      deleteSport(index){
        this.sport.splice(index,1);
      },
    retriveCareer($event){
      const vm = this
      axios({
        url:'career/get',
        method:'post' ,
        data : {user : vm.user} ,
        onDownloadProgress : ()=>{ vm.careerIsLoading = true ; }
      }).then((response)=>{
          vm.career = response.data;
          vm.careerLength = vm.career.length;
          vm.careerLoaded = true ;
          vm.careerIsLoading = false ;
      });
    },
    retriveEducation($event){
      const vm = this
      axios({
        method:'post',
        url:'education/get',
        data : {user : vm.user} ,
        onDownloadProgress : ()=>{vm.educationIsLoading = true; }
      }).then((response)=>{
        vm.education = response.data;
        vm.educationLoaded = true;
        vm.educationIsLoading = false ;
      });
    },
    retriveHighEducation(event){
      const vm = this
      axios({
        method:'post',
        url:'high_education/get',
        data : {user : vm.user} ,
        onDownloadProgress : ()=>{vm.higheducationIsLoading = true;}
      }).then((response)=>{
        vm.high_education = response.data;
        vm.higheducationLoaded = true;
        vm.higheducationIsLoading = false ;
      });
    },
    retriveHobby($event){
      const vm = this
      axios({
        method:'post',
        url:'hobby/get',
        data : {user : vm.user} ,
        onDownloadProgress: ()=>{vm.hobbyIsLoading = true;}
      }).then((response)=>{
        vm.hobby = response.data ;
        vm.hobbyLoaded = true;
        vm.hobbyIsLoading = false ;
      });
    },
    retriveSport($event){
      const vm = this
      axios({
        method:'post',
        url:'sport/get',
        data : {user : vm.user} ,
        onDownloadProgress: ()=>{vm.sportIsLoading = true;}
      }).then((response)=>{
        vm.sport = response.data ;
        vm.sportLoaded = true;
        vm.sportIsLoading = false ;
      });
    },
    handleClick(tab, event) {
      const vm = this;
      if(this.activeName == 'career' && !this.careerLoaded)
      this.retriveCareer();
      if(this.activeName == 'education' && !this.educationLoaded)
      this.retriveEducation();
      if(this.activeName == 'high_education' && !this.higheducationLoaded)
      this.retriveHighEducation();
      if(this.activeName == 'hobby' && !this.hobbyLoaded)
      this.retriveHobby();
      if(this.activeName == 'sport' && !this.sportLoaded)
      this.retriveSport();
    },
    gethobbyURL(index){
      const vm = this
    if( vm.hobby[index].url == null)
    return false;
    else return true;
  },
  getsportURL(index){
    const vm = this
  if( vm.sport[index].url == null)
  return false;
  else return true;
},
increaseCareerRang(){
  if(this.career.length - this.showCareerKey > 2 ) {
    this.showCareerKey += 3;
  }else{
     this.showCareerKey += this.career.length - this.showCareerKey;
    }
},
reduceCareerRang(){
  if( this.showCareerKey - 4 < 3) {
    this.showCareerKey = 3;
  }else{
     this.showCareerKey -= 3 ;
    }
},
showCareerRange(){
    return this.career.length - this.showCareerKey - 1;
  },
  inCareerRange(index){
    return index > this.showCareerRange() ? true : false;
  },

  increaseEducationRang(){
    if(this.education.length - this.showEducationKey > 2 ) {
      this.showEducationKey += 3;
    }else{
       this.showEducationKey += this.education.length - this.showEducationKey;
      }
  },
  reduceEducationRang(){
    if( this.showEducationKey - 4 < 3) {
      this.showEducationKey = 3;
    }else{
       this.showEducationKey -= 3 ;
      }
  },
  showEducationRange(){
      return this.education.length - this.showEducationKey - 1;
    },
    inEducationRange(index){
      return index > this.showEducationRange() ? true : false;
    },

    increaseHighEducationRang(){
      if(this.high_education.length - this.showHighEducationKey > 2 ) {
        this.showHighEducationKey += 3;
      }else{
         this.showHighEducationKey += this.high_education.length - this.showHighEducationKey;
        }
    },
    reduceHighEducationRang(){
      if( this.showHighEducationKey - 4 < 3) {
        this.showHighEducationKey = 3;
      }else{
         this.showHighEducationKey -= 3 ;
        }
    },
    showHighEducationRange(){
        return this.high_education.length - this.showHighEducationKey - 1;
      },
      inHighEducationRange(index){
        return index > this.showHighEducationRange() ? true : false;
      },

      increaseHobbyRang(){
        if(this.hobby.length - this.showHobbyKey > 2 ) {
          this.showHobbyKey += 3;
        }else{
           this.showHobbyKey += this.hobby.length - this.showHobbyKey;
          }
      },
      reduceHobbyRang(){
        if( this.showHobbyKey - 4 < 3) {
          this.showHobbyKey = 3;
        }else{
           this.showHobbyKey -= 3 ;
          }
      },
      showHobbyRange(){
          return this.hobby.length - this.showHobbyKey - 1;
        },
        inHobbyRange(index){
          return index > this.showHobbyRange() ? true : false;
        },

        increaseSportRang(){
          if(this.sport.length - this.showSportKey > 2 ) {
            this.showSportKey += 3;
          }else{
             this.showSportKey += this.sport.length - this.showSportKey;
            }
        },
        reduceSportRang(){
          if( this.showSportKey - 4 < 3) {
            this.showSportKey = 3;
          }else{
             this.showSportKey -= 3 ;
            }
        },
        showSportRange(){
            return this.sport.length - this.showSportKey - 1;
          },
          inSportRange(index){
            return index > this.showSportRange() ? true : false;
          },

  }
}
</script>
<style lang="css" scoped>
.el-tabs__item.is-active {
}
.el-tabs__active-bar{
background-color: #91124f !important;
}
.el-collapse-item__header {
    height: 100%;
    line-height: 300%;
    padding-left: 1%;
    color: #91124f !important;
    cursor: pointer;
    border-bottom: 1px solid #dfe6ec;
    font-size: 13px;
    border-top-left-radius: 5px !important;
    border-top-right-radius: 5px !important;
}
.el-tabs__item.is-active>span.knocks_text_anchor{
  color: #f06292 !important;
}
.el-collapse-item__content {
    padding: 10px 15px;
    font-size: 13px;
    color:#91124f ;
    line-height: 1.769230769230769;
}
.knocks_add_text{
  color: #20a0ff;
}
</style>
