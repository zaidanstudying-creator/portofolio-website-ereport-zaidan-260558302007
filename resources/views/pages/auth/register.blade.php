<x-layouts::auth :title="__('Daftar')">
    <div>
        <p class="eyebrow">Mulai melapor</p>
        <h2>Buat akun warga.</h2>
        <p>Daftarkan akun untuk mengirim dan memantau laporan Anda.</p>
    </div>
    @if (session('status'))<div class="alert-success" role="status">{{ session('status') }}</div>@endif
    <form method="POST" action="{{ route('register.store') }}" class="auth-fields">
        @csrf
        <div class="field"><label for="name">Nama lengkap</label><input id="name" name="name" value="{{ old('name') }}" type="text" required autofocus autocomplete="name" placeholder="Nama sesuai identitas">@error('name')<span class="field-error">{{ $message }}</span>@enderror</div>
        <div class="field"><label for="email">Alamat email</label><input id="email" name="email" value="{{ old('email') }}" type="email" required autocomplete="email" placeholder="nama@email.com">@error('email')<span class="field-error">{{ $message }}</span>@enderror</div>
        <div class="field"><label for="password">Kata sandi</label><div class="password-input"><input id="password" name="password" type="password" required autocomplete="new-password" passwordrules="{{ \Illuminate\Validation\Rules\Password::defaults()->toPasswordRulesString() }}"><button type="button" data-password-toggle="password" aria-label="Tampilkan kata sandi">Lihat</button></div>@error('password')<span class="field-error">{{ $message }}</span>@enderror</div>
        <div class="field"><label for="password_confirmation">Ulangi kata sandi</label><div class="password-input"><input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password" passwordrules="{{ \Illuminate\Validation\Rules\Password::defaults()->toPasswordRulesString() }}"><button type="button" data-password-toggle="password_confirmation" aria-label="Tampilkan konfirmasi kata sandi">Lihat</button></div></div>
        <p class="field-hint">Pendaftaran publik otomatis membuat akun warga.</p>
        <button class="button" type="submit">Buat akun warga</button>
    </form>
    <p class="auth-switch">Sudah punya akun? <a href="{{ route('login') }}">Masuk</a></p>
</x-layouts::auth>
