<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Gym Admin - Payments</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-app text-white min-h-screen">

<div class="flex">

    <!-- SIDEBAR -->
    <div class="w-64 h-screen bg-black/80 backdrop-blur-md p-5">

        <h1 class="text-orange-500 text-2xl font-bold mb-10">
            GYM SYSTEM
        </h1>

        <a href="/admin/dashboard" class="block mb-4 hover:text-orange-400">Dashboard</a>
        <a href="{{ route('members.index') }}" class="block mb-4 hover:text-orange-400">Members</a>
        <a href="/admin/memberships" class="block mb-4 hover:text-orange-400">Membership</a>
        <a href="#" class="block mb-4 text-orange-400">Payments</a>
        <a href="/admin/workouts" class="block mb-4 hover:text-orange-400">Workout Plans</a>

        <form method="POST" action="/logout">
            @csrf
            <button class="text-red-500 mt-10">Logout</button>
        </form>

    </div>

    <!-- MAIN -->
    <div class="flex-1 p-6">

        <h1 class="text-3xl font-bold text-orange-500 mb-6">
            Payment Management
        </h1>

        <!-- PAYMENT LIST -->
        <div class="bg-white/10 backdrop-blur-md p-5 rounded-2xl border border-orange-500/30">

            <h2 class="text-orange-400 font-bold mb-3">Pending Payments</h2>

            <table class="w-full text-left text-gray-300">
                <tr class="border-b border-white/10">
                    <th class="p-2">Member</th>
                    <th class="p-2">Plan</th>
                    <th class="p-2">Payment Method</th>
                    <th class="p-2">Reference</th>
                    <th class="p-2">Status</th>
                </tr>

                @forelse($memberships as $membership)
                <tr class="border-b border-white/5">
                    <td class="p-2">{{ $membership->member->user->name ?? 'N/A' }}</td>
                    <td class="p-2">{{ $membership->plan }}</td>
                    <td class="p-2">{{ ucfirst($membership->payment_method) }}</td>
                    <td class="p-2">{{ $membership->reference_number ?? '—' }}</td>
                    <td class="p-2">
                        @if($membership->status == 'pending')
                            <span class="text-yellow-400">Pending</span>
                        @elseif($membership->status == 'active')
                            <span class="text-green-400">Active</span>
                        @else
                            <span class="text-red-400">{{ ucfirst($membership->status) }}</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-2 text-center text-gray-500">No payments found.</td>
                </tr>
                @endforelse
</div>

</body>
</html>