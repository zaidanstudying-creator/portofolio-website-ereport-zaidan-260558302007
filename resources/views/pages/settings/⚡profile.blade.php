<?php

use App\Concerns\ProfileValidationRules;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

new #[Title('Profil saya')] class extends Component
{
    use ProfileValidationRules, WithFileUploads;

    public string $name = '';

    public string $email = '';

    public string $no_whatsapp = '';

    public string $alamat = '';

    public mixed $foto = null;

    public ?string $successMessage = null;

    public function mount(): void
    {
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
        $this->no_whatsapp = Auth::user()->no_whatsapp ?? '';
        $this->alamat = Auth::user()->alamat ?? '';
    }

    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            ...$this->profileRules($user->id),
            'no_whatsapp' => ['nullable', 'string', 'max:25'],
            'alamat' => ['nullable', 'string', 'max:1000'],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);

        unset($validated['foto']);
        $user->fill($validated);

        if ($this->foto) {
            $newPhotoPath = $this->foto->store('profiles', 'public');

            if ($user->foto) {
                Storage::disk('public')->delete($user->foto);
            }

            $user->foto = $newPhotoPath;
        }

        $user->save();
        $this->foto = null;
        $this->successMessage = 'Perubahan profil berhasil disimpan.';
    }
}; ?>

<section class="w-full">
    <x-pages::settings.layout heading="Profil saya" subheading="Perbarui informasi kontak yang digunakan untuk laporan Anda.">
        <form wire:submit="updateProfileInformation" class="settings-form">
            <div class="settings-section-heading">
                <h2>Informasi pribadi</h2>
                <p>Nama dan email membantu kami mengenali akun Anda.</p>
            </div>

            @if ($successMessage)
                <div class="alert-success" role="status">{{ $successMessage }}</div>
            @endif

            <div class="settings-fields">
                <div class="field">
                    <label for="profile-name">Nama lengkap</label>
                    <input id="profile-name" wire:model="name" type="text" required autocomplete="name" aria-describedby="@error('name') profile-name-error @enderror">
                    @error('name') <span class="field-error" id="profile-name-error">{{ $message }}</span> @enderror
                </div>

                <div class="field">
                    <label for="profile-email">Alamat email</label>
                    <input id="profile-email" wire:model="email" type="email" required autocomplete="email" aria-describedby="@error('email') profile-email-error @enderror">
                    @error('email') <span class="field-error" id="profile-email-error">{{ $message }}</span> @enderror
                </div>

                <div class="field">
                    <label for="profile-whatsapp">Nomor WhatsApp <span class="field-optional">Opsional</span></label>
                    <input id="profile-whatsapp" wire:model="no_whatsapp" type="tel" autocomplete="tel" aria-describedby="@error('no_whatsapp') profile-whatsapp-error @enderror">
                    @error('no_whatsapp') <span class="field-error" id="profile-whatsapp-error">{{ $message }}</span> @enderror
                </div>

                <div class="field">
                    <label for="profile-address">Alamat <span class="field-optional">Opsional</span></label>
                    <textarea id="profile-address" wire:model="alamat" rows="3" aria-describedby="@error('alamat') profile-address-error @enderror"></textarea>
                    @error('alamat') <span class="field-error" id="profile-address-error">{{ $message }}</span> @enderror
                </div>

                <div class="field">
                    <label for="profile-photo">Foto profil <span class="field-optional">Opsional</span></label>
                    <div class="profile-photo-row">
                        @if ($foto)
                            <img class="profile-photo-preview" src="{{ $foto->temporaryUrl() }}" alt="Pratinjau foto profil baru">
                        @elseif (auth()->user()->foto)
                            <img class="profile-photo-preview" src="{{ Storage::disk('public')->url(auth()->user()->foto) }}" alt="Foto profil saat ini">
                        @else
                            <span class="profile-photo-placeholder" aria-hidden="true">{{ auth()->user()->initials() }}</span>
                        @endif

                        <div class="profile-photo-input">
                            <input id="profile-photo" wire:model="foto" type="file" accept="image/jpeg,image/png,image/webp" aria-describedby="photo-hint @error('foto') profile-photo-error @enderror">
                            <span class="field-hint" id="photo-hint">JPG, PNG, atau WebP. Maksimal 5 MB.</span>
                            @error('foto') <span class="field-error" id="profile-photo-error">{{ $message }}</span> @enderror
                            <span class="field-hint" wire:loading wire:target="foto" role="status">Mengunggah foto…</span>
                        </div>
                    </div>
                </div>
            </div>

            @if ($errors->any())
                <p class="field-error" role="alert">Periksa kembali kolom yang ditandai.</p>
            @endif

            <div class="settings-actions">
                <button class="button" type="submit" data-test="update-profile-button" wire:loading.attr="disabled" wire:target="updateProfileInformation">
                    <span wire:loading.remove wire:target="updateProfileInformation">Simpan perubahan</span>
                    <span wire:loading wire:target="updateProfileInformation">Menyimpan…</span>
                </button>
            </div>
        </form>

        <livewire:pages::settings.delete-user-form />
    </x-pages::settings.layout>
</section>
