@extends('layouts.user')
@section('content')
<div class = "row knocks_tinny_top_padding" style = "">
  <?php
$s = $group->groupMembers()->where('position', '=', 'Owner')->pluck('user_id');
$name = (int) str_replace('[', '', $s);
$name1 = (int) str_replace(']', '', $name);
$exists = $group->groupMembers()->where('user_id', '=', auth()->user()->id)->exists();
?>
  @if($exists)
  <title>{{$group->name}}</title>
  <el-popover
  ref="popover2"
  placement="bottom"
  title="Settings"
  width="200"
  trigger="hover"
  content="You can manage all your group Settings from here.">
  </el-popover>
  <div class="row knocks_parent_container lighten-4 z-depth-1 knocks_fair_bounds" style="border-radius : 15px; padding : 10px; width : 98%; border: 3px solid rgba(0,0,0,.1); background-color : rgba(255,255,255,0.5) ">
    @if($group->memberPostion() == 'Owner' || $group->memberPostion() == 'Admin')
    <el-badge :value="{{$group->groupRequests()}}" class="item right" v-if="{{$group->groupRequests()}} != 0">
    <a href="{{asset('group/'.$group->id.'/settings')}}" class="right" v-popover:popover2>
    <i class="knocks-settings5 knocks_text_md grey-text text-darken-2"></i></a></el-badge>

    <a href="{{asset('group/'.$group->id.'/settings')}}" class="right" v-popover:popover2 v-if="{{$group->groupRequests()}} == 0">
    <i class="knocks-settings5 knocks_text_md grey-text text-darken-2"></i></a>
    @endif
    <div class = "col s4 l3 knocks_house_keeper z-depth-1" style=" border: 2px solid white;
      background-color: white; border-radius: 25px;">
      <img class = "knocks_group_avatar_scope" src = "{{ asset('media/group/picture/'.$group->id) }}" style="width : 100%; border-radius : 25px; padding : 3px; " />
    </div>
    <div class="col s6 l7 push-l1 push-s1 knocks_house_keeper knocks_fair_bounds" style="padding-top : 50px !important; ">
      <h3 class="knocks_house_keeper knocks_text_dark" id="group_name_view" >{{$group->name}}</h3>
      <h6 class="knocks_sp_top_margin grey-text" style=""><i class="knocks-group2 grey-text"></i> Members : <span id="group_member_count" class="green-text">{{$group->groupMembers()->count()}} </span></h6>
      <div class="col l6 s12 knocks_house_keeper" >
        <!--  <span class = "uk-badge red" style="padding : 3px !important; max-height : 15px;">
        </span> -->
        <div class="ui horizontal divider transparent" style = "margin : 1px !important">
          <static_message msg = "Owned by" classes = "grey-text"></static_message>
        </div>
        <div style="margin-top : 3px">
          <knocksuser
          name_class = "knocks_text_anchor knocks_text_bold knocks_house_keeper col"
          image_container_class = "col"
          name_container_class = "col"
          main_container="row knocks_house_keeper" class=" animated fadeIn knocks_house_keeper" :as_label="true" :user = "{{$name1}}"></knocksuser>
        </div>
      </div>
    </div>
  </div>
  <div class="col l12 s12 knocks_house_keeper ">
    <knocksgroupmembers :group_object="{{$group}}"></knocksgroupmembers>
  </div>
  <div class="col l8 s12 white knocks_house_keeper knocks_standard_border_radius knocks_ocean_blue_border" style="margin-left: 5px !important">
    <div class="knocks_fair_bounds  ">
      <knock
      :scope= "['knockgroup']"
      :error_at="[]"
      submit_at = "post/create"
      :recorder_upload_data = "{ user : '7esam' , index : {}}"
      :player_show_options = "false"
      :post_at = "{{$group->id}}"
      parent_type = "group"
      success_at = "done"
      success_msg = "Done."
      gid = "knockknock"></knock>
    </div>
    @if($group->picture == null && ($group->memberPostion() == 'Owner' || $group->memberPostion() == 'Admin'))
    <div class="row knocks_fair_bounds" v-if="uploadGroupPic">
      <div class="col  s12  knocks_house_keeper">
        <p class="col s12 center knocks_text_md grey-text">
          <static_message msg = "Set an avatar for this group."></static_message>
        </p>
        <knockscroppie
        gid = "knocks_group_picture_uploader"
        success_at = "done"
        success_msg = "Updated Your group picture succecfully!"
        :upload_data = "{ group_id : {{$group->id}} }"
        :error_at = "[]"
        callback_event = "update"
        :callback_payloads = "{}"
        ref = "ss"
        :special_submit = "true"
        :scope = "['group_picture_handler']"
        upload_at = "media/group/upload"
        @knocks_file_uploaded = "uploadGroupPic = false"
        ></knockscroppie>
      </div>
    </div>
    @endif
    <div class=" row knocks_house_keeper">
      <h4 class="ui horizontal divider header transparent col s12">
      <i class="knocks-newspaper5"></i>
      <static_message msg = "** 's Knocks" replaceable :replacements = "[{target : '**' , body : '{{$group->name}}'}]"></static_message>
      </h4>
      <knocksknockinjector class = ""
      :current_user = "{{auth()->user()->id}}"
      newer_retrive = "group/posts/newer"
      older_retrive = "group/posts/older"
      basic_retrive = "group/posts"
      :requsted = "{{$group->id}}">
      </knocksknockinjector>
    </div>
  </div>
  @else
  <div >
    <title>{{$group->name}}</title>
    <div class="row knocks_parent_container lighten-4 z-depth-1 knocks_fair_bounds" style="border-radius : 15px; padding : 10px; width : 98%; border: 3px solid rgba(0,0,0,.1); background-color : rgba(255,255,255,0.5)">
      <div class = "col s4 l3 knocks_house_keeper z-depth-1" style=" border: 2px solid white;
        background-color: white; border-radius: 25px;">
        <img class = "knocks_group_avatar_scope" src = "{{ asset('media/group/picture/'.$group->id) }}" style="width : 100%; border-radius : 25px; padding : 3px; " />
      </div>
      @if(!$exists)
      <knocksgroupjoining class="right" :group_id="{{$group->id}}" as_result></knocksgroupjoining>
      @endif
      <div style="padding-top : 10px !important">
        <ul class="col s6 l7  knocks_fair_bounds uk-list uk-list-divider" style="">
          <h3 style="" class=" knocks_house_keeper knocks_fair_bounds "><i class="knocks-info"></i>     Group Info :</h3>
          <li><span class="knocks_house_keeper knocks_text_dark" ><i class="knocks-group2"></i> {{$group->name}}</span></li>
          <li><span class="knocks_house_keeper knocks_text_dark" ><i class="knocks-th-large"></i> {{$group->category}}</span></li>
          @if($group->preset == 'public')
          <li><span class="knocks_house_keeper knocks_text_dark" ><i class="knocks-globe"></i> {{$group->preset}}</span></li>
          @endif
          @if($group->preset == 'closed')
          <li><span class="knocks_house_keeper knocks_text_dark" ><i class="knocks-lock2"></i> {{$group->preset}}</span></li>
          @endif
          <li><span class="knocks_house_keeper knocks_text_dark" ><i class="knocks-user"></i> Members : {{$group->groupMembers()->count()}}</span></li>
        </ul>
      </div>
    </div>
  </div>
  <div style="padding-top : 100px">
    <h1 class="grey-text center">You are not in this Group :)</h1>
  </div>
  @endif
  @endsection