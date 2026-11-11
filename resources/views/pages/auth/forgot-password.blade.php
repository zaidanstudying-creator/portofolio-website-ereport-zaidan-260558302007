<x-layouts::auth :title="__('Atur ulang kata sandi')">
    <div>
        <p class="eyebrow">Bantuan akun</p>
        <h2>Lupa kata sandi?</h2>
        <p>Masukkan email akun Anda. Jika terdaftar, kami akan mengirim tautan untuk membuat kata sandi baru.</p>
    </div>
    @if (session('status'))<div class="alert-success" role="status">{{ session('status') }}</div>@endif
    <form method="POST" action="{{ route('password.email') }}" class="auth-fields">
        @csrf
        <div class="field"><label for="email">Alamat email</label><input id="email" name="email" value="{{ old('email') }}" type="email" required autofocus autocomplete="email" placeholder="nama@email.com" aria-describedby="@error('email') email-error @enderror">@error('email')<span class="field-error" id="email-error">{{ $message }}</span>@enderror</div>
        <button class="button" type="submit">Kirim tautan pemulihan</button>
    </form>
    <p class="auth-switch"><a href="{{ route('login') }}">Kembali ke halaman masuk</a></p>
</x-layouts::auth>
