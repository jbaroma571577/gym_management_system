<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Gym Admin - Trainers</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-app text-white min-h-screen">

<div class="flex">

    <div class="w-64 h-screen bg-black/80 backdrop-blur-md p-5 border-r border-orange-500/20">
        <h1 class="text-orange-500 text-2xl font-bold mb-10">GYM SYSTEM</h1>
        <nav class="space-y-2">
            <a href="/admin/dashboard" class="block px-4 py-2 rounded-lg hover:text-orange-400 hover:bg-white/5 transition">Dashboard</a>
            <a href="{{ route('members.index') }}" class="block px-4 py-2 rounded-lg hover:text-orange-400 hover:bg-white/5 transition">Members</a>
            <a href="/admin/memberships" class="block px-4 py-2 rounded-lg hover:text-orange-400 hover:bg-white/5 transition">Memberships</a>
            <a href="/admin/payments" class="block px-4 py-2 rounded-lg hover:text-orange-400 hover:bg-white/5 transition">Payments</a>
            <a href="/admin/workouts" class="block px-4 py-2 rounded-lg hover:text-orange-400 hover:bg-white/5 transition">Workout Plans</a>
            <a href="/admin/trainers" class="block px-4 py-2 rounded-lg text-orange-400 bg-orange-500/20 border border-orange-500/30">Trainers</a>
        </nav>

        <form method="POST" action="/logout" class="mt-10">
            @csrf
            <button class="w-full text-red-500 hover:text-red-400 hover:bg-red-500/10 px-4 py-2 rounded-lg transition">Logout</button>
        </form>
    </div>

    <div class="flex-1 p-6">
        <h1 class="text-4xl font-bold text-orange-500 mb-8">Trainer Availability</h1>

        <div class="bg-white/10 backdrop-blur-md p-6 rounded-3xl border border-orange-500/30 shadow-sm shadow-orange-500/10">
            <p class="text-gray-300 mb-4">View all trainer accounts and their current availability status.</p>

            <div class="overflow-x-auto">
                <table class="min-w-full text-left text-gray-300 border-separate border-spacing-y-4">
                    <thead>
                        <tr class="text-gray-400 uppercase text-xs tracking-[0.2em]">
                            <th class="pb-4 px-3">Name</th>
                            <th class="pb-4 px-3">Email</th>
                            <th class="pb-4 px-3">Status</th>
                            <th class="pb-4 px-3">Members Assigned</th>
                            <th class="pb-4 px-3">Availability</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($trainers as $trainer)
                            <tr class="bg-black/40 rounded-3xl border border-white/5">
                                <td class="py-4 px-3">{{ $trainer->name }}</td>
                                <td class="py-4 px-3">{{ $trainer->email }}</td>
                                <td class="py-4 px-3 capitalize">{{ $trainer->role }}</td>
                                <td class="py-4 px-3">
                                    <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-500/10 text-blue-300">
                                        {{ $trainer->assigned_members_count ?? 0 }} member(s)
                                    </span>
                                </td>
                                <td class="py-4 px-3">
                                    @if($trainer->is_available)
                                        <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-500/10 text-emerald-300">Available</span>
                                    @else
                                        <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-red-500/10 text-red-300">Not Available</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-6 text-center text-gray-500">No trainers found yet. Create trainer users with role="trainer".</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

</body>
</html>
