
{{-- MOBILE OVERLAY --}}
<div
    class="ns-mobile-overlay"
    x-show="sidebarOpen"
    x-transition.opacity
    @click="sidebarOpen = false"
    x-cloak
></div>

<aside
    class="ns-sidebar"
    :class="sidebarOpen ? 'is-open' : ''"
    aria-label="Sidebar navigasi guru"
>
    {{-- BRAND --}}
    <div class="ns-sidebar-brand">
        <div class="relative flex h-11 w-11 shrink-0 items-center justify-center overflow-hidden rounded-2xl bg-gradient-to-br from-[#087cf0] via-[#12afe9] to-[#35d99a] text-xl font-black text-white shadow-lg shadow-blue-200/60">
            N
            <div class="absolute -right-2 -top-2 h-6 w-6 rounded-full bg-white/20"></div>
        </div>

        <div class="min-w-0 flex-1">
            <div class="ns-brand-name">
                NUMERA <span>SMART</span>
            </div>
            <div class="ns-brand-tagline">
                Dari Kesalahan Menuju Pemahaman
            </div>
        </div>

        <button
            type="button"
            class="ns-icon-button ns-close-sidebar"
            @click="sidebarOpen = false"
            aria-label="Tutup menu"
        >
            ×
        </button>
    </div>

    {{-- LABEL NAVIGASI --}}
    <div class="flex items-center justify-between px-5 pb-3 pt-5">
        <span class="text-[10px] font-black uppercase tracking-[.18em] text-emerald-600">
            Ruang Guru
        </span>

        <span class="rounded-full bg-emerald-50 px-2.5 py-1 text-[9px] font-bold uppercase tracking-wider text-emerald-600">
            Teacher
        </span>
    </div>

    {{-- NAVIGASI UTAMA --}}
    <nav class="ns-side-nav" aria-label="Navigasi guru">

        {{-- DASHBOARD --}}
        <a
            class="ns-side-link {{ request()->routeIs('teacher.dashboard') ? 'is-active' : '' }}"
            href="{{ route('teacher.dashboard') }}"
            @click="sidebarOpen = false"
        >
            <span class="ns-nav-icon">⌂</span>
            <span>Dashboard</span>
        </a>

        {{-- DATA SISWA --}}
        <a
            class="ns-side-link {{ request()->routeIs('teacher.students.*') ? 'is-active' : '' }}"
            href="{{ route('teacher.students.index') }}"
            @click="sidebarOpen = false"
        >
            <span class="ns-nav-icon">♟</span>
            <span>Data Siswa</span>
        </a>

        {{-- MATERI UTAMA --}}
        <a
            class="ns-side-link {{ request()->routeIs('teacher.learning-materials.*') ? 'is-active' : '' }}"
            href="{{ route('teacher.learning-materials.index') }}"
            @click="sidebarOpen = false"
        >
            <span class="ns-nav-icon">📚</span>
            <span>Materi Utama</span>
        </a>

        {{-- BANK SOAL --}}
        <a
            class="ns-side-link {{ request()->routeIs('teacher.questions.*') ? 'is-active' : '' }}"
            href="{{ route('teacher.questions.index') }}"
            @click="sidebarOpen = false"
        >
            <span class="ns-nav-icon">▤</span>
            <span>Bank Soal</span>
        </a>

        {{-- REVIEW SOAL --}}
        <a
            class="ns-side-link {{ request()->routeIs('teacher.review.*') ? 'is-active' : '' }}"
            href="{{ route('teacher.review.index') }}"
            @click="sidebarOpen = false"
        >
            <span class="ns-nav-icon">✓</span>
            <span>Review Soal</span>
        </a>

        {{-- HASIL ASESMEN --}}
        <a
            class="ns-side-link {{ request()->routeIs('teacher.results.*') ? 'is-active' : '' }}"
            href="{{ route('teacher.results.index') }}"
            @click="sidebarOpen = false"
        >
            <span class="ns-nav-icon">▥</span>
            <span>Hasil Asesmen</span>
        </a>

        {{-- ANALISIS KESULITAN --}}
        <a
            class="ns-side-link {{ request()->routeIs('teacher.analyses.*') ? 'is-active' : '' }}"
            href="{{ route('teacher.analyses.index') }}"
            @click="sidebarOpen = false"
        >
            <span class="ns-nav-icon">⌁</span>
            <span>Analisis Kesulitan</span>
        </a>

        {{-- REMEDIASI --}}
        <a
            class="ns-side-link {{ request()->routeIs('teacher.remedials.*') ? 'is-active' : '' }}"
            href="{{ route('teacher.remedials.index') }}"
            @click="sidebarOpen = false"
        >
            <span class="ns-nav-icon">✦</span>
            <span>Remediasi</span>
        </a>

    </nav>

    {{-- BAGIAN BAWAH SIDEBAR --}}
    <div class="ns-sidebar-bottom">

        {{-- KARTU INFORMASI --}}
        <div class="ns-help-card relative overflow-hidden">
            <div class="relative z-10">
                <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-blue-100 to-emerald-100 text-xl">
                    💡
                </div>

                <strong class="block text-sm font-extrabold text-slate-800">
                    Ruang Kendali Guru
                </strong>

                <p class="mt-2 text-xs leading-5 text-slate-500">
                    Pantau perkembangan siswa, temukan kesulitan, dan bantu mereka belajar lebih percaya diri.
                </p>
            </div>

            <div class="pointer-events-none absolute -bottom-7 -right-7 h-20 w-20 rounded-full bg-emerald-100/50"></div>
            <div class="pointer-events-none absolute -right-4 -top-5 h-16 w-16 rounded-full bg-blue-100/40"></div>
        </div>

        {{-- VERSI APLIKASI --}}
        <div class="ns-sidebar-version flex items-center justify-between">
            <span>NUMERA SMART</span>

            <span class="rounded-full bg-slate-100 px-2 py-1 text-[9px] font-bold text-slate-500">
                v1.0
            </span>
        </div>

    </div>

</aside>
