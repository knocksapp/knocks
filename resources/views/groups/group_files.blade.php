@extends('layouts.user')
@section('content')
<div class = "row knocks_tinny_top_padding" style = "">


	   <div class="row knocks_parent_container lighten-4 z-depth-1 knocks_fair_bounds" style="border-radius : 15px; padding : 10px; width : 98%; border: 3px solid rgba(0,0,0,.1); background-color : rgba(255,255,255,0.5) ">
      <div class = "col s4 l3 knocks_house_keeper z-depth-1" style=" border: 2px solid white;
    background-color: white; border-radius: 25px;">
          <img class = "knocks_group_avatar_scope" src = "{{ asset('media/group/picture/'.$group->id) }}" style="width : 100%; border-radius : 25px; padding : 3px; " />
      </div>
      <div class="col s6 l7 push-l1 push-s1 knocks_house_keeper knocks_fair_bounds" style="padding-top : 120px !important">
         <h3 class="knocks_house_keeper knocks_text_dark" ><a class="knocks_house_keeper knocks_text_dark" href="{{asset('group/'.$group->id) }}">{{$group->name}}</a></h3>

         <h6 class="knocks_sp_top_margin knocks_text_dark" style="opacity : 0.5"><i class="knocks-user"></i> Members : <span class="green-text">{{$group->groupMembers()->count()}}</span></h6>
    
     </div>



  

</div> 
<div class="row knocks_parent_container lighten-4 z-depth-1 knocks_fair_bounds" style="border-radius : 15px; padding : 10px; width : 98%; border: 3px solid rgba(0,0,0,.1); background-color : rgba(255,255,255,0.5) ">
  <h3 class="grey-text">Files of {{$group->name}}</h3>
     <knocksgroupfiles :group_id="{{$group->id}}"></knocksgroupfiles>
</div>
  @endsection