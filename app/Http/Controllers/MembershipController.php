<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Membership;
use App\Models\Member;

class MembershipController extends Controller
{
    public function index()
    {
        $memberships = Membership::with('member.user')->latest()->get();
        return view('admin.memberships', compact('memberships'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'plan' => 'required',
            'payment_method' => 'required',
            'reference_number' => 'nullable',
        ]);

        // Get or create member from authenticated user
        $member = auth()->user()->member;

        if (!$member) {
            $member = Member::create([
                'user_id' => auth()->id(),
            ]);
        }

        Membership::create([
            'member_id' => $member->id,
            'plan' => $request->plan,
            'payment_method' => $request->payment_method,
            'reference_number' => $request->reference_number,
            'status' => 'pending'
        ]);

        return redirect()->back()->with('success', 'Membership application submitted successfully! Please wait for admin approval.');
    }

    public function activate($id)
    {
        $membership = Membership::findOrFail($id);

        $membership->update([
            'status' => 'active'
        ]);

        return redirect()->back()->with('success', 'Membership activated successfully!');
    }

    public function reject($id)
    {
        $membership = Membership::findOrFail($id);

        $membership->update([
            'status' => 'rejected'
        ]);

        return redirect()->back()->with('success', 'Membership rejected successfully!');
    }
}