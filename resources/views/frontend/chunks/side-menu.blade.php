<div class="nav side-menu">
    <ul class="side-menu__list">
        @foreach ($items as $item)
            <li class="side-menu__item">
                <a class="{{ (request()->routeIs($item['route']) ? 'side-menu__link_active' : '') }} side-menu__link" href="{{ route($item['route']) }}">
                   {{ $item['text'] }}
                </a>
            </li>
        @endforeach
    </ul>
</div>
