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
	<meta name="keywords" content="{{ $keywords }}"><!--через запятую ключевые слова-->
	<meta name="description" content="{{ $description }}"><!--здесь инфа для снипета-->
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<!--этот файл загружается чтоб ослиный браузер понимал html5-->
	<!--[if lt IE 9]>
	<script src="js/html5shiv.js"></script>
    <![endif]-->

	<link rel="shortcut icon" href="/favicon.ico"/>
	<link href="https://fonts.googleapis.com/css?family=Alef|Amiri|Architects+Daughter|Bellefair|Cardo|EB+Garamond|El+Messiri|Halant|Kurale|Marck+Script|Marmelad|Molengo|Oregano|Poiret+One|Prociono|Sanchez|Simonetta|Slabo+13px|The+Girl+Next+Door|Trirong|Unna|Zeyada" rel="stylesheet">
	
	

	<title>{{ $siteTitle.' '.$siteTitleSecond }}</title> 

   
	@yield('link_css')

</head>	
		
<body style = "background-image: url(/assets/img/bg-ob.png);">
 
	@section('header')
	<header>
		<div id="head_wrap">
			<span class="icon-menu" id="menu_logo"></span>
			<hgroup>
				<h1>{{ $siteTitle }}</h1>
				<h2>{{ $siteTitleSecond }}</h2>
			</hgroup>
			<img src="/assets/img/flag-icon.png" alt="" title="" />
		</div>	
	</header>
	@show

	@section('leftMenu')
	<nav id = 'leftMenu'>

		<div class = 'close_button'>
			<div>
				<span class = "icon-left-open-big"></span>
			</div>
		</div>

		<div class = 'menu_wrap'>

			@if( $showAuthPanel )
			<div class = 'menu_auth'>

				@if( $isAuth )

				<div class = 'menu_user_info'>
					<span class = 'menu_user_name'>{{ $userName }}</span>
					<span class = 'icon'><span class = 'icon-user'></span></span>
				</div>

				<div class = 'menu_auth_button'>
					<a href = {{ asset('').'logout' }} >
						Выход
					</a> 
				</div>

				@else

				<div class = 'menu_auth_button'>
					<a href = {{ asset('').'login' }} >
						Вход/Регистрация
					</a> 
				</div>

				@endif

			</div>			
			@endif

			<ul class = 'menu_items'>
			@for( $i = 0; $i < count($articles); $i++)
				@if( $i === 0)
				<li >
					<a  
					class = 'itemMenu' 
						id =        "{{ 'menu_'.$articles[$i]['alias'] }} "
					>
						Главная
					</a>
				</li>
				@else
				<li>
					<a 
					class = 'itemMenu' 
						id =        "{{ 'menu_'.$articles[$i]['alias'] }}" 
					>
						{{ $articles[$i]['title'] }}
					</a>
				</li>
				@endif		
			@endfor
			</ul>

			<div class = 'menu_start_button'>
				<div>
					<a href = {{ route('dictionaries') }}>Выбрать словарь</a>
				</div>
			</div>

			@if( $adminPanel )
			<div class = 'menu_start_button'>
				<div>
					<a href = {{ route('admin') }}>Адмика</a>
				</div>
			</div>
			@endif


		</div>
	</nav>
	@show

	<main>

	@section('topInfo')
		<aside class = "body_auth">
		@if( $showAuthPanel )
		@if( $isAuth )
			<div class="body_auth_wrap" >
				<span class = "body_auth_us_name">{{ $userName }}</span>
				<span class = 'body_auth_icon'>
					<span class = 'icon-user'></span>
				</span>
				<a  class = "body_auth_button" href = {{ asset('').'logout' }}>Выход</a>
			</div>
		@else
			<div class="body_auth_wrap" >
				<a class = 'body_auth_button'  href = {{ asset('').'login' }}>Вход/Регистрация</a>
			</div>
		@endif
		@endif
		</aside>
	@show

	@yield('content')

	</main>
	
	@section('footer')	
	<footer id = "footer">
		<div>

		</div>
	</footer>
	@show	

	@yield('jsonMassage')

	@yield('script_js')
</body>
</html>


