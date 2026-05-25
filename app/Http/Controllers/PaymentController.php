<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Membership;
use App\Models\Payment;

class PaymentController extends Controller
{
    public function index()
    {
        if (auth()->user()->role === 'admin') {
            return response()->json(Payment::with('membership.member.user')->latest()->get());
        }

        $member = auth()->user()->member;
        if (! $member) {
            return response()->json([]);
        }

        $payments = Payment::with('membership.member.user')
            ->whereHas('membership', function ($query) use ($member) {
                $query->where('member_id', $member->id);
            })
            ->latest()
            ->get();

        return response()->json($payments);
    }

    public function store(Request $request)
    {
        $request->validate([
            'membership_id' => 'required|exists:memberships,id',
            'amount' => 'required|numeric|min:0',
            'reference_number' => 'nullable|string|max:255',
        ]);

        $member = auth()->user()->member;
        if (! $member) {
            return response()->json(['message' => 'Member record not found.'], 403);
        }

        $membership = Membership::findOrFail($request->membership_id);
        if ($membership->member_id !== $member->id) {
            return response()->json(['message' => 'Unauthorized payment submission.'], 403);
        }

        $payment = Payment::create([
            'membership_id' => $membership->id,
            'amount' => $request->amount,
            'reference_number' => $request->reference_number,
            'status' => 'pending',
        ]);

        return response()->json([
            'message' => 'Payment submitted successfully.',
            'payment' => $payment->load('membership.member.user'),
        ]);
    }

    public function approve($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->update(['status' => 'paid']);

        if (request()->wantsJson()) {
            return response()->json(['message' => 'Payment approved.', 'payment' => $payment]);
        }

        return redirect()->back()->with('success', 'Payment approved successfully.');
    }

    public function reject($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->update(['status' => 'rejected']);

        if (request()->wantsJson()) {
            return response()->json(['message' => 'Payment rejected.', 'payment' => $payment]);
        }

        return redirect()->back()->with('success', 'Payment rejected successfully.');
    }
}
