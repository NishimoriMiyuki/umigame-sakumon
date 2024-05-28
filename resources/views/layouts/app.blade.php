<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
          [x-cloak] {
            display: none !important;
          }
        </style>
    </head>
    <body 
        class="font-sans antialiased"
        x-init="
            window.toast = function(message, options = {}){
                let description = '';
                let type = 'default';
                let position = 'top-center';
                let html = '';
                if(typeof options.description != 'undefined') description = options.description;
                if(typeof options.type != 'undefined') type = options.type;
                if(typeof options.position != 'undefined') position = options.position;
                if(typeof options.html != 'undefined') html = options.html;
                
                window.dispatchEvent(new CustomEvent('toast-show', { detail : { type: type, message: message, description: description, position : position, html: html }}));
            }

            window.customToastHTML = `
                <div class='relative flex items-start justify-center p-4'>
                    <img src='https://cdn.devdojo.com/images/august2023/headshot-new.jpeg' class='w-10 h-10 mr-2 rounded-full'>
                    <div class='flex flex-col'>
                        <p class='text-sm font-medium text-gray-800'>New Friend Request</p>
                        <p class='mt-1 text-xs leading-none text-gray-800'>Friend request from John Doe.</p>
                        <div class='flex mt-3'>
                            <button type='button' @click='burnToast(toast.id)' class='inline-flex items-center px-2 py-1 text-xs font-semibold text-white bg-indigo-600 rounded shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600'>Accept</button>
                            <button type='button' @click='burnToast(toast.id)' class='inline-flex items-center px-2 py-1 ml-3 text-xs font-semibold text-gray-900 bg-white rounded shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50'>Decline</button>
                        </div>
                    </div>
                </div>
            `
        ">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')
            @include('layouts.toast')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
        
        @if(session('type'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    let message;
                    const type = '{{ session('type', 'default') }}';
                    const description = '{{ session('description', '') }}';
                    
                    switch (type) 
                    {
                        case 'default':
                            message = '通知';
                            break;
                        case 'success':
                            message = '成功通知';
                            break;
                        case 'info':
                            message = '情報通知';
                            break;
                        case 'warning':
                            message = '警告通知';
                            break;
                        case 'danger':
                            message = '危険通知';
                            break;
                    }
                    
                    toast(message, { type: type, description: description });
                });
            </script>
        @endif
    </body>
</html>
