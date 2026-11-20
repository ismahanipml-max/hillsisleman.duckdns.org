<?php

namespace App\Http\Controllers;

use App\Models\Lpk;
use App\Models\Article;
use App\Models\Setting;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function index()
    {
        $settings = Setting::getAllAsMap();
        $lpks = Lpk::where('aktif', true)
            ->with(['services'])
            ->orderBy('urutan')
            ->get();

        $categories = Lpk::where('aktif', true)
            ->distinct()
            ->pluck('bidang')
            ->values()
            ->toArray();

        $lpksJson = $lpks->map(function ($item) {
            return [
                'id' => $item->slug,
                'url' => url('/lpk/' . $item->slug),
                'n' => $item->nama,
                'f' => $item->bidang,
                'e' => $item->ikon,
                'c' => $item->warna,
                'logo' => $item->logo_url,
                's' => $item->services->pluck('nama_layanan')->toArray(),
                'k' => strtolower($item->nama . ' ' . $item->bidang . ' ' . implode(' ', $item->services->pluck('nama_layanan')->toArray()) . ' ' . $item->tentang),
            ];
        })->values();

        // Ambil data Berita & Kegiatan dari database
        $dbArticles = Article::where('aktif', true)
            ->orderBy('urutan')
            ->orderByDesc('id')
            ->get();

        $articlesData = $dbArticles->map(function ($item) {
            return [
                'id' => $item->id,
                'ikon' => $item->ikon ?: '📰',
                'warna' => $item->warna ?: '#0e4c54',
                'judul' => $item->judul,
                'kategori' => $item->kategori ?: 'Berita',
                'tanggal' => $item->tanggal,
                'penulis' => $item->penulis ?: 'DPC HILLSI Sleman',
                'sumber' => $item->sumber,
                'sumber_teks' => $item->sumber_teks,
                'foto' => $item->foto_url,
                'ringkasan' => $item->ringkasan,
                'isi' => is_array($item->isi) ? $item->isi : (empty($item->isi) ? [$item->ringkasan] : [$item->isi]),
            ];
        })->values()->toArray();

        return view('home', compact('settings', 'lpks', 'categories', 'lpksJson', 'articlesData'));
    }

    public function show(string $slug)
    {
        $settings = Setting::getAllAsMap();
        $lpk = Lpk::where('slug', $slug)
            ->with([
                'services',
                'galleries' => function ($q) {
                    $q->orderBy('urutan')->orderBy('id')->take(36);
                },
                'partners',
                'features'
            ])
            ->firstOrFail();

        return view('lpk-detail', compact('lpk', 'settings'));
    }
}
