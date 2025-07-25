@props(['name' => '', 'label' => null, 'type' => 'text', 'placeholder' => '', 'value' => ''])

<div>
    @if ($label)
        <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 mb-1">{{ $label }}</label>
    @endif
    <input type="{{ $type }}" id="{{ $name }}" name="{{ $name }}" placeholder="{{ $placeholder }}"
        value="{{ $value }}"
        {{ $attributes->merge(['class' => 'mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm']) }}>
</div>
