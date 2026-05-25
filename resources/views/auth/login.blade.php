<x-guest-layout>

    <!-- FIX: better outer spacing -->
    <div class="flex items-center justify-center min-h-screen px-4 py-20 sm:px-6 lg:px-10">

        <div class="w-full max-w-screen-xl mx-auto">

            <!-- FIX: grid spacing improved -->
            <div class="grid lg:grid-cols-[1.35fr_1fr] gap-16">

                <!-- LEFT: LOGIN -->
                <div class="overflow-hidden rounded-[32px] border border-white/10 bg-black/80 shadow-2xl min-h-[700px] flex flex-col">

                    <div class="bg-gradient-to-br from-orange-500 via-red-500 to-pink-500 px-10 py-14 text-white">

                        <p class="text-sm uppercase tracking-[0.32em] text-orange-100/80">
                            Premium Gym Portal
                        </p>

                        <h1 class="mt-6 text-4xl font-extrabold tracking-tight">
                            Welcome back, athlete.
                        </h1>

                        <p class="mt-4 max-w-xl text-gray-100/90">
                            Sign in to access your member dashboard, track attendance, manage your membership, and follow your workout plan.
                        </p>

                    </div>

                    <!-- FIX: increased padding -->
                    <div class="flex-1 p-10 lg:p-12 bg-[#090909]">

                        <x-auth-session-status class="mb-6" :status="session('status')" />

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <!-- FIX: more spacing between inputs -->
                            <div class="space-y-8">

                                <!-- EMAIL -->
                                <div>
                                    <x-input-label for="email" :value="__('Email')" class="text-gray-200" />

                                    <x-text-input
                                        id="email"
                                        class="block mt-3 w-full rounded-3xl border border-white/10 bg-black/80 px-5 py-4 text-white"
                                        type="email"
                                        name="email"
                                        :value="old('email')"
                                        required
                                        autofocus
                                    />

                                    <x-input-error :messages="$errors->get('email')" class="mt-3 text-sm text-red-400" />
                                </div>

                                <!-- PASSWORD -->
                                <div>
                                    <x-input-label for="password" :value="__('Password')" class="text-gray-200" />

                                    <x-text-input
                                        id="password"
                                        class="block mt-3 w-full rounded-3xl border border-white/10 bg-black/80 px-5 py-4 text-white"
                                        type="password"
                                        name="password"
                                        required
                                    />

                                    <x-input-error :messages="$errors->get('password')" class="mt-3 text-sm text-red-400" />
                                </div>

                                <!-- FIX: better spacing for options -->
                                <div class="flex items-center justify-between text-sm text-gray-300">

                                    <label class="flex items-center gap-2">
                                        <input type="checkbox" name="remember" class="rounded border-white/20 bg-black/80 text-orange-400">
                                        Remember me
                                    </label>

                                    @if (Route::has('password.request'))
                                        <a href="{{ route('password.request') }}" class="text-orange-300 hover:text-white transition">
                                            Forgot password?
                                        </a>
                                    @endif

                                </div>

                                <!-- FIX: button spacing -->
                                <button class="w-full py-4 rounded-3xl bg-orange-500 hover:bg-orange-400 font-semibold transition">
                                    Log in
                                </button>

                            </div>
                        </form>

                    </div>
                </div>

                <!-- RIGHT: INFO PANEL -->
                <div class="rounded-[32px] border border-white/10 bg-white/5 p-10 shadow-2xl backdrop-blur-xl text-gray-100">

                    <div class="space-y-6">

                        <div>
                            <p class="text-sm uppercase tracking-[0.3em] text-orange-400">
                                Gym system features
                            </p>

                            <h2 class="mt-4 text-3xl font-semibold text-white">
                                Manage your whole gym experience.
                            </h2>
                        </div>

                        <ul class="space-y-5">

                            <li class="flex gap-4 rounded-3xl bg-white/5 p-5 border border-white/10">
                                <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-orange-500/15 text-orange-300">
                                    ✓
                                </span>
                                <div>
                                    <p class="font-semibold text-white">Fast login</p>
                                    <p class="text-sm text-gray-400">Secure access for members and admins.</p>
                                </div>
                            </li>

                            <li class="flex gap-4 rounded-3xl bg-white/5 p-5 border border-white/10">
                                <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-orange-500/15 text-orange-300">
                                    🏋️
                                </span>
                                <div>
                                    <p class="font-semibold text-white">Workout planning</p>
                                    <p class="text-sm text-gray-400">Review personalized workout plans easily.</p>
                                </div>
                            </li>

                            <li class="flex gap-4 rounded-3xl bg-white/5 p-5 border border-white/10">
                                <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-orange-500/15 text-orange-300">
                                    📊
                                </span>
                                <div>
                                    <p class="font-semibold text-white">Live dashboard</p>
                                    <p class="text-sm text-gray-400">Track attendance and membership status.</p>
                                </div>
                            </li>

                        </ul>

                    </div>

                    <!-- CTA -->
                    <div class="mt-10 rounded-3xl bg-black/70 border border-white/10 p-6">

                        <p class="text-sm text-gray-400">New here?</p>

                        <h3 class="mt-3 text-xl font-semibold text-white">
                            Create your account now.
                        </h3>

                        <p class="mt-2 text-gray-400">
                            Join the gym portal and manage everything in one place.
                        </p>

                        <a href="{{ route('register') }}"
                           class="mt-6 inline-flex w-full justify-center rounded-3xl bg-orange-500 px-5 py-4 text-sm font-semibold text-black transition hover:bg-orange-400">
                            Create an account
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</x-guest-layout>