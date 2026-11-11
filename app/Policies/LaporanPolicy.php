<?php

namespace App\Policies;

use App\Models\Laporan;
use App\Models\User;

class LaporanPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->role === 'admin' || $user->role === 'warga';
    }

    public function view(User $user, Laporan $laporan): bool
    {
        return $user->role === 'admin' || $laporan->pelapor_id === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->role === 'warga';
    }

    public function update(User $user, Laporan $laporan): bool
    {
        return $user->role === 'warga'
            && $laporan->pelapor_id === $user->id
            && $laporan->status === 'pending';
    }

    public function delete(User $user, Laporan $laporan): bool
    {
        return $this->update($user, $laporan);
    }

    public function updateStatus(User $user): bool
    {
        return $user->role === 'admin';
    }
}
