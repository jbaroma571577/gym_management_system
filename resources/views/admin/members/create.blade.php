<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Gym Admin - Add Member</title>
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

        <h1 class="text-3xl font-bold text-orange-500 mb-6">Add New Member</h1>

        <!-- FORM -->
        <div class="bg-white/10 backdrop-blur-md p-5 rounded-2xl border border-orange-500/30 max-w-2xl">

            <form method="POST" action="{{ route('members.store') }}">
                @csrf

                <div class="mb-4">
                    <label class="block text-orange-400 mb-2">User</label>
                    <select name="user_id" id="user_id" class="w-full p-3 bg-black/40 border border-white/10 rounded-lg text-white" required>
                        <option value="">Select User</option>
                        @foreach(\App\Models\User::all() as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                        @endforeach
                    </select>
                    @if($errors->has('user_id'))
                        <p class="text-red-400 mt-2">{{ $errors->first('user_id') }}</p>
                    @endif
                </div>

                <div class="mb-4">
                    <label class="block text-orange-400 mb-2">Phone</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" class="w-full p-3 bg-black/40 border border-white/10 rounded-lg text-white" required>
                    @if($errors->has('phone'))
                        <p class="text-red-400 mt-2">{{ $errors->first('phone') }}</p>
                    @endif
                </div>

                <div class="mb-4">
                    <label class="block text-orange-400 mb-2">Fitness Goal</label>
                    <select name="goal" id="goal" class="w-full p-3 bg-black/40 border border-white/10 rounded-lg text-white">
                        <option value="">Select Goal</option>
                        <option value="Fat Loss Program">Fat Loss Program</option>
                        <option value="Muscle Building Program">Muscle Building Program</option>
                        <option value="Body Recomposition Program">Body Recomposition Program</option>
                        <option value="Health and Endurance Program">Health and Endurance Program</option>
                        <option value="Discipline and Lifestyle Change Program">Discipline and Lifestyle Change Program</option>
                    </select>
                    @if($errors->has('goal'))
                        <p class="text-red-400 mt-2">{{ $errors->first('goal') }}</p>
                    @endif
                </div>

                <div class="mb-4">
                    <label class="block text-orange-400 mb-2">Assign Trainer (Optional)</label>
                    <select name="trainer_id" id="trainer_id" class="w-full p-3 bg-black/40 border border-white/10 rounded-lg text-white">
                        <option value="">No Trainer Assigned</option>
                        @forelse($availableTrainers as $trainer)
                            <option value="{{ $trainer->id }}">{{ $trainer->name }} (Available)</option>
                        @empty
                            <option value="" disabled>No available trainers</option>
                        @endforelse
                    </select>
                    @if($errors->has('trainer_id'))
                        <p class="text-red-400 mt-2">{{ $errors->first('trainer_id') }}</p>
                    @endif
                </div>

                <div class="flex items-center justify-end gap-4">
                    <a href="{{ route('members.index') }}" class="text-gray-400 hover:text-gray-300">Cancel</a>
                    <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg">
                        Create Member
                    </button>
                </div>
            </form>

        </div>

    </div>

</div>

</body>
</html>