@props(['name' => '', 'label' => null, 'options' => [], 'selected' => null, 'placeholder' => null])

<div>
    @if ($label)
        <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 mb-1">{{ $label }}</label>
    @endif
    <select id="{{ $name }}" name="{{ $name }}"
        {{ $attributes->merge(['class' => 'mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md']) }}>
        @if ($placeholder)
            <option value="">{{ $placeholder }}</option>
        @endif
        @foreach ($options as $key => $option)
            @if (is_array($option) && isset($option['value']) && isset($option['label']))
                <option value="{{ $option['value'] }}" @if ($selected == $option['value']) selected @endif>{{ $option['label'] }}</option>
            @else
                <option value="{{ $key }}" @if ($selected == $key) selected @endif>{{ $option }}</option>
            @endif
        @endforeach
    </select>
    @error($name)
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>
