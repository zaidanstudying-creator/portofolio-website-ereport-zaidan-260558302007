@props(['heading' => 'Pengaturan akun', 'subheading' => null])

<section class="settings-page">
    <header class="page-heading">
        <div>
            <p class="eyebrow">PENGATURAN AKUN</p>
            <h1>{{ $heading ?? 'Pengaturan akun' }}</h1>
            @if ($subheading)
                <p class="page-description">{{ $subheading }}</p>
            @endif
        </div>
    </header>

    <nav class="settings-nav" aria-label="Pengaturan akun">
        <a href="{{ route('profile.edit') }}" wire:navigate @class(['active' => request()->routeIs('profile.edit')]) @if (request()->routeIs('profile.edit')) aria-current="page" @endif>Profil</a>
        <a href="{{ route('security.edit') }}" wire:navigate @class(['active' => request()->routeIs('security.edit')]) @if (request()->routeIs('security.edit')) aria-current="page" @endif>Keamanan</a>
    </nav>

    <div class="settings-content">
        {{ $slot }}
    </div>
</section>
