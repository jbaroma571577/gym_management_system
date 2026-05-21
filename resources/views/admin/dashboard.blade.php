<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Gym Admin Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * {
            color-scheme: dark;
        }
    </style>
</head>

<body class="bg-app text-white min-h-screen">

<div class="flex h-full">

    <!-- SIDEBAR -->
    <div class="w-64 h-screen bg-black/80 backdrop-blur-md p-5 border-r border-orange-500/20">

        <h1 class="text-orange-500 text-2xl font-bold mb-10">
            GYM SYSTEM
        </h1>

        <nav class="space-y-2">
            <a href="/admin/dashboard" class="block px-4 py-2 rounded-lg text-orange-400 bg-orange-500/20 border border-orange-500/30">Dashboard</a>
            <a href="{{ route('members.index') }}" class="block px-4 py-2 rounded-lg hover:text-orange-400 hover:bg-white/5 transition">Members</a>
            <a href="/admin/memberships" class="block px-4 py-2 rounded-lg hover:text-orange-400 hover:bg-white/5 transition">Memberships</a>
            <a href="/admin/payments" class="block px-4 py-2 rounded-lg hover:text-orange-400 hover:bg-white/5 transition">Payments</a>
            <a href="/admin/workouts" class="block px-4 py-2 rounded-lg hover:text-orange-400 hover:bg-white/5 transition">Workout Plans</a>
        </nav>

        <form method="POST" action="/logout" class="mt-10">
            @csrf
            <button class="w-full text-red-500 hover:text-red-400 hover:bg-red-500/10 px-4 py-2 rounded-lg transition">Logout</button>
        </form>

    </div>

    <!-- MAIN -->
    <div class="flex-1 p-6">

        <h1 class="text-4xl font-bold text-orange-500 mb-8">
            Dashboard
        </h1>

        <!-- STATS CARDS -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">

            <div class="bg-white/10 backdrop-blur-md p-6 rounded-2xl border border-orange-500/30 hover:border-orange-500/60 transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm mb-2">Total Members</p>
                        <p class="text-3xl font-bold text-orange-400">{{ \App\Models\Member::count() ?? 0 }}</p>
                    </div>
                    <div class="text-orange-500/30 text-4xl">👥</div>
                </div>
                <p class="text-gray-500 text-xs mt-3">Active gym members</p>
            </div>

            <div class="bg-white/10 backdrop-blur-md p-6 rounded-2xl border border-orange-500/30 hover:border-orange-500/60 transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm mb-2">Active Memberships</p>
                        <p class="text-3xl font-bold text-green-400">{{ \App\Models\Membership::where('status', 'active')->count() ?? 0 }}</p>
                    </div>
                    <div class="text-green-500/30 text-4xl">✓</div>
                </div>
                <p class="text-gray-500 text-xs mt-3">Current active plans</p>
            </div>

            <div class="bg-white/10 backdrop-blur-md p-6 rounded-2xl border border-orange-500/30 hover:border-orange-500/60 transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm mb-2">Pending Approvals</p>
                        <p class="text-3xl font-bold text-yellow-400">{{ \App\Models\Membership::where('status', 'pending')->count() ?? 0 }}</p>
                    </div>
                    <div class="text-yellow-500/30 text-4xl">⏳</div>
                </div>
                <p class="text-gray-500 text-xs mt-3">Waiting for review</p>
            </div>

            <div class="bg-white/10 backdrop-blur-md p-6 rounded-2xl border border-orange-500/30 hover:border-orange-500/60 transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm mb-2">Today's Attendance</p>
                        <p class="text-3xl font-bold text-blue-400">{{ \App\Models\Attendance::whereDate('created_at', \Carbon\Carbon::today())->count() ?? 0 }}</p>
                    </div>
                    <div class="text-blue-500/30 text-4xl">📍</div>
                </div>
                <p class="text-gray-500 text-xs mt-3">Check-ins today</p>
            </div>

        </div>

        <!-- QUICK ACTIONS -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

            <a href="{{ route('members.index') }}" class="bg-white/10 backdrop-blur-md p-6 rounded-2xl border border-orange-500/30 hover:border-orange-500/60 hover:bg-white/15 transition">
                <h2 class="text-orange-400 font-bold text-lg mb-2">👥 Members</h2>
                <p class="text-gray-300 text-sm">Manage and view all gym members</p>
                <p class="text-orange-500 text-xs mt-3">→ View Members</p>
            </a>

            <a href="{{ route('members.create') }}" class="bg-white/10 backdrop-blur-md p-6 rounded-2xl border border-orange-500/30 hover:border-orange-500/60 hover:bg-white/15 transition">
                <h2 class="text-orange-400 font-bold text-lg mb-2">➕ Add Member</h2>
                <p class="text-gray-300 text-sm">Register a new member to system</p>
                <p class="text-orange-500 text-xs mt-3">→ Create New</p>
            </a>

            <a href="/admin/memberships" class="bg-white/10 backdrop-blur-md p-6 rounded-2xl border border-orange-500/30 hover:border-orange-500/60 hover:bg-white/15 transition">
                <h2 class="text-orange-400 font-bold text-lg mb-2">📋 Memberships</h2>
                <p class="text-gray-300 text-sm">Approve or reject applications</p>
                <p class="text-orange-500 text-xs mt-3">→ Manage Requests</p>
            </a>

        </div>

        <!-- RECENT MEMBERS TABLE -->
        <div class="bg-white/10 backdrop-blur-md p-6 rounded-2xl border border-orange-500/30">

            <div class="flex justify-between items-center mb-4">
                <h2 class="text-orange-400 font-bold text-lg">Recent Members</h2>
                <a href="{{ route('members.index') }}" class="text-orange-500 hover:text-orange-400 text-sm">View All →</a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-gray-300">
                    <thead>
                        <tr class="border-b border-orange-500/30">
                            <th class="p-3 text-orange-400 font-bold">Name</th>
                            <th class="p-3 text-orange-400 font-bold">Email</th>
                            <th class="p-3 text-orange-400 font-bold">Phone</th>
                            <th class="p-3 text-orange-400 font-bold">Goal</th>
                            <th class="p-3 text-orange-400 font-bold">Joined</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse(\App\Models\Member::with('user')->latest()->take(5)->get() as $member)
                            <tr class="border-b border-white/5 hover:bg-white/5 transition">
                                <td class="p-3 font-medium">{{ $member->user->name }}</td>
                                <td class="p-3">{{ $member->user->email }}</td>
                                <td class="p-3">{{ $member->phone ?? '-' }}</td>
                                <td class="p-3"><span class="text-orange-400">{{ $member->goal ?? 'Not Set' }}</span></td>
                                <td class="p-3 text-gray-500">{{ $member->created_at->format('M d, Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-8 text-center text-gray-500">No members found</td>
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