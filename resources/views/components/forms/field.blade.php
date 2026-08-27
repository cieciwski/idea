@props(['label', 'name', 'type' => 'text'])

<div>
    <label for="{{ $name }}" class="label">{{ $label }}</label>
    <input
        type="{{ $type }}"
        id="{{ $name }}"
        name="{{ $name }}"
        value="{{ old($name) }}"
        {{ $attributes->merge(['class' => 'input']) }}
    >
    <x-error :name="$name" />
</div>
