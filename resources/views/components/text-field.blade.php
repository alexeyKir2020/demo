@php
    $classes = "input";
    if($errors->has($attributes['name'])) {
        $classes = $classes. " input_invalid";
    }

@endphp

<div class="input-field">

    {{ $icon ?? '' }}
    <input {{ $attributes->merge(["class" => $classes]) }}/>
    <label for="{{ $attributes['name'] }}">{{ $slot }}</label>

    @error($attributes['name'])
        <x-alert type="invalid">
            {{ $message }}
        </x-alert>
    @enderror
</div>

