<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LpkFeature extends Model
{
    protected $fillable = ['lpk_id', 'judul', 'deskripsi', 'ikon', 'urutan'];

    public function lpk(): BelongsTo
    {
        return $this->belongsTo(Lpk::class);
    }
}

