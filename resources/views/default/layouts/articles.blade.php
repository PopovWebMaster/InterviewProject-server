<section id='home'>
    @for( $i = 0; $i < count($articles); $i++)
        <article id="{{ $articles[$i]['alias'] }}">
            <h2 class='accent1'>{{ $articles[$i]['title'] }}</h2> 
            <h2 class='accent2'>{{ $articles[$i]['second_title'] }}</h2>
            {!! $articles[$i]['text'] !!}
        </article>

        @if( $i == 1 )
            @if( !$isAuth )
                <p  class='enter_exit' style =  "display: 'block';">
                    <a href = {{ asset('').'register' }}>Пройти регистрацию и начать работу!</a>
                </p>
            @endif
        @endif
    @endfor
</section>
            