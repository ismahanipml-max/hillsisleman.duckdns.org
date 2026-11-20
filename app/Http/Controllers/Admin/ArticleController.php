<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
            'ikon' => $validated['ikon'] ?: '📰',
            'warna' => $validated['warna'] ?: '#0e4c54',
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
            'ikon' => $validated['ikon'] ?: '📰',
            'warna' => $validated['warna'] ?: '#0e4c54',
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
