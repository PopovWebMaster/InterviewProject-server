<!-- reset_password -->

@extends('default.layouts.layout')

@section('link_css')
    <link href= {{ $css_main }} rel="stylesheet">
	<link href= {{ $css_reset_password }} rel="stylesheet">
@endsection

@section('topInfo')
    @parent
@endsection

@section('content')
    @include('default.layouts.reset_password')
@endsection

@section('jsonMassage')
    <div id="jsonMassage" style="display: none;">{{ $jsonMassage }}</div>
@endsection

@section('script_js')
    <script type="text/javascript" src={{ $js_vendors }}></script>
    <script type="text/javascript" src={{ $js_main }}></script>
    <script type="text/javascript" src={{ $js_reset_password }}></script>
@endsection 