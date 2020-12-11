<div id="header-profile" class="profile">
    @guest
        <a class="profile__link" href="{{ route('auth.form.login') }}">
            <i class="icon_login mdi mdi-account-key-outline"></i> <span class="profile__text">@lang('profile.login')</span>
        </a>
    @else
        <a class="profile__avatar">
            <ul class="dropdown dropdown_js">

                @foreach($profile['menu'] as $item)
                    <li class="dropdown__item">
                        <a class="dropdown__link" href="{!! $item['link'] !!}">
                            <span class="dropdown__text"> {{ $item['name'] }}</span>
                        </a>
                    </li>
                @endforeach

                @if(RoleChecker::isAdmin())
                    <li class="dropdown__item">
                        <a class="dropdown__link" href="{{ route('admin.index') }}">
                            <span class="dropdown__text">
                                @lang('profile.admin')
                            </span>
                        </a>
                    </li>
                @endif
            </ul>
        </a>
        <span class="profile__separator"></span>
        <a class="profile__link" href="{{ route('auth.logout') }}">
            <i class="icon_login mdi mdi-account-lock-outline"></i>
            <span class="profile__text">
                @lang('profile.logout')
            </span>
        </a>
    @endguest
</div>
