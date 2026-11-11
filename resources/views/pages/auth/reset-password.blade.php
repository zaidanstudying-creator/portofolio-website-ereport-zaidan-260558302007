<x-layouts::auth :title="__('Buat kata sandi baru')">
    <div>
        <p class="eyebrow">Pemulihan akun</p>
        <h2>Buat kata sandi baru.</h2>
        <p>Pilih kata sandi baru untuk melindungi akun E-Report Warga Anda.</p>
    </div>
    <form method="POST" action="{{ route('password.update') }}" class="auth-fields">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <div class="field"><label for="email">Alamat email</label><input id="email" name="email" value="{{ old('email', $email) }}" type="email" required autocomplete="email">@error('email')<span class="field-error">{{ $message }}</span>@enderror</div>
        <div class="field"><label for="password">Kata sandi baru</label><div class="password-input"><input id="password" name="password" type="password" required autocomplete="new-password"><button type="button" data-password-toggle="password" aria-label="Tampilkan kata sandi">Lihat</button></div>@error('password')<span class="field-error">{{ $message }}</span>@enderror</div>
        <div class="field"><label for="password_confirmation">Ulangi kata sandi</label><div class="password-input"><input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password"><button type="button" data-password-toggle="password_confirmation" aria-label="Tampilkan konfirmasi kata sandi">Lihat</button></div></div>
        <button class="button" type="submit">Simpan kata sandi baru</button>
    </form>
</x-layouts::auth>
