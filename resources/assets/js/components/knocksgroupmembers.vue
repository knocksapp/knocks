<template>
	<div class="row">
		<knocksretriver
		v-model=  "group_members"
		url = "get_group_members"
		:xdata="{group_id : group_object.id}"
		@success = "isOwner()"
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
				    <ul class="knocks_text_dark animated fadeIn">
				    	<li class="knocks_fair_bounds"> <i class="knocks-group2"></i> Group Name : {{group_object.name}}</li>
				    	<li class="knocks_fair_bounds"> <i class="knocks-th-large"></i> Group Category : {{group_object.category}}</li>
				    	<li class="knocks_fair_bounds"> <i class="knocks-locked2"></i> Privacy : {{group_object.preset}}</li>
				    	<li class="knocks_fair_bounds"> <i class="knocks-calendar2"></i> Created At : {{dateFormate}}</li>
				    </ul>
					  </el-tab-pane>
					  <el-tab-pane>
				    <span slot="label" class="grey-text"><i class="knocks-group2"></i> Members</span>
				    <el-input placeholder="Find people" class="knocks_fair_bounds"></el-input>
				    <div class="row" v-if="group_members != null && group_members.response != null">
				    	<ul class="uk-list uk-list-divider">
				    	<li  v-for="(mem,index) in group_members.response" class="knocks_fair_bounds">
				    	<knocksuser  :show_accept_shortcut="false" class="col s10 animated fadeIn" :user="mem.user_id" v-model="members_names[index]" :as_result="true">
                    <span slot="append_to_name" class=""><span v-if="mem.position == 'Owner'" style="font-size : 10px !important" class="uk-badge red">Owner</span><span v-if="mem.position == 'Member'" style="font-size : 10px !important" class="uk-badge blue">Member</span> <span 
                  v-if="mem.position == 'Admin'" 
                  class="uk-badge green knocks_text_sm" 
                  style="font-size : 10px !important">
                   Admin
                  </span></span>
                         </knocksuser>
                         <span class="right" v-if="flag"><knocksgroupmemberdelete @member_deleted="group_members.response.splice(index,1)" :group_id="group_object.id" :gid="index" :member_delete = "mem.user_id"></knocksgroupmemberdelete></span>
      				      </li>
      				    </ul>
      				    </div>
      					  </el-tab-pane>
      					 <el-tab-pane v-if="flag">
      					 	<span slot="label" class="grey-text"><i class="knocks-user-plus"></i> Add Members</span>
      					 	<knockselinput v-model = "test" placeholder="search" autocomplete :autocomplete_start="2" autocomplete_from = "user/search" @autocomplete="user = $event" ></knockselinput>
      					 	<ul class="uk-list uk-list-divider">
      				    	<li >
                      <div v-for="(u ,index) in user" v-if="!inGroup(u)">
      				    	<knocksuser  main_container="col s10 knocks_house_keeper"  class="animated bounceIn" :user="user[index]"  :key = "u">
                     </knocksuser>
                     <knocksgroupjoining 
                     @member_added = "addMember($event)"
                     class="col s2 right" :group_id="group_object.id" :add_member_mode="true" :user_id="u"></knocksgroupjoining>
                   </div>
				      </li>
				  </ul>
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
     flag : false,
     memberInGroup : false,
     members_names : [],
     user : [],
     test : '' ,
     search : '',
     group_pictures : null,
     group_files : null,
     group_voices : null,
     group_videos : null,
     current_user : UserId
    }
  },
  props:{
     group_object :{
     	type : Object,
        required : true
     }
  },
  methods:{
       isOwner(){
       	const vm = this

       	let i;
       	 for (i = 0; i < vm.group_members.response.length; i++){
       	 	 if( parseInt(UserId) == vm.group_members.response[i].user_id &&
       	 	 	vm.group_members.response[i].position == 'Owner' ){
                 return vm.flag = true;
           }else{
           	return vm.flag = false
           }
       	 }
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