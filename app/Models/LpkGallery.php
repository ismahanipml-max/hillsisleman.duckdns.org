<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LpkGallery extends Model
{
    protected $fillable = ['lpk_id', 'foto', 'keterangan', 'urutan'];

    public function lpk(): BelongsTo
    {
        return $this->belongsTo(Lpk::class);
    }

    public function getFotoUrlAttribute(): string
    {
        if (str_starts_with($this->foto, 'http') || str_starts_with($this->foto, '/')) {
            return $this->foto;
        }
        if (file_exists(public_path($this->foto))) {
            return asset($this->foto);
        }
        return asset('storage/' . $this->foto);
    }
}

