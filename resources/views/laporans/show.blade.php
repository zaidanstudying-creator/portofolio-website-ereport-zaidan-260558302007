<x-layouts::civic title="Detail laporan">
    <x-page-header eyebrow="Laporan saya" :title="$laporan->judul" description="Dikirim {{ $laporan->created_at->format('d M Y') }}" >
        <x-slot:action><a class="button-secondary" href="{{ route('laporans.index') }}">Kembali ke laporan</a></x-slot:action>
    </x-page-header>
    <div class="detail-layout"><article><dl class="detail-meta"><div><dt>Tanggal kejadian</dt><dd>{{ $laporan->tanggal->format('d M Y') }}</dd></div><div><dt>Dikirim pada</dt><dd>{{ $laporan->created_at->format('d M Y, H:i') }}</dd></div></dl><h2 class="section-title">Keterangan</h2><p class="detail-copy">{{ $laporan->detail }}</p>@if($laporan->foto)<img class="report-photo" src="{{ route('laporans.photo', $laporan) }}" alt="Foto pendukung laporan: {{ $laporan->judul }}">@endif</article>
        <aside class="detail-side"><h2>Perkembangan</h2><p><span class="status status-{{ $laporan->status }}">{{ ucfirst($laporan->status === 'proses' ? 'Diproses' : ($laporan->status === 'pending' ? 'Menunggu' : 'Selesai')) }}</span></p><p>{{ ['pending' => 'Laporan diterima dan menunggu tindak lanjut.', 'proses' => 'Petugas sedang meninjau atau menangani laporan.', 'selesai' => 'Penanganan laporan telah dinyatakan selesai.'][$laporan->status] }}</p>
            @can('update', $laporan)<div class="inline-actions"><a class="button-secondary" href="{{ route('laporans.edit', $laporan) }}">Edit laporan</a><form method="POST" action="{{ route('laporans.destroy', $laporan) }}" onsubmit="return confirm('Hapus laporan ini? Tindakan ini tidak dapat dibatalkan.');">@csrf @method('DELETE')<button class="button-secondary" type="submit" style="color:var(--danger)">Hapus</button></form></div>@endcan
        </aside></div>
</x-layouts::civic>
