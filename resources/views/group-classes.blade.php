<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Group Classes</title>
    <link rel="stylesheet" href="/build/assets/app.css">
</head>
<body class="bg-app text-white min-h-screen">
    <div class="bg-black/80 backdrop-blur-md p-4 border-b border-orange-500/30">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <h1 class="text-orange-500 text-2xl font-bold">Group Classes</h1>
            <div class="flex items-center gap-4">
                <span class="text-gray-400">{{ auth()->user()->name }}</span>
                <a href="/dashboard" class="text-sky-400 hover:text-sky-300">Dashboard</a>
            </div>
        </div>
    </div>

    <main class="max-w-5xl mx-auto p-6 space-y-6">
        <section class="bg-white/10 border border-slate-500/20 rounded-3xl p-6">
            <h2 class="text-3xl font-bold text-white mb-3">Group Classes</h2>
            <p class="text-gray-300">Attend our instructor-led group workouts. Premium and VIP members can join group sessions with priority access.</p>
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
                <h3 class="text-2xl font-semibold text-white mb-4">Available classes</h3>
                <div class="space-y-4">
                    <div class="rounded-3xl bg-white/5 border border-slate-700 p-4">
                        <p class="text-lg font-semibold text-white">Yoga Flow</p>
                        <p class="text-gray-300 mt-1">Wednesday 6:00 PM · Studio A</p>
                    </div>
                    <div class="rounded-3xl bg-white/5 border border-slate-700 p-4">
                        <p class="text-lg font-semibold text-white">HIIT Blast</p>
                        <p class="text-gray-300 mt-1">Friday 7:30 AM · Studio B</p>
                    </div>
                    <div class="rounded-3xl bg-white/5 border border-slate-700 p-4">
                        <p class="text-lg font-semibold text-white">Core & Mobility</p>
                        <p class="text-gray-300 mt-1">Saturday 10:00 AM · Studio C</p>
                    </div>
                </div>
            </section>
        @else
            <section class="bg-red-500/10 border border-red-500/30 rounded-3xl p-6">
                <h3 class="text-2xl font-semibold text-white mb-4">Classes not available</h3>
                <p class="text-gray-300 mb-4">{{ $statusMessage ?? 'Group classes require Premium or VIP membership status.' }}</p>
                <a href="/membership" class="inline-flex items-center justify-center bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded-lg font-medium transition">Upgrade or apply for membership</a>
            </section>
        @endif
    </main>
</body>
</html>
