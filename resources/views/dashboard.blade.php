<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Member Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-app text-white min-h-screen">

<!-- TOP NAV -->
<div class="bg-black/80 backdrop-blur-md p-4 border-b border-orange-500/30">
    <div class="max-w-7xl mx-auto flex justify-between items-center">
        <h1 class="text-orange-500 text-2xl font-bold">GYM MEMBER</h1>
        <div class="flex items-center gap-4">
            <span class="text-gray-400">{{ auth()->user()->name }}</span>
            <form method="POST" action="/logout" style="display: inline;">
                @csrf
                <button class="text-red-500 hover:text-red-600">Logout</button>
            </form>
        </div>
    </div>
</div>

<!-- MAIN CONTENT -->
<div class="max-w-7xl mx-auto p-6">
    <h2 class="text-3xl font-bold text-orange-500 mb-6">Dashboard</h2>

    <!-- CARDS GRID -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- MEMBERSHIP STATUS -->
        <div class="bg-white/10 backdrop-blur-md p-6 rounded-2xl border border-orange-500/30">
            <h3 class="text-orange-400 font-bold mb-4">Membership Status</h3>
            @if(auth()->user()->member && auth()->user()->member->membership)
                <div class="space-y-3">
                    <div>
                        <p class="text-gray-400 text-sm">Plan</p>
                        <p class="text-green-400 font-medium">{{ auth()->user()->member->membership->plan }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400 text-sm">Status</p>
                        <p class="font-medium text-green-400">{{ ucfirst(auth()->user()->member->membership->status) }}</p>
                    </div>
                </div>
            @else
                <p class="text-gray-400 mb-4">No active membership</p>
                <a href="{{ route('membership') }}" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg inline-block">Apply Now</a>
            @endif
        </div>

        <!-- ATTENDANCE -->
        <div class="bg-white/10 backdrop-blur-md p-6 rounded-2xl border border-orange-500/30">
            <h3 class="text-orange-400 font-bold mb-4">Recent Attendance</h3>
            @if(auth()->user()->member)
                <div class="space-y-3">
                    <div>
                        <p class="text-gray-400 text-sm">Sessions This Month</p>
                        <p class="text-green-400 font-medium text-2xl">{{ auth()->user()->member->attendances->count() }}</p>
                    </div>
                    <a href="{{ url('/attendance') }}" class="text-orange-400 hover:text-orange-300">View Details →</a>
                </div>
            @else
                <p class="text-gray-400">No data available</p>
            @endif
        </div>

        <!-- WORKOUT PLAN -->
        <div class="bg-white/10 backdrop-blur-md p-6 rounded-2xl border border-orange-500/30">
            <h3 class="text-orange-400 font-bold mb-4">Workout Plan</h3>
            @if(auth()->user()->member && auth()->user()->member->workoutPlan)
                <div class="space-y-3">
                    <div>
                        <p class="text-gray-400 text-sm">Program</p>
                        <p class="text-orange-400 font-medium">{{ auth()->user()->member->workoutPlan->program_type }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400 text-sm">Assigned</p>
                        <p class="font-medium">{{ auth()->user()->member->workoutPlan->created_at->format('M d, Y') }}</p>
                    </div>
                </div>
            @else
                <p class="text-gray-400">No workout plan assigned</p>
            @endif
        </div>
    </div>

    <!-- QUICK ACTIONS -->
    <div class="mt-6 bg-white/10 backdrop-blur-md p-6 rounded-2xl border border-orange-500/30">
        <h3 class="text-orange-400 font-bold mb-4 text-lg">Quick Actions</h3>
        <div class="flex flex-wrap gap-3">
            <a href="{{ url('/membership') }}" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg text-sm">Apply for Membership</a>
            <a href="{{ url('/attendance') }}" class="bg-indigo-500 hover:bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm">View Attendance</a>
            <a href="{{ url('/profile') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm">Update Profile</a>
        </div>
    </div>

    <!-- TODAY'S CHECK IN -->
    @php
        $todayCheckIn = auth()->user()->member ? 
            \App\Models\Attendance::where('member_id', auth()->user()->member->id)
                ->whereDate('created_at', \Carbon\Carbon::today())
                ->first() : null;
    @endphp
    <div class="mt-6 bg-gradient-to-r from-orange-500/20 to-red-500/10 backdrop-blur-md p-6 rounded-2xl border-2 border-orange-500/50">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-orange-400 font-bold text-lg mb-2">Today's Check-In</h3>
                @if($todayCheckIn)
                    <p class="text-gray-400 text-sm">Checked in at {{ $todayCheckIn->created_at->format('H:i A') }}</p>
                @else
                    <p class="text-gray-400 text-sm">Click the button to check in at the gym</p>
                @endif
            </div>
            @if($todayCheckIn)
                <div class="text-center">
                    <p class="text-green-400 font-bold text-3xl">✓</p>
                    <p class="text-green-400 text-sm mt-1">Checked In</p>
                </div>
            @else
                <form method="POST" action="{{ route('attendance.checkin') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white px-8 py-4 rounded-lg font-bold text-lg transition transform hover:scale-105">
                        🏋️ CHECK IN NOW
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>

</body>
</html>
