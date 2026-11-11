<?php

use App\Concerns\PasswordValidationRules;
use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

new class extends Component
{
    use PasswordValidationRules;

    public string $password = '';

    /**
     * Delete the currently authenticated user.
     */
    public function deleteUser(Logout $logout): void
    {
        $this->validate([
            'password' => $this->currentPasswordRules(),
        ]);

        tap(Auth::user(), $logout(...))->delete();

        $this->redirect('/', navigate: true);
    }
}; ?>

<flux:modal name="confirm-user-deletion" :show="$errors->isNotEmpty()" focusable class="max-w-lg">
    <form method="POST" wire:submit="deleteUser" class="settings-delete-form">
        <div class="settings-section-heading">
            <h2>Konfirmasi penghapusan akun</h2>
            <p>Semua data dan laporan pada akun ini akan dihapus permanen. Masukkan kata sandi untuk melanjutkan.</p>
        </div>

        <div class="field">
            <label for="delete-account-password">Kata sandi</label>
            <input id="delete-account-password" wire:model="password" type="password" autocomplete="current-password" required>
            @error('password') <span class="field-error">{{ $message }}</span> @enderror
        </div>

        <div class="settings-actions">
            <flux:modal.close>
                <button class="button-secondary" type="button">Batal</button>
            </flux:modal.close>

            <button class="button-danger" type="submit" data-test="confirm-delete-user-button">Hapus akun</button>
        </div>
    </form>
</flux:modal>
