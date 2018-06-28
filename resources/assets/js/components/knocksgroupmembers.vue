<template>
	<div class="row knocks_fair_bounds">
		<knocksretriver
		v-model=  "group_members"
		url = "get_group_members"
		:xdata="{group_id : group_object.id , q : test1}"
		@success = "isOwner($event)"
	  >
		</knocksretriver>
      <knocksretriver
    v-model=  "group_pictures"
    url = "get_group_pictures"
    :xdata="{group_id : group_object.id}"
    prevent_on_mount
    :scope = "['group_pictures']"
    >
    </knocksretriver>
    <knocksretriver
    v-model=  "group_files"
    url = "get_group_files"
    :xdata="{group_id : group_object.id}"
    prevent_on_mount
    :scope = "['group_files']"
    >
    </knocksretriver>
    <knocksretriver
    v-model=  "group_voices"
    url = "get_group_voices"
    :xdata="{group_id : group_object.id}"
    prevent_on_mount
    :scope = "['group_voices']"
    >
    </knocksretriver>
    <knocksretriver
    v-model=  "group_videos"
    url = "get_group_videos"
    :xdata="{group_id : group_object.id}"
    prevent_on_mount
    :scope = "['group_videos']"
    >
    </knocksretriver>
 
			 <el-tabs type="border-card">
				  <el-tab-pane>
				    <span slot="label" class="grey-text"><i class="knocks-info2"></i> Group Info</span>
				    <ul class="knocks_text_dark animated fadeIn knocks_fair_bounds">
				    	<li class=""> <div class="chip"><i class="knocks-group2"></i> Group Name : {{group_object.name}}</div></li>
				    	<li class=""> <div class="chip"><i class="knocks-th-large"></i> Group Category : {{group_object.category}}</div></li>
				    	<li class=""> <div class="chip"><i class="knocks-locked2"></i> Privacy : {{group_object.preset}}</div></li>
				    	<li class=""> <div class="chip"><i class="knocks-calendar2"></i> Created At : {{dateFormate}}</div></li>
				    </ul>
					  </el-tab-pane>
					  <el-tab-pane>
				    <span slot="label" class="grey-text"><i class="knocks-group2"></i> Members</span>
				    <el-input placeholder="Find people" v-model = "test1" @input="retGroupMem()" class="knocks_fair_bounds"></el-input>
				    <div class="row" v-if="group_members != null && group_members.response != null">
				    	<ul class="uk-list uk-list-divider">
				    	<li  v-for="(mem,index) in group_members.response" class="knocks_fair_bounds" v-if="index < showKey" >
				    	<knocksuser  :show_accept_shortcut="false" main_container="col s10 animated fadeIn" :user="mem.user_id" v-model="members_names[index]" :as_result="true">
                    <span slot="append_to_name" class=""><span v-if="mem.position == 'Owner'" style="font-size : 10px !important" class="uk-badge red">Owner</span><span v-if="mem.position == 'Member'" style="font-size : 10px !important" class="uk-badge blue">Member</span> <span 
                  v-if="mem.position == 'Admin'" 
                  class="uk-badge green knocks_text_sm" 
                  style="font-size : 10px !important">
                   Admin
                  </span></span>
                         </knocksuser>
                         <span class="right" v-if="mem.position != 'Owner' || mem.position != 'Admin'">
                          <knocksgroupmemberdelete 
                          :authposition = "authposition"
                          :position="mem.position" @member_deleted="group_members.response.splice(index,1); deletedMember($event)" :group_id="group_object.id" :gid="index" :member_delete = "mem.user_id"></knocksgroupmemberdelete></span>
      				      </li>
                    <div class="center" v-if="group_members.response.length > 3">
                    <el-button-group >
                    <el-button @click = "showKey+=4" :disabled="showKey >= group_members.response.length">See More</el-button>
                    <el-button @click="showKey-=4" :disabled="showKey < 5">See Less</el-button>
                  </el-button-group>
                  <h5 class="grey-text">{{showKey >= group_members.response.length ? group_members.response.length : showKey}} / {{group_members.response.length}}</h5>
                </div>
      				    </ul>
      				    </div>
      					  </el-tab-pane>
      					 <el-tab-pane v-if="flag || flag3">
      					 	<span slot="label" class="grey-text"><i class="knocks-user-plus"></i> Add Members</span>
      					 	<knockselinput v-model = "test" placeholder="search" class="knocks_fair_bounds" autocomplete :autocomplete_start="2" autocomplete_from = "user/search" @autocomplete="user = $event" ></knockselinput>
                  <h3 v-if="user == [] || test.length == 0" class="grey-text center animated fadeIn knocks_fair_bounds"><i class="knocks-search"></i> Please , Search For Users.</h3>
      					 	<ul class="uk-list uk-list-divider knocks_fair_bounds" v-if="test.length != 0">
                    
      				    	<li v-for="(u ,index) in user" class="knocks_fair_bounds" v-if="index < showKeys">
                      <div v-if="test.length != 0">

      				    	<knocksuser   main_container="col s10 knocks_house_keeper"  class="animated bounceIn" :user="user[index]"  :key = "u">
                     </knocksuser>
                     <knocksgroupjoining 
                     v-if="!inGroup(u)"
                     @member_added = "addMember($event)"
                     class="right" :group_id="group_object.id" :add_member_mode="true" :user_id="u"></knocksgroupjoining>
                     <el-button type="success" icon="knocks-tick" class="right" :disabled = "true" v-if="inGroup(u)">Joined</el-button>
                   </div>
				      </li>
             
				  </ul>
           <div class="center" v-if="user.length > 3">
                    <el-button-group >
                    <el-button @click = "showKeys+=4" :disabled="showKeys >= group_members.response.length">See More</el-button>
                    <el-button @click="showKeys-=4" :disabled="showKeys < 5">See Less</el-button>
                  </el-button-group>
                  <h5 class="grey-text">{{showKeys >= user.length ? user.length : showKeys}} / {{user.length}}</h5>
                </div>
					 </el-tab-pane>

           <el-tab-pane>
                <span slot="label"><a @click="emitPicture()" class="grey-text"><i class="knocks-picture"></i> Photos</a></span>
                <div class="row animated fadeIn" v-if = "group_pictures != null && group_pictures.response != null" v-loading="group_pictures.loading">

                  <div class="uk-position-relative uk-visible-toggle uk-light" uk-slider="sets: true">
                      <ul class="uk-slider-items uk-child-width-1-4 " >
                          <li v-for="(pic , index) in group_pictures.response" >
                              <knocksimg :src = "asset('media/image/retrive/'+pic)" v-if = "index < 6" ></knocksimg>
                              <div class="uk-position-center uk-panel"></div>
                          </li>
                      </ul>
                       <a class="uk-position-center-left uk-position-small uk-hidden-hover" href="#" uk-slidenav-previous uk-slider-item="previous"></a>
                       <a class="uk-position-center-right uk-position-small uk-hidden-hover" href="#" uk-slidenav-next uk-slider-item="next"></a>
                    </div>
                    <a v-if="group_object != null && group_pictures.response.length != 0" class="knocks_fair_bounds right" :href = "asset('group/'+group_object.id+'/pictures')">Browse more <i class="knocks-search-5"></i></a>
                    <h3 v-if="group_pictures.response.length == 0 " class="grey-text center"><i class="knocks-picture"></i> There is No Pictures.</h3>
                </div>
           </el-tab-pane>

           <el-tab-pane>
                <span slot="label"><a class="grey-text" @click="emitFile()"><i class="knocks-files2"></i> Files</a></span>
                <div class="row animated fadeIn" v-if = "group_files != null && group_files.response != null" v-loading="group_files.loading">
                  <ul class="uk-list uk-list-divider">
                      <li v-for = "(file,index) in group_files.response"><knocksfileviewer :file="file" v-if="index < 10"></knocksfileviewer></li>
                  </ul>
                  <a class="knocks_fair_bounds right" v-if="group_object != null && group_files.response.length != 0"  :href = "asset('group/'+group_object.id+'/files')">Browse more <i class="knocks-search-5"></i></a>
                  <h3 v-if="group_files.response.length == 0 " class="grey-text center"><i class="knocks-files2"></i> There is No Files.</h3>
                </div>
           </el-tab-pane>

           <el-tab-pane>
              <span slot="label"><a class="grey-text" @click="emitVoice()"><i class="knocks-sound2"></i> Voices</a></span>
                <div class="row animated fadeIn" v-if = "group_voices != null && group_voices.response != null" v-loading="group_voices.loading">
                  <ul class="uk-list uk-list-divider" >
                      <li v-for = "(voice,index) in group_voices.response">
                        <knocksuser :user = "voice.user" as_chip></knocksuser>
                        <knocksplayer
                        v-if="index < 5"
                        :gid="index+'_group_player'"
                        main_container = "row knocks_house_keeper"
                        class="voice col 12 knocks_house_keeper"
                        :show_volume="false"
                        buttons_container = "col"
                        :show_options="false"
                        :specifications = "{id : voice.blob , user : current_user , object : voice.blob}"
                        full_back_loading
                        :load_on_mount="false"></knocksplayer>
                      </li>
                  </ul>
                  <a class="knocks_fair_bounds right"  v-if="group_object != null && group_voices.response.length != 0"  :href = "asset('group/'+group_object.id+'/voices')"> Browse more <i class="knocks-search-5"></i></a>
                  <h3 v-if="group_voices.response.length == 0" class="grey-text center"><i class="knocks-sound2"></i> There is no Voices.</h3>
                </div>
           </el-tab-pane>

           <el-tab-pane>
              <span slot="label"><a class="grey-text" @click="emitVideo()"><i class="knocks-video4"></i> Videos</a></span>
                <div class="row animated fadeIn" v-if = "group_videos != null && group_videos.response != null" v-loading="group_videos.loading">
                  <ul class="uk-list uk-list-divider">
                      <li v-for = "vid in group_videos.response"></li>
                  </ul>
                   <h3 class="grey-text center"><i class="knocks-video4"></i> There is No Videos.</h3>
                </div>
           </el-tab-pane>

			</el-tabs>
	</div>
