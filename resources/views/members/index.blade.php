<!DOCTYPE html>
<html>
<head>
    <title>Members</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-app text-white min-h-screen">

<div class="p-6">

    <h1 class="text-2xl text-orange-500 font-bold mb-6">
        Members Management
    </h1>

    <!-- ADD MEMBER FORM -->
    <div class="bg-white/10 backdrop-blur-md p-5 rounded-2xl border border-orange-500/30 mb-6">

        <form method="POST" action="/members">
            @csrf

            <input name="phone" placeholder="Phone"
                class="w-full mb-3 p-3 bg-black/40 border border-white/10 rounded-lg text-white">

            <input name="goal" placeholder="Goal (Fat loss, Muscle gain...)"
                class="w-full mb-3 p-3 bg-black/40 border border-white/10 rounded-lg text-white">

            <button class="bg-orange-500 px-4 py-2 rounded-lg">
                Add Member
            </button>
        </form>

    </div>

    <!-- MEMBER LIST -->
    <div class="bg-white/10 backdrop-blur-md p-5 rounded-2xl border border-orange-500/30">

        <table class="w-full text-left text-gray-300">

            <tr class="border-b border-white/10">
                <th class="p-2">Phone</th>
                <th class="p-2">Goal</th>
            </tr>

            @foreach($members as $member)
            <tr class="border-b border-white/5">
                <td class="p-2">{{ $member->phone }}</td>
                <td class="p-2 text-orange-400">{{ $member->goal }}</td>
            </tr>
            @endforeach

        </table>

    </div>

</div>

</body>
</html>