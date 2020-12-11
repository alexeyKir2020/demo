<header id="header" class="header {{ RouteChecker::isHome() ? 'header_full-height' : '' }}{{  (RouteChecker::isAuth() || RouteChecker::isItemRoute()) ? 'header_compact': '' }}">

        <nav class="nav header__nav">
            <div class="menu container">
                <a href="{{ route('frontend.static.home') }}" class="brand-logo logo header__logo"></a>
                <a href="#" data-target="mobile-sidebar" class="sidenav-trigger menu__toggler"><i class="mdi mdi-menu"></i></a>
                <form class="menu__search hide-on-xlarge-only">
                    <div class="input-field">
                        <input id="search" class="search__input" placeholder=" " type="search" required>
                        <i class="search__close mdi mdi-close"></i>
                        <label class="label-icon search__icon" for="search"><i class="icon_search mdi mdi-magnify"></i></label>
                    </div>
                </form>

                <ul class="menu__nav hide-on-large-and-down">
                    @foreach($headerMenu['all'] as $item)
                        <li class="menu__item {{ request()->is($item['link'])? 'nav__item_active' : '' }}">
                            <a class="menu__link nav__link" href="{!! route($item['link']) !!}">
                                <span class="menu__text"> {{ $item['name'] }}</span>
                            </a>
                        </li>
                    @endforeach

                    @foreach($headerMenu['actions'] as $item)
                        <li class="menu__item {{ request()->is($item['link'])? 'nav__item_active' : '' }}">
                            <a class="menu__link nav__link" href="{!! route($item['link']) !!}">
                                <span class="nav__text"> {{ $item['name'] }}</span>
                            </a>
                        </li>
                    @endforeach

                    <li class="menu__item {{ request()->is(route('auth.form.login'))? 'nav__item_active' : '' }}">
                        @include("frontend.chunks.profile")
                    </li>
                </ul>
            </div>

            <ul class="sidenav" id="mobile-sidebar">
                <div class="sidenav__header">
                    <a href="{{ route('frontend.static.home') }}" class="brand-logo logo header__logo_side"></a>
                </div>


                @foreach($headerMenu['all'] as $item)
                    <li class="nav__item {{ request()->is($item['link'])? 'nav__item_active' : '' }}">
                        <a class="menu__link nav__link" href="{!! route($item['link']) !!}">
                            <span class="nav__text"> {{ $item['name'] }}</span>
                        </a>
                    </li>
                @endforeach

                @foreach($headerMenu['actions'] as $item)
                    <li class="nav__item {{ request()->is($item['link'])? 'nav__item_active' : '' }}">
                        <a class="menu__link nav__link" href="{!! route($item['link']) !!}">
                            <span class="nav__text"> {{ $item['name'] }}</span>
                        </a>
                    </li>
                @endforeach


                <li class="nav__item {{ request()->is(route('auth.form.login'))? 'nav__item_active' : '' }}">
                    @include("frontend.chunks.profile")
                </li>
            </ul>
        </nav>

    @if (RouteChecker::isHome() || RouteChecker::isAuth() || RouteChecker::isItemRoute())
        <section class="header__content">
            <div class="container center">
                @if (RouteChecker::isHome())
                    <h1 class="header__slogan">
                        @lang('header.title')
                    </h1>
                    <h2 class="header__subtitle">
                        @lang('header.subtitle')
                    </h2>
                @endif

                <form id="header-search" class="header__search hide-on-large-and-down search {{ RouteChecker::isHome() ? "header__search_hidden" : "" }}" method="get">
                    <input type="text" class="input search__input_big" name="query" placeholder="{{ trans('header.search_placeholder' )}}" value="{{ empty($_GET['query'])? '': $_GET['query'] }}">
                    <button class="search__button waves-effect waves-light" type="submit">
                        <i class="mdi mdi-magnify"></i>
                    </button>
                </form>

                @if(RouteChecker::isHome())
                <!--
                    <div class='header__buttons'>
                        <a class="button waves-effect waves-light btn-large" href="@lang('header.button_resume.link')" target="_blank">
                            <span class="button__content">@lang('header.button_resume.title')</span>
                            <span class="button__content lg-up-only">@lang('header.button_resume.text')</span>
                        </a>
                        <a class="button waves-effect waves-light btn-large" href="@lang('header.button_resume.link')" target="_blank">
                            <span class="button__content ">@lang('header.button_companies.title')</span>
                            <span class="button__content lg-up-only">@lang('header.button_companies.text')</span>
                        </a>
                    </div>-->
                @endif
            </div>
        </section>
    @endif

</header>
