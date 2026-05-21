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
    </head>
    <body class="font-sans text-white antialiased bg-app">
        <div class="min-h-screen relative overflow-hidden">
            <div class="absolute inset-0 bg-black/75"></div>

            <div class="relative min-h-screen flex flex-col justify-center items-center px-4 py-10">
                <div class="w-full sm:max-w-md bg-black/70 border border-orange-500/20 shadow-2xl backdrop-blur-xl rounded-[32px] overflow-hidden">
                    <div class="p-6 border-b border-orange-500/10 bg-black/60 text-center">
                        <h1 class="text-3xl font-extrabold tracking-tight text-orange-400">GYM PORTAL</h1>
                        <p class="mt-2 text-sm text-gray-300">Secure sign in or create your account with a premium fitness style</p>
                    </div>
                    <div class="px-6 py-8">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
