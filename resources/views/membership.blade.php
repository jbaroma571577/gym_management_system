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
<div class="max-w-2xl mx-auto p-6">
    <h2 class="text-3xl font-bold text-orange-500 mb-6">Apply for Gym Membership</h2>

    <!-- FORM -->
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
</div>

</body>
</html>