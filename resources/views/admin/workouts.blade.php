<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Gym Admin - Workout Plans</title>
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
        <a href="/admin/payments" class="block mb-4 hover:text-orange-400">Payments</a>
        <a href="#" class="block mb-4 text-orange-400">Workout Plans</a>

        <form method="POST" action="/logout">
            @csrf
            <button class="text-red-500 mt-10">Logout</button>
        </form>

    </div>

    <!-- MAIN -->
    <div class="flex-1 p-6">

        <h1 class="text-3xl font-bold text-orange-500 mb-6">
            Workout Plan Management
        </h1>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- ASSIGN FORM -->
        <div class="bg-white/10 backdrop-blur-md p-5 rounded-2xl border border-orange-500/30 mb-6">

            <h2 class="text-orange-400 font-bold mb-3">Assign Workout Program</h2>

            <form method="POST" action="/admin/workouts">
                @csrf

                <select name="member_id" class="w-full mb-3 p-3 bg-black/40 border border-white/10 rounded-lg" required>
                    <option value="">Select Member</option>
                    @foreach($members as $member)
                        <option value="{{ $member->id }}">{{ optional($member->user)->name ?? 'Member ' . $member->id }}</option>
                    @endforeach
                </select>

                <select name="program_type" class="w-full mb-3 p-3 bg-black/40 border border-white/10 rounded-lg" required>
                    <option value="">Select Program</option>
                    <option value="Fat Loss Program">Fat Loss Program</option>
                    <option value="Muscle Building Program">Muscle Building Program</option>
                    <option value="Body Recomposition Program">Body Recomposition Program</option>
                    <option value="Health and Endurance Program">Health and Endurance Program</option>
                    <option value="Discipline and Lifestyle Change Program">Discipline and Lifestyle Change Program</option>
                </select>

                <textarea name="description" placeholder="Workout description/details" class="w-full mb-3 p-3 bg-black/40 border border-white/10 rounded-lg" rows="4" required></textarea>

                <button class="bg-orange-500 px-4 py-2 rounded-lg">
                    Assign Program
                </button>
            </form>

        </div>

        <!-- LIST -->
        <div class="bg-white/10 backdrop-blur-md p-5 rounded-2xl border border-orange-500/30">

            <h2 class="text-orange-400 font-bold mb-3">Assigned Programs</h2>

            <table class="w-full text-left text-gray-300">
                <tr class="border-b border-white/10">
                    <th class="p-2">Member</th>
                    <th class="p-2">Program</th>
                    <th class="p-2">Description</th>
                    <th class="p-2">Assigned Date</th>
                </tr>

                @forelse($plans as $plan)
                <tr class="border-b border-white/5">
                    <td class="p-2">{{ optional($plan->member->user)->name ?? 'N/A' }}</td>
                    <td class="p-2 text-orange-400">{{ $plan->program_type }}</td>
                    <td class="p-2">{{ \Illuminate\Support\Str::limit($plan->description, 50) }}</td>
                    <td class="p-2">{{ $plan->created_at->format('M d, Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="p-2 text-center text-gray-500">No workout plans assigned yet.</td>
                </tr>
                @endforelse

            </table>

        </div>

    </div>

</div>

</body>
</html>