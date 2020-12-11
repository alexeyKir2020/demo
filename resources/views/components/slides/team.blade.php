<div class="swiper-slide slide">
    <div class="slide__wrapper">
        <div class="slide__header">
            <img class="slide__image" src="{{ config('urls.images') }}/section-team/image-{{ $slide['image-name'] }}.webp">
        </div>

        <p class="slide__name">{{ $slide['name'] }}</p>
        <p class="slide__role">{{ $slide['role'] }}</p>
        <div class="slide__social">
            @foreach($slide['social'] as $link)
                <a class="social-link social-link_fb" href="{{ $link }}" target="_blank"></a>
            @endforeach
        </div>
    </div>
</div>
