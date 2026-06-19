<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Motor extends Model
{
    use HasFactory;

    protected $fillable = [
        'pelanggan_id', 'no_polisi', 'merk', 'tipe_motor',
        'tahun_pembuatan', 'no_rangka', 'no_mesin', 'warna',
    ];

    public function pelanggan(): BelongsTo
    {
        return $this->belongsTo(Pelanggan::class);
    }

    public function servis(): HasMany
    {
        return $this->hasMany(Servis::class);
    }
    public function setNoPolisiAttribute($value)
    {
        $this->attributes['no_polisi'] = strtoupper($value);
    }

    public function getNoPolisiAttribute($value)
    {
        return strtoupper($value);
    }
}
