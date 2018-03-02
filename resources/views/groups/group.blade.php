@extends('layouts.user')
@section('content')
<div class = "row knocks_house_keeper">


	   <div class="row">

      <div class = "col s4 l2" style="border-raduis: 25px;">
          <img class = "knocks_group_avatar_scope red" src = "{{ asset('media/group/picture/'.$group->id) }}" style="width : 100%; border-radius : 25px;" />
      </div>
      <div class="col s8 l9">
         <h3 class="knocks_sp_top_margin" >{{$group->name}}</h3>
         <h6 class="knocks_sp_top_margin" >Member : {{$group->groupMembers()->count()}}</h6>
     </div>
   </div>  
   <div class="col s9 knocks_fair_bounds">
  <knocksgroupmembers :group_object="{{$group}}"></knocksgroupmembers>
</div>
  <div class="knocks_fair_bounds col s9">
   <knock 
   :scope= "['knock']" 
   :error_at="[]" 
   submit_at = "post/create"
   :recorder_upload_data = "{ user : '7esam' , index : {}}"
   :player_show_options = "false"
   :post_at = "{{ auth()->user()->id }}"
   parent_type = "self"
   success_at = "done"
   success_msg = "Done."
   gid = "knockknock"></knock>
  </div>
  
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
<div class="knocks knocks_fair_bounds">

<h4 class="ui horizontal divider header transparent">
      <i class="knocks-newspaper5"></i>
      <static_message msg = "** 's Knocks" replaceable :replacements = "[{target : '**' , body : '{{$group->name}}' }]"></static_message>
      </h4>
      <knocksknockinjector class = ""
      :current_user = "{{auth()->user()->id}}"
      as_atimeline
      newer_retrive = "user/profile/posts/newer"
      older_retrive = "user/profile/posts/older"
      basic_retrive = "user/profile/posts"
      :requsted = "{{auth()->user()->id}}">
      </knocksknockinjector>

</div>


</div>
  @endsection