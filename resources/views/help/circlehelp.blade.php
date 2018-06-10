@extends('layouts.user')
@section('content')
<title>Knocks | Help</title>
<h4 class="ui horizontal divider header transparent knocks_fair_padding">
  <i class="knocks-atom2"></i>
<static_message msg = "Circle Tips" classes = "knocks_text_ms"  ></static_message>

</h4>
<div class = "row white">
  <div >
    <div class = "row">
  <img :src="asset('snaps/circle.png')" alt="tips" class = "col s8 push-s2 l6 push-l3 z-depth-3 knocks_standard_border_radius">
</div>
  <div class = "knocks_fair_padding">
    <div class = "knocks_fair_padding">
      <h4>
          <i class="knocks-atom2 knocks_text_md "></i>
    <static_message msg = "Circle" classes = "knocks_text_ms"  ></static_message>

    </h4>
    <static_message msg = "Circles can help you to categorize your people so you can do your preset and control your privacy, Knocks made it easy for you so you can add, edit and delete circle also you can search on your circles and add anyone you want to add at your circle ." classes = "knocks_text_ms"  ></static_message>
    </div>
  </div>
  </div>
</div>
@endsection
