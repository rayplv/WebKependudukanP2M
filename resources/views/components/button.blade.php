@props(['type' => 'button', 'variant' => 'primary'])

@php
    $class =
        'inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-offset-2 transition ease-in-out duration-150';

    switch ($variant) {
        case 'primary':
            $class .= ' bg-indigo-600 hover:bg-indigo-700 text-white focus:ring-indigo-500';
            break;
        case 'secondary':
            $class .= ' bg-gray-200 hover:bg-gray-300 text-gray-800 focus:ring-gray-500';
            break;
        case 'danger':
            $class .= ' bg-red-600 hover:bg-red-700 text-white focus:ring-red-500';
            break;
        case 'info':
            $class .= ' bg-blue-500 hover:bg-blue-600 text-white focus:ring-blue-500';
            break;
        default:
            $class .= ' bg-indigo-600 hover:bg-indigo-700 text-white focus:ring-indigo-500';
            break;
    }
@endphp

<button type="{{ $type }}" {{ $attributes->merge(['class' => $class]) }}>
    {{ $slot }}
</button>
