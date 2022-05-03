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

	<!--этот файл загружается чтоб ослиный браузер понимал html5-->
	<!--[if lt IE 9]>
	<script src="js/html5shiv.js"></script>
    <![endif]-->

	<link rel="shortcut icon" href="/favicon.ico"/>
	<link href="https://fonts.googleapis.com/css?family=Alef|Amiri|Architects+Daughter|Bellefair|Cardo|EB+Garamond|El+Messiri|Halant|Kurale|Marck+Script|Marmelad|Molengo|Oregano|Poiret+One|Prociono|Sanchez|Simonetta|Slabo+13px|The+Girl+Next+Door|Trirong|Unna|Zeyada" rel="stylesheet">

	<title>Админка</title> 

    <link href="/assets/css/app.ee1ded47daa559b32063.css" rel="stylesheet">
</head>	
		
<body style = "background-image: url(/assets/img/bg-ob.png);">
 

<header>
		<div id="head_wrap">
			<span class="icon-menu" id="menu_logo"></span>
			<hgroup>
				<h1>Название 1</h1>
				<h2>Название 2</h2>
			</hgroup>
			<img src="/assets/img/flag-icon.png" alt="" title="" />
		</div>	
</header>
<main style='margin-top: 150px;'>
    <h3>action="{{ url('/admin/workspace') }}"</h3>
    <form  role="form" method="POST" >
        {{ csrf_field() }}
        <label for="mypost">Что-то впиши сюда </label>
        <input id='mypost' name="mypost" value="">
        <button id='save'> Нажми </button>
    </form>



</main>
	
<footer id = "footer">
		<div>

		</div>
</footer>

<script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>
<script type="text/javascript" src="/assets/js/vendors.ee1ded47daa559b32063.js"></script><script type="text/javascript" src="/assets/js/admin.js"></script></body>
</html>


