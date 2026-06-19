<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServisSparepart extends Model
{
    use HasFactory;

    protected $table = 'servis_sparepart';

    protected $fillable = ['servis_id', 'sparepart_id', 'qty', 'harga_satuan', 'subtotal'];

    public function servis(): BelongsTo
    {
        return $this->belongsTo(Servis::class);
    }

    public function sparepart(): BelongsTo
    {
        return $this->belongsTo(Sparepart::class);
    }
}
