@extends('layouts.user')
@section('headers')
<title>Settings</title>
@endsection
@section('content')

<div>
  <h4 class="ui horizontal divider header transparent knocks_fair_bounds">
<i class="knocks-settings5" style="font-size:150%"></i>
<static_message msg = "Settings" classes = "knocks_text_ms"  ></static_message>

</h4>

</div>
<div >
{{-- <knocksuserinfo>
</knocksuserinfo> --}}
<knocksusersettings
@if(isset($_GET['t']))
init_tab = "<?=$_GET['t']?>"
@endif
@if(isset($_GET['f']))
init_field = "<?=$_GET['f']?>"
@endif
></knocksusersettings>
</div>

@endsection
