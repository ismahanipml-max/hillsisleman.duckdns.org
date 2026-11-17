<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lpk extends Model
{
    protected $table = 'lpks';

    protected $fillable = [
        'nama',
        'slug',
        'bidang',
        'tagline',
        'tentang',
        'cover',
        'logo',
        'ikon',
        'warna',
        'nama_admin',
        'whatsapp',
        'alamat',
        'email',
        'instagram',
        'website',
        'link_maps',
        'urutan',
        'aktif',
    ];

    protected $casts = [
        'aktif' => 'boolean',
        'urutan' => 'integer',
    ];

    public function services(): HasMany
    {
        return $this->hasMany(LpkService::class)->orderBy('urutan')->orderBy('id');
    }

    public function galleries(): HasMany
    {
        return $this->hasMany(LpkGallery::class)->orderBy('urutan')->orderBy('id');
    }

    public function partners(): HasMany
    {
        return $this->hasMany(LpkPartner::class)->orderBy('urutan')->orderBy('id');
    }

    public function features(): HasMany
    {
        return $this->hasMany(LpkFeature::class)->orderBy('urutan')->orderBy('id');
    }

    public function getWaLinkAttribute(): string
    {
        $raw = preg_replace('/[^0-9]/', '', $this->whatsapp ?? '');
        if (str_starts_with($raw, '0')) {
            $raw = '62' . substr($raw, 1);
        }
        return $raw ? 'https://wa.me/' . $raw : 'https://wa.me/6281200000000';
    }

    public function getIgLinkAttribute(): string
    {
        if (!$this->instagram) {
            return Setting::get('instagram', 'https://www.instagram.com/dpc.hillsi.sleman/');
        }
        if (str_starts_with($this->instagram, 'http')) {
            return $this->instagram;
        }
        $handle = ltrim($this->instagram, '@');
        return 'https://www.instagram.com/' . $handle;
    }

    public function getMapsLinkAttribute(): string
    {
        if ($this->link_maps) {
            return $this->link_maps;
        }
        return 'https://www.google.com/maps/search/?api=1&query=' . urlencode($this->nama . ' Sleman');
    }

    public function getLogoUrlAttribute(): ?string
    {
        if (!$this->logo) {
            return null;
        }
        if (str_starts_with($this->logo, 'http') || str_starts_with($this->logo, '/')) {
            return $this->logo;
        }
        if (file_exists(public_path($this->logo))) {
            return asset($this->logo);
        }
        return asset('storage/' . $this->logo);
    }

    public function getCoverUrlAttribute(): ?string
    {
        if (!$this->cover) {
            return null;
        }
        if (str_starts_with($this->cover, 'http') || str_starts_with($this->cover, '/')) {
            return $this->cover;
        }
        if (file_exists(public_path($this->cover))) {
            return asset($this->cover);
        }
        return asset('storage/' . $this->cover);
    }
}

