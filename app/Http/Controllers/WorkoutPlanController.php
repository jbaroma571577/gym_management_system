<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WorkoutPlan;
use App\Models\Member;

class WorkoutPlanController extends Controller
{
    // STORE WORKOUT PLAN
    public function store(Request $request)
    {
        $request->validate([
            'member_id' => 'required|exists:members,id',
            'program_type' => 'required',
            'description' => 'required',
        ]);

        $member = Member::with('membership')->find($request->member_id);

        if (! $member || ! $member->membership) {
            return redirect()->back()->with('warning', 'This member does not have a membership plan yet. Assign a membership first.');
        }

        $membershipPlan = $member->membership->plan;
        $allowedPrograms = WorkoutPlan::allowedProgramsForMembership($membershipPlan);

        if (! in_array($request->program_type, $allowedPrograms)) {
            return redirect()->back()->with('warning', sprintf('The selected workout program is not available for %s members. Choose one of: %s', $membershipPlan, implode(', ', $allowedPrograms)));
        }

        WorkoutPlan::create([
            'member_id' => $member->id,
            'program_type' => $request->program_type,
            'description' => $request->description,
        ]);

        return redirect()->back()->with('success', 'Workout Plan Assigned!');
    }

    // SHOW ALL WORKOUT PLANS
    public function index()
    {
        $plans = WorkoutPlan::with('member.user')->latest()->get();
        $members = Member::with(['user', 'membership'])->get();

        return view('admin.workouts', compact('plans', 'members'));
    }
}