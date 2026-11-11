<x-layouts::civic title="Edit laporan">
    <x-page-header eyebrow="Laporan menunggu" title="Perbarui laporan" description="Laporan dapat diubah selama belum mulai diproses." />
    <div class="form-layout">
        <form method="POST" action="{{ route('laporans.update', $laporan) }}" enctype="multipart/form-data" novalidate>@csrf @method('PUT')
            @if($errors->any())<div class="form-error-summary" role="alert" tabindex="-1"><strong>Periksa kembali isian berikut:</strong><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
            <div class="field"><label for="judul">Judul pengaduan <span aria-hidden="true">*</span></label><input id="judul" name="judul" value="{{ old('judul', $laporan->judul) }}" required maxlength="255">@error('judul')<span class="field-error">{{ $message }}</span>@enderror</div>
            <div class="field"><label for="detail">Detail pengaduan <span aria-hidden="true">*</span></label><textarea id="detail" name="detail" required maxlength="10000">{{ old('detail', $laporan->detail) }}</textarea>@error('detail')<span class="field-error">{{ $message }}</span>@enderror</div>
            <div class="field"><label for="tanggal">Tanggal kejadian <span aria-hidden="true">*</span></label><input id="tanggal" name="tanggal" type="date" value="{{ old('tanggal', $laporan->tanggal->toDateString()) }}" max="{{ now()->toDateString() }}" required>@error('tanggal')<span class="field-error">{{ $message }}</span>@enderror</div>
            <div class="field"><label for="foto">Foto pengaduan <span>(opsional)</span></label>@if($laporan->foto)<img class="report-photo" src="{{ route('laporans.photo', $laporan) }}" alt="Foto laporan saat ini">@endif<input id="foto" name="foto" type="file" accept="image/jpeg,image/png,image/webp"><p class="field-hint">JPG, PNG, atau WebP. Maksimal 5 MB. Pilih berkas baru untuk mengganti foto.</p>@error('foto')<span class="field-error">{{ $message }}</span>@enderror</div>
            <div class="form-actions"><button class="button" type="submit">Simpan perubahan</button><a class="text-link" href="{{ route('laporans.show', $laporan) }}">Kembali ke detail</a></div>
        </form>
        <aside class="form-aside"><h2>Status laporan</h2><p>Laporan ini masih menunggu tindak lanjut. Setelah petugas mulai memprosesnya, isian tidak lagi dapat diubah.</p></aside>
    </div>
</x-layouts::civic>
