<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Attendance</title>
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
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold text-orange-500">Attendance Records</h2>
        <a href="{{ url('/dashboard') }}" class="text-orange-400 hover:text-orange-300">← Back to Dashboard</a>
    </div>

    <!-- SUCCESS/WARNING MESSAGES -->
    @if(session('success'))
        <div class="bg-green-500/20 border border-green-500/50 text-green-400 p-4 rounded-lg mb-6">
            {{ session('success') }}
        </div>
    @endif

    @if(session('warning'))
        <div class="bg-yellow-500/20 border border-yellow-500/50 text-yellow-400 p-4 rounded-lg mb-6">
            {{ session('warning') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-500/20 border border-red-500/50 text-red-400 p-4 rounded-lg mb-6">
            {{ session('error') }}
        </div>
    @endif

    <!-- CHECK IN CARD -->
    <div class="bg-white/10 backdrop-blur-md p-6 rounded-2xl border border-orange-500/30 mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-orange-400 font-bold text-lg mb-2">Today's Check-In</h3>
                <p class="text-gray-400 text-sm">Check in when you arrive at the gym</p>
            </div>
            @php
                $todayCheckIn = auth()->user()->member ? 
                    \App\Models\Attendance::where('member_id', auth()->user()->member->id)
                        ->whereDate('created_at', \Carbon\Carbon::today())
                        ->first() : null;
            @endphp
            @if($todayCheckIn)
                <div class="text-right">
                    <p class="text-green-400 font-bold text-2xl">✓ Checked In</p>
                    <p class="text-gray-400 text-sm mt-1">{{ $todayCheckIn->time_in ? \Carbon\Carbon::parse($todayCheckIn->time_in)->format('H:i A') : $todayCheckIn->created_at->format('H:i A') }}</p>
                    @if($todayCheckIn->time_out)
                        <p class="text-blue-400 font-bold text-lg mt-2">✓ Checked Out</p>
                        <p class="text-gray-400 text-sm">{{ \Carbon\Carbon::parse($todayCheckIn->time_out)->format('H:i A') }}</p>
                    @else
                        <form method="POST" action="{{ route('attendance.checkout') }}" class="mt-3">
                            @csrf
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded-lg font-bold transition transform hover:scale-105">
                                🚪 CHECK OUT
                            </button>
                        </form>
                    @endif
                </div>
            @else
                <form method="POST" action="{{ route('attendance.checkin') }}">
                    @csrf
                    <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white px-8 py-3 rounded-lg font-bold transition transform hover:scale-105">
                        🏋️ CHECK IN NOW
                    </button>
                </form>
            @endif
        </div>
    </div>

    <!-- ATTENDANCE TABLE -->
    <div class="bg-white/10 backdrop-blur-md p-6 rounded-2xl border border-orange-500/30 overflow-x-auto">
        <table class="w-full text-left text-gray-300">
            <thead>
                <tr class="border-b border-white/10">
                    <th class="p-4 text-orange-400 font-bold">Date</th>
                    <th class="p-4 text-orange-400 font-bold">Time In</th>
                    <th class="p-4 text-orange-400 font-bold">Time Out</th>
                    <th class="p-4 text-orange-400 font-bold">Duration</th>
                </tr>
            </thead>
            <tbody>
                @if(auth()->user()->member && auth()->user()->member->attendances->count() > 0)
                    @foreach(auth()->user()->member->attendances as $attendance)
                        <tr class="border-b border-white/5 hover:bg-white/5 transition">
                            <td class="p-4">{{ $attendance->created_at->format('M d, Y') }}</td>
                            <td class="p-4">{{ $attendance->time_in ? \Carbon\Carbon::parse($attendance->time_in)->format('H:i A') : $attendance->created_at->format('H:i A') }}</td>
                            <td class="p-4">{{ $attendance->time_out ? \Carbon\Carbon::parse($attendance->time_out)->format('H:i A') : '-' }}</td>
                            <td class="p-4 text-green-400 font-medium">
                                @if($attendance->time_in && $attendance->time_out)
                                    {{ \Carbon\Carbon::parse($attendance->time_in)->diff(\Carbon\Carbon::parse($attendance->time_out))->format('%Hh %Im') }}
                                @elseif($attendance->time_in)
                                    {{ \Carbon\Carbon::parse($attendance->time_in)->diffInHours(\Carbon\Carbon::now()) }}h+
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="4" class="p-8 text-center text-gray-400">
                            No attendance records found.
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

</body>
</html>