<div class="ns-mobile-overlay" x-show="sidebarOpen" x-transition.opacity @click="sidebarOpen = false" x-cloak></div>
<aside class="ns-sidebar" :class="sidebarOpen ? 'is-open' : ''">
    <div class="ns-sidebar-brand">
        <div class="ns-brand-mark">N</div>
        <div>
            <div class="ns-brand-name">NUMERA <span>SMART</span></div>
            <div class="ns-brand-tagline">Petualangan Seru Belajar Numerasi</div>
        </div>
        <button class="ns-icon-button ns-close-sidebar" @click="sidebarOpen = false" aria-label="Tutup menu">×</button>
    </div>
    <div class="ns-student-level-card">
        <span class="ns-level-star">✦</span>
        <div><strong>Ruang Petualangan</strong><small>Terus naik level dengan belajar!</small></div>
    </div>
    <nav class="ns-side-nav" aria-label="Navigasi utama">
        <a class="ns-side-link {{ request()->routeIs('student.dashboard') && !request()->query('section') ? 'is-active' : '' }}" href="{{ route('student.dashboard') }}"><span class="ns-nav-icon">⌂</span><span>Beranda</span></a>
        <a class="ns-side-link" href="{{ route('student.dashboard') }}#asesmen"><span class="ns-nav-icon">✎</span><span>Asesmen</span></a>
        <a class="ns-side-link" href="{{ route('student.dashboard') }}#perjalanan"><span class="ns-nav-icon">➜</span><span>Perjalanan</span></a>
        <a class="ns-side-link" href="{{ route('student.dashboard') }}#hasil-belajar"><span class="ns-nav-icon">▤</span><span>Hasil Belajar</span></a>
        <a class="ns-side-link" href="{{ route('student.dashboard') }}#lencana"><span class="ns-nav-icon">★</span><span>Lencana</span></a>
    </nav>
    <div class="ns-sidebar-bottom">
        <div class="ns-help-card"><div class="ns-help-emoji">🦕</div><strong>Kamu pasti bisa!</strong><p>Selesaikan misi kecil hari ini. Setiap usaha membuatmu semakin hebat.</p></div>
        <div class="ns-sidebar-version">NUMERA SMART <span>LEARN · PLAY · GROW</span></div>
    </div>
</aside>
