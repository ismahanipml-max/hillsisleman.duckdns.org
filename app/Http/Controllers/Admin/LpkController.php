<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lpk;
use App\Models\LpkService;
use App\Models\LpkGallery;
use App\Models\LpkPartner;
use App\Models\LpkFeature;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class LpkController extends Controller
{
    public function index()
    {
        $lpks = Lpk::with(['services', 'partners'])
            ->withCount(['services', 'galleries', 'partners'])
            ->orderBy('urutan')
            ->orderBy('id')
            ->get();

        $categories = Lpk::distinct()->pluck('bidang')->sort()->values()->toArray();
        $maxUrutan = Lpk::max('urutan') ?? 0;

        return view('admin.lpks.index', compact('lpks', 'categories', 'maxUrutan'));
    }

    public function show(Lpk $lpk)
    {
        $lpk->load(['services', 'partners', 'galleries']);
        return response()->json([
            'id' => $lpk->id,
            'nama' => $lpk->nama,
            'slug' => $lpk->slug,
            'bidang' => $lpk->bidang,
            'tagline' => $lpk->tagline,
            'tentang' => $lpk->tentang,
            'nama_admin' => $lpk->nama_admin,
            'whatsapp' => $lpk->whatsapp,
            'email' => $lpk->email,
            'instagram' => $lpk->instagram,
            'alamat' => $lpk->alamat,
            'website' => $lpk->website,
            'link_maps' => $lpk->link_maps,
            'urutan' => $lpk->urutan,
            'aktif' => (bool)$lpk->aktif,
            'cover_url' => $lpk->cover_url,
            'logo_url' => $lpk->logo_url,
            'layanan' => $lpk->services->pluck('nama_layanan')->implode("\n"),
            'mitra' => $lpk->partners->pluck('nama_mitra')->implode("\n"),
            'galleries' => $lpk->galleries->map(function ($g) {
                return [
                    'id' => $g->id,
                    'foto_url' => $g->foto_url,
                    'keterangan' => $g->keterangan,
                ];
            }),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:lpks,slug',
            'bidang' => 'nullable|string|max:255',
            'tagline' => 'nullable|string|max:255',
            'tentang' => 'nullable|string',
            'cover' => 'nullable|image|max:2048',
            'logo' => 'nullable|image|max:2048',
            'ikon' => 'nullable|string|max:10',
            'warna' => 'nullable|string|max:20',
            'nama_admin' => 'nullable|string|max:100',
            'whatsapp' => 'nullable|string|max:50',
            'alamat' => 'nullable|string',
            'email' => 'nullable|string|max:100',
            'instagram' => 'nullable|string|max:100',
            'website' => 'nullable|string|max:255',
            'link_maps' => 'nullable|string',
            'urutan' => 'nullable|integer',
            'aktif' => 'nullable|boolean',
            'layanan' => 'nullable|string',
            'mitra' => 'nullable|string',
            'galleries.*' => 'nullable|image|max:2048',
        ], [
            'nama.required' => 'Nama LPK wajib diisi.',
            'cover.max' => 'Ukuran gambar cover maksimal 2 MB.',
            'logo.max' => 'Ukuran gambar logo maksimal 2 MB.',
            'galleries.*.max' => 'Setiap foto galeri maksimal berukuran 2 MB.',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['nama']);
            $orig = $validated['slug'];
            $count = 1;
            while (Lpk::where('slug', $validated['slug'])->exists()) {
                $validated['slug'] = $orig . '-' . $count++;
            }
        }

        $validated['bidang'] = !empty($validated['bidang']) ? $validated['bidang'] : 'Umum';
        $validated['aktif'] = $request->has('aktif') ? (bool)$request->aktif : true;
        $validated['urutan'] = $validated['urutan'] ?? ((Lpk::max('urutan') ?? 0) + 1);
        $validated['ikon'] = $request->input('ikon') ?: '🏛️';
        $validated['warna'] = $request->input('warna') ?: '#0b5d63';

        if (!empty($validated['website']) && !preg_match('#^https?://#i', $validated['website'])) {
            $validated['website'] = 'https://' . $validated['website'];
        }

        if (isset($validated['tentang'])) {
            $validated['tentang'] = trim(str_replace(["\r\n", "\r"], "\n", $validated['tentang']));
        }

        if ($request->hasFile('cover')) {
            $path = $request->file('cover')->store('covers', 'public');
            $validated['cover'] = $path;
        }

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('logos', 'public');
            $validated['logo'] = $path;
        }

        $lpk = Lpk::create($validated);

        // Save Services (split by newline)
        if (!empty($request->layanan)) {
            $lines = preg_split('/[\r\n]+/', $request->layanan);
            foreach ($lines as $i => $line) {
                $line = trim($line);
                if ($line !== '') {
                    LpkService::create([
                        'lpk_id' => $lpk->id,
                        'nama_layanan' => $line,
                        'urutan' => $i + 1,
                    ]);
                }
            }
        }

        // Save Partners (split by newline)
        if (!empty($request->mitra)) {
            $parts = preg_split('/[\r\n]+/', $request->mitra);
            $idx = 1;
            foreach ($parts as $p) {
                $p = trim($p);
                if ($p !== '') {
                    LpkPartner::create([
                        'lpk_id' => $lpk->id,
                        'nama_mitra' => $p,
                        'urutan' => $idx++,
                    ]);
                }
            }
        }

        // Save Gallery uploads (maksimal 36 foto per lembaga)
        if ($request->hasFile('galleries')) {
            $currentCount = $lpk->galleries()->count();
            $maxAllowed = max(0, 36 - $currentCount);
            $files = array_slice($request->file('galleries'), 0, $maxAllowed);
            foreach ($files as $file) {
                $path = $file->store('galleries', 'public');
                LpkGallery::create([
                    'lpk_id' => $lpk->id,
                    'foto' => $path,
                    'keterangan' => 'Foto Kegiatan',
                    'urutan' => ++$currentCount,
                ]);
            }
        }

        return redirect()->route('admin.lpks.index')->with('success', 'LPK baru "' . $lpk->nama . '" berhasil ditambahkan!');
    }

    public function edit(Lpk $lpk)
    {
        $lpk->load(['services', 'galleries', 'partners', 'features']);
        return view('admin.lpks.edit', compact('lpk'));
    }

    public function update(Request $request, Lpk $lpk)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:lpks,slug,' . $lpk->id,
            'bidang' => 'nullable|string|max:255',
            'tagline' => 'nullable|string|max:255',
            'tentang' => 'nullable|string',
            'cover' => 'nullable|image|max:2048',
            'logo' => 'nullable|image|max:2048',
            'ikon' => 'nullable|string|max:10',
            'warna' => 'nullable|string|max:20',
            'nama_admin' => 'nullable|string|max:100',
            'whatsapp' => 'nullable|string|max:50',
            'alamat' => 'nullable|string',
            'email' => 'nullable|string|max:100',
            'instagram' => 'nullable|string|max:100',
            'website' => 'nullable|string|max:255',
            'link_maps' => 'nullable|string',
            'urutan' => 'nullable|integer',
            'aktif' => 'nullable|boolean',
            'layanan' => 'nullable|string',
            'mitra' => 'nullable|string',
            'galleries.*' => 'nullable|image|max:2048',
        ], [
            'nama.required' => 'Nama LPK wajib diisi.',
            'cover.max' => 'Ukuran gambar cover maksimal 2 MB.',
            'logo.max' => 'Ukuran gambar logo maksimal 2 MB.',
            'galleries.*.max' => 'Setiap foto galeri maksimal berukuran 2 MB.',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = $lpk->slug;
        }

        $validated['bidang'] = !empty($validated['bidang']) ? $validated['bidang'] : $lpk->bidang;
        $validated['aktif'] = $request->has('aktif') ? (bool)$request->aktif : false;
        $validated['urutan'] = $validated['urutan'] ?? $lpk->urutan;
        $validated['ikon'] = $request->input('ikon') ?: ($lpk->ikon ?: '🏛️');
        $validated['warna'] = $request->input('warna') ?: ($lpk->warna ?: '#0b5d63');

        if (!empty($validated['website']) && !preg_match('#^https?://#i', $validated['website'])) {
            $validated['website'] = 'https://' . $validated['website'];
        }

        if (isset($validated['tentang'])) {
            $validated['tentang'] = trim(str_replace(["\r\n", "\r"], "\n", $validated['tentang']));
        }

        if ($request->hasFile('cover')) {
            $path = $request->file('cover')->store('covers', 'public');
            $validated['cover'] = $path;
        }

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('logos', 'public');
            $validated['logo'] = $path;
        }

        $lpk->update($validated);

        // Update Services
        if ($request->has('layanan')) {
            $lpk->services()->delete();
            $lines = preg_split('/[\r\n]+/', $request->layanan ?? '');
            foreach ($lines as $i => $line) {
                $line = trim($line);
                if ($line !== '') {
                    LpkService::create([
                        'lpk_id' => $lpk->id,
                        'nama_layanan' => $line,
                        'urutan' => $i + 1,
                    ]);
                }
            }
        }

        // Update Partners
        if ($request->has('mitra')) {
            $lpk->partners()->delete();
            $parts = preg_split('/[\r\n]+/', $request->mitra ?? '');
            $idx = 1;
            foreach ($parts as $p) {
                $p = trim($p);
                if ($p !== '') {
                    LpkPartner::create([
                        'lpk_id' => $lpk->id,
                        'nama_mitra' => $p,
                        'urutan' => $idx++,
                    ]);
                }
            }
        }

        // Upload additional galleries (maksimal 36 foto per lembaga)
        if ($request->hasFile('galleries')) {
            $currentCount = $lpk->galleries()->count();
            $maxAllowed = max(0, 36 - $currentCount);
            $files = array_slice($request->file('galleries'), 0, $maxAllowed);
            foreach ($files as $file) {
                $path = $file->store('galleries', 'public');
                LpkGallery::create([
                    'lpk_id' => $lpk->id,
                    'foto' => $path,
                    'keterangan' => 'Foto Kegiatan',
                    'urutan' => ++$currentCount,
                ]);
            }
        }

        return redirect()->route('admin.lpks.index')->with('success', 'Data LPK "' . $lpk->nama . '" berhasil diperbarui!');
    }

    public function toggleActive(Lpk $lpk)
    {
        $lpk->aktif = !$lpk->aktif;
        $lpk->save();

        return response()->json([
            'success' => true,
            'aktif' => $lpk->aktif,
            'message' => $lpk->aktif 
                ? "LPK \"{$lpk->nama}\" sekarang ditampilkan di website." 
                : "LPK \"{$lpk->nama}\" sekarang disembunyikan dari website."
        ]);
    }

    public function destroy(Lpk $lpk)
    {
        $nama = $lpk->nama;
        $lpk->services()->delete();
        $lpk->partners()->delete();
        $lpk->galleries()->delete();
        $lpk->features()->delete();
        $lpk->delete();

        return redirect()->route('admin.lpks.index')->with('success', "LPK \"{$nama}\" berhasil dihapus!");
    }

    public function destroyGallery(Lpk $lpk, LpkGallery $gallery)
    {
        if ($gallery->lpk_id === $lpk->id) {
            if (Storage::disk('public')->exists($gallery->foto)) {
                Storage::disk('public')->delete($gallery->foto);
            }
            $gallery->delete();

            if (request()->wantsJson() || request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Foto galeri berhasil dihapus!'
                ]);
            }
            return back()->with('success', 'Foto galeri berhasil dihapus!');
        }

        if (request()->wantsJson() || request()->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'Foto galeri tidak ditemukan.'
            ], 404);
        }
        return back()->with('error', 'Foto galeri tidak ditemukan.');
    }
}
