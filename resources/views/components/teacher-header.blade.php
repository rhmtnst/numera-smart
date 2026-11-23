<header class="ns-topbar">
    <button type="button" class="ns-icon-button ns-menu-toggle" @click="sidebarOpen = true" aria-label="Buka menu">☰</button>
    <div class="ns-topbar-context">
        <span class="ns-context-dot"></span>
        Ruang Guru
        <span class="ns-context-divider">/</span>
        <strong>{{ trim($__env->yieldContent('title')) ?: 'Dashboard' }}</strong>
    </div>
    <div class="ns-topbar-actions">
        <div class="ns-profile-wrapper" x-data="{ profileOpen: false }" @click.outside="profileOpen = false">
            <button type="button" class="ns-profile-chip" @click="profileOpen = !profileOpen" :aria-expanded="profileOpen">
                <span class="ns-avatar">👨‍🏫</span>
                <span class="ns-profile-text"><strong>{{ auth()->user()->name }}</strong><small>Guru</small></span>
                <span class="ns-chevron">⌄</span>
            </button>
            <div x-cloak x-show="profileOpen" x-transition class="ns-profile-dropdown">
                <div class="ns-dropdown-info"><strong>{{ auth()->user()->name }}</strong><small>{{ auth()->user()->email }}</small></div>
                <div class="ns-dropdown-divider"></div>
                <form action="{{ route('logout') }}" method="POST">@csrf
                    <button type="submit" class="ns-logout-button"><span>↪</span> Keluar dari akun</button>
                </form>
            </div>
        </div>
    </div>
</header>
