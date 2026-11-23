
@extends('layouts.student')

@section('title', 'Beranda')

@section('content')

@php
    // Pengaturan visual setiap dunia pembelajaran.
    $worldVisuals = [
        'operasi-hitung' => [
            'color' => 'orange',
            'icon' => '🧮',
            'symbol' => '+ − × ÷',
            'subtitle' => 'Berhitung dalam kehidupan sehari-hari',
        ],
        'pengukuran' => [
            'color' => 'blue',
            'icon' => '📏',
            'symbol' => '⏱',
            'subtitle' => 'Mengenal waktu, panjang, dan kapasitas',
        ],
        'geometri' => [
            'color' => 'green',
            'icon' => '📐',
            'symbol' => '◇ ○ □',
            'subtitle' => 'Menjelajahi bentuk dan ruang',
        ],
        'data-dan-penyajian' => [
            'color' => 'teal',
            'icon' => '📊',
            'symbol' => '▂ ▅ ▇',
            'subtitle' => 'Membaca informasi dari data',
        ],
    ];

    // Hanya tampilkan dunia yang memiliki topik tersedia.
    $visibleDomains = $domains
        ->filter(fn ($domain) => $domain->topics->isNotEmpty())
        ->values();
@endphp

{{-- WELCOME --}}
<section class="ns-welcome-row">
    <div>
        <div class="ns-eyebrow">
            <span class="ns-eyebrow-spark">✦</span>
            SELAMAT DATANG DI NUMERA SMART
        </div>

        <h1>Hai, {{ $student->name }}! <span class="ns-wave">👋</span></h1>
        <p>Siap melanjutkan petualangan numerasimu hari ini?</p>
    </div>

    <div class="ns-streak">
        <span>🔥</span>
        <div>
            <strong>2 Hari</strong>
            <small>Belajar beruntun</small>
        </div>
    </div>
</section>

{{-- HERO BANNER --}}
<section class="ns-hero" aria-label="Petualangan Numerasimu">
    <div class="ns-hero-content">
        <div class="ns-hero-copy">
            <span class="ns-hero-label">✨ BELAJAR SAMBIL BERTUALANG</span>

            <h2>Petualangan Numerasi Dimulai!</h2>

            <p>
                Jelajahi dunia angka, pecahkan tantangan,
                dan temukan bahwa matematika itu menyenangkan.
            </p>

            <a href="#dunia-belajar" class="ns-hero-button">
                Mulai Petualangan <span>→</span>
            </a>
        </div>

        <div class="ns-hero-illustration" aria-hidden="true">
            <div class="ns-sun"></div>
            <div class="ns-cloud ns-cloud-one"></div>
            <div class="ns-cloud ns-cloud-two"></div>

            <div class="ns-floating-number ns-number-one">+</div>
            <div class="ns-floating-number ns-number-two">7</div>
            <div class="ns-floating-number ns-number-three">×</div>

            <div class="ns-hero-mascot">
                <div class="ns-mascot-antenna"></div>

                <div class="ns-mascot-face">
                    <div class="ns-mascot-eyes">
                        <span></span><span></span>
                    </div>
                    <div class="ns-mascot-smile"></div>
                    <div class="ns-mascot-cheek ns-cheek-left"></div>
                    <div class="ns-mascot-cheek ns-cheek-right"></div>
                </div>

                <div class="ns-mascot-body">
                    <span>N</span>
                </div>
            </div>

            <div class="ns-hero-platform"></div>
        </div>
    </div>

    <div class="ns-hero-decoration">
        NUMERA SMART · EXPLORE · LEARN · GROW
    </div>
</section>

