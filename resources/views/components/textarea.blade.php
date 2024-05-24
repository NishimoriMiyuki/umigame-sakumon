@props(['disabled' => false])

<textarea 
    x-data
    x-init="$el.style.height = $el.scrollHeight + 'px'; $el.style.overflowY = 'hidden';"
    @input="$el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px';"
    {{ $disabled ? 'disabled' : '' }} 
    {!! $attributes->merge(['class' => 'resize-none border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm']) !!}
>{{ $slot }}</textarea>