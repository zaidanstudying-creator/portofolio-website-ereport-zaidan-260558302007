<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['pelapor_id', 'judul', 'detail', 'tanggal', 'foto', 'status'])]
class Laporan extends Model
{
    public const STATUSES = ['pending', 'proses', 'selesai'];

    protected function casts(): array
    {
        return ['tanggal' => 'date'];
    }

    /** @return BelongsTo<User, $this> */
    public function pelapor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pelapor_id');
    }
}