{{-- DUNIA PEMBELAJARAN --}}
<section class="ns-section" id="dunia-belajar">

    <div class="ns-section-heading">
        <div class="ns-heading-left">
            <span class="ns-section-number">
                {{ $visibleDomains->count() }}
            </span>

            <div>
                <h2>Pilih Dunia Pembelajaran</h2>
                <p>
                    Selesaikan misi di setiap dunia untuk
                    mengumpulkan lencana kecakapan!
                </p>
            </div>
        </div>

        <div class="ns-total-progress">
            <span>🎯</span>
            Total Progres:
            <strong>{{ $completedMissions }}/{{ $totalMissions }} Misi</strong>
        </div>
    </div>

    <div class="ns-world-grid">

        @forelse($visibleDomains as $index => $domain)

            @php
                $visual = $worldVisuals[$domain->slug] ?? [
                    'color' => 'green',
                    'icon' => '📚',
                    'symbol' => '＋ ◇ ○',
                    'subtitle' => $domain->description ?? 'Jelajahi dunia pembelajaran ini',
                ];

                $completedInDomain = $domain->topics
                    ->whereIn('id', $completedTopicIds->all())
                    ->count();

                $totalInDomain = $domain->topics->count();
            @endphp

            <a
                href="{{ route('student.topics.index', $domain->id) }}"
                class="ns-world-card ns-{{ $visual['color'] }}"
                style="text-decoration: none;"
            >

                <div class="ns-world-art">
                    <span class="ns-world-index">
                        {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                    </span>

                    <div class="ns-world-symbol">
                        {{ $visual['symbol'] }}
                    </div>

                    <div class="ns-world-illustration">
                        {{ $visual['icon'] }}
                    </div>

                    <span class="ns-world-spark">✦</span>
                </div>

                <div class="ns-world-info">
                    <h3>{{ $domain->name }}</h3>
                    <p>{{ $domain->description ?: $visual['subtitle'] }}</p>
                </div>

                <div class="ns-world-footer">
                    <span class="ns-mission-count">
                        <span>♧</span>
                        {{ $completedInDomain }}/{{ $totalInDomain }}
                    </span>

                    <span
                        class="ns-round-arrow"
                        aria-label="Jumlah topik tersedia"
                        title="{{ $totalInDomain }} topik tersedia"
                    >
                        →
                    </span>
                </div>

            </a>

        @empty

            <p>
                Belum ada topik aktif untuk kelasmu.
                Silakan hubungi guru atau administrator sekolah.
            </p>

        @endforelse

    </div>
</section>

{{-- ASESMEN TERSEDIA --}}
<section class="ns-section" id="asesmen">

    <div class="ns-section-heading">
        <div class="ns-heading-left">
            <span class="ns-section-number">✎</span>
            <div>
                <h2>Asesmen Numerasi</h2>
                <p>
                    Pilih asesmen dari topik yang sudah memiliki
                    soal disetujui guru.
                </p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-3">

        @forelse($availableAssessmentTopics as $topic)

            <article class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">

                <p class="text-xs font-semibold text-emerald-700">
                    {{ $topic->learningDomain->name ?? 'Numerasi' }}
                    · Kelas {{ $profile->grade_level }}
                </p>

                <h3 class="mt-2 font-bold text-gray-800">
                    {{ $topic->title }}
                </h3>

                <p class="mt-2 text-sm text-gray-500">
                    {{ $topic->available_questions_count }} soal tersedia
                </p>

                <a
                    class="mt-4 inline-flex rounded-xl bg-emerald-600 px-4 py-2 text-sm font-semibold text-white"
                    href="{{ route('student.topics.show', $topic) }}"
                >
                    Buka topik →
                </a>

            </article>

        @empty

            <div class="rounded-2xl border border-dashed border-gray-300 bg-white p-6 text-sm text-gray-500 md:col-span-2 xl:col-span-3">
                Belum ada asesmen yang dipublikasikan untuk kelasmu.
                Kamu tetap dapat mempelajari seluruh kartu topik yang tersedia.
            </div>

        @endforelse

    </div>
</section>

{{-- HASIL BELAJAR --}}
<section class="ns-section" id="hasil-belajar">

    <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
        <div>
            <span class="text-xs font-extrabold uppercase tracking-widest text-blue-500">
                🏆 Pencapaianmu
            </span>
            <h2 class="mt-2 text-2xl font-extrabold text-slate-800">
                Galeri Hasil Belajar!
            </h2>
            <p class="mt-1 text-sm text-slate-500">
                Lihat perjalananmu dan temukan hal hebat yang sudah kamu pelajari.
            </p>
        </div>

        <div class="rounded-2xl border border-amber-100 bg-amber-50 px-5 py-3">
            <span class="text-xl">⭐</span>
            <span class="ml-1 text-sm font-bold text-amber-700">
                {{ $completedAssessmentCount }} Asesmen Selesai
            </span>
        </div>
    </div>

    <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-3">

        <div class="rounded-3xl border border-blue-100 bg-blue-50 p-5">
            <div class="flex items-center justify-between">
                <span class="text-sm font-bold text-blue-700">Misi selesai</span>
                <span class="text-3xl">🎯</span>
            </div>
            <p class="mt-3 text-3xl font-black text-blue-800">
                {{ $completedMissions }}
            </p>
            <p class="mt-1 text-xs text-blue-600">Dari {{ $totalMissions }} misi tersedia</p>
        </div>

        <div class="rounded-3xl border border-emerald-100 bg-emerald-50 p-5">
            <div class="flex items-center justify-between">
                <span class="text-sm font-bold text-emerald-700">Progres belajar</span>
                <span class="text-3xl">🌱</span>
            </div>
            <p class="mt-3 text-3xl font-black text-emerald-800">
                {{ $progressPercentage }}%
            </p>
            <p class="mt-1 text-xs text-emerald-600">Terus tumbuh setiap hari!</p>
        </div>

        <div class="rounded-3xl border border-purple-100 bg-purple-50 p-5">
            <div class="flex items-center justify-between">
                <span class="text-sm font-bold text-purple-700">Koleksi lencana</span>
                <span class="text-3xl">🏅</span>
            </div>
            <p class="mt-3 text-3xl font-black text-purple-800">
                {{ collect([1, 3, 5])->filter(fn ($target) => $completedAssessmentCount >= $target)->count() }}/3
            </p>
            <p class="mt-1 text-xs text-purple-600">Lencana berhasil dibuka</p>
        </div>

    </div>

    <div class="mb-4 flex items-center justify-between gap-3">
        <div>
            <h3 class="text-lg font-extrabold text-slate-800">
                📚 Riwayat Petualanganmu
            </h3>
            <p class="mt-1 text-xs text-slate-500">
                Setiap asesmen adalah pengalaman baru!
            </p>
        </div>
        <span class="rounded-full bg-cyan-100 px-3 py-2 text-xs font-bold text-cyan-700">
            {{ $recentAttempts->count() }} Riwayat
        </span>
    </div>

    <div class="space-y-4">

        @forelse($recentAttempts as $attempt)

            <article class="overflow-hidden rounded-3xl border border-sky-100 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-lg">

                <div class="flex flex-col gap-4 p-5 sm:flex-row sm:items-center">

                    <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-cyan-100 to-blue-100 text-3xl">
                        🧠
                    </div>

                    <div class="min-w-0 flex-1">
                        <span class="text-xs font-bold uppercase tracking-wide text-cyan-600">
                            {{ $attempt->topic?->learningDomain?->name ?? 'Petualangan Numerasi' }}
                        </span>

                        <h4 class="mt-1 text-base font-extrabold text-slate-800">
                            {{ $attempt->topic?->title ?? 'Asesmen Numerasi' }}
                        </h4>

                        <p class="mt-1 text-xs text-slate-400">
                            🗓️ {{ $attempt->completed_at?->format('d M Y, H:i') ?? '-' }}
                        </p>
                    </div>

                    <div class="rounded-2xl bg-emerald-50 px-5 py-3 text-center">
                        <p class="text-xs font-semibold text-emerald-600">Nilai kamu</p>
                        <p class="text-2xl font-black text-emerald-700">
                            {{ $attempt->score !== null
                                ? number_format((float) $attempt->score, 0) . '%'
                                : '—' }}
                        </p>
                    </div>

                </div>

                <div class="border-t border-sky-50 bg-sky-50/60 p-4">

                    @php
                        $topicDecision = $attempt->topicReview?->decision;
                        $topicDecisionLabel = match ($topicDecision) {
                            'confirmed' => 'Diagnosis topik sudah ditinjau guru',
                            'needs_revision' => 'Diagnosis topik perlu ditinjau ulang',
                            default => 'Diagnosis topik menunggu tinjauan guru',
                        };
                        $topicDecisionClass = match ($topicDecision) {
                            'confirmed' => 'bg-emerald-50 text-emerald-700',
                            'needs_revision' => 'bg-rose-50 text-rose-700',
                            default => 'bg-amber-50 text-amber-700',
                        };
                    @endphp

                    <div class="mb-3 flex flex-wrap items-center justify-between gap-2">
                        <span class="rounded-full px-3 py-1.5 text-[11px] font-bold {{ $topicDecisionClass }}">
                            {{ $topicDecisionLabel }}
                        </span>
                        <span class="text-[11px] font-semibold text-slate-500">
                            {{ $attempt->answers->count() }} tantangan
                        </span>
                    </div>

                    @if($attempt->answers->isNotEmpty())

                        <div class="grid grid-cols-1 gap-2 sm:grid-cols-2">

                            @foreach($attempt->answers as $answer)

                                <div class="flex min-w-0 items-center justify-between gap-2 rounded-xl border border-white bg-white px-3 py-2.5">

                                    <div class="flex min-w-0 items-center gap-2.5">
                                        <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg {{ $answer->analysis ? 'bg-cyan-50 text-cyan-700' : 'bg-slate-100 text-slate-500' }} text-sm">
                                            {{ $answer->analysis ? '✓' : '…' }}
                                        </span>

                                        <div class="min-w-0">
                                            <p class="text-xs font-bold text-slate-700">
                                                Tantangan {{ $loop->iteration }}
                                            </p>
                                            <p class="mt-0.5 truncate text-[10px] text-slate-500">
                                                {{ $answer->analysis ? 'Perjalanan berpikir tersedia' : 'Analisis belum tersedia' }}
                                            </p>
                                        </div>
                                    </div>

                                    @if($answer->analysis)
                                        <a
                                            href="{{ route('student.verifications.show', ['analysis' => $answer->analysis->id]) }}"
                                            class="shrink-0 rounded-lg bg-gradient-to-r from-cyan-500 to-blue-500 px-3 py-2 text-[10px] font-extrabold text-white shadow-sm transition hover:from-cyan-600 hover:to-blue-600"
                                            aria-label="Lihat perjalanan berpikir tantangan {{ $loop->iteration }}"
                                        >
                                            Lihat →
                                        </a>
                                    @else
                                        <span class="shrink-0 text-[10px] text-slate-400">Belum ada</span>
                                    @endif

                                </div>

                            @endforeach

                        </div>

                    @else

                        <p class="rounded-2xl bg-white p-4 text-sm text-slate-500">
                            Belum ada jawaban yang tercatat pada asesmen ini.
                        </p>

                    @endif

                </div>

            </article>

        @empty

            <div class="rounded-3xl border-2 border-dashed border-sky-200 bg-white px-6 py-12 text-center">
                <div class="text-6xl">🚀</div>
                <h3 class="mt-4 text-lg font-extrabold text-slate-800">
                    Petualanganmu Baru Dimulai!
                </h3>
                <p class="mx-auto mt-2 max-w-md text-sm text-slate-500">
                    Selesaikan asesmen pertamamu untuk mengisi galeri hasil belajar ini.
                    Setiap langkah kecil adalah sebuah pencapaian!
                </p>
                <a href="#dunia-belajar"
                   class="mt-5 inline-flex rounded-full bg-cyan-500 px-6 py-3 text-sm font-bold text-white hover:bg-cyan-600">
                    Mulai Belajar ✨
                </a>
            </div>

        @endforelse

    </div>

</section>

{{-- LENCANA --}}
<section class="ns-section" id="lencana">

    <div class="ns-section-heading">
        <div class="ns-heading-left">
            <span class="ns-section-number">★</span>
            <div>
                <h2>Lencana Kecakapan</h2>
                <p>Penghargaan berdasarkan aktivitas belajarmu.</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">

        @php
            $badges = [
                [
                    'title' => 'Langkah Pertama',
                    'desc' => 'Selesaikan asesmen pertamamu.',
                    'unlocked' => $completedAssessmentCount >= 1,
                    'icon' => '🌱',
                ],
                [
                    'title' => 'Penjelajah Numerasi',
                    'desc' => 'Selesaikan 3 asesmen.',
                    'unlocked' => $completedAssessmentCount >= 3,
                    'icon' => '🧭',
                ],
                [
                    'title' => 'Sahabat Angka',
                    'desc' => 'Selesaikan 5 asesmen.',
                    'unlocked' => $completedAssessmentCount >= 5,
                    'icon' => '🏅',
                ],
            ];
        @endphp

        @foreach($badges as $badge)

            <article class="rounded-2xl border p-5 {{ $badge['unlocked'] ? 'border-amber-200 bg-amber-50' : 'border-gray-100 bg-white opacity-70' }}">

                <div class="text-3xl">
                    {{ $badge['icon'] }}
                </div>

                <h3 class="mt-3 font-bold text-gray-800">
                    {{ $badge['title'] }}
                </h3>

                <p class="mt-1 text-sm text-gray-500">
                    {{ $badge['desc'] }}
                </p>

                <p class="mt-3 text-xs font-semibold {{ $badge['unlocked'] ? 'text-amber-700' : 'text-gray-400' }}">
                    {{ $badge['unlocked'] ? 'Terbuka' : 'Belum terbuka' }}
                </p>

            </article>

        @endforeach

    </div>
</section>

{{-- REKOMENDASI REMEDIASI --}}
@if($remedialRecommendations->isNotEmpty())

<section class="ns-section" id="materi-remediasi">

    <div class="ns-section-heading">
        <div class="ns-heading-left">
            <span class="ns-section-number">✦</span>

            <div>
                <h2>Rekomendasi Belajarmu</h2>
                <p>
                    Gurumu telah menyiapkan materi untuk membantumu
                    memahami bagian yang masih perlu dipelajari.
                </p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-5 md:grid-cols-2">

        @foreach($remedialRecommendations as $recommendation)

            @php
                $stageLabels = [
                    'reading' => 'Reading (Membaca)',
                    'comprehension' => 'Comprehension (Memahami)',
                    'transformation' => 'Transformation (Transformasi)',
                    'process_skills' => 'Process Skills (Keterampilan Proses)',
                    'encoding' => 'Encoding (Penulisan Jawaban)',
                ];

                $stageLabel = $stageLabels[
                    $recommendation->newmanFinding->stage
                ] ?? $recommendation->newmanFinding->stage;

                $material = $recommendation->remedialMaterial;

                $statusLabels = [
                    'pending' => 'Belum Dikerjakan',
                    'in_progress' => 'Sedang Dikerjakan',
                    'completed' => 'Sudah Diselesaikan',
                ];

                $statusLabel = $statusLabels[$recommendation->status]
                    ?? 'Status Tidak Diketahui';

                $statusClasses = [
                    'pending' => 'bg-amber-50 text-amber-700',
                    'in_progress' => 'bg-blue-50 text-blue-700',
                    'completed' => 'bg-emerald-50 text-emerald-700',
                ];

                $statusClass = $statusClasses[$recommendation->status]
                    ?? 'bg-gray-100 text-gray-600';
            @endphp

            @if($material)

                <article class="rounded-3xl border border-emerald-100 bg-white p-6 shadow-sm">

                    <div class="flex items-center justify-between gap-3">

                        <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700">
                            Rekomendasi Guru
                        </span>

                        <div class="flex flex-wrap items-center justify-end gap-2">

                            <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $statusClass }}">
                                {{ $statusLabel }}
                            </span>

                            <span class="text-sm text-gray-400">
                                Kelas {{ $material->topic->grade_level }}
                            </span>

                        </div>

                    </div>

                    <h3 class="mt-4 text-lg font-bold text-gray-800">
                        {{ $material->title }}
                    </h3>

                    <p class="mt-2 text-sm leading-6 text-gray-500">
                        {{ $material->description }}
                    </p>

                    <div class="mt-4 rounded-xl bg-amber-50 p-4">

                        <p class="text-xs font-semibold text-amber-800">
                            Bagian yang perlu kamu pelajari
                        </p>

                        <p class="mt-1 text-sm text-amber-900">
                            {{ $stageLabel }}
                        </p>

                    </div>

                    <div class="mt-3">

                        <p class="text-xs font-semibold text-gray-600">
                            Pesan dari guru
                        </p>

                        <p class="mt-1 text-sm leading-6 text-gray-500">
                            {{ $recommendation->reason }}
                        </p>

                    </div>

                    <p class="mt-3 text-xs text-gray-400">
                        Topik: {{ $material->topic->title }}
                    </p>

                    <a
                        href="{{ route('student.remedials.show', [
                            'remedial' => $material->id,
                            'recommendation_id' => $recommendation->id,
                        ]) }}"
                        class="mt-5 inline-flex items-center rounded-xl px-5 py-3 text-sm font-semibold text-white transition
                        {{ $recommendation->status === 'completed'
                            ? 'bg-blue-500 hover:bg-blue-600'
                            : 'bg-emerald-500 hover:bg-emerald-600' }}"
                    >
                        {{ $recommendation->status === 'completed'
                            ? 'Pelajari Kembali →'
                            : ($recommendation->status === 'in_progress'
                                ? 'Lanjutkan Belajar →'
                                : 'Pelajari Materi →') }}
                    </a>

                </article>

            @endif

        @endforeach

    </div>

