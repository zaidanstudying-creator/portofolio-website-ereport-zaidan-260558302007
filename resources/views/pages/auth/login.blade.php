<x-layouts::auth :title="__('Masuk')">
    <div>
        <p class="eyebrow">Akun E-Report Warga</p>
        <h2>Selamat datang kembali.</h2>
        <p>Masuk untuk melihat laporan dan perkembangannya.</p>
    </div>
    @if (session('status'))<div class="alert-success" role="status">{{ session('status') }}</div>@endif
    <form method="POST" action="{{ route('login.store') }}" class="auth-fields">
        @csrf
        <div class="field"><label for="email">Alamat email</label><input id="email" name="email" value="{{ old('email') }}" type="email" required autofocus autocomplete="username" placeholder="nama@email.com" aria-describedby="@error('email') email-error @enderror">@error('email')<span class="field-error" id="email-error">{{ $message }}</span>@enderror</div>
        <div class="field"><div class="password-label"><label for="password">Kata sandi</label>@if (Route::has('password.request'))<a href="{{ route('password.request') }}" wire:navigate>Lupa kata sandi?</a>@endif</div><div class="password-input"><input id="password" name="password" type="password" required autocomplete="current-password" placeholder="Masukkan kata sandi"><button type="button" data-password-toggle="password" aria-label="Tampilkan kata sandi">Lihat</button></div>@error('password')<span class="field-error">{{ $message }}</span>@enderror</div>
        <label class="remember-control"><input type="checkbox" name="remember" value="1" @checked(old('remember'))> <span>Ingat saya di perangkat ini</span></label>
        <button class="button" type="submit">Masuk</button>
    </form>
    <p class="auth-switch">Belum punya akun? <a href="{{ route('register') }}">Daftar sebagai warga</a></p>
</x-layouts::auth>
