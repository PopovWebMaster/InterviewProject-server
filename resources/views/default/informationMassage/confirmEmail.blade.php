@extends('default.layouts.layout')
@extends('default.informationMassage.layout')

@section('content')
    <section id = {{ $section_id_name }}>
        <div class = 'informationMassage'>
            <p>
                На вашу почту было выслано письмо. Перейдите по ссылке указанной в данном письме, чтобы подтвердить адреса вашей электронной почты.
            </p>
        </div>
    </section>   
@endsection
