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
<knockspagesearch start_as = "{{$_GET['q']}}"></knockspagesearch>
@endif
@if(!isset($_GET['q']))
<knockspagesearch></knockspagesearch>
@endif


@endsection
