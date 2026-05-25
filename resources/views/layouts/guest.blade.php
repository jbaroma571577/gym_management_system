<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Laravel'))</title>

    <!-- Theme -->
    <meta name="theme-color" content="#000000">

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Vite CSS only for guest pages -->
    @vite(['resources/css/app.css'])

    <!-- Page-specific styles -->
    @stack('styles')
</head>

<body class="font-sans text-white antialiased bg-app min-h-screen relative">

    <!-- Background Overlay -->
    <div class="absolute inset-0 bg-black/75"></div>

    <!-- Main Content -->
    <div class="relative min-h-screen flex flex-col justify-center items-center px-4 py-10">

        <div class="w-full sm:max-w-md bg-black/70 border border-orange-500/20 shadow-2xl backdrop-blur-xl rounded-[32px] overflow-hidden">

            <!-- Header -->
            <div class="p-6 border-b border-orange-500/10 bg-black/60 text-center">
                <h1 class="text-3xl font-extrabold tracking-tight text-orange-400">
                    GYM PORTAL
                </h1>
                <p class="mt-2 text-sm text-gray-300">
                    Secure sign in or create your account with a premium fitness style
                </p>
            </div>

            <!-- Page Content -->
            <div class="px-6 py-8">
                {{ $slot }}
            </div>

        </div>
    </div>

    <!-- Page-specific scripts -->
    @stack('scripts')

</body>
</html>