<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Apply for Membership</title>
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
@php
    $membership = auth()->user()->member ? auth()->user()->member->membership : null;
@endphp

<div class="max-w-2xl mx-auto p-6">
    <h2 class="text-3xl font-bold text-orange-500 mb-6">Apply for Gym Membership</h2>

    <!-- STATUS -->
    @if($membership)
        @php
            $planInfo = \App\Models\Membership::planDetails()[$membership->plan] ?? null;
        @endphp
        <div class="bg-white/10 backdrop-blur-md p-6 rounded-2xl border border-green-500/30 mb-6">
            <h3 class="text-xl font-semibold text-white mb-3">Membership status</h3>
            <p class="text-gray-300 mb-2">
                Plan: <span class="font-semibold text-white">{{ $membership->plan }}</span>
                @if($planInfo)
                    <span class="ml-3 px-2 py-1 rounded-full text-xs {{ $planInfo['badge_class'] }}">{{ $planInfo['label'] }}</span>
                @endif
            </p>
            <p class="text-gray-300 mb-2">Status: <span class="font-semibold text-white capitalize">{{ $membership->status }}</span></p>
            @if($membership->expires_at)
                <p class="text-gray-300 mb-4">Expires on: <span class="font-semibold text-white">{{ $membership->expires_at->format('M d, Y') }}</span></p>
            @endif

            @if(in_array($membership->status, ['pending', 'active']))
                <p class="text-gray-300 mb-4">
                    @if($membership->status === 'pending')
                        Your VIP membership has been submitted and is awaiting admin approval. It will only unlock trainer bookings and classes after activation.
                    @else
                        Your membership is approved{{ $membership->isExpired() ? ' but has expired' : '' }}.
                    @endif
                </p>
                <p class="text-gray-300 mb-4">{{ $planInfo['description'] ?? 'A gym membership plan with your selected perks.' }}</p>
                @if(! empty($planInfo['features']))
                    <div class="mb-4 space-y-2">
                        <h4 class="text-white font-semibold">Plan features</h4>
                        <ul class="list-disc list-inside text-gray-300 text-sm">
                            @foreach($planInfo['features'] as $feature)
                                <li>{{ $feature }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if(! $membership->isExpired())
                    <div class="space-y-4">
                        <a href="{{ url('/attendance') }}" class="inline-flex items-center justify-center bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded-lg font-medium transition">
                            Go to Attendance
                        </a>

                        @if($membership->status === 'active' && in_array($membership->plan, ['Premium', 'VIP']))
                            <div class="grid gap-3 sm:grid-cols-2">
                                <a href="{{ url('/trainer-booking') }}" class="inline-flex items-center justify-center bg-sky-500 hover:bg-sky-600 text-white px-6 py-3 rounded-lg font-medium transition">
                                    Trainer booking
                                </a>
                                <a href="{{ url('/classes') }}" class="inline-flex items-center justify-center bg-indigo-500 hover:bg-indigo-600 text-white px-6 py-3 rounded-lg font-medium transition">
                                    Group classes
                                </a>
                            </div>
                        @endif
                    </div>
                @else
                    <span class="inline-flex items-center justify-center bg-red-500/15 text-red-200 px-4 py-2 rounded-lg font-medium">Expired membership. Please renew.</span>
                @endif

                @if($membership->status === 'active' && ! $membership->isExpired())
                    <div class="mt-6 bg-black/40 border border-white/10 rounded-2xl p-4">
                        <h4 class="text-white font-semibold mb-3">Change plan</h4>
                        <form method="POST" action="{{ url('/membership/change-plan') }}" class="flex flex-col gap-4 sm:flex-row sm:items-end">
                            @csrf
                            <div class="flex-1">
                                <label for="plan" class="block text-gray-300 mb-2">Select new plan</label>
                                <select name="plan" id="plan" class="w-full p-3 bg-black/50 border border-white/10 rounded-lg text-white focus:outline-none focus:border-orange-500" required>
                                    @foreach(['Basic', 'Premium', 'VIP'] as $plan)
                                        <option value="{{ $plan }}" {{ $membership->plan === $plan ? 'selected' : '' }}>{{ $plan }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg font-medium transition">Update plan</button>
                        </form>
                    </div>
                @endif
            @elseif($membership->status === 'rejected')
                <p class="text-red-300 mb-4">Your previous membership application was rejected. You can submit a new application below.</p>
            @endif
        </div>
    @endif

    @if(!$membership || $membership->status === 'rejected' || ($membership->status === 'active' && $membership->isExpired()))
        <div class="bg-white/10 backdrop-blur-md p-6 rounded-2xl border border-orange-500/30">
            @if(session('success'))
                <div class="bg-green-500/20 border border-green-500/50 text-green-400 p-4 rounded-lg mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="/membership">
                @csrf

                <div class="mb-6">
                    <label for="plan" class="block text-orange-400 font-medium mb-2">Membership Plan</label>
                    <select name="plan" id="plan" class="w-full p-3 bg-black/40 border border-white/10 rounded-lg text-white focus:outline-none focus:border-orange-500" required>
                        <option value="">Select Plan</option>
                        <option value="Basic">Basic - ₱500/month</option>
                        <option value="Premium">Premium - ₱800/month</option>
                        <option value="VIP">VIP - ₱1200/month</option>
                    </select>
                    @if($errors->has('plan'))
                        <p class="text-red-400 mt-2 text-sm">{{ $errors->first('plan') }}</p>
                    @endif
                </div>

                <div class="mb-6">
                    <label for="payment_method" class="block text-orange-400 font-medium mb-2">Payment Method</label>
                    <select name="payment_method" id="payment_method" class="w-full p-3 bg-black/40 border border-white/10 rounded-lg text-white focus:outline-none focus:border-orange-500" required>
                        <option value="">Select Payment Method</option>
                        <option value="gcash">GCash</option>
                        <option value="card">Credit/Debit Card</option>
                        <option value="cash">Cash (Admin Verification)</option>
                    </select>
                    @if($errors->has('payment_method'))
                        <p class="text-red-400 mt-2 text-sm">{{ $errors->first('payment_method') }}</p>
                    @endif
                </div>

                <div class="mb-6">
                    <label for="reference_number" class="block text-orange-400 font-medium mb-2">Reference Number (for GCash/Card)</label>
                    <input type="text" id="reference_number" name="reference_number" value="{{ old('reference_number') }}" class="w-full p-3 bg-black/40 border border-white/10 rounded-lg text-white focus:outline-none focus:border-orange-500" />
                    @if($errors->has('reference_number'))
                        <p class="text-red-400 mt-2 text-sm">{{ $errors->first('reference_number') }}</p>
                    @endif
                </div>

                <div class="flex justify-end">
                    <a href="{{ url('/dashboard') }}" class="text-gray-400 hover:text-gray-300 mr-4 py-2">Cancel</a>
                    <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-2 rounded-lg font-medium">
                        Submit Application
                    </button>
                </div>
            </form>
        </div>
    @endif
</div>

</body>
</html>