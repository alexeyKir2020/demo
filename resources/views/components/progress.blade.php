@php
    $classes = "progress";
@endphp
<div {{ $attributes->merge(["class" => $classes]) }}>
    <div class="indeterminate"></div>
</div>
