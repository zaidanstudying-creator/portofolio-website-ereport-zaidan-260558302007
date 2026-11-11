<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <title>E-Report Warga · Suara Warga, Langkah Perubahan</title>
    <meta name="description" content="Laporkan permasalahan di sekitar Anda dan ikuti proses penanganannya dengan E-Report Warga.">
    <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="public-site">
<nav class="public-nav" aria-label="Navigasi utama">
    <a class="brand" href="{{ route('home') }}"><span class="brand-mark" aria-hidden="true">ER</span><span><strong>E-Report</strong><small>Suara Warga, Langkah Perubahan</small></span></a>
    <div class="public-links"><a href="#cara-melapor">Cara melapor</a><a href="#tentang">Tentang layanan</a><a href="{{ route('login') }}">Masuk</a><a class="button" href="{{ route('register') }}">Buat laporan</a></div>
</nav>
<main>
    <section class="public-hero">
        <div><p class="eyebrow">Layanan pengaduan warga</p><h1>Suara warga, perubahan nyata.</h1><p class="lead">Sampaikan permasalahan di sekitar Anda, ikuti proses penanganannya, dan bantu wujudkan pelayanan masyarakat yang lebih responsif.</p><div class="hero-actions"><a class="button" href="{{ route('register') }}">Buat pengaduan</a><a class="button-secondary" href="#cara-melapor">Pelajari cara kerja</a></div></div>
        <div class="hero-art" aria-label="Contoh perjalanan sebuah laporan"><span class="hero-art-label">Perjalanan laporan warga</span><div class="report-ticket"><div class="ticket-top"><span>Contoh laporan</span><span>ER · 001</span></div><h2 class="ticket-title">Lampu jalan padam</h2><p class="ticket-copy">Gang Melati · Dilaporkan oleh warga<br>22 Oktober 2026</p><div class="ticket-track"><span>Diterima</span><span>Dalam proses</span><span>Ditangani</span></div></div><span class="hero-art-label">Dari informasi menjadi tindak lanjut</span></div>
    </section>
    <section class="landing-section" id="cara-melapor"><div class="landing-inner"><p class="eyebrow">Proses yang jelas</p><h2>Setiap laporan punya langkah berikutnya.</h2><p>Anda dapat mengirimkan laporan, melihat perkembangannya, dan mengetahui saat penanganan selesai.</p><div class="steps"><article class="step"><span class="step-number">01 · Kirim</span><h3>Ceritakan yang terjadi</h3><p>Tulis judul, detail kejadian, tanggal, dan tambahkan foto jika membantu menjelaskan.</p></article><article class="step"><span class="step-number">02 · Pantau</span><h3>Ikuti pembaruan</h3><p>Laporan tersimpan di akun Anda. Perubahan status dapat dilihat kapan saja.</p></article><article class="step"><span class="step-number">03 · Tuntas</span><h3>Lihat hasil penanganan</h3><p>Petugas memperbarui status saat laporan mulai diproses hingga selesai ditangani.</p></article></div></div></section>
    <section class="landing-section" id="tentang" style="background:#edf0ea"><div class="landing-inner"><p class="eyebrow">Untuk kebutuhan sekitar kita</p><h2>Hal yang berdampak pada kenyamanan bersama.</h2><p>Gunakan layanan untuk menyampaikan persoalan lingkungan dan fasilitas umum secara tertib.</p><div class="issue-list"><div>Jalan rusak dan akses lingkungan</div><div>Lampu jalan dan penerangan umum</div><div>Saluran air, genangan, dan sampah</div><div>Fasilitas umum yang perlu perbaikan</div><div>Gangguan ketertiban lingkungan</div><div>Persoalan layanan lingkungan lainnya</div></div></div></section>
    <section class="landing-section"><div class="landing-inner"><p class="eyebrow">Status laporan</p><h2>Informasi perkembangan yang mudah dipahami.</h2><div class="landing-statuses"><article><span class="status status-pending">Menunggu</span><h3>Pending</h3><p>Laporan sudah diterima dan menunggu tindak lanjut petugas.</p></article><article><span class="status status-proses">Diproses</span><h3>Proses</h3><p>Petugas sedang meninjau atau menangani laporan.</p></article><article><span class="status status-selesai">Selesai</span><h3>Selesai</h3><p>Penanganan laporan telah dinyatakan selesai.</p></article></div></div></section>
    <section class="landing-section" style="background:#edf0ea"><div class="landing-inner"><p class="eyebrow">Privasi dan pertanyaan</p><h2>Informasi laporan terkait dengan akun Anda.</h2><div class="faq-list"><details><summary>Apakah saya bisa melihat laporan warga lain?</summary><p>Tidak. Warga hanya dapat melihat laporan yang dibuat melalui akunnya sendiri.</p></details><details><summary>Apakah foto harus disertakan?</summary><p>Tidak. Foto bersifat opsional dan dapat ditambahkan jika membantu menjelaskan kondisi.</p></details><details><summary>Bisakah laporan diubah setelah dikirim?</summary><p>Laporan dapat diperbarui atau dihapus selama statusnya masih menunggu.</p></details></div></div></section>
    <section class="landing-section"><div class="landing-inner cta-band"><div><p class="eyebrow">Sampaikan dengan jelas</p><h2>Mulai dari satu laporan yang bermanfaat.</h2></div><a class="button" href="{{ route('register') }}">Buat pengaduan</a></div></section>
</main>
<footer class="public-footer"><div class="landing-inner">E-Report Warga · Suara Warga, Langkah Perubahan.</div></footer>
</body></html>
