<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased overflow-hidden">
        
        <video autoplay loop muted playsinline class="fixed inset-0 w-full h-full object-cover z-0">
            <source src="{{ asset('videos/background.mp4') }}" type="video/mp4">
        </video>

        <div class="fixed inset-0 bg-black/60 z-0"></div>

        <div class="relative min-h-screen flex flex-col sm:justify-center items-center pt-2 sm:pt-0 z-10">
            
            <div class="mb-2 mt-4 sm:mt-0">
                <a href="/" class="flex flex-col items-center group">
                    <x-application-logo class="w-16 h-16 fill-current text-white drop-shadow-2xl transition-transform group-hover:scale-110" />
                    <span class="text-white font-bold text-xl mt-1 tracking-wider drop-shadow-md">WIRA SYSTEM</span>
                </a>
            </div>

            <div class="w-full sm:max-w-md px-6 py-6 bg-white/90 backdrop-blur-md shadow-2xl overflow-hidden sm:rounded-xl border-t-4 border-red-600">
                {{ $slot }}
            </div>

            <div class="mt-4 mb-4 text-gray-400 text-sm font-light">
                &copy; {{ date('Y') }} Wira Toyota Body & Paint
            </div>
        </div>
    </body>
</html>