</section>

@endif

{{-- RINGKASAN PROGRES --}}
<section class="ns-bottom-grid" id="perjalanan">

    <article class="ns-progress-card">

        <div class="ns-mini-heading">
            <div>
                <span class="ns-mini-icon">🌱</span>
                <h3>Perjalanan Belajarmu</h3>
            </div>

            <span>Lihat progresmu</span>
        </div>

        <div class="ns-progress-summary">
            <strong>{{ $progressPercentage }}%</strong>

            <span>
                @if($completedMissions === 0)
                    Perjalanan baru dimulai. Yuk, selesaikan misi pertamamu!
                @elseif($completedMissions === $totalMissions)
                    Hebat! Kamu telah menyelesaikan seluruh misi yang tersedia!
                @else
                    Terus semangat! Kamu sudah menyelesaikan
                    {{ $completedMissions }} dari {{ $totalMissions }} misi.
                @endif
            </span>
        </div>

        <div class="ns-progress-track">
            <span style="width: {{ $progressPercentage }}%"></span>
        </div>

        <div class="ns-progress-meta">
            <span>
                {{ $completedMissions }} dari {{ $totalMissions }} misi selesai
            </span>

            <span>
                Target: {{ $totalMissions }} misi
            </span>
        </div>

    </article>

    <article class="ns-quote-card">
        <span class="ns-quote-mark">“</span>

        <p>
            Kesalahan bukan akhir dari belajar.
            Dari setiap kesalahan, kita menemukan
            cara untuk menjadi lebih baik.
        </p>

        <span class="ns-quote-credit">
            Semangat belajar, ya! ✨
        </span>
    </article>

</section>

@endsection
