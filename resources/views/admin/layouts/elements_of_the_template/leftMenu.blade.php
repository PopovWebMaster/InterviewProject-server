<nav id="nav_main">
    <!-- КНОПКА ЗАКРЫТИЯ МЕНЮ В ВИДЕ СТРЕЛКИ СЛЕВА -->
    <div id="nav_close_wrp">
        <div id="nav_close">
            <span class="icon-left-open-big"></span>
        </div>
    </div>

    <!-- СПИСОК СТРАНИЦ -->
    <div id="nav_li">
        <ul id="ul_list">
        
            <!-- КНОПКА ВХОДА/ВЫХОДА -->
            <li id="ul_li_ent_exit">
                <span class="us_name">{{ $userName }}</span>
                <span class="icon-user"></span>
                <a href={{ asset('').'logout' }} class="enter_exit text_right">Выход</a>
            </li>

            <!-- НАЧАЛО СПИСКА -->
            <li class = 'itenMenuLi'>
                <img src="/assets/admin/img/icons/home-2.png" alt="">
                <a href={{ route('admin_home') }} class = 'itemMenu active' id = '' >Главная</a>
            </li>

            <li class = 'itenMenuLi'>
                <img src="/assets/admin/img/icons/project-4.png" alt="">
                <a href={{ route('admin_projects') }} class = 'itemMenu active' id = '' >Проекты</a>
            </li>

            <li class = 'itenMenuLi'>
                <img src="/assets/admin/img/icons/analiz-4.png" alt="">
                <a href={{ route('admin_analysis') }} class = 'itemMenu active' id = '' >Анализ</a>
            </li>

            <li class = 'itenMenuLi'>
                <img src="/assets/admin/img/icons/dictionary-3.png" alt="">
                <a href={{ route('admin_dictionaries') }} class = 'itemMenu active' id = '' >Словари</a>
            </li>

            <li class = 'itenMenuLi'>
                <img src="/assets/admin/img/icons/sirota-1.png" alt="">
                <a href={{ route('admin_anticipation') }} class = 'itemMenu active' id = '' >Слова в ожидании</a>
            </li>

            <li class = 'itenMenuLi'>
                <img src="/assets/admin/img/icons/settings-2.png" alt="">
                <a href={{ route('admin_setting') }} class = 'itemMenu active' id = '' >Настройки сайта</a>
            </li>
            
            <li class = 'itenMenuLi'>
                <img src="/assets/admin/img/icons/project-1.png" alt="">
                <a href={{ route('admin_articles') }} class = 'itemMenu active' id = '' >Статьи</a>
            </li>

            <li class = 'itenMenuLi'>
                <img src="/assets/admin/img/icons/reklama-1.png" alt="">
                <a href={{ route('admin_advertising') }} class = 'itemMenu active' id = '' >Менеджер реклымы</a>
            </li> 
            <!-- КОНЕЦ СПИСКА -->

            <!-- ССЫЛКА НА САЙТ -->
            <li class = 'itenMenuLi goToMySite'>
                <img src="/assets/admin/img/icons/my-site-1.png" alt="">
                <a href={{ route('home') }} target="_blank" class = 'itemMenu active' id = '' >My Site!</a>
            </li>

        </ul>     
    </div>
</nav>