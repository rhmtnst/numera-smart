<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Ruang Kendali Admin') · NUMERA SMART</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="numera-body ns-admin-body" x-data="{ sidebarOpen: false }">
    <div class="ns-mobile-overlay" x-show="sidebarOpen" x-transition.opacity @click="sidebarOpen = false" x-cloak></div>
    <aside class="ns-sidebar ns-admin-sidebar" :class="sidebarOpen ? 'is-open' : ''">
        <div class="ns-sidebar-brand">
            <div class="ns-brand-mark">N</div>
            <div><div class="ns-brand-name">NUMERA <span>SMART</span></div><div class="ns-brand-tagline">Dari Kesalahan Menuju Pemahaman</div></div>
            <button class="ns-icon-button ns-close-sidebar" @click="sidebarOpen = false" aria-label="Tutup menu">×</button>
        </div>
        <div class="ns-admin-nav-label">MENU UTAMA</div>
        <nav class="ns-side-nav" aria-label="Navigasi administrator">
            <a class="ns-side-link {{ request()->routeIs('admin.dashboard') ? 'is-active' : '' }}" href="{{ route('admin.dashboard') }}"><span class="ns-nav-icon">⌂</span><span>Dashboard</span></a>
            <a class="ns-side-link {{ request()->routeIs('admin.schools.*') ? 'is-active' : '' }}" href="{{ route('admin.schools.index') }}"><span class="ns-nav-icon">🏫</span><span>Data Sekolah</span></a>
            <a class="ns-side-link {{ request()->routeIs('admin.teachers.*') ? 'is-active' : '' }}" href="{{ route('admin.teachers.index') }}"><span class="ns-nav-icon">👩‍🏫</span><span>Data Guru</span></a>
            <a class="ns-side-link {{ request()->routeIs('admin.assignments.*') ? 'is-active' : '' }}" href="{{ route('admin.assignments.index') }}"><span class="ns-nav-icon">⇄</span><span>Penugasan Guru</span></a>
            <a class="ns-side-link {{ request()->routeIs('admin.codes.*') ? 'is-active' : '' }}" href="{{ route('admin.codes.index') }}"><span class="ns-nav-icon">🔐</span><span>Kode Sekolah</span></a>
            <a class="ns-side-link {{ request()->routeIs('admin.students.*') ? 'is-active' : '' }}" href="{{ route('admin.students.index') }}"><span class="ns-nav-icon">🎓</span><span>Data Siswa</span></a>
        </nav>
        <div class="ns-sidebar-bottom">
            <div class="ns-help-card"><div class="ns-help-emoji">✨</div><strong>Ruang Kendali Admin</strong><p>Kelola ekosistem belajar NUMERA SMART dalam satu tempat.</p></div>
            <div class="ns-sidebar-version">NUMERA SMART <span>v1.0</span></div>
        </div>
    </aside>
    <div class="ns-main-column ns-admin-main">
        <header class="ns-topbar ns-admin-topbar">
            <button class="ns-icon-button ns-menu-toggle" @click="sidebarOpen = true" aria-label="Buka menu">☰</button>
            <div class="ns-topbar-context"><span class="ns-context-dot"></span> NUMERA SMART <span class="ns-context-divider">/</span><strong>@yield('title', 'Ruang Kendali Sistem')</strong></div>
            <div class="ns-topbar-actions">
                <div class="ns-admin-identity"><strong>{{ auth()->user()->name }}</strong><small>Super Administrator</small></div>
                <span class="ns-avatar ns-admin-avatar">A</span>
                <form action="{{ route('logout') }}" method="POST">@csrf<button type="submit" class="ns-admin-logout">Keluar</button></form>
            </div>
        </header>
        <main class="ns-main-content ns-admin-content">@yield('content')</main>
        <footer class="ns-footer">© {{ date('Y') }} NUMERA SMART · Dari Kesalahan Menuju Pemahaman</footer>
    </div>
</body>
</html>
