<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Profile</title>
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
<div class="max-w-4xl mx-auto p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold text-orange-500">Profile Settings</h2>
        <a href="{{ url('/dashboard') }}" class="text-orange-400 hover:text-orange-300">← Back to Dashboard</a>
    </div>

    <!-- SECTIONS -->
    <div class="space-y-6">
        <!-- UPDATE PROFILE INFO -->
        <div class="bg-white/10 backdrop-blur-md p-6 rounded-2xl border border-orange-500/30">
            <h3 class="text-orange-400 font-bold mb-4 text-xl">Profile Information</h3>
            @include('profile.partials.update-profile-information-form')
        </div>

        <!-- UPDATE PASSWORD -->
        <div class="bg-white/10 backdrop-blur-md p-6 rounded-2xl border border-orange-500/30">
            <h3 class="text-orange-400 font-bold mb-4 text-xl">Update Password</h3>
            @include('profile.partials.update-password-form')
        </div>

        <!-- DELETE ACCOUNT -->
        <div class="bg-white/10 backdrop-blur-md p-6 rounded-2xl border border-orange-500/30">
            <h3 class="text-red-400 font-bold mb-4 text-xl">Danger Zone</h3>
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</div>

</body>
</html>
