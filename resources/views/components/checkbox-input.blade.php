@props(['disabled' => false, 'checked' => false])

<input 
    type="checkbox" 
    x-data 
    @keydown.enter.prevent 
    {{ $disabled ? 'disabled' : '' }}
    {{ $checked ? 'checked' : '' }} 
    {!! $attributes->merge(['class' => 'appearance-none w-4 h-4 border border-gray-300 dark:border-gray-600 rounded mr-2 checked:bg-blue-500 checked:border-transparent dark:checked:bg-blue-400']) !!}>