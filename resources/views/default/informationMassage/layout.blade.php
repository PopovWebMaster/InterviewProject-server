@section('link_css')
    <link href= {{ $css_main }} rel="stylesheet">
	<link href= {{ $css_information_message }} rel="stylesheet">
@endsection

@section('topInfo')
    @parent
@endsection

@section('jsonMassage')
    <div id="jsonMassage" style="display: none;">{{ $jsonMassage }}</div>
@endsection

@section('script_js')
    <script type="text/javascript" src={{ $js_vendors }}></script>
    <script type="text/javascript" src={{ $js_main }}></script>
    <script type="text/javascript" src={{ $js_information_message }}></script>
@endsection 