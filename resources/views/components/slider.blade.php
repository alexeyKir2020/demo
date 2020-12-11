<section class="slider">
    <div {{ $attributes }} class="swiper-container">
        <div class="swiper-wrapper">
            @each('frontend.component.slides.'. $slideType, $slides, 'slide')
        </div>
    </div>
    <div class="slider__button slider__button_prev slider__button_prev_{{ $attributes->id }}"></div>
    <div class="slider__button slider__button_next slider__button_next_{{ $attributes->id }}"></div>
</section>
