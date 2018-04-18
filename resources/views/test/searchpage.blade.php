@extends('layouts.no_sidebar')
@section('head_externals')
<style>
.el-tabs__content{
  background-color: #e3e3e3;
}
</style>

@endsection
@section('content')


@if(isset($_GET['q']))
<title>Knocks Search | <?=$_GET['q']?> </title>
<knockspagesearch
@if(isset($_GET['t']))
start_tap = "<?=$_GET['t']?>"
@endif
start_as = "{{$_GET['q']}}"></knockspagesearch>
@endif
@if(!isset($_GET['q']))
<title>Knocks Search</title>
<knockspagesearch></knockspagesearch>
@endif


@endsection
<!-- search page -->
