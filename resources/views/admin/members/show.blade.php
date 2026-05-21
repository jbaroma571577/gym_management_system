<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Gym Admin - Member Details</title>
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
        <a href="{{ route('members.index') }}" class="block mb-4 text-orange-400">Members</a>
        <a href="/admin/memberships" class="block mb-4 hover:text-orange-400">Membership</a>
        <a href="/admin/payments" class="block mb-4 hover:text-orange-400">Payments</a>
        <a href="/admin/workouts" class="block mb-4 hover:text-orange-400">Workout Plans</a>

        <form method="POST" action="/logout">
            @csrf
            <button class="text-red-500 mt-10">Logout</button>
        </form>

    </div>

    <!-- MAIN -->
    <div class="flex-1 p-6">

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-orange-500">Member Details</h1>
            <div class="flex gap-3">
                <a href="{{ route('members.edit', $member) }}" class="bg-indigo-500 hover:bg-indigo-600 text-white px-4 py-2 rounded-lg">Edit</a>
                <a href="{{ route('members.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg">Back</a>
            </div>
        </div>

        <!-- MEMBER INFO -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <div class="bg-white/10 backdrop-blur-md p-5 rounded-2xl border border-orange-500/30">
                <h2 class="text-orange-400 font-bold mb-4">Basic Information</h2>
                <div class="space-y-3 text-gray-300">
                    <div>
                        <p class="text-gray-400 text-sm">ID</p>
                        <p class="font-medium">{{ $member->id }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400 text-sm">Name</p>
                        <p class="font-medium">{{ $member->user->name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400 text-sm">Email</p>
                        <p class="font-medium">{{ $member->user->email ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400 text-sm">Phone</p>
                        <p class="font-medium">{{ $member->phone ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400 text-sm">Fitness Goal</p>
                        <p class="text-orange-400 font-medium">{{ $member->goal ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400 text-sm">Joined</p>
                        <p class="font-medium">{{ $member->created_at->format('M d, Y') }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white/10 backdrop-blur-md p-5 rounded-2xl border border-orange-500/30">
                <h2 class="text-orange-400 font-bold mb-4">Related Information</h2>
                <div class="space-y-3 text-gray-300">
                    <div>
                        <p class="text-gray-400 text-sm">Membership Status</p>
                        <p class="font-medium">
                            @if($member->membership)
                                <span class="text-{{ $member->membership->status == 'active' ? 'green' : ($member->membership->status == 'pending' ? 'yellow' : 'red') }}-400">
                                    {{ ucfirst($member->membership->status) }}
                                </span>
                            @else
                                <span class="text-gray-400">No Membership</span>
                            @endif
                        </p>
                    </div>
                    <div>
                        <p class="text-gray-400 text-sm">Workout Plan</p>
                        <p class="font-medium">{{ $member->workoutPlan->program_type ?? 'Not Assigned' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400 text-sm">Attendance Sessions</p>
                        <p class="font-medium text-green-400">{{ $member->attendances->count() }} sessions</p>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>

</body>
</html>