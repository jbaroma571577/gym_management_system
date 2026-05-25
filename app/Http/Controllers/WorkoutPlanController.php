<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WorkoutPlan;

class WorkoutPlanController extends Controller
{
    // STORE WORKOUT PLAN
    public function store(Request $request)
    {
        $request->validate([
            'member_id' => 'required',
            'program_type' => 'required',
            'description' => 'required',
        ]);

        WorkoutPlan::create([
            'member_id' => $request->member_id,
            'program_type' => $request->program_type,
            'description' => $request->description,
        ]);

        return redirect()->back()->with('success', 'Workout Plan Assigned!');
    }

    // SHOW ALL WORKOUT PLANS
    public function index()
    {
        $plans = WorkoutPlan::with('member.user')->latest()->get();
        $members = \App\Models\Member::with('user')->get();

        return view('admin.workouts', compact('plans', 'members'));
    }
}