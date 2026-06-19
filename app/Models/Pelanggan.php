<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pelanggan extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'no_ktp', 'no_hp', 'email', 'alamat'];

    public function motors(): HasMany
    {
        return $this->hasMany(Motor::class);
    }
}
