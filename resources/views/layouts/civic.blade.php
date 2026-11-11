<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'E-Report Warga' }} · E-Report Warga</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="civic-app">
<a class="skip-link" href="#main-content">Lewati ke konten</a>
<div class="app-frame">
    <aside class="app-sidebar" id="app-sidebar" aria-label="Navigasi utama">
        <a class="brand" href="{{ route('dashboard') }}"><span class="brand-mark" aria-hidden="true">ER</span><span><strong>E-Report</strong><small>Suara Warga, Langkah Perubahan</small></span></a>
        <div class="nav-caption">RUANG KERJA</div>
        <nav class="side-nav">
            @if(auth()->user()->role === 'admin')
                <a class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">Ikhtisar</a>
                <a class="{{ request()->routeIs('admin.laporans.*') ? 'active' : '' }}" href="{{ route('admin.laporans.index') }}">Semua pengaduan</a>
            @else
                <a class="{{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">Beranda</a>
                <a class="{{ request()->routeIs('laporans.index') ? 'active' : '' }}" href="{{ route('laporans.index') }}">Laporan saya</a>
                <a class="{{ request()->routeIs('laporans.create') ? 'active' : '' }}" href="{{ route('laporans.create') }}">Buat laporan</a>
            @endif
            <a class="{{ request()->routeIs('profile.edit') ? 'active' : '' }}" href="{{ route('profile.edit') }}">Profil saya</a>
            <a class="{{ request()->routeIs('security.edit') ? 'active' : '' }}" href="{{ route('security.edit') }}">Keamanan akun</a>
        </nav>
        <div class="sidebar-bottom">
            <div class="user-chip"><span class="avatar">{{ auth()->user()->initials() }}</span><span><strong>{{ auth()->user()->name }}</strong><small>{{ auth()->user()->role === 'admin' ? 'Administrator' : 'Warga' }}</small></span></div>
            <form method="POST" action="{{ route('logout') }}">@csrf<button class="logout-button" type="submit">Keluar dari akun</button></form>
        </div>
    </aside>
    <div class="app-workspace">
        <header class="app-topbar"><button class="menu-toggle" type="button" aria-label="Buka navigasi" aria-expanded="false" aria-controls="app-sidebar">☰</button><span>E-Report Warga</span><span class="topbar-user">{{ auth()->user()->name }}</span></header>
        <main id="main-content" class="work-sheet">
            @if(session('status'))<div class="alert-success" role="status">{{ session('status') }}</div>@endif
            {{ $slot }}
        </main>
    </div>
</div>
@livewireScripts
@fluxScripts
<div class="nav-scrim" hidden></div>
<script>
    (() => {
        const button = document.querySelector('.menu-toggle');
        const sidebar = document.querySelector('.app-sidebar');
        const scrim = document.querySelector('.nav-scrim');
        const mobile = window.matchMedia('(max-width: 900px)');
        const syncInert = () => { sidebar.inert = mobile.matches && !sidebar.classList.contains('is-open'); };
        const close = (restoreFocus = true) => { sidebar.classList.remove('is-open'); scrim.hidden = true; button.setAttribute('aria-expanded', 'false'); syncInert(); if (restoreFocus && mobile.matches) button.focus(); };
        syncInert();
        mobile.addEventListener('change', syncInert);
        button.addEventListener('click', () => { const open = sidebar.classList.toggle('is-open'); scrim.hidden = !open; button.setAttribute('aria-expanded', String(open)); syncInert(); if (open) sidebar.querySelector('a')?.focus(); });
        scrim.addEventListener('click', close);
        document.addEventListener('keydown', event => {
            if (event.key === 'Escape' && sidebar.classList.contains('is-open')) close();
            if (event.key === 'Tab' && sidebar.classList.contains('is-open')) {
                const controls = [...sidebar.querySelectorAll('a[href], button:not([disabled])')];
                const first = controls[0];
                const last = controls.at(-1);
                if (event.shiftKey && document.activeElement === first) { event.preventDefault(); last.focus(); }
                if (!event.shiftKey && document.activeElement === last) { event.preventDefault(); first.focus(); }
            }
        });
    })();
</script>
</body>
</html>
