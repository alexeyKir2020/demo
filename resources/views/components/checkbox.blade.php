@php
    $classes = "checkbox";
@endphp

<label>
    <input {{ $attributes->merge(["class" => $classes]) }} type="checkbox"/>
    <span>{{ $slot }}</span>
</label>

