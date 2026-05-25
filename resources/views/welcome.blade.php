<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', '65 Star Gym') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-gradient-to-br from-[#070707] via-[#120c0e] to-[#2a1419] text-white min-h-screen" style="background: radial-gradient(circle at top left, rgba(7,7,7,1), rgba(18,12,14,1) 30%, rgba(42,20,25,1) 100%); color: #f8fafc;">
        <div class="max-w-[1200px] mx-auto px-6 py-8 lg:px-10 lg:py-12" style="background-color: transparent;">
            <header class="flex items-center justify-between gap-6">
                <div>
                    <span class="text-sm uppercase tracking-[0.3em] text-[#f1b24a]">65 Star Gym</span>
                    <h1 class="mt-2 text-2xl lg:text-4xl font-semibold tracking-tight">Premium fitness for every member.</h1>
                </div>
                <nav class="flex items-center gap-3 text-sm lg:text-base">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="rounded-full bg-[#f1b24a] px-5 py-2 font-medium text-[#090909] shadow-lg shadow-[#f1b24a]/20 hover:bg-[#e7a72f] transition">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="rounded-full border border-white/20 bg-[#0d0f12]/90 px-5 py-2 text-white transition hover:bg-[#1b202b]" style="background-color: #0d0f12; color: #ffffff;">Log in</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="rounded-full bg-[#f1b24a] text-[#090909] px-5 py-2 font-medium shadow-lg shadow-[#f1b24a]/25 hover:bg-[#e7a72f] hover:text-[#090909] transition" style="background-color: #f1b24a; color: #090909;">Join now</a>
                            @endif
                        @endauth
                    @endif
                </nav>
            </header>

            <main class="mt-14 grid gap-12 lg:grid-cols-[1.2fr_0.8fr] lg:items-center">
                <section class="space-y-8">
                    <div class="max-w-xl">
                        <span class="inline-flex items-center rounded-full bg-[#1b1f26]/80 px-4 py-2 text-xs uppercase tracking-[0.35em] text-[#f1b24a]">Feel the power</span>
                        <h2 class="mt-6 text-4xl lg:text-5xl font-semibold tracking-tight leading-tight">Elite training, smart tracking, and a gym experience that feels like a luxury membership.</h2>
                        <p class="mt-6 text-base text-[#d5d5d5] max-w-xl">Discover your strongest self with access to attendance tracking, premium workout plans, membership management, and real-time progress insights.</p>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div class="rounded-3xl border border-white/10 bg-[#0d1015]/90 p-6 shadow-[0_25px_75px_-40px_rgba(241,178,74,0.8)]">
                            <p class="text-xl font-semibold">Live Attendance</p>
                            <p class="mt-3 text-sm text-[#d5d5d5]">Clock in, check your streak, and see your gym presence in one premium dashboard.</p>
                        </div>
                        <div class="rounded-3xl border border-white/10 bg-[#0d1015]/90 p-6 shadow-[0_25px_75px_-40px_rgba(241,178,74,0.8)]">
                            <p class="text-xl font-semibold">Membership Plans</p>
                            <p class="mt-3 text-sm text-[#d5d5d5]">Choose the right package with clear pricing and automatic payment history.</p>
                        </div>
                        <div class="rounded-3xl border border-white/10 bg-[#0d1015]/90 p-6 shadow-[0_25px_75px_-40px_rgba(241,178,74,0.8)]">
                            <p class="text-xl font-semibold">Workout Tracking</p>
                            <p class="mt-3 text-sm text-[#d5d5d5]">Personal workout plans help you stay focused, consistent, and in control.</p>
                        </div>
                        <div class="rounded-3xl border border-white/10 bg-[#0d1015]/90 p-6 shadow-[0_25px_75px_-40px_rgba(241,178,74,0.8)]">
                            <p class="text-xl font-semibold">Secure Access</p>
                            <p class="mt-3 text-sm text-[#d5d5d5]">Login, register, and manage your profile in a polished gym portal designed for members.</p>
                        </div>
                    </div>

                    <div class="flex flex-col gap-4 sm:flex-row">
                        <a href="{{ route('register') }}" class="inline-flex items-center justify-center rounded-full bg-[#f1b24a] px-8 py-3 text-sm font-semibold text-[#090909] shadow-lg shadow-[#f1b24a]/25 hover:bg-[#e7a72f] transition" style="background-color: #f1b24a; color: #090909;">Start membership</a>
                        <a href="{{ route('login') }}" class="inline-flex items-center justify-center rounded-full border border-[#f1b24a]/20 bg-[#10131a]/90 px-8 py-3 text-sm text-[#f1b24a] transition hover:bg-[#1f2630]" style="background-color: #10131a; color: #f1b24a;">View member login</a>
                    </div>

                    <div class="mt-6 rounded-3xl border border-white/10 bg-[#0f1012]/90 p-6 text-sm text-[#e5e7eb] shadow-lg shadow-black/30">
                        <h3 class="text-xl font-semibold text-[#f1b24a] mb-4">How to use the member portal</h3>
                        <div class="space-y-4">
                            <p><span class="font-semibold text-white">If you already have an account:</span> click the login button to open your gym dashboard and manage attendance, payments, and workout plans.</p>
                            <p><span class="font-semibold text-white">If you are new:</span> click Join now to register, choose a plan, and start tracking your membership immediately.</p>
                            <p><span class="font-semibold text-white">Need help?</span> Ask gym staff for membership setup or contact support to get your account ready.</p>
                        </div>
                    </div>
                </section>

                <section class="relative overflow-hidden rounded-[2rem] border border-white/10 bg-[#090909]/90 p-8 shadow-2xl shadow-black/40">
                    <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,_rgba(241,178,74,0.35),_transparent_40%)]"></div>
                    <div class="absolute inset-0 bg-[radial-gradient(circle_at_bottom_right,_rgba(255,255,255,0.12),_transparent_45%)]"></div>
                    <div class="relative z-10 flex flex-col gap-8">
                        <div>
                            <span class="text-sm uppercase tracking-[0.3em] text-[#f1b24a]">Featured plan</span>
                            <h3 class="mt-3 text-3xl font-semibold">Gold Elite Membership</h3>
                        </div>

                        <div class="rounded-[1.5rem] bg-[#111111]/90 p-6 border border-white/10">
                            <div class="flex items-end justify-between gap-6">
                                <div>
                                    <p class="text-sm uppercase tracking-[0.3em] text-[#f1b24a]">Monthly</p>
                                    <p class="mt-4 text-5xl font-semibold leading-none">₱2,499</p>
                                </div>
                                <span class="rounded-full bg-[#1b1f26]/80 px-4 py-2 text-xs uppercase tracking-[0.3em] text-[#f1b24a]">Best value</span>
                            </div>
                            <p class="mt-4 text-sm text-[#c3c3c3]">Includes unlimited gym access, full-plan tracking, and attendance analytics.</p>
                        </div>

                        <ul class="space-y-4 text-sm text-[#d5d5d5]">
                            <li class="flex items-start gap-3"><span class="mt-1 inline-flex h-2.5 w-2.5 rounded-full bg-[#f1b24a]"></span>Unlimited gym access</li>
                            <li class="flex items-start gap-3"><span class="mt-1 inline-flex h-2.5 w-2.5 rounded-full bg-[#f1b24a]"></span>Premium workout programming</li>
                            <li class="flex items-start gap-3"><span class="mt-1 inline-flex h-2.5 w-2.5 rounded-full bg-[#f1b24a]"></span>Attendance and payment history</li>
                            <li class="flex items-start gap-3"><span class="mt-1 inline-flex h-2.5 w-2.5 rounded-full bg-[#f1b24a]"></span>Secure member portal</li>
                        </ul>
                    </div>
                </section>
            </main>
        </div>
    </body>
</html>
