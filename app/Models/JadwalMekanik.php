<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JadwalMekanik extends Model
{
    use HasFactory;

    protected $table = 'jadwal_mekaniks';

    protected $fillable = ['mekanik_id', 'tanggal', 'shift', 'status', 'keterangan'];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function mekanik(): BelongsTo
    {
        return $this->belongsTo(Mekanik::class);
    }
}
