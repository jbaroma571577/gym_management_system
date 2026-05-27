<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Gym Admin - Memberships</title>
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
        <a href="#" class="block mb-4 text-orange-400">Membership</a>
        <a href="/admin/payments" class="block mb-4 hover:text-orange-400">Payments</a>
        <a href="/admin/workouts" class="block mb-4 hover:text-orange-400">Workout Plans</a>

        <form method="POST" action="/logout">
            @csrf
            <button class="text-red-500 mt-10">Logout</button>
        </form>

    </div>

    <!-- MAIN -->
    <div class="flex-1 p-6">

        <h1 class="text-3xl font-bold text-orange-500 mb-6">
            Membership Management
        </h1>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- MEMBERSHIP LIST -->
        <div class="bg-white/10 backdrop-blur-md p-5 rounded-2xl border border-orange-500/30">

            <h2 class="text-orange-400 font-bold mb-3">Membership Applications</h2>

            <table class="w-full text-left text-gray-300">
                <tr class="border-b border-white/10">
                    <th class="p-2">Member</th>
                    <th class="p-2">Email</th>
                    <th class="p-2">Plan</th>
                    <th class="p-2">Status</th>
                    <th class="p-2">Expires</th>
                    <th class="p-2">Applied Date</th>
                    <th class="p-2">Actions</th>
                </tr>

                @forelse($memberships as $membership)
                <tr class="border-b border-white/5">
                    <td class="p-2">{{ $membership->member->user->name ?? 'N/A' }}</td>
                    <td class="p-2 text-gray-300">{{ $membership->member->user->email ?? '-' }}</td>
                    <td class="p-2">
                        @php
                            $planData = \App\Models\Membership::planDetails()[$membership->plan] ?? null;
                        @endphp
                        <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold {{ $planData['badge_class'] ?? 'bg-slate-500/15 text-slate-300' }}">
                            {{ $membership->plan }}
                        </span>
                    </td>
                    <td class="p-2">
                        @if($membership->status == 'pending')
                            <span class="text-yellow-400">Pending</span>
                        @elseif($membership->status == 'active')
                            <span class="text-green-400">Active</span>
                        @else
                            <span class="text-red-400">{{ ucfirst($membership->status) }}</span>
                        @endif
                    </td>
                    <td class="p-2">{{ $membership->expires_at ? $membership->expires_at->format('M d, Y') : 'TBD' }}</td>
                    <td class="p-2">{{ $membership->created_at->format('M d, Y') }}</td>
                    <td class="p-2">
                        @if($membership->status == 'pending')
                            <form method="POST" action="/membership/{{ $membership->id }}/activate" class="inline">
                                @csrf
                                <button type="submit" class="bg-green-500 hover:bg-green-600 px-3 py-1 rounded text-sm mr-2 text-white transition">Approve</button>
                            </form>
                            <form method="POST" action="/membership/{{ $membership->id }}/reject" class="inline">
                                @csrf
                                <button type="submit" class="bg-red-500 hover:bg-red-600 px-3 py-1 rounded text-sm text-white transition">Reject</button>
                            </form>
                        @elseif($membership->status == 'active')
                            <form method="POST" action="/membership/{{ $membership->id }}/change-plan" class="flex items-center gap-2">
                                @csrf
                                <select name="plan" class="bg-black/40 border border-white/10 text-white rounded-lg p-2 text-sm">
                                    @foreach(['Basic', 'Premium', 'VIP'] as $plan)
                                        <option value="{{ $plan }}" {{ $membership->plan === $plan ? 'selected' : '' }}>{{ $plan }}</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="bg-indigo-500 hover:bg-indigo-600 px-3 py-1 rounded text-sm text-white transition">Update</button>
                            </form>
                        @else
                            <span class="text-gray-500">No actions</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="p-2 text-center text-gray-500">No membership applications found.</td>
                </tr>
                @endforelse

            </table>

        </div>

    </div>

</div>

</body>
</html>