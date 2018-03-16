<template lang="html">

    <div id = "page_search">
    <div class = "row" >
    <div class = "row" id = "sidebar_search_group_holder">

          <el-input
          class = "knocks_tinny_top_padding knocks_side_padding input-with-select"
          placeholder="Search"
          @input = "pageRunSearch()"
          id="page_search_box"
          v-model="pageSearch">
          <knocksvoicerecognition v-model = "pageSearchRecognition" :lang = "pageSearchLanguage" @recognition = "runVoicePageSearch($event)" slot = "prepend"></knocksvoicerecognition>
          <el-button slot="append" icon=" knocks_icon knocks-search2"></el-button>
          </el-input>
  <div  id = "page_search_results">
    <div class = "row knocks_side_padding knocks_tinny_top_padding">
      <div class = "right">
                    <el-select v-model="pageSearchLanguage" slot="prepend"  style = "width :110px !important">
      <el-option label = "English" value = "en"></el-option>
      <el-option label = "العربيه" value = "ar-sa"></el-option>
      </el-select>
      <span class = "knocks-globe9 blue-text knocks_text_md"></span>
      </div>
          <transition enter-active-class = "animated bounceInLeft" leave-active-class = "animated bounceOutRight">
          <div v-if = "pageSearchRecognition.loading" class = "animated bounceInLeft">
            <span class = "blue-text knocks-spinner13 knocks_spinner"></span>
            <static_message msg = "Processing your voice.." classes = "blue-text"></static_message>
          </div>
        </transition>
          <transition enter-active-class = "animated bounceInLeft" leave-active-class = "animated bounceOutUp">
            <div v-if = "pageSearchRecognition.speaking" class = "">
              <a class = "btn btn-floating pulse red">
            <span class = "knocks-assistive-listening-systems white-text "></span>
          </a>
            <static_message msg = "Listening.." classes = "red-text"></static_message>
          </div>
          </transition>
        </div>
        <!-- <transition enter-active-class = "animated zoomIn" leave-active-class = "animated zoomOut"> -->
            <div class = " center row knocks_house_keeper"  :class = "[{'animated zoomOut' : pageSearchResult != null} ,{'animated zoomIn' : pageSearchResult == null} ]">
              <h1 class = "grey-text">
                <span class = "knocks-search6 animated swing infinite"></span>
                <static_message msg = "Start searching!"></static_message>
              </h1>
            </div>

          <div class = "row knocks_house_keeper" v-if = "pageSearchResult != null">
            <el-tabs  class = "white knocks_house_keeper" v-model = "pageSearchTaps">

              <el-tab-pane class=" knocks_house_keeper" style="background-color:#e3e3e3" name ="all" >
                <span slot="label">
               <el-tooltip class="item" effect="dark" placement="top">
                  <span slot = "content">
                    <i class="knocks_icon knocks-knocks"></i> <static_message msg = "All"  ></static_message>
                  </span>

                  <span>
                    <i class="knocks_icon knocks-knocks"></i><static_message msg = "All" class = "hide-on-small-only"></static_message>
                    <span class="uk-badge " v-if = "pageSearchResult != null">
                      <span class = "knocks_text_xs">{{allPagePlusNumber(pageSearchResult.knock.length,pageSearchResult.groups.length,pageSearchResult.users.length)}}</span></span>
                    </span>
                 </el-tooltip>
                  </span>
                  <div class =" white knocks_standard_border_radius row knocks_text_dark knocks_fair_bounds" v-if = "pageSearchResult != null &&  pageSearchResult.users.length > 0">
                    <h4 class="ui horizontal divider header transparent">
        <i class="knocks-user-outline" style="font-size:150%"></i>
        <static_message msg = "People" classes = "knocks_text_ms"  ></static_message>

      </h4>

                <!-- <transition  enter-active-class = "animated slideInUp" leave-active-class = "animated slideOutLeft"> -->
                  <div class = "row" v-for = "(user,index) in pageSearchResult.users"  v-if="inUserRange(index)">
                      <div class = " col l8 s12 knocks_fair_bounds">
                 <knocksuser :key = "user" as_result :user ="user" show_accept_shortcut ></knocksuser>
               </div>
               </div>
                <!-- </transition> -->
                <div v-if="pageSearchResult != null && pageSearchResult.users.length > 3" class="uk-divider-icon"></div>
                <div class="center" v-if="pageSearchResult != null && pageSearchResult.users.length > 3">
                <a v-if = "pageSearchResult != null && showUserKey < pageSearchResult.users.length"
                   @click="switchUserTab()"
                   class = " knocks_side_padding knocks_text_anchor knocks_pointer" >
                  <span class = "knocks-user-outline center"></span> See More
                </a>
                </div>
              </div>
              <div class =" white knocks_standard_border_radius row knocks_text_dark knocks_fair_bounds"  v-if = "pageSearchResult != null &&  pageSearchResult.knock.length > 0">
                <h4 class="ui horizontal divider header transparent">
    <i class="knocks-newspaper5"></i>
    <static_message msg = "Knocks" classes = "knocks_text_ms"  ></static_message>

  </h4>



                  <div class = "row" v-for = "(knock , index) in pageSearchResult.knock" :key="index" v-if="inKnockRange(index)">
                    <div class = " col l8 s12 knocks_fair_bounds">
                      <knocksknock  :knock = "knock" :gid="'knock_side_search_result_'+index"
                      :current_user = "userId" replier_message = "Leave a comment" ></knocksknock>
                    </div></div>

                <div v-if="pageSearchResult != null && pageSearchResult.knock.length > 3" class="uk-divider-icon"></div>
                <div class="center" v-if="pageSearchResult != null && pageSearchResult.knock.length > 3">
                <a v-if = "pageSearchResult != null && showKnockKey < pageSearchResult.knock.length"
                   @click="  switchKnockTab()"
                   class = " knocks_side_padding knocks_text_anchor knocks_pointer" >
                  <span class = "knocks-newspaper5 center"></span> See More
                </a>
                </div>
              </div>
              <div class =" white knocks_standard_border_radius row  knocks_fair_bounds"   v-if = "pageSearchResult != null &&  pageSearchResult.groups.length > 0 ">
                <h4 class="ui horizontal divider header transparent">
    <i class="knocks-team"></i>
    <static_message msg = "Groups" classes = "knocks_text_ms"  ></static_message>

  </h4>




                  <div class = "row" v-for = "(groups , index) in pageSearchResult.groups" :key = "index" v-if="inGroupRange(index)" >

                    <knocksgroupshortcut as_result :group_id ="groups"></knocksgroupshortcut>

                  </div>

                <div v-if="pageSearchResult != null && pageSearchResult.groups.length > 3" class="uk-divider-icon"></div>
                <div class="center" v-if="pageSearchResult != null && pageSearchResult.groups.length > 3">
                <a v-if = "pageSearchResult != null && showGroupKey < pageSearchResult.groups.length"
                   @click="switchGroupTab()"
                   class = " knocks_side_padding knocks_text_anchor knocks_pointer" >
                  <span class = "knocks-team center"></span> See More
                </a>
                </div>

              </div>
              </el-tab-pane>
            <el-tab-pane name = "users"class="white knocks_standard_border_radius knocks_fair_bounds">
            <span slot="label">
           <el-tooltip class="item" effect="dark" placement="top">
              <span slot = "content">
                <i class="knocks_icon knocks-user-outline"></i> <static_message msg = "People"  ></static_message>
              </span>

              <span>
                <i class="knocks_icon knocks-user-outline"></i><static_message msg = "People" class = "hide-on-small-only"></static_message>
                <span class="uk-badge " v-if = "pageSearchResult != null">
                  <span class = "knocks_text_xs">{{pagePlusNumber(pageSearchResult.users.length)}}</span></span>
                </span>
             </el-tooltip>
              </span>
                               <center v-if = "pageSearchResult == null ||  pageSearchResult.users.length == 0">
                <span class = "knocks-alert-circle knocks_text_ms"></span>
                <static_message msg = "No users matches your search." classes = "knocks_fair_bounds knocks_text_ms"></static_message>
                </center>

                <div class = "row"   v-for = "(user , index) in pageSearchResult.users" v-if="inIncUserRange(index)" :key ="user" >
                  <div class = "  col l8 s12 m12 knocks_fair_bounds">
                <knocksuser as_result :user ="user" show_accept_shortcut ></knocksuser>
              </div>
            </div>

              <div v-if="pageSearchResult != null && pageSearchResult.users.length > 3" class="uk-divider-icon"></div>
              <div class="center" v-if="pageSearchResult != null && pageSearchResult.users.length > 3">
              <a v-if = "pageSearchResult != null && showIncUserKey < pageSearchResult.users.length"
                 @click="increaseUserRange()"
                 class = " knocks_side_padding knocks_text_anchor knocks_pointer" >
                <span class = "knocks-user-outline center"></span> See More
              </a>
              </div>

              </el-tab-pane>

              <el-tab-pane name = "knock"class=" white knocks_standard_border_radius knocks_fair_bounds">
              <span slot="label">
                <el-tooltip class="item" effect="dark" placement="top">
                <span slot = "content">
                  <i class="knocks_icon knocks-newspaper5"></i> <static_message msg = "knocks"></static_message>
                </span>
                <span>
                  <i class="knocks_icon knocks-newspaper5"></i> <static_message msg = "knocks" class = "hide-on-small-only"></static_message>
                  <span class="uk-badge knocks_xs_padding" v-if = "pageSearchResult != null">
                    <span class = "knocks_text_xs">{{pagePlusNumber(pageSearchResult.knock.length)}}</span></span>
                  </span>
                  </el-tooltip>
                </span>
                                 <center v-if = "pageSearchResult == null ||  pageSearchResult.knock.length == 0">
                <span class = "knocks-alert-circle knocks_text_ms"></span>
                <static_message msg = "No Knocks matches your search." classes = "knocks_fair_bounds knocks_text_ms"></static_message>
                </center>

                  <div class = "row " v-if="inIncKnockRange(index)" v-for = "(knock , index) in pageSearchResult.knock" :key="index" >
                    <div class = "  col l8 s12 m12 knocks_fair_bounds">
                      <knocksknock  :knock = "knock" :gid="'knock_side_search_result_'+index+'_'+knock"
                      :current_user = "userId" replier_message = "Leave a comment" ></knocksknock>
                    </div></div>

                <div v-if="pageSearchResult != null && pageSearchResult.knock.length > 3" class="uk-divider-icon"></div>
                <div class="center" v-if="pageSearchResult != null && pageSearchResult.knock.length > 3">
                <a v-if = "pageSearchResult != null && showIncKnockKey < pageSearchResult.knock.length"
                   @click="  increaseKnockRang()"
                   class = " knocks_side_padding knocks_text_anchor knocks_pointer" >
                  <span class = "knocks-newspaper5 center"></span> See More
                </a>
                </div>

                </el-tab-pane>

                <el-tab-pane name = "groups"class="white white knocks_standard_border_radius knocks_fair_bounds">
                <span slot="label">
                  <el-tooltip class="item" effect="dark" placement="top">
                  <span slot = "content">
                    <i class="knocks_icon knocks-group2"></i> <static_message msg = "Groups"></static_message>
                  </span>
                  <span>
                    <i class="knocks_icon knocks-team"></i> <static_message msg = "Groups" class = "hide-on-small-only"></static_message>
                    <span class="uk-badge knocks_xs_padding" v-if = "pageSearchResult != null">
                      <span class = "knocks_text_xs">{{pagePlusNumber(pageSearchResult.groups.length)}}</span>
                    </span>
                  </span>
                </el-tooltip>
                </span>
                <center v-if = "pageSearchResult == null ||  pageSearchResult.groups.length == 0">
                <span class = "knocks-alert-circle knocks_text_ms"></span>
                <static_message msg = "No Groups matches your search." classes = "knocks_fair_bounds knocks_text_ms"></static_message>
                </center>
                 <div >
                  <div class = "row" v-if="inIncGroupRange(index)"  v-for = "(groups , index) in pageSearchResult.groups" :key ="index">
                    <div class = "  col l8 s12 m12 knocks_fair_bounds">
                      <knocksgroupshortcut as_result :group_id ="groups"></knocksgroupshortcut>
                  </div>
                </div>
              </div>

                <div v-if="pageSearchResult != null && pageSearchResult.groups.length > 3" class="uk-divider-icon"></div>
                <div class="center" v-if="pageSearchResult != null && pageSearchResult.groups.length > 3">
                <a v-if = "pageSearchResult != null && showIncGroupKey < pageSearchResult.groups.length"
                   @click="increaseGroupRange()"
                   class = " knocks_side_padding knocks_text_anchor knocks_pointer" >
                  <span class = "knocks-group2 center"></span> See More
                </a>
                </div>
                </el-tab-pane>
                </el-tabs>
              </div>

  </div>

  </div>
  </div>
  </div>
