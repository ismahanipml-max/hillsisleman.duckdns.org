<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LpkService extends Model
{
    protected $fillable = ['lpk_id', 'nama_layanan', 'urutan'];

    public function lpk(): BelongsTo
    {
        return $this->belongsTo(Lpk::class);
    }
}

