<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'E-Report Warga' }} · E-Report Warga</title>
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    @fonts
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@500;600;700;800&display=swap" rel="stylesheet">
</head>
<body class="public-site">
<div class="auth-shell">
    <aside class="auth-aside"><a class="brand" href="{{ route('home') }}" wire:navigate><span class="brand-mark" aria-hidden="true">ER</span><span><strong>E-Report</strong><small>Suara Warga, Langkah Perubahan</small></span></a><div><p class="eyebrow">Layanan untuk lingkungan kita</p><h1>Perubahan dimulai dari Anda.</h1><p>Sampaikan persoalan di sekitar Anda dan ikuti perkembangannya dengan mudah.</p></div><a class="text-link" href="{{ route('home') }}">Kembali ke beranda</a></aside>
    <main class="auth-main"><div class="auth-form">{{ $slot }}</div></main>
</div>
</body>
</html>
