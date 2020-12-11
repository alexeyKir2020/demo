@php
    $classes = "map";
@endphp

<div {{ $attributes->merge(["class" => $classes]) }} data-location="{{ $location  }}">

</div>
