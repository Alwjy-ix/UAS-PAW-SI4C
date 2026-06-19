<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Servis extends Model
{
    use HasFactory;

    protected $table = 'servis';

    protected $fillable = [
        'no_servis', 'motor_id', 'mekanik_id', 'tanggal_masuk', 'tanggal_keluar',
        'keluhan', 'diagnosa', 'status', 'biaya_jasa', 'total_biaya', 'catatan',
    ];

    protected $casts = [
        'tanggal_masuk' => 'datetime',
        'tanggal_keluar' => 'datetime',
    ];

    public function motor(): BelongsTo
    {
        return $this->belongsTo(Motor::class);
    }

    public function mekanik(): BelongsTo
    {
        return $this->belongsTo(Mekanik::class);
    }

    public function sparepart(): HasMany
    {
        return $this->hasMany(ServisSparepart::class);
    }

    /**
     * Generate nomor servis berformat SV-YYYYMMDD-0001.
     * Untuk trafik tinggi sebaiknya diganti pakai sequence/lock di database,
     * cara ini cukup aman untuk skala tugas/kecil-menengah.
     */
    public static function generateNoServis(): string
    {
        $tanggal = now()->format('Ymd');
        $urutan = static::whereDate('created_at', now())->count() + 1;

        return sprintf('SV-%s-%04d', $tanggal, $urutan);
    }
}
