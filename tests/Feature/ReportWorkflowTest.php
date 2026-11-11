<?php

use App\Models\Laporan;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

test('registration always creates a citizen even when an admin role is submitted', function () {
    $this->post(route('register.store'), [
        'name' => 'Warga Baru',
        'email' => 'warga@example.test',
        'password' => 'password',
        'password_confirmation' => 'password',
        'role' => 'admin',
    ])->assertRedirect(route('dashboard', absolute: false));

    expect(User::where('email', 'warga@example.test')->value('role'))->toBe('warga');
});

test('citizens can create a report with ownership and pending status assigned by the server', function () {
    Storage::fake('local');
    $warga = User::factory()->create();

    $this->actingAs($warga)->post(route('laporans.store'), [
        'judul' => 'Lampu jalan padam',
        'detail' => 'Lampu di Gang Melati padam sejak kemarin.',
        'tanggal' => now()->subDay()->toDateString(),
        'status' => 'selesai',
        'pelapor_id' => 999,
        'foto' => UploadedFile::fake()->image('lampu.jpg'),
    ])->assertRedirect(route('laporans.index'));

    $laporan = Laporan::firstOrFail();
    expect($laporan->pelapor_id)->toBe($warga->id)
        ->and($laporan->status)->toBe('pending');
    Storage::disk('local')->assertExists($laporan->foto);

    $this->actingAs($warga)->post(route('laporans.store'), [
        'judul' => 'Berkas tidak valid',
        'detail' => 'Berkas teks tidak boleh diterima sebagai foto.',
        'tanggal' => now()->subDay()->toDateString(),
        'foto' => UploadedFile::fake()->create('bukti.txt', 1, 'text/plain'),
    ])->assertSessionHasErrors('foto');
});

test('citizens cannot view another citizens report or edit a report after processing starts', function () {
    $owner = User::factory()->create();
    $other = User::factory()->create();
    $laporan = $owner->laporans()->create([
        'judul' => 'Saluran tersumbat',
        'detail' => 'Air tidak mengalir.',
        'tanggal' => now()->subDay()->toDateString(),
        'status' => 'pending',
    ]);

    $this->actingAs($other)->get(route('laporans.show', $laporan))->assertForbidden();
    $this->actingAs($owner)->patch(route('laporans.update', $laporan), [
        'judul' => 'Pembaruan judul',
        'detail' => 'Keterangan lengkap.',
        'tanggal' => now()->subDay()->toDateString(),
    ])->assertRedirect(route('laporans.show', $laporan));

    $laporan->update(['status' => 'proses']);
    $this->actingAs($owner)->get(route('laporans.edit', $laporan))->assertForbidden();
    $this->actingAs($owner)->delete(route('laporans.destroy', $laporan))->assertForbidden();

    $pendingLaporan = $owner->laporans()->create([
        'judul' => 'Laporan menunggu',
        'detail' => 'Belum mulai diproses.',
        'tanggal' => now()->subDay()->toDateString(),
        'status' => 'pending',
    ]);
    $this->actingAs($owner)->delete(route('laporans.destroy', $pendingLaporan))->assertRedirect(route('laporans.index'));
    $this->assertDatabaseMissing('laporans', ['id' => $pendingLaporan->id]);
});

test('administrators can move reports through the ordered status workflow only', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $warga = User::factory()->create();
    $laporan = $warga->laporans()->create([
        'judul' => 'Jalan rusak',
        'detail' => 'Lubang di depan balai warga.',
        'tanggal' => now()->subDay()->toDateString(),
        'status' => 'pending',
    ]);
    $this->actingAs($admin)->patch(route('admin.laporans.status', $laporan), ['status' => 'selesai'])->assertStatus(422);
    $this->patch(route('admin.laporans.status', $laporan), ['status' => 'proses'])->assertRedirect();
    $this->patch(route('admin.laporans.status', $laporan), ['status' => 'selesai'])->assertRedirect();
    expect($laporan->fresh()->status)->toBe('selesai');

    $this->actingAs($warga)->get(route('admin.dashboard'))->assertForbidden();
});

test('citizen and administrator workspaces and protected report photos render for authorized users', function () {
    Storage::fake('local');
    $warga = User::factory()->create();
    $laporan = $warga->laporans()->create([
        'judul' => 'Pohon tumbang',
        'detail' => 'Pohon menghalangi jalan lingkungan.',
        'tanggal' => now()->subDay()->toDateString(),
        'foto' => 'laporans/pohon.jpg',
        'status' => 'pending',
    ]);
    $warga->laporans()->create([
        'judul' => 'Laporan dengan kejadian lebih lama',
        'detail' => 'Dilaporkan sebagai data pembanding.',
        'tanggal' => now()->subDays(3)->toDateString(),
        'status' => 'pending',
    ]);
    Storage::disk('local')->put($laporan->foto, 'image-bytes');

    $this->actingAs($warga);
    $this->get(route('laporans.index'))->assertOk();
    $this->get(route('laporans.create'))->assertOk();
    $this->get(route('laporans.show', $laporan))->assertOk();
    $this->get(route('laporans.photo', $laporan))->assertOk();
    $this->get(route('profile.edit'))->assertOk();
    $this->get(route('security.edit'))->assertOk();

    $other = User::factory()->create();
    $this->actingAs($other)->get(route('laporans.photo', $laporan))->assertForbidden();

    $admin = User::factory()->create(['role' => 'admin']);
    $this->actingAs($admin);
    $this->get(route('admin.dashboard'))->assertOk();
    $this->get(route('admin.laporans.index'))->assertOk();
    $this->get(route('admin.laporans.index', ['sort' => 'incident_oldest']))
        ->assertSeeInOrder(['Laporan dengan kejadian lebih lama', 'Pohon tumbang']);
    $this->get(route('admin.laporans.show', $laporan))->assertOk();
});
