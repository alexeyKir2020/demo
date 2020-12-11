@php
    $classes = "textarea materialize-textarea";
    if($errors->has($attributes['name'])) {
        $classes = $classes. " input_invalid";
    }

@endphp

<div class="input-field">

    {{ $icon ?? '' }}
    <textarea {{ $attributes->merge(["class" => $classes]) }}></textarea>
    <label for="{{ $attributes['name'] }}">{{ $slot }}</label>

    @error($attributes['name'])
        <x-alert type="invalid">
            {{ $message }}
        </x-alert>
    @enderror
</div>

