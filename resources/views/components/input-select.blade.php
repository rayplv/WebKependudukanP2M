@props(['name' => '', 'label' => null, 'options' => [], 'selected' => null])

<div>
    @if ($label)
        <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 mb-1">{{ $label }}</label>
    @endif
    <select id="{{ $name }}" name="{{ $name }}"
        {{ $attributes->merge(['class' => 'mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md']) }}>
        @foreach ($options as $value => $text)
            <option value="{{ $value }}" @if ($selected == $value) selected @endif>{{ $text }}
            </option>
        @endforeach
    </select>
</div>
