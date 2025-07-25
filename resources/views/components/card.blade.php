<div
    {{ $attributes->merge(['class' => 'rounded-lg shadow-md p-6'])->class(['bg-white' => !$attributes->has('class') || !str_contains($attributes->get('class'), 'bg-')]) }}>
    {{ $slot }}
</div>
