<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trainer Booking</title>
    <link rel="stylesheet" href="/build/assets/app.css">
</head>
<body class="bg-app text-white min-h-screen">
    <div class="bg-black/80 backdrop-blur-md p-4 border-b border-orange-500/30">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <h1 class="text-orange-500 text-2xl font-bold">Trainer Booking</h1>
            <div class="flex items-center gap-4">
                <span class="text-gray-400">{{ auth()->user()->name }}</span>
                <a href="/dashboard" class="text-sky-400 hover:text-sky-300">Dashboard</a>
            </div>
        </div>
    </div>

    <main class="max-w-5xl mx-auto p-6 space-y-6">
        <section class="bg-white/10 border border-slate-500/20 rounded-3xl p-6">
            <h2 class="text-3xl font-bold text-white mb-3">Trainer Sessions</h2>
            <p class="text-gray-300">Premium and VIP members can book trainer sessions directly from this page.</p>
        </section>

        <section class="bg-white/10 border border-slate-500/20 rounded-3xl p-6">
            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <p class="text-sm text-gray-400">Current plan</p>
                    <p class="mt-2 text-xl font-semibold text-white">{{ $membership ? $membership->plan : 'No membership' }}</p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-400">Status</p>
                    <p class="mt-2 text-xl font-semibold text-white">{{ $membership ? ucfirst($membership->status) : 'Inactive' }}</p>
                </div>
            </div>
        </section>

        @if($allowed)
            <section class="bg-slate-900/80 border border-slate-700 rounded-3xl p-6">
                <h3 class="text-2xl font-semibold text-white mb-4">Book a trainer session</h3>
                <p class="text-gray-300 mb-4">You can schedule a trainer session up to twice per month with your {{ $membership->plan }} plan.</p>
                <div class="grid gap-4 sm:grid-cols-2">
                    <div class="rounded-3xl bg-white/5 border border-slate-700 p-4">
                        <p class="text-sm uppercase tracking-[0.3em] text-gray-400">Available slots</p>
                        <ul class="mt-3 text-gray-300 list-disc list-inside space-y-2">
                            <li>Monday 6:00 PM</li>
                            <li>Wednesday 7:00 PM</li>
                            <li>Friday 5:00 PM</li>
                        </ul>
                    </div>
                    <div class="rounded-3xl bg-white/5 border border-slate-700 p-4">
                        <p class="text-sm uppercase tracking-[0.3em] text-gray-400">Next steps</p>
                        <p class="mt-3 text-gray-300">Choose a session and confirm with gym staff. Your membership plan already grants you trainer booking access.</p>
                    </div>
                </div>
            </section>
        @else
            <section class="bg-red-500/10 border border-red-500/30 rounded-3xl p-6">
                <h3 class="text-2xl font-semibold text-white mb-4">Booking not available</h3>
                <p class="text-gray-300 mb-4">{{ $statusMessage ?? 'Trainer booking is reserved for Premium and VIP members.' }}</p>
                <a href="/membership" class="inline-flex items-center justify-center bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded-lg font-medium transition">Upgrade or apply for membership</a>
            </section>
        @endif
    </main>
</body>
</html>
