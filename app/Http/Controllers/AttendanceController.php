<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Member;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    // CHECK IN FOR TODAY
    public function checkIn(Request $request)
    {
        $member = auth()->user()->member;

        if (!$member) {
            $member = Member::create([
                'user_id' => auth()->id(),
            ]);
        }

        // Check if already checked in today
        $existingCheckIn = Attendance::where('member_id', $member->id)
            ->whereDate('created_at', Carbon::today())
            ->first();

        if ($existingCheckIn) {
            if ($request->wantsJson()) {
                return response()->json(['message' => 'You have already checked in today!'], 409);
            }
            return redirect()->back()->with('warning', 'You have already checked in today!');
        }

        // Create attendance record
        Attendance::create([
            'member_id' => $member->id,
            'date' => Carbon::today(),
            'time_in' => Carbon::now()->format('H:i:s'),
        ]);

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Checked in successfully', 'checked_in' => true]);
        }

        return redirect()->back()->with('success', 'Welcome! You have checked in successfully! 💪');
    }

    // CHECK OUT FOR TODAY
    public function checkOut(Request $request)
    {
        $member = auth()->user()->member;

        if (!$member) {
            return redirect()->back()->with('error', 'Member not found!');
        }

        // Find today's check-in record
        $attendance = Attendance::where('member_id', $member->id)
            ->whereDate('created_at', Carbon::today())
            ->whereNull('time_out')
            ->first();

        if (!$attendance) {
            if ($request->wantsJson()) {
                return response()->json(['message' => 'You need to check in first!'], 404);
            }
            return redirect()->back()->with('warning', 'You need to check in first!');
        }

        // Update with check-out time
        $attendance->update([
            'time_out' => Carbon::now()->format('H:i:s'),
        ]);

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Checked out successfully', 'checked_out' => true]);
        }

        return redirect()->back()->with('success', 'See you next time! You have checked out successfully! 👋');
    }

    // GET TODAY'S CHECK IN STATUS
    public function getTodayStatus()
    {
        $member = auth()->user()->member;

        if (!$member) {
            return null;
        }

        return Attendance::where('member_id', $member->id)
            ->whereDate('created_at', Carbon::today())
            ->first();
    }
}
