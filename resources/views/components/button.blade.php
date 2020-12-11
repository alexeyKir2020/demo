@php
    $classes = "button btn";
    $type = ($attributes['type'] == 'submit') ? 'button' : 'a';
@endphp

<{{ $type }} role="button" {{ $attributes->merge(["class" => $classes]) }}>

    {{ $icon ?? '' }}

    <span class="button__content">
       {{ $slot ?? '' }}
    </span>
</{{ $type }}>
