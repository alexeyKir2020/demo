<div class="ckeck-group">
    <div class="check-group__label">
        {{ $label }}
    </div>
    <p>
        @foreach($items as $item)
            <x-checkbox  :name="$parameter" :value="$item['value']">
                {{ $item['name'] }}
            </x-checkbox>
        @endforeach
    </p>
</div>

