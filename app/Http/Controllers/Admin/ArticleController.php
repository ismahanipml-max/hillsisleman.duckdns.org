<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $query = Article::query();

        if ($request->filled('search')) {
            $s = trim($request->search);
            $query->where(function ($q) use ($s) {
                $q->where('judul', 'like', "%{$s}%")
                  ->orWhere('kategori', 'like', "%{$s}%")
                  ->orWhere('penulis', 'like', "%{$s}%")
                  ->orWhere('ringkasan', 'like', "%{$s}%");
            });
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('status') && $request->status !== '') {
            $query->where('aktif', (bool) $request->status);
        }

        $articles = $query->orderBy('urutan')->orderByDesc('id')->paginate(15)->withQueryString();

        $categories = Article::distinct()->pluck('kategori')->filter()->values();

        if ($request->wantsJson()) {
            return response()->json($articles);
        }

        return view('admin.articles.index', compact('articles', 'categories'));
    }

    public function show(Article $article)
    {
        return response()->json($article);
    }

    public function fetchUrl(Request $request)
    {
        $request->validate([
            'url' => 'required|url',
        ]);

        $url = trim($request->url);

        try {
            $response = Http::withHeaders([
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36',
                'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
                'Accept-Language' => 'id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7',
            ])->timeout(15)->withoutVerifying()->get($url);

            if (!$response->successful()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal mengakses URL (Kode HTTP: ' . $response->status() . '). Pastikan website tujuan aktif dan dapat diakses publik.',
                ], 422);
            }

            $html = $response->body();
            if (empty(trim($html))) {
                return response()->json([
                    'success' => false,
                    'message' => 'Konten halaman dari URL tersebut kosong. Silakan masukkan artikel secara manual.',
                ], 422);
            }

            $data = $this->parseArticleHtml($html, $url);

            return response()->json([
                'success' => true,
                'message' => 'Berhasil mengambil artikel dari URL!',
                'data' => $data,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memproses URL: ' . $e->getMessage() . '. Silakan isi naskah secara manual.',
            ], 500);
        }
    }

    private function parseArticleHtml(string $html, string $url): array
    {
        libxml_use_internal_errors(true);
        $dom = new \DOMDocument();
        $dom->loadHTML('<?xml encoding="UTF-8">' . $html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $xpath = new \DOMXPath($dom);

        $parsedUrl = parse_url($url);
        $host = $parsedUrl['host'] ?? '';
        $cleanHost = preg_replace('/^www\./i', '', $host);

        // 1. Ekstraksi Judul
        $title = '';
        $metaOgTitle = $xpath->query('//meta[@property="og:title"]/@content')->item(0);
        $metaTwTitle = $xpath->query('//meta[@name="twitter:title"]/@content')->item(0);
        $h1Node = $xpath->query('//h1')->item(0);
        $titleNode = $xpath->query('//title')->item(0);

        if ($metaOgTitle && trim($metaOgTitle->nodeValue)) {
            $title = trim($metaOgTitle->nodeValue);
        } elseif ($metaTwTitle && trim($metaTwTitle->nodeValue)) {
            $title = trim($metaTwTitle->nodeValue);
        } elseif ($h1Node && trim($h1Node->nodeValue)) {
            $title = trim($h1Node->nodeValue);
        } elseif ($titleNode && trim($titleNode->nodeValue)) {
            $title = trim($titleNode->nodeValue);
        }

        if (!empty($title)) {
            $title = preg_replace('/\s*[-–|]\s*(Halaman \d+|' . preg_quote($cleanHost, '/') . '|Kompas\.com|Detikcom|Antara News).*$/i', '', $title);
            $title = html_entity_decode($title, ENT_QUOTES | ENT_HTML5, 'UTF-8');
            $title = trim(preg_replace('/\s+/', ' ', $title));
        }

        // 2. Ekstraksi Deskripsi / Ringkasan
        $description = '';
        $metaOgDesc = $xpath->query('//meta[@property="og:description"]/@content')->item(0);
        $metaDesc = $xpath->query('//meta[@name="description"]/@content')->item(0);
        $metaTwDesc = $xpath->query('//meta[@name="twitter:description"]/@content')->item(0);

        if ($metaOgDesc && trim($metaOgDesc->nodeValue)) {
            $description = trim($metaOgDesc->nodeValue);
        } elseif ($metaDesc && trim($metaDesc->nodeValue)) {
            $description = trim($metaDesc->nodeValue);
        } elseif ($metaTwDesc && trim($metaTwDesc->nodeValue)) {
            $description = trim($metaTwDesc->nodeValue);
        }

        if (!empty($description)) {
            $description = html_entity_decode($description, ENT_QUOTES | ENT_HTML5, 'UTF-8');
            $description = trim(preg_replace('/\s+/', ' ', $description));
        }

        // 3. Ekstraksi Gambar Utama
        $imageUrl = '';
        $metaOgImage = $xpath->query('//meta[@property="og:image"]/@content')->item(0);
        $metaTwImage = $xpath->query('//meta[@name="twitter:image"]/@content')->item(0);

        if ($metaOgImage && trim($metaOgImage->nodeValue)) {
            $imageUrl = trim($metaOgImage->nodeValue);
        } elseif ($metaTwImage && trim($metaTwImage->nodeValue)) {
            $imageUrl = trim($metaTwImage->nodeValue);
        }

        if (!empty($imageUrl) && !preg_match('/^https?:\/\//i', $imageUrl)) {
            $scheme = $parsedUrl['scheme'] ?? 'https';
            $imageUrl = $scheme . '://' . $host . '/' . ltrim($imageUrl, '/');
        }

        // 4. Ekstraksi Tanggal Publikasi
        $publishedDate = '';
        $metaTime = $xpath->query('//meta[@property="article:published_time"]/@content')->item(0);
        $metaPub = $xpath->query('//meta[@name="pubdate"]/@content')->item(0);
        $timeNode = $xpath->query('//time/@datetime')->item(0);

        $rawTime = '';
        if ($metaTime && trim($metaTime->nodeValue)) {
            $rawTime = trim($metaTime->nodeValue);
        } elseif ($metaPub && trim($metaPub->nodeValue)) {
            $rawTime = trim($metaPub->nodeValue);
        } elseif ($timeNode && trim($timeNode->nodeValue)) {
            $rawTime = trim($timeNode->nodeValue);
        }

        if (!empty($rawTime)) {
            try {
                $carbon = Carbon::parse($rawTime);
                $months = [
                    1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                    5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                    9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                ];
                $publishedDate = $carbon->day . ' ' . ($months[$carbon->month] ?? $carbon->format('F')) . ' ' . $carbon->year;
            } catch (\Exception $e) {
                $publishedDate = '';
            }
        }

        if (empty($publishedDate)) {
            if (preg_match('/(\d{1,2})\s+(Januari|Februari|Maret|April|Mei|Juni|Juli|Agustus|September|Oktober|November|Desember)\s+(\d{4})/i', $html, $m)) {
                $publishedDate = $m[1] . ' ' . ucfirst(strtolower($m[2])) . ' ' . $m[3];
            } else {
                $carbonNow = Carbon::now();
                $months = [
                    1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                    5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                    9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                ];
                $publishedDate = $carbonNow->day . ' ' . ($months[$carbonNow->month] ?? $carbonNow->format('F')) . ' ' . $carbonNow->year;
            }
        }

        // 5. Ekstraksi Penulis
        $author = '';
        $metaAuthor = $xpath->query('//meta[@name="author"]/@content')->item(0);
        $metaOgAuthor = $xpath->query('//meta[@property="article:author"]/@content')->item(0);
        if ($metaAuthor && trim($metaAuthor->nodeValue)) {
            $author = trim($metaAuthor->nodeValue);
        } elseif ($metaOgAuthor && trim($metaOgAuthor->nodeValue)) {
            $author = trim($metaOgAuthor->nodeValue);
        } else {
            $author = 'Humas ' . ucfirst(explode('.', $cleanHost)[0]);
        }

        // 6. Ekstraksi Paragraf Isi Lengkap
        $scripts = $xpath->query('//script|//style|//nav|//header|//footer|//aside|//noscript|//figure|//figcaption');
        foreach ($scripts as $node) {
            if ($node->parentNode) {
                $node->parentNode->removeChild($node);
            }
        }

        $bodyNodes = $xpath->query('//article//p | //div[contains(@class,"content") or contains(@class,"detail") or contains(@class,"body") or contains(@class,"article") or contains(@class,"post") or contains(@class,"read")]//p');
        if ($bodyNodes->length === 0) {
            $bodyNodes = $xpath->query('//p');
        }

        $paragraphs = [];
        foreach ($bodyNodes as $p) {
            $text = trim(preg_replace('/\s+/', ' ', $p->textContent));
            if (mb_strlen($text) > 40 && !preg_match('/(baca juga|simak video|copyright|hak cipta|advertisement|iklan|terpopuler|komentar)/i', $text)) {
                $paragraphs[] = $text;
            }
        }

        $paragraphs = array_values(array_unique($paragraphs));
        $isiText = implode("\n\n", $paragraphs);

        if (empty($description) && !empty($paragraphs)) {
            $description = mb_substr($paragraphs[0], 0, 200) . '...';
        }

        // Deteksi kategori otomatis
        $kategori = 'Pelatihan Vokasi';
        $fullTextLower = strtolower($title . ' ' . $description);
        if (str_contains($fullTextLower, 'rapat') || str_contains($fullTextLower, 'koordinasi') || str_contains($fullTextLower, 'musyawarah')) {
            $kategori = 'Koordinasi DPC';
        } elseif (str_contains($fullTextLower, 'uji kompetensi') || str_contains($fullTextLower, 'sertifikasi') || str_contains($fullTextLower, 'bnsp')) {
            $kategori = 'Sertifikasi Resmi';
        } elseif (str_contains($fullTextLower, 'k3') || str_contains($fullTextLower, 'keselamatan')) {
            $kategori = 'Praktik & K3';
        } elseif (str_contains($fullTextLower, 'akreditasi')) {
            $kategori = 'Akreditasi Mutu';
        } elseif (str_contains($fullTextLower, 'bursa') || str_contains($fullTextLower, 'job fair') || str_contains($fullTextLower, 'expo')) {
            $kategori = 'Kemitraan Daerah';
        } elseif (str_contains($fullTextLower, 'wirausaha') || str_contains($fullTextLower, 'inkubasi') || str_contains($fullTextLower, 'bisnis')) {
            $kategori = 'Kewirausahaan';
        } elseif (str_contains($fullTextLower, 'drone')) {
            $kategori = 'Pelatihan Vokasi';
        }

        return [
            'judul' => $title,
            'ringkasan' => $description,
            'isi_text' => $isiText,
            'foto_url' => $imageUrl,
            'tanggal' => $publishedDate,
            'penulis' => $author,
            'sumber' => $url,
            'sumber_teks' => $cleanHost,
            'kategori' => $kategori,
        ];
    }

    private function downloadRemoteImage(string $url): ?string
    {
        try {
            $res = Http::timeout(12)->withoutVerifying()->get($url);
            if ($res->successful() && strlen($res->body()) > 200) {
                $ext = pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION);
                if (!in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'webp'])) {
                    $ext = 'jpg';
                }
                $filename = 'articles/import_' . time() . '_' . Str::random(8) . '.' . $ext;
                Storage::disk('public')->put($filename, $res->body());
                return 'storage/' . $filename;
            }
        } catch (\Exception $e) {
            return $url;
        }
        return $url;
    }

    public function create()
    {
        $categories = Article::distinct()->pluck('kategori')->filter()->values();
        return view('admin.articles.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'tanggal' => 'required|string|max:100',
            'penulis' => 'nullable|string|max:150',
            'sumber' => 'nullable|url|max:255',
            'sumber_teks' => 'nullable|string|max:150',
            'ikon' => 'nullable|string|max:50',
            'warna' => 'nullable|string|max:30',
            'ringkasan' => 'required|string',
            'isi_text' => 'nullable|string',
            'urutan' => 'nullable|integer',
            'aktif' => 'nullable|boolean',
            'foto' => 'nullable|image|max:3072',
        ]);

        $data = [
            'judul' => $validated['judul'],
            'kategori' => $validated['kategori'],
            'tanggal' => $validated['tanggal'],
            'penulis' => $validated['penulis'] ?: 'Pengurus DPC HILLSI',
            'sumber' => $validated['sumber'] ?: null,
            'sumber_teks' => $validated['sumber_teks'] ?: null,
            'ikon' => $validated['ikon'] ?? '📰',
            'warna' => $validated['warna'] ?? '#0e4c54',
            'ringkasan' => $validated['ringkasan'],
            'urutan' => (int) ($validated['urutan'] ?? 0),
            'aktif' => $request->has('aktif') ? (bool) $request->aktif : true,
        ];

        // Format Isi Berita ke array paragraf
        $isiRaw = $request->input('isi_text', '');
        $paragraphs = array_values(array_filter(array_map('trim', explode("\n", $isiRaw))));
        $data['isi'] = !empty($paragraphs) ? $paragraphs : [$validated['ringkasan']];

        // Handle Image Upload
        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('articles', 'public');
            $data['foto'] = 'storage/' . $path;
        } elseif ($request->filled('remote_foto_url')) {
            $data['foto'] = $this->downloadRemoteImage($request->remote_foto_url);
        }

        $article = Article::create($data);

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Berita berhasil disimpan!', 'data' => $article]);
        }

        return redirect()->route('admin.articles.index')->with('success', 'Berita & Kegiatan berhasil ditambahkan!');
    }

    public function edit(Article $article)
    {
        $categories = Article::distinct()->pluck('kategori')->filter()->values();
        return view('admin.articles.edit', compact('article', 'categories'));
    }

    public function update(Request $request, Article $article)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'tanggal' => 'required|string|max:100',
            'penulis' => 'nullable|string|max:150',
            'sumber' => 'nullable|url|max:255',
            'sumber_teks' => 'nullable|string|max:150',
            'ikon' => 'nullable|string|max:50',
            'warna' => 'nullable|string|max:30',
            'ringkasan' => 'required|string',
            'isi_text' => 'nullable|string',
            'urutan' => 'nullable|integer',
            'aktif' => 'nullable|boolean',
            'foto' => 'nullable|image|max:3072',
            'hapus_foto' => 'nullable|boolean',
        ]);

        $data = [
            'judul' => $validated['judul'],
            'kategori' => $validated['kategori'],
            'tanggal' => $validated['tanggal'],
            'penulis' => $validated['penulis'] ?: 'Pengurus DPC HILLSI',
            'sumber' => $validated['sumber'] ?: null,
            'sumber_teks' => $validated['sumber_teks'] ?: null,
            'ikon' => $validated['ikon'] ?? '📰',
            'warna' => $validated['warna'] ?? '#0e4c54',
            'ringkasan' => $validated['ringkasan'],
            'urutan' => (int) ($validated['urutan'] ?? 0),
            'aktif' => $request->has('aktif') ? (bool) $request->aktif : true,
        ];

        // Format Isi Berita ke array paragraf
        if ($request->filled('isi_text')) {
            $isiRaw = $request->input('isi_text', '');
            $paragraphs = array_values(array_filter(array_map('trim', explode("\n", $isiRaw))));
            $data['isi'] = !empty($paragraphs) ? $paragraphs : [$validated['ringkasan']];
        }

        // Hapus foto jika dicentang
        if ($request->boolean('hapus_foto')) {
            if ($article->foto && str_starts_with($article->foto, 'storage/')) {
                Storage::disk('public')->delete(str_replace('storage/', '', $article->foto));
            }
            $data['foto'] = null;
        }

        // Handle Image Upload baru
        if ($request->hasFile('foto')) {
            if ($article->foto && str_starts_with($article->foto, 'storage/')) {
                Storage::disk('public')->delete(str_replace('storage/', '', $article->foto));
            }
            $path = $request->file('foto')->store('articles', 'public');
            $data['foto'] = 'storage/' . $path;
        } elseif ($request->filled('remote_foto_url') && empty($data['foto'])) {
            $data['foto'] = $this->downloadRemoteImage($request->remote_foto_url);
        }

        $article->update($data);

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Berita berhasil diperbarui!', 'data' => $article]);
        }

        return redirect()->route('admin.articles.index')->with('success', 'Berita & Kegiatan berhasil diperbarui!');
    }

    public function toggleActive(Article $article)
    {
        $article->aktif = !$article->aktif;
        $article->save();

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'aktif' => $article->aktif,
                'message' => 'Status artikel berhasil diubah!'
            ]);
        }

        return back()->with('success', 'Status artikel berhasil diubah!');
    }

    public function destroy(Article $article)
    {
        $judul = $article->judul;

        if ($article->foto && str_starts_with($article->foto, 'storage/')) {
            Storage::disk('public')->delete(str_replace('storage/', '', $article->foto));
        }

        $article->delete();

        if (request()->wantsJson()) {
            return response()->json(['success' => true, 'message' => "Artikel \"{$judul}\" berhasil dihapus!"]);
        }

        return redirect()->route('admin.articles.index')->with('success', "Artikel \"{$judul}\" berhasil dihapus!");
    }
}
