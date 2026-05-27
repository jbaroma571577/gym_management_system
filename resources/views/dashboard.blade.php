<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Member Dashboard</title>
    <script>window.APP_USER_ROLE = "{{ auth()->user()->role ?? 'guest' }}";</script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-app text-white min-h-screen">
    <div id="app"></div>
</body>
</html>
