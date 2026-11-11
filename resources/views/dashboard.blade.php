@php($counts = collect($counts))
<x-layouts::civic title="Beranda">
    <x-page-header eyebrow="Ruang warga" title="Selamat datang, {{ auth()->user()->name }}" description="Pantau laporan yang Anda kirim dan lihat perkembangannya." >
        <x-slot:action><a class="button" href="{{ route('laporans.create') }}">Buat pengaduan</a></x-slot:action>
    </x-page-header>
    <div class="summary-layout">
        <section aria-labelledby="recent-title">
            <div class="section-top"><h2 class="section-title" id="recent-title">Laporan terbaru</h2><a class="text-link" href="{{ route('laporans.index') }}">Lihat semua</a></div>
            @if($recent->isEmpty())
                <div class="empty-state"><p>Belum ada laporan dari akun Anda.</p><a class="text-link" href="{{ route('laporans.create') }}">Kirim laporan pertama</a></div>
            @else
                <div class="table-wrap"><table class="report-table"><thead><tr><th>Judul</th><th>Tanggal</th><th>Status</th><th>Aksi</th></tr></thead><tbody>
                    @foreach($recent as $laporan)<tr><td>{{ $laporan->judul }}</td><td>{{ $laporan->created_at->format('d M Y') }}</td><td><span class="status status-{{ $laporan->status }}">{{ ucfirst($laporan->status === 'proses' ? 'Diproses' : ($laporan->status === 'pending' ? 'Menunggu' : 'Selesai')) }}</span></td><td><a class="text-link" href="{{ route('laporans.show', $laporan) }}">Detail</a></td></tr>@endforeach
                </tbody></table></div>
            @endif
        </section>
        <aside aria-labelledby="summary-title"><div class="section-top"><h2 class="section-title" id="summary-title">Ringkasan status</h2></div><div class="status-legend">
            <div class="status-line"><span class="status status-pending">Menunggu</span><strong>{{ $counts->get('pending', 0) }}</strong></div>
            <div class="status-line"><span class="status status-proses">Diproses</span><strong>{{ $counts->get('proses', 0) }}</strong></div>
            <div class="status-line"><span class="status status-selesai">Selesai</span><strong>{{ $counts->get('selesai', 0) }}</strong></div>
            <div class="status-line"><span>Total laporan</span><strong>{{ $counts->sum() }}</strong></div>
        </div><p class="quiet-note">Laporan hanya dapat diubah saat masih berstatus menunggu.</p></aside>
    </div>
</x-layouts::civic>
