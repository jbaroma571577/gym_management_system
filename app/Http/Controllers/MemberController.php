<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    /**
     * Display a listing of members
     */
    public function index()
    {
        $members = Member::with('user', 'trainer')->get();
        if (request()->wantsJson()) {
            return response()->json($members);
        }

        return view('admin.members.index', compact('members'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        $availableTrainers = \App\Models\User::where('role', 'trainer')
            ->where('is_available', true)
            ->get();
        
        return view('admin.members.create', compact('availableTrainers'));
    }

    /**
     * Store new member
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required',
            'phone' => 'nullable',
            'goal' => 'nullable',
            'trainer_id' => 'nullable|integer|exists:users,id',
        ]);

        // Validate trainer is available if provided
        if ($validated['trainer_id']) {
            $trainer = \App\Models\User::findOrFail($validated['trainer_id']);
            if ($trainer->role !== 'trainer' || !$trainer->is_available) {
                return redirect()->back()->withErrors(['trainer_id' => 'Selected trainer is not available or is not a trainer.']);
            }
        }

        $member = Member::create($validated);

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Member created', 'member' => $member]);
        }

        return redirect()->route('members.index')->with('success', 'Member created successfully');
    }

    /**
     * Show single member
     */
    public function show(string $id)
    {
        $member = Member::with('user', 'trainer')->findOrFail($id);
        if (request()->wantsJson()) {
            return response()->json($member);
        }

        return view('admin.members.show', compact('member'));
    }

    /**
     * Edit form
     */
    public function edit(string $id)
    {
        $member = Member::findOrFail($id);
        $availableTrainers = \App\Models\User::where('role', 'trainer')
            ->where('is_available', true)
            ->get();
        
        if (request()->wantsJson()) {
            return response()->json($member);
        }

        return view('admin.members.edit', compact('member', 'availableTrainers'));
    }

    /**
     * Update member
     */
    public function update(Request $request, string $id)
    {
        $member = Member::findOrFail($id);

        $validated = $request->validate([
            'user_id' => 'required',
            'phone' => 'nullable',
            'goal' => 'nullable',
            'trainer_id' => 'nullable|integer|exists:users,id',
        ]);

        // Validate trainer is available if provided
        if ($validated['trainer_id']) {
            $trainer = \App\Models\User::findOrFail($validated['trainer_id']);
            if ($trainer->role !== 'trainer' || !$trainer->is_available) {
                return redirect()->back()->withErrors(['trainer_id' => 'Selected trainer is not available or is not a trainer.']);
            }
        }

        $member->update($validated);
        if ($request->wantsJson()) {
            return response()->json(['message' => 'Member updated', 'member' => $member]);
        }

        return redirect()->route('members.index')->with('success', 'Member updated successfully');
    }

    /**
     * Delete member
     */
    public function destroy(string $id)
    {
        Member::destroy($id);

        if (request()->wantsJson()) {
            return response()->json(['message' => 'Member deleted', 'id' => $id]);
        }

        return redirect()->route('members.index')->with('success', 'Member deleted');
    }
}