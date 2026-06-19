<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sparepart extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_part', 'nama_part', 'kategori', 'satuan',
        'harga_beli', 'harga_jual', 'stok', 'stok_minimum',
    ];

    public function servisSparepart(): HasMany
    {
        return $this->hasMany(ServisSparepart::class);
    }

    public function stokMenipis(): bool
    {
        return $this->stok <= $this->stok_minimum;
    }
}
