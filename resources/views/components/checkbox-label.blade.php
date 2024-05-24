@props(['value'])

<label {{ $attributes->merge(['class' => 'text-gray-700 dark:text-gray-300 flex items-center cursor-pointer']) }}>
    {{ $value ?? $slot }}
</label>