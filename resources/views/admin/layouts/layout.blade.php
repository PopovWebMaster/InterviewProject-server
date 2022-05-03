<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="Content-Language" content="ru">
	<meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no"/>
	<meta name="theme-color" content="#000000"/>

	<meta name="Author" content="Попов Александр Игоревич">
	<meta http-equiv="Content-Language" content="ru">
	<meta name="robots" content="all"> <!--инфа для робота, индексировать всё и по всем ссылкам переходить-->
	<meta name="Subject" content=""><!--сюда висать тему страницы. Это для поисковиков-->
	<meta name="Reply-to" content="адрес электронной почты"><!--здесь адрес почты как связаться с владельцем сайта-->
	<meta name="keywords" content=""><!--через запятую ключевые слова-->
	<meta name="description" content=""><!--здесь инфа для снипета-->


	<meta name="csrf-token" content="{{ csrf_token() }}">

	<!--этот файл загружается чтоб ослиный браузер понимал html5-->
	<!--[if lt IE 9]>
	<script src="js/html5shiv.js"></script>
    <![endif]-->

	<link rel="shortcut icon" href="/favicon.ico"/>
	<link href="https://fonts.googleapis.com/css?family=Alef|Amiri|Architects+Daughter|Bellefair|Cardo|EB+Garamond|El+Messiri|Halant|Kurale|Marck+Script|Marmelad|Molengo|Oregano|Poiret+One|Prociono|Sanchez|Simonetta|Slabo+13px|The+Girl+Next+Door|Trirong|Unna|Zeyada" rel="stylesheet">
	
	<title>Админка :-)</title> 

	<link href={{ $css_file }} rel="stylesheet">
</head>	


<body style = "background-image: url(/assets/img/bg-ob.png);">

	<!-- ШАПКА -->
	@section('header')
		@include('admin.layouts.elements_of_the_template.header')
	@show

	<!-- ЛЕВОЕ МЕНЮ -->
	@section('leftMenu')
		@include('admin.layouts.elements_of_the_template.leftMenu')
	@show

	<main>

		<!-- ПВНЕЛЬ С КНОПКАМИ ВХОДА/ВЫХОДА И ИМЕНЕМ ПОЛЬЗОВАТЕЛЯ (расположена вверху страницы)-->
		@section('asideEnter')
			@include('admin.layouts.elements_of_the_template.asideEnter')
		@show

		<section id='adminPage'>
            @yield('content')
        </section>

	</main>

	<div id="jsonMassage" style="display: none;">{{ $jsonMassage }}</div>

	<!-- FOOTER -->
	@section('footer')
		@include('admin.layouts.elements_of_the_template.footer')
	@show

	<script type="text/javascript" src={{ $vendors_js }}></script>
	<script type="text/javascript" src={{ $app_js }}></script>

</body>
</html>


