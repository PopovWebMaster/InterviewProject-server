<html>

    <p style = 'text-indent: 4em; line-height: 3em;'>
        Для подтверждения регистрации на сайте 
        <span style = 'padding: 0.5em 0.8em; border-radius: 2em; background-color: #928282d4; font-style:bold; margin: 0 1em;'>
            <span style = 'color: #d4ff3d;' >{{ $site_name_part_1 }}</span> <span style = 'color: #fff;' >{{ $site_name_part_2 }}</span>
        </span>
        нажмите <a href = {{ route('confirm_email', ['token' => $token ]) }}>подтвердить регистрацию</a>
    </p>

    <p style = 'text-indent: 4em;'>Если вы не проходили регистрацию на этом сайте, то просто проигнорируйте данное письмо</p>

</html>