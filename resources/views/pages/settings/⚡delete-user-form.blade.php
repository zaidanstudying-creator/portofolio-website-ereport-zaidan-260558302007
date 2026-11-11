<?php

use Livewire\Component;

new class extends Component {}; ?>

<section class="settings-danger-zone">
    <div>
        <h2>Hapus akun</h2>
        <p>Hapus akun warga dan seluruh laporan yang terkait dengannya.</p>
    </div>

    <flux:modal.trigger name="confirm-user-deletion">
        <button class="button-danger" type="button" data-test="delete-user-button">Hapus akun</button>
    </flux:modal.trigger>

    <livewire:pages::settings.delete-user-modal />
</section>
