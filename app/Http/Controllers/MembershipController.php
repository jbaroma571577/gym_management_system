<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Membership;
use App\Models\Member;
use App\Models\Payment;
use Carbon\Carbon;

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
            'plan' => 'required|in:Basic,Premium,VIP',
            'payment_method' => 'required',
            'reference_number' => 'nullable|string|max:255',
        ]);

        $member = auth()->user()->member;

        if (! $member) {
            $member = Member::create([
                'user_id' => auth()->id(),
            ]);
        }

        if ($member->membership && ($member->membership->status === 'pending' || ($member->membership->status === 'active' && ! $member->membership->isExpired()))) {
            return redirect()->back()->with('warning', 'You already have an active or pending membership. Please wait for admin approval or contact support.');
        }

        $membership = Membership::create([
            'member_id' => $member->id,
            'plan' => $request->plan,
            'payment_method' => $request->payment_method,
            'reference_number' => $request->reference_number,
            'status' => 'pending',
        ]);

        $amount = Membership::planDetails()[$request->plan]['price'] ?? 0;

        Payment::create([
            'membership_id' => $membership->id,
            'amount' => $amount,
            'reference_number' => $request->reference_number,
            'status' => 'pending',
        ]);

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Membership application submitted', 'status' => 'pending']);
        }

        return redirect()->back()->with('success', 'Membership application submitted successfully! Please wait for admin approval.');
    }

    public function changePlanByMember(Request $request)
    {
        $request->validate([
            'plan' => 'required|in:Basic,Premium,VIP',
        ]);

        $member = auth()->user()->member;
        if (! $member || ! $member->membership) {
            return redirect()->back()->with('warning', 'No membership found to update.');
        }

        $membership = $member->membership;
        if (! $membership->isActiveWithValidity()) {
            return redirect()->back()->with('warning', 'You can only change plans for an active membership.');
        }

        $duration = Membership::planDetails()[$request->plan]['duration_days'] ?? 30;

        $membership->update([
            'plan' => $request->plan,
            'expires_at' => now()->addDays($duration),
        ]);

        return redirect()->back()->with('success', 'Your membership plan has been updated successfully.');
    }

    public function activate($id)
    {
        $membership = Membership::findOrFail($id);

        $membership->update([
            'status' => 'active',
            'expires_at' => Carbon::now()->addDays($membership->getDurationDays()),
        ]);

        if (request()->wantsJson()) {
            return response()->json(['message' => 'Membership activated', 'id' => $membership->id, 'status' => $membership->status]);
        }

        return redirect()->back()->with('success', 'Membership activated successfully!');
    }

    public function reject($id)
    {
        $membership = Membership::findOrFail($id);

        $membership->update([
            'status' => 'rejected',
            'expires_at' => null,
        ]);

        if (request()->wantsJson()) {
            return response()->json(['message' => 'Membership rejected', 'id' => $membership->id, 'status' => $membership->status]);
        }

        return redirect()->back()->with('success', 'Membership rejected successfully!');
    }

    public function changePlan(Request $request, $id)
    {
        $request->validate([
            'plan' => 'required|in:Basic,Premium,VIP',
        ]);

        $membership = Membership::findOrFail($id);
        $duration = Membership::planDetails()[$request->plan]['duration_days'] ?? 30;

        $membership->update([
            'plan' => $request->plan,
            'expires_at' => Carbon::now()->addDays($duration),
        ]);

        return redirect()->back()->with('success', 'Membership plan updated successfully.');
    }
}
