
<div class="mx-auto max-w-5xl space-y-7">

    {{-- BACK NAVIGATION --}}
    <a href="{{ route('admin.schools.index') }}"
       class="group inline-flex items-center gap-2 text-sm font-bold text-slate-500 transition hover:text-blue-700">
        <span class="transition-transform group-hover:-translate-x-1">←</span>
        Kembali ke Manajemen Sekolah
    </a>


    {{-- HERO --}}
    <section class="relative isolate overflow-hidden rounded-[28px] bg-gradient-to-br from-[#087f68] via-[#0da991] to-[#16b9c9] p-7 text-white shadow-xl shadow-emerald-900/10 sm:p-9">
        <div class="pointer-events-none absolute -right-16 -top-20 h-72 w-72 rounded-full border-[36px] border-white/[0.08]"></div>
        <div class="pointer-events-none absolute -bottom-32 right-1/4 h-64 w-64 rounded-full bg-cyan-200/10"></div>

        <div class="relative z-10 flex flex-col justify-between gap-6 sm:flex-row sm:items-center">
            <div class="max-w-2xl">
                <div class="inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-3.5 py-2 text-[10px] font-black uppercase tracking-[.18em] text-white/90 backdrop-blur-sm">
                    <span class="h-2 w-2 rounded-full bg-lime-300"></span>
                    Administrasi Institusi
                </div>

                <h1 class="mt-5 text-3xl font-black tracking-tight sm:text-4xl">
                    {{ $school->exists ? 'Perbarui Data Sekolah' : 'Daftarkan Sekolah Baru' }}
                    <span class="ml-1 inline-block">🏫</span>
                </h1>

                <p class="mt-3 max-w-xl text-sm leading-7 text-emerald-50">
                    {{ $school->exists
                        ? 'Perbarui informasi institusi untuk memastikan data sekolah tetap akurat dan terkini.'
                        : 'Lengkapi informasi institusi pendidikan untuk bergabung dengan ekosistem NUMERA SMART.' }}
                </p>
            </div>

            <div class="hidden h-32 w-32 shrink-0 items-center justify-center rounded-[28px] border border-white/20 bg-white/10 shadow-xl backdrop-blur-md sm:flex">
                <svg class="h-20 w-20 text-white" viewBox="0 0 100 100" fill="none">
                    <path d="M12 42L50 17L88 42" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M20 40V84H80V40" stroke="currentColor" stroke-width="4" stroke-linejoin="round"/>
                    <path d="M39 84V61C39 55 44 50 50 50C56 50 61 55 61 61V84" stroke="currentColor" stroke-width="3"/>
                    <path d="M29 52H34M66 52H71M29 65H34M66 65H71" stroke="currentColor" stroke-width="4" stroke-linecap="round"/>
                    <path d="M50 9V17" stroke="currentColor" stroke-width="4" stroke-linecap="round"/>
                </svg>
            </div>
        </div>
    </section>


    {{-- VALIDATION ERRORS --}}
    @if($errors->any())
        <div class="overflow-hidden rounded-2xl border border-rose-200 bg-rose-50">
            <div class="flex items-start gap-3 p-4">
                <div class="grid h-9 w-9 shrink-0 place-items-center rounded-xl bg-rose-100 text-rose-600">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="9"/>
                        <path d="M12 8v5M12 16h.01" stroke-linecap="round"/>
                    </svg>
                </div>

                <div class="flex-1">
                    <p class="text-sm font-black text-rose-800">Periksa kembali data yang dimasukkan</p>
                    <div class="mt-2 space-y-1 text-xs leading-5 text-rose-700">
                        @foreach($errors->all() as $error)
                            <p>• {{ $error }}</p>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif


    {{-- SCHOOL FORM --}}
    <form
        method="POST"
        action="{{ $school->exists ? route('admin.schools.update', $school) : route('admin.schools.store') }}"
        class="overflow-hidden rounded-[26px] border border-slate-100 bg-white shadow-sm"
    >
        @csrf

        @if($school->exists)
            @method('PUT')
        @endif

        <div class="space-y-8 p-6 sm:p-8">

            {{-- SECTION HEADER --}}
            <div class="flex items-start gap-4 border-b border-slate-100 pb-6">
                <div class="grid h-12 w-12 shrink-0 place-items-center rounded-2xl bg-emerald-50 text-emerald-600">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M3 21h18M5 21V7l8-4 8 4v14M9 21v-6h6v6"/>
                        <path d="M9 9h.01M15 9h.01M9 12h.01M15 12h.01" stroke-width="3" stroke-linecap="round"/>
                    </svg>
                </div>

                <div>
                    <h2 class="text-lg font-black text-slate-800">Informasi Institusi</h2>
                    <p class="mt-1 text-xs leading-5 text-slate-500">
                        Masukkan identitas dan informasi dasar sekolah.
                    </p>
                    <p class="mt-2 text-[10px] font-semibold text-slate-400">
                        <span class="text-rose-500">*</span> Kolom wajib diisi
                    </p>
                </div>
            </div>


            {{-- SCHOOL NAME --}}
            <div>
                <label for="name" class="mb-2 block text-xs font-extrabold uppercase tracking-wider text-slate-600">
                    Nama Sekolah <span class="text-rose-500">*</span>
                </label>

                <input
                    id="name"
                    type="text"
                    name="name"
                    required
                    value="{{ old('name', $school->name) }}"
                    placeholder="Contoh: SD Negeri Numera 01"
                    class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3.5 text-sm font-medium text-slate-700 outline-none transition placeholder:font-normal placeholder:text-slate-400 focus:border-emerald-400 focus:bg-white focus:ring-4 focus:ring-emerald-50"
                >
            </div>


            {{-- NPSN AND STATUS --}}
            <div class="grid gap-5 sm:grid-cols-2">

                <div>
                    <label for="npsn" class="mb-2 block text-xs font-extrabold uppercase tracking-wider text-slate-600">
                        NPSN
                    </label>

                    <input
                        id="npsn"
                        type="text"
                        name="npsn"
                        value="{{ old('npsn', $school->npsn) }}"
                        placeholder="Nomor Pokok Sekolah"
                        class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3.5 text-sm font-medium text-slate-700 outline-none transition placeholder:font-normal placeholder:text-slate-400 focus:border-emerald-400 focus:bg-white focus:ring-4 focus:ring-emerald-50"
                    >

                    <p class="mt-2 text-[10px] text-slate-400">
                        Nomor identitas satuan pendidikan.
                    </p>
                </div>

                <div>
                    <label for="status" class="mb-2 block text-xs font-extrabold uppercase tracking-wider text-slate-600">
                        Status Sekolah <span class="text-rose-500">*</span>
                    </label>

                    <select
                        id="status"
                        name="status"
                        required
                        class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3.5 text-sm font-semibold text-slate-700 outline-none transition focus:border-emerald-400 focus:bg-white focus:ring-4 focus:ring-emerald-50"
                    >
                        <option value="active" @selected(old('status', $school->status ?: 'active') === 'active')>
                            Aktif
                        </option>
                        <option value="inactive" @selected(old('status', $school->status) === 'inactive')>
                            Nonaktif
                        </option>
                    </select>

                    <p class="mt-2 text-[10px] text-slate-400">
                        Tentukan status operasional sekolah.
                    </p>
                </div>

            </div>


            {{-- ADDRESS SECTION --}}
            <div class="border-t border-slate-100 pt-7">
                <div class="mb-5 flex items-center gap-3">
                    <div class="grid h-10 w-10 place-items-center rounded-xl bg-sky-50 text-sky-600">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20 10c0 5-8 12-8 12S4 15 4 10a8 8 0 1 1 16 0Z"/>
                            <circle cx="12" cy="10" r="2.5"/>
                        </svg>
                    </div>

                    <div>
                        <h2 class="text-base font-black text-slate-800">Lokasi Sekolah</h2>
                        <p class="mt-1 text-xs text-slate-500">Lengkapi informasi alamat institusi.</p>
                    </div>
                </div>

                {{-- ADDRESS --}}
                <div>
                    <label for="address" class="mb-2 block text-xs font-extrabold uppercase tracking-wider text-slate-600">
                        Alamat Lengkap
                    </label>

                    <textarea
                        id="address"
                        name="address"
                        rows="4"
                        placeholder="Masukkan alamat lengkap sekolah..."
                        class="w-full resize-y rounded-xl border border-slate-200 bg-slate-50 px-4 py-3.5 text-sm font-medium leading-6 text-slate-700 outline-none transition placeholder:font-normal placeholder:text-slate-400 focus:border-emerald-400 focus:bg-white focus:ring-4 focus:ring-emerald-50"
                    >{{ old('address', $school->address) }}</textarea>
                </div>

                {{-- CITY AND PROVINCE --}}
                <div class="mt-5 grid gap-5 sm:grid-cols-2">

                    <div>
                        <label for="city" class="mb-2 block text-xs font-extrabold uppercase tracking-wider text-slate-600">
                            Kabupaten / Kota
                        </label>

                        <input
                            id="city"
                            type="text"
                            name="city"
                            value="{{ old('city', $school->city) }}"
                            placeholder="Contoh: Medan"
                            class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3.5 text-sm font-medium text-slate-700 outline-none transition placeholder:font-normal placeholder:text-slate-400 focus:border-emerald-400 focus:bg-white focus:ring-4 focus:ring-emerald-50"
                        >
                    </div>

                    <div>
                        <label for="province" class="mb-2 block text-xs font-extrabold uppercase tracking-wider text-slate-600">
                            Provinsi
                        </label>

                        <input
                            id="province"
                            type="text"
                            name="province"
                            value="{{ old('province', $school->province) }}"
                            placeholder="Contoh: Sumatera Utara"
                            class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3.5 text-sm font-medium text-slate-700 outline-none transition placeholder:font-normal placeholder:text-slate-400 focus:border-emerald-400 focus:bg-white focus:ring-4 focus:ring-emerald-50"
                        >
                    </div>

                </div>
            </div>

        </div>


        {{-- FORM ACTIONS --}}
        <div class="flex flex-col-reverse justify-between gap-3 border-t border-slate-100 bg-slate-50/80 p-6 sm:flex-row sm:items-center sm:px-8">

            <a
                href="{{ route('admin.schools.index') }}"
                class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-5 py-3 text-sm font-bold text-slate-600 transition hover:border-slate-300 hover:bg-slate-100"
            >
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M19 12H5M12 19l-7-7 7-7"/>
                </svg>
                Batalkan
            </a>

            <button
                type="submit"
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-500 px-6 py-3.5 text-sm font-extrabold text-white shadow-lg shadow-emerald-100 transition duration-300 hover:-translate-y-0.5 hover:shadow-xl"
            >
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    @if($school->exists)
                        <path d="M5 12l4 4L19 6"/>
                    @else
                        <path d="M12 5v14M5 12h14"/>
                    @endif
                </svg>

                {{ $school->exists ? 'Simpan Perubahan' : 'Daftarkan Sekolah' }}

                <span>→</span>
            </button>

        </div>
    </form>

</div>
