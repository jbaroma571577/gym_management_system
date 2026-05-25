<x-guest-layout>

    <!-- FIX: better outer spacing -->
    <div class="grid gap-16 lg:grid-cols-[1.35fr_1fr] w-full max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-10 py-20">

        <!-- LEFT SIDE -->
        <div class="overflow-hidden rounded-[32px] border border-white/10 bg-black/80 shadow-2xl min-h-[700px] flex flex-col">

            <div class="bg-gradient-to-br from-orange-500 via-red-500 to-pink-500 px-10 py-14 text-white">
                <p class="text-sm uppercase tracking-[0.32em] text-orange-100/80">
                    Premium Gym Portal
                </p>

                <h1 class="mt-6 text-4xl font-extrabold tracking-tight">
                    Create your fitness account.
                </h1>

                <p class="mt-4 max-w-xl text-gray-100/90">
                    Register now to manage your membership, workouts, attendance, and premium gym services.
                </p>
            </div>

            <!-- FIX: increased padding + spacing -->
            <div class="flex-1 p-10 lg:p-12 bg-[#090909]">

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- FIX: more spacing between inputs -->
                    <div class="space-y-8">

                        <div>
                            <x-input-label for="name" :value="__('Name')" class="text-gray-200" />
                            <x-text-input id="name"
                                class="block mt-3 w-full rounded-3xl border border-white/10 bg-black/80 px-5 py-4 text-white"
                                type="text" name="name" :value="old('name')" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2 text-sm text-red-400" />
                        </div>

                        <div>
                            <x-input-label for="email" :value="__('Email')" class="text-gray-200" />
                            <x-text-input id="email"
                                class="block mt-3 w-full rounded-3xl border border-white/10 bg-black/80 px-5 py-4 text-white"
                                type="email" name="email" :value="old('email')" required />
                            <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-400" />
                        </div>

                        <div>
                            <x-input-label for="password" :value="__('Password')" class="text-gray-200" />
                            <x-text-input id="password"
                                class="block mt-3 w-full rounded-3xl border border-white/10 bg-black/80 px-5 py-4 text-white"
                                type="password" name="password" required />
                            <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-400" />
                        </div>

                        <div>
                            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-gray-200" />
                            <x-text-input id="password_confirmation"
                                class="block mt-3 w-full rounded-3xl border border-white/10 bg-black/80 px-5 py-4 text-white"
                                type="password" name="password_confirmation" required />
                        </div>

                        <!-- FIX: better spacing for buttons -->
                        <div class="flex flex-col gap-4">

                            <a class="text-sm text-orange-300 hover:text-white transition" href="{{ route('login') }}">
                                {{ __('Already registered?') }}
                            </a>

                            <x-primary-button class="w-full py-4 rounded-3xl bg-orange-500 hover:bg-orange-400 transition">
                                {{ __('Register') }}
                            </x-primary-button>

                        </div>

                    </div>
                </form>

            </div>
        </div>

        <!-- RIGHT SIDE -->
        <div class="rounded-[32px] border border-white/10 bg-white/5 p-10 shadow-2xl backdrop-blur-xl text-gray-100">

            <div class="space-y-6">

                <div>
                    <p class="text-sm uppercase tracking-[0.3em] text-orange-400">
                        Why join 65 Star Gym?
                    </p>

                    <h2 class="mt-4 text-3xl font-semibold text-white">
                        Your gym system, reimagined.
                    </h2>
                </div>

                <ul class="space-y-5">

                    <li class="flex gap-4 rounded-3xl bg-white/5 p-5 border border-white/10">
                        <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-orange-500/15 text-orange-300">🏋️</span>
                        <div>
                            <p class="font-semibold text-white">Track your workouts</p>
                            <p class="text-sm text-gray-400">Personalized workout plans and performance logging.</p>
                        </div>
                    </li>

                    <li class="flex gap-4 rounded-3xl bg-white/5 p-5 border border-white/10">
                        <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-orange-500/15 text-orange-300">💳</span>
                        <div>
                            <p class="font-semibold text-white">Manage memberships</p>
                            <p class="text-sm text-gray-400">Stay on top of your active plan and billing status.</p>
                        </div>
                    </li>

                    <li class="flex gap-4 rounded-3xl bg-white/5 p-5 border border-white/10">
                        <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-orange-500/15 text-orange-300">📍</span>
                        <div>
                            <p class="font-semibold text-white">Check-ins & attendance</p>
                            <p class="text-sm text-gray-400">See your daily gym activity and progress at a glance.</p>
                        </div>
                    </li>

                </ul>

            </div>

            <div class="mt-10 rounded-3xl bg-black/70 border border-white/10 p-6">

                <p class="text-sm text-gray-400">Already a member?</p>

                <h3 class="mt-3 text-xl font-semibold text-white">
                    Sign in anytime.
                </h3>

                <p class="mt-2 text-gray-400">
                    Use login to access your dashboard.
                </p>

                <a href="{{ route('login') }}"
                   class="mt-6 inline-flex w-full justify-center rounded-3xl bg-orange-500 px-5 py-4 text-sm font-semibold text-black transition hover:bg-orange-400">
                    Log in
                </a>

            </div>

        </div>

    </div>

</x-guest-layout>