</template>
<script>
export default {
  name: 'knocksgroupmembers',
  data () {
    return {
     group_members : null,
     showKey: 4,
     showKeys: 4,
     flag : false,
     flag3 : false,
     memberInGroup : false,
     members_names : [],
     user : [],
     test : '' ,
     search : '',
     group_pictures : null,
     group_files : null,
     group_voices : null,
     group_videos : null,
     current_user : UserId , 
     authposition : null , 
     test1 : ''
    }
  },
  props:{
     group_object :{
     	type : Object,
        required : true
     }
  },
  methods:{
    retGroupMem(){
      if(this.test1.length == 0)
        return;
      this.group_members.retrive();
    },
    deletedMember(e,index){
     
     $('#group_member_count').empty().append(this.group_members.response.length);
    },
       isOwner(e){
       	const vm = this

           vm.group_members.response = e.response;

           let i;
         for (i = 0; i < vm.group_members.response.length; i++){
           if( parseInt(UserId) == vm.group_members.response[i].user_id &&
            vm.group_members.response[i].position == 'Owner' ){
                 vm.flag = true;
                 vm.authposition = 'Owner'
           }
         }
         let j;
         for (j = 0; j < vm.group_members.response.length; j++){
           if( parseInt(UserId) == vm.group_members.response[j].user_id &&
            vm.group_members.response[j].position == 'Admin' ){
                 vm.authposition = 'Admin'
                 return vm.flag3 = true;
           }
         }
         if (vm.authposition == null ) vm.authposition = 'Member'
        
       	App.$emit('KnocksContentChanged')
       },
        inGroup(id){
              const vm = this
              let i;
              for(i = 0; i < vm.group_members.response.length; i++){
              	if(id == vm.group_members.response[i].user_id){
              		return true;
              	}
              }
              return false ;
        },
        addMember(e , index){

          this.group_members.response.push({
            user_id : e , 
            position : 'Member'
          });
          $('#group_member_count').empty().append(this.group_members.response.length);
         },
       emitChanged(){
       	App.$emit('KnocksContentChanged');
       },
       asset(url){
        return window.Asset(url);
       },
       emitPicture(){
        App.$emit('knocksRetriver',{scope : ['group_pictures']});
       },
       emitFile(){
        App.$emit('knocksRetriver',{scope : ['group_files']});
       },
       emitVoice(){
        App.$emit('knocksRetriver',{scope : ['group_voices']});
       },
       emitVideo(){
        App.$emit('knocksRetriver',{scope : ['group_videos']});
       },
      

  },
  mounted(){
  },
  computed : {
     dateFormate(){
              const vm = this;
              return moment(vm.group_object.created_at).format('DD-MM-YYYY');
       }
  },
}
</script>
<style lang="css" scoped>
.uk-badge {
    -webkit-box-sizing: border-box;
    box-sizing: border-box;
    min-width: 22px;
    height: 17px !important;
    padding: 0 5px;
    border-radius: 500px;
    vertical-align: middle;
    background: #1e87f0;
    color: #fff;
    font-size: 0.875rem;
    display: -webkit-inline-box;
    display: -ms-inline-flexbox;
    display: inline-flex;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
}
</style>