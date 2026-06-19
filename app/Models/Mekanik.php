<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Mekanik extends Model
{
    use HasFactory;

    protected $fillable = ['npk', 'nama', 'jabatan', 'no_hp', 'status'];

    public function jadwal(): HasMany
    {
        return $this->hasMany(JadwalMekanik::class);
    }

    public function servis(): HasMany
    {
        return $this->hasMany(Servis::class);
    }
}
