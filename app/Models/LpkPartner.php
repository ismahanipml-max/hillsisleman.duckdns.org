<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LpkPartner extends Model
{
    protected $fillable = ['lpk_id', 'nama_mitra', 'urutan'];

    public function lpk(): BelongsTo
    {
        return $this->belongsTo(Lpk::class);
    }
}

