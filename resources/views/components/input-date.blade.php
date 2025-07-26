@props([
    'label' => '',
    'name' => '',
    'value' => '',
    'required' => false,
    'disabled' => false,
    'placeholder' => '',
])

<div class="flex flex-col space-y-1">
    @if($label)
        <label for="{{ $name ?: $attributes->get('wire:model') }}" class="text-sm font-medium text-gray-700">
            {{ $label }}
            @if($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif
    
    <input 
        type="date"
        id="{{ $name ?: $attributes->get('wire:model') }}"
        name="{{ $name }}"
        value="{{ $value }}"
        @if($required) required @endif
        @if($disabled) disabled @endif
        placeholder="{{ $placeholder }}"
        {{ $attributes->merge(['class' => 'block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500']) }}
    >
    
    @error($name ?: $attributes->get('wire:model'))
        <span class="text-sm text-red-600">{{ $message }}</span>
    @enderror
</div>
