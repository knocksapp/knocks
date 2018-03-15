@extends('layouts.user')
@section('content')
<div class = "row knocks_tinny_top_padding" style = "">


	   <div class="row knocks_parent_container lighten-4 z-depth-1 knocks_fair_bounds" style="border-radius : 15px; padding : 10px; width : 98%; border: 3px solid rgba(0,0,0,.1); background-color : rgba(255,255,255,0.5) ">
      <div class = "col s4 l3 knocks_house_keeper z-depth-1" style=" border: 2px solid white;
    background-color: white; border-radius: 25px;">
          <img class = "knocks_group_avatar_scope" src = "{{ asset('media/group/picture/'.$group->id) }}" style="width : 100%; border-radius : 25px; padding : 3px; " />
      </div>
      <div class="col s6 l7 push-l1 push-s1 knocks_house_keeper knocks_fair_bounds" style="padding-top : 120px !important">
         <h3 class="knocks_house_keeper knocks_text_dark" >{{$group->name}}</h3>

         <h6 class="knocks_sp_top_margin knocks_text_dark" style="opacity : 0.5"><i class="knocks-user"></i> Members : <span class="green-text">{{$group->groupMembers()->count()}} </span></h6>
    
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
      <knocksknockinjector class = "col s12"
      :current_user = "{{auth()->user()->id}}"
      as_atimeline
      newer_retrive = "group/posts/newer"
      older_retrive = "group/posts/older"
      basic_retrive = "group/posts"
      :requsted = "{{$group->id}}">
      </knocksknockinjector>

</div>





   </div>


  

</div> 
  @endsection