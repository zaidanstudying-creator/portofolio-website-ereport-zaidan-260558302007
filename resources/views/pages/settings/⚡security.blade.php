<?php

use App\Concerns\PasswordValidationRules;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Keamanan akun')] class extends Component
{
    use PasswordValidationRules;

    public string $current_password = '';

    public string $password = '';

    public string $password_confirmation = '';

    public ?string $successMessage = null;

    public function updatePassword(): void
    {
        $validated = $this->validate([
            'current_password' => $this->currentPasswordRules(),
            'password' => $this->passwordRules(),
        ]);

        Auth::user()->update([
            'password' => $validated['password'],
        ]);

        $this->reset('current_password', 'password', 'password_confirmation');

        $this->successMessage = 'Kata sandi berhasil diperbarui.';
    }
}; ?>

<section class="w-full">
    <x-pages::settings.layout heading="Keamanan akun" subheading="Lindungi akun dengan kata sandi yang hanya Anda gunakan di sini.">
        <form wire:submit="updatePassword" class="settings-form">
            <div class="settings-section-heading">
                <h2>Ubah kata sandi</h2>
                <p>Masukkan kata sandi saat ini sebelum memilih kata sandi baru.</p>
            </div>

            @if ($successMessage)
                <div class="alert-success" role="status">{{ $successMessage }}</div>
            @endif

            <div class="settings-fields">
                <div class="field">
                    <label for="current-password">Kata sandi saat ini</label>
                    <div class="password-input">
                        <input id="current-password" wire:model="current_password" type="password" required autocomplete="current-password" aria-describedby="@error('current_password') current-password-error @enderror">
                        <button type="button" data-password-toggle="current-password" aria-label="Tampilkan kata sandi saat ini">Lihat</button>
                    </div>
                    @error('current_password') <span class="field-error" id="current-password-error">{{ $message }}</span> @enderror
                </div>

                <div class="field">
                    <label for="new-password">Kata sandi baru</label>
                    <div class="password-input">
                        <input id="new-password" wire:model="password" type="password" required autocomplete="new-password" aria-describedby="@error('password') new-password-error @enderror">
                        <button type="button" data-password-toggle="new-password" aria-label="Tampilkan kata sandi baru">Lihat</button>
                    </div>
                    @error('password') <span class="field-error" id="new-password-error">{{ $message }}</span> @enderror
                </div>

                <div class="field">
                    <label for="password-confirmation">Ulangi kata sandi baru</label>
                    <div class="password-input">
                        <input id="password-confirmation" wire:model="password_confirmation" type="password" required autocomplete="new-password">
                        <button type="button" data-password-toggle="password-confirmation" aria-label="Tampilkan konfirmasi kata sandi baru">Lihat</button>
                    </div>
                </div>
            </div>

            <div class="settings-actions">
                <button class="button" type="submit" wire:loading.attr="disabled" wire:target="updatePassword">
                    <span wire:loading.remove wire:target="updatePassword">Simpan kata sandi</span>
                    <span wire:loading wire:target="updatePassword">Menyimpan…</span>
                </button>
            </div>
        </form>
    </x-pages::settings.layout>
</section>
