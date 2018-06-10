@extends('layouts.user')
@section('content')
<title>Knocks | Help</title>
<h4 class="ui horizontal divider header transparent knocks_fair_padding">
  <i class="knocks-atom2"></i>
<static_message msg = "Record Your Knocks Tips" classes = "knocks_text_ms"  ></static_message>

</h4>
<div class = "row white">
  <div >
    <div class = "row">
  <img :src="asset('snaps/recorder.png')" alt="tips" class = "col s8 push-s2 l6 push-l3 z-depth-3 knocks_standard_border_radius">
</div>
  <div class = "knocks_fair_padding">
    <h4>
        <i class="knocks-microphone-3 knocks_text_md "></i>
  <static_message msg = "Record" classes = "knocks_text_ms"  ></static_message>

  </h4>
    <static_message msg = "While clicking on the record button you can record your voice and post your knock by your voice or you can record your voice and what you are saying will turn into to text and by clicking on add to my knock you will post your knock as text also you can change the language." classes = "knocks_text_ms"  ></static_message>
  </div>
  </div>
</div>
@endsection
