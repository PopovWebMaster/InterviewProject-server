@extends('default.layouts.layout')

@section('link_css')
    <link href= {{ $css_main }} rel="stylesheet">
    <style>
    
        .site_is_closed{
            width: 70%;
            margin: 10% auto;
            border: 2px solid #cacaca;
            border-radius: 4px;
            font-size: 1em;

            box-shadow: 0 0 10px 5px rgba(221, 221, 221, 1);

            padding: 2em 3em;

            background-color: #fafafa; 
            text-align: center;
        }
        .site_is_closed span.antismile{
            color: #d04848;
        }
        .site_is_closed h2{
            margin: 0.4em 0;
            font-size: 2em;
            
        }
        .site_is_closed p{
            margin: 0.4em 0;
            font-size: 1.7em;
            text-indent: 0.8em;
            color: #4f4f4f;
        }
        @media screen and (min-width: 720px) and (max-width: 1020px) {
            .site_is_closed{
                font-size: 0.7em;
            }
        }

        @media screen and (min-width: 460px) and (max-width: 720px) {
            .site_is_closed{
                font-size: 0.6em;
            }
        }
        @media screen and (min-width: 360px) and (max-width: 460px) {
            .site_is_closed{
                font-size: 0.5em;
            }
        }
        @media screen and (min-width: 10px) and (max-width: 360px) {
            .site_is_closed{
                font-size: 0.4em;
            }
        }
    


    </style>
@endsection

@section('header')
    
@endsection

@section('leftMenu')
    
@endsection

@section('topInfo')
    
@endsection


<div class = 'site_is_closed'>
    <h2>Сайт закрыт на ремонт <span class="icon-frown antismile"></span></h2>
    <hr/>
    <p>
        В настоящий момент на сайте ведутся технические работы.
    </p>
    <p>
        Скоро всё заработает - обязательно возвращайтесь!
    </p>

</div>




@section('footer')
    
@endsection