</template>

<script>
export default {
  name: 'knockspagesearch',
  props :{
    start_as : {
      type : String ,
      default : null ,
    },
    start_tap : {
      type : String ,
      default : 'all'
    }
  },
  mounted(){
    if(this.start_as != null ){
      this.pageSearch = this.start_as;
      this.pageRunSearchInit();
    }
    this.pageSearchTaps = this.start_tap;
  },
  methods:{
    pageRunSearch(){
      if(this.pageSearch.length == 0) return;
      const vm = this;
      axios({
        url : LaravelOrgin + '/search/main' ,
        method : 'post' ,
        onDownloadProgress : ()=> { vm.pageSeachLoading = true; } ,
        data : {q : vm.pageSearch}
      }).then((res)=>{
        vm.pageSeachLoading = false ;
        let lastRes = vm.pageSearchResult;


        App.$emit('KnocksContentChanged');
        App.$emit('knocks_refresh_posts_done');

        setTimeout(()=>{
          vm.pageSearchResult = null;
           vm.pageSearchResult = res.data;
           vm.pageSearchTaps = 'all';
console.log(vm.pageSearchResult);
           if(vm.pageSearchResult.knock !== undefined && vm.pageSearchResult.knock.length > 0)
           vm.pageSearchResult.knock = vm.pageSearchResult.knock.reverse();

        } , 200);

      }).catch(()=>{ vm.pageSeachLoading = false });
    },


    pageRunSearchInit(){
      if(this.pageSearch.length == 0) return;
      const vm = this;
      axios({
        url : LaravelOrgin + '/search/main' ,
        method : 'post' ,
        onDownloadProgress : ()=> { vm.pageSeachLoading = true; } ,
        data : {q : vm.pageSearch}
      }).then((res)=>{
        vm.pageSeachLoading = false ;
        let lastRes = vm.pageSearchResult;


        App.$emit('KnocksContentChanged');
        App.$emit('knocks_refresh_posts_done');

        setTimeout(()=>{
          vm.pageSearchResult = null;
           vm.pageSearchResult = res.data;
           vm.pageSearchTaps = 'all';

           if(vm.pageSearchResult.knock !== undefined && vm.pageSearchResult.knock.length > 0)
           vm.pageSearchResult.knock = vm.pageSearchResult.knock.reverse();


           setTimeout( ()=>{ vm.pageSearchTaps = vm.start_tap; } , 500);

        } , 200);

      }).catch(()=>{ vm.pageSeachLoading = false });
    },



    runVoicePageSearch(e){
      this.pageSearch = e;
      this.pageRunSearch();

    },
    pagePlusNumber(input){
      return input > 9 ? '+9' : input;
    },
    allPagePlusNumber(knock,groups,users){
      var input;
      input = knock+ groups+ users ;
      return input > 9 ? '+9' : input;
    },
    showGroupRange(){
         return this.showGroupKey ;
      },
      showIncGroupRange(){
           return this.showIncGroupKey ;
        },
      inGroupRange(index){
        return index < this.showGroupRange() ? true : false;
      },
      inIncGroupRange(index){
        return index < this.showIncGroupRange() ? true : false;
      },
      switchGroupTab(){
        this.pageSearchTaps="groups";
      },
      increaseGroupRange(){
        if(this.pageSearchResult.groups.length - this.showIncGroupKey > 2 ) {
          this.showIncGroupKey += 3;
        }else{
           this.showIncGroupKey += this.pageSearchResult.groups.length - this.showIncGroupKey;
          }
      },
      showKnockRange(){
          return this.showKnockKey;
        },
        showIncKnockRange(){
            return this.showIncKnockKey;
          },
           inKnockRange(index){
              return index < this.showKnockRange() ? true : false;
            },
        inIncKnockRange(index){
          return index < this.showIncKnockRange() ? true : false;
        },
        increaseKnockRang(){
          if(this.pageSearchResult.knock.length - this.showIncKnockKey > 2 ) {
            this.showIncKnockKey += 3;
          }else{
             this.showIncKnockKey += this.pageSearchResult.knock.length - this.showIncKnockKey;
            }
        },
        switchKnockTab(){
          this.pageSearchTaps="knock";
        },
          showUserRange(){
            return  this.showUserKey ;
          },
          showIncUserRange(){
              return  this.showIncUserKey ;
            },
          inUserRange(index){
            return index < this.showUserRange() ? true : false;
          },
            inIncUserRange(index){
              return index < this.showIncUserRange() ? true : false;
            },
          switchUserTab(){
            this.pageSearchTaps="users";
          },
          increaseUserRange(){
            if(this.pageSearchResult.users.length - this.showIncUserKey > 2 ) {
              this.showIncUserKey += 3;
            }else{
               this.showIncUserKey += this.pageSearchResult.users.length - this.showIncUserKey;
              }
          },
  },

  data() {
      return {
       pageSearchLanguage : currentUserLanguage ,
       pageSearch : '',
       showKnockKey : 3,
       showUserKey : 3,
       showGroupKey : 3,
       showIncKnockKey : 3,
       showIncUserKey : 3,
       showIncGroupKey : 3,
       pageSearchRecognition : {loading : false , speaking : false , result : ''},
       pageSeachLoading: false ,
       pageSearchTaps : 'all' ,
       pageSearchResult : null ,
       userId : parseInt(UserId) ,
     };
    },
    computed : {
        }
    }

</script>
<!-- knockspagesearch  -->
