<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Gym Admin - Members</title>
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
        <a href="#" class="block mb-4 text-orange-400">Members</a>
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
            <h1 class="text-3xl font-bold text-orange-500">Members Management</h1>
            <a href="{{ route('members.create') }}" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg">
                + Add Member
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- MEMBERS LIST -->
        <div class="bg-white/10 backdrop-blur-md p-5 rounded-2xl border border-orange-500/30">

            <h2 class="text-orange-400 font-bold mb-3">All Members</h2>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-gray-300">
                    <tr class="border-b border-white/10">
                        <th class="p-2">ID</th>
                        <th class="p-2">Name</th>
                        <th class="p-2">Phone</th>
                        <th class="p-2">Goal</th>
                        <th class="p-2">Trainer</th>
                        <th class="p-2">Actions</th>
                    </tr>

                    @forelse($members as $member)
                    <tr class="border-b border-white/5">
                        <td class="p-2">{{ $member->id }}</td>
                        <td class="p-2">{{ $member->user->name ?? 'N/A' }}</td>
                        <td class="p-2">{{ $member->phone ?? 'N/A' }}</td>
                        <td class="p-2 text-orange-400">{{ $member->goal ?? 'N/A' }}</td>
                        <td class="p-2">
                            @if($member->trainer)
                                <span class="text-green-400">{{ $member->trainer->name }}</span>
                            @else
                                <span class="text-gray-500">Unassigned</span>
                            @endif
                        </td>
                        <td class="p-2">
                            <a href="{{ route('members.show', $member) }}" class="text-blue-400 hover:text-blue-300 mr-3">View</a>
                            <a href="{{ route('members.edit', $member) }}" class="text-indigo-400 hover:text-indigo-300 mr-3">Edit</a>
                            <form method="POST" action="{{ route('members.destroy', $member) }}" class="inline" onsubmit="return confirm('Are you sure?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-400 hover:text-red-300">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="p-2 text-center text-gray-500">No members found.</td>
                    </tr>
                    @endforelse

                </table>
            </div>

        </div>

    </div>

</div>

</body>
</html>