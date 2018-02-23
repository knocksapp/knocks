<template lang="html">
<el-tabs @tab-click="handleClick" v-model="activeName" tab-position="left" class = "knocks_house_keeper">
<el-tab-pane name = "general">
<span class ="knocks_text_anchor" slot="label">
  <i class="knocks-user"></i>
  <static_message msg = "General" class = "hide-on-small-only"></static_message>
</span>
<knocksuser main_container = "row knocks_house_keeper" v-model = "userObject" :user="user" as_report></knocksuser>
</el-tab-pane>
<el-tab-pane name = "career" v-loading = "careerIsLoading">
<span class ="knocks_text_anchor" slot="label">
  <i class="knocks-suitcase3"></i>
  <static_message msg = "Career" class = "hide-on-small-only"></static_message>
</span>
<center v-if = "career != null &&  career.length == 0">
<span class = "knocks-alert-circle"></span>
<static_message msg = "Nothing to show here"></static_message>
</center>
 <!--  -->
<el-collapse accordion>
<el-collapse-item v-for="(com,index) in career" :key = "index"  :name="'career_'+index">
  <knocksusercareeredit
  :careerObject="com"
  class="col right"
  @knocks_career_updated ="updateCareer($event , index)"
  >
</knocksusercareeredit>
<knocksuseraboutdelete
  :about_object="com"
  @knocks_about_deleted ="deleteCareer(index)"
  route="career"
  message="career"
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
<el-collapse-item   v-if = "education[index] != null" v-for="(com,index) in education" :key = "index" :name="'education_'+index">
  <knocksusereducationedit
  :educationObject="com"
  class="col right"
 @knocks_education_updated = "updateEducationList($event , index)"
  >
</knocksusereducationedit>
<knocksuseraboutdelete
  :about_object="com"
  @knocks_about_deleted ="deleteEducation(index)"
  route="education"
  message="education"
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
<el-collapse-item v-if = "high_education[index] != null" v-for="(com,index) in high_education" :key = "index" :name="'high_education_'+index">
  <knocksuseraboutedit
   class = "col right"
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
<el-collapse-item v-for="(com,index) in hobby"v-if = "hobby[index] != null" :key = "index" :name="'hobby_'+index">
  <knocksuserhobbyedit
  :hobbyObject="com"
  class="col right"
  @knocks_hobby_updated ="updateHobby($event , index)"
  >
</knocksuserhobbyedit>
<knocksuseraboutdelete
  :about_object="com"
  @knocks_about_deleted ="deleteHobby(index)"
  route="hobby"
  message="hobby"
  class="col right"
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
<el-collapse-item  v-if = "sport[index] != null" v-for="(com,index) in sport" :key = "index" :name="'sport_'+index">
  <knocksusersportedit
  :sportObject="com"
  class = "col right"
  @knocks_sport_updated ="updateSport($event , index)"
  >
</knocksusersportedit>
<knocksuseraboutdelete
  :about_object="com"
  @knocks_about_deleted ="deleteSport(index)"
  route="sport"
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
    careerLen : 0
  }
  },
  computed:{
  },
  mounted(){
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
    updateHighEducationAdd(event){
      this.high_education.push(event);
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
