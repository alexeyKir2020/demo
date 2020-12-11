<footer class="footer">
    <div class="container">
        <div class="footer__wrapper row">
            <div class="col xs2 l1">
                <a class="footer__logo logo logo_square" href="/">
                </a>
            </div>

            <div class="col xs10 l8">
                <ul class="nav footer__nav">


                    @foreach($footerMenu as $item)

                        <li class="nav__item footer__item">
                            <a class="nav__link footer__link" href="{{ route($item['link']) }}">
                                {{ $item['name'] }}
                            </a>
                        </li>

                    @endforeach

                </ul>
            </div>

            <div class="col xs12 l3">
                <div class="footer__social">
                    <div class="row spaced">
                        <div class="social">
                            <p class="social__title">@lang('footer.social.title')</p>

                            <div class="social__container">

                                @foreach($footerSocialLinks as $item)
                                    <a class="social__icon mdi mdi-{{ $item['name'] }}" href="{!! $item['link'] !!}"></a>
                                @endforeach

                            </div>
                        </div>

                        <div class="social">
                            <p class="social__title">@lang('footer.social.blog.title')</p>

                            <div class="social__container">
                                <a class="social__icon icon_blog" href="@lang('footer.social.blog.link')"></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer__copyright">
        <span>© Teenjob.by, 2019 — 2020</span>
    </div>
</footer>
