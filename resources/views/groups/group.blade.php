@extends('layouts.user')
@section('content')
<div class = "row knocks_tinny_top_padding" style = "">
   <?php

  $exists = $group->groupMembers()->where('user_id' , '=' , auth()->user()->id)->exists();

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
            <a href="{{asset('group/'.$group->id.'/settings')}}" class="right" v-popover:popover2> 
              <i class="knocks-settings5 knocks_text_md grey-text text-darken-2"></i></a>
      <div class = "col s4 l3 knocks_house_keeper z-depth-1" style=" border: 2px solid white;
    background-color: white; border-radius: 25px;">
          <img class = "knocks_group_avatar_scope" src = "{{ asset('media/group/picture/'.$group->id) }}" style="width : 100%; border-radius : 25px; padding : 3px; " />
      </div>
      
      <div class="col s6 l7 push-l1 push-s1 knocks_house_keeper knocks_fair_bounds" style="padding-top : 120px !important">
         <h3 class="knocks_house_keeper knocks_text_dark" >{{$group->name}}</h3>

         <h6 class="knocks_sp_top_margin knocks_text_dark" style="opacity : 0.5"><i class="knocks-user"></i> Members : <span class="green-text">{{$group->groupMembers()->count()}} </span></h6>
    
     </div>

</div>
 

  <div class="col l12 s12 knocks_fair_bounds ">
  <knocksgroupmembers :group_object="{{$group}}"></knocksgroupmembers>
</div>
  <div class="knocks_fair_bounds col l9 s12">
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
  

  @if($group->picture == null)
		<div class="row knocks_fair_bounds" v-if="uploadGroupPic">
			<div class="col l6 s12 push-l3">
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
<div class=" col s12 knocks_fair_bounds">

<h4 class="ui horizontal divider header transparent col l9 s12">
      <i class="knocks-newspaper5"></i>
      <static_message msg = "** 's Knocks" replaceable :replacements = "[{target : '**' , body : '{{$group->name}}' }]"></static_message>
      </h4>
      <knocksknockinjector class = "col l9 s12"
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
      <knocksgroupjoining class="right" :group_id="{{$group->id}}" as_result></knocksgroupjoining>
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
  <div style="padding-top : 100px">
    <h1 class="grey-text center">You are not in this Group :)</h1>
  </div>
@endif
</div> 
  @endsection