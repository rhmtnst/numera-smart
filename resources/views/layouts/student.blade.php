<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Beranda') · NUMERA SMART</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="numera-body" x-data="{ sidebarOpen: false }">
    <div class="ns-app-shell">
        @include('components.student-sidebar')
        <div class="ns-main-column">
            @include('components.student-header')
            <main class="ns-main-content">
                @yield('content')
            </main>
            <footer class="ns-footer">© {{ date('Y') }} NUMERA SMART · Dari Kesalahan Menuju Pemahaman</footer>
        </div>
    </div>
</body>
</html>
