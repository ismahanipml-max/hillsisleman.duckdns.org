@extends('layouts.admin')

@section('title', 'Kelola Berita & Kegiatan')
@section('page-title', 'Kelola Berita & Kegiatan')
@section('page-subtitle', 'Daftar publikasi, dokumentasi kegiatan, dan berita seputar DPC HILLSI Sleman')

@section('content')
<div class="card-box">
    <!-- Top Action Toolbar -->
    <div style="display: flex; gap: 14px; align-items: center; justify-content: space-between; flex-wrap: wrap; margin-bottom: 22px;">
        <form method="GET" action="{{ route('admin.articles.index') }}" style="display: flex; gap: 12px; align-items: center; flex-wrap: wrap; flex: 1; min-width: 280px;">
            <!-- Live Search -->
            <div style="position: relative; flex: 1; min-width: 220px; max-width: 360px;">
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}" 
                    placeholder="Cari judul, penulis, atau kata kunci..." 
                    class="form-control"
                    style="padding-left: 36px;"
                >
                <span style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); font-size: 15px; color: var(--text-muted); pointer-events: none;">
                    🔍
                </span>
            </div>

            <!-- Filter Kategori -->
            <select name="kategori" class="form-control" style="width: auto; min-width: 170px;" onchange="this.form.submit()">
                <option value="">Semua Kategori</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat }}" {{ request('kategori') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                @endforeach
            </select>

            <!-- Filter Status -->
            <select name="status" class="form-control" style="width: auto; min-width: 140px;" onchange="this.form.submit()">
                <option value="">Semua Status</option>
                <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Aktif (Tampil)</option>
                <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Sembunyi</option>
            </select>

            @if(request()->anyFilled(['search', 'kategori', 'status']))
                <a href="{{ route('admin.articles.index') }}" class="btn btn-secondary btn-sm" title="Reset Filter">
                    ✕ Reset
                </a>
            @endif
        </form>

        <!-- Tombol Tambah Berita Baru -->
        <a href="{{ route('admin.articles.create') }}" class="btn btn-primary">
            <span style="font-size: 16px;">+</span>
            <span>Tambah Berita & Kegiatan Baru</span>
        </a>
    </div>

    @if(session('success'))
        <div style="padding: 12px 18px; background: rgba(70, 223, 177, 0.15); border: 1px solid var(--accent); border-radius: 10px; color: var(--text); margin-bottom: 20px; font-size: 13.5px; font-weight: 600; display: flex; align-items: center; gap: 10px;">
            <span>✅</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Table of Articles -->
    <div class="table-container">
        <table class="admin-table">
            <thead>
                <tr>
                    <th style="width: 50px; text-align: center;">#</th>
                    <th style="width: 80px; text-align: center;">Thumbnail</th>
                    <th>Judul Berita & Kegiatan</th>
                    <th>Kategori</th>
                    <th>Tanggal Publikasi</th>
                    <th style="text-align: center; width: 110px;">Tampil</th>
                    <th style="text-align: right; width: 140px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($articles as $idx => $art)
                    <tr>
                        <td style="text-align: center; color: var(--text-muted); font-weight: 700;">
                            {{ $articles->firstItem() + $idx }}
                        </td>
                        <td style="text-align: center;">
                            <div style="width: 58px; height: 42px; border-radius: 8px; overflow: hidden; background: linear-gradient(135deg, {{ $art->warna ?? '#0e4c54' }}, #051317); display: grid; place-items: center; margin: 0 auto; box-shadow: 0 2px 8px rgba(0,0,0,0.25); position: relative;">
                                @if($art->foto)
                                    <img src="{{ $art->foto_url }}" alt="{{ $art->judul }}" style="width: 100%; height: 100%; object-fit: cover;">
                                @else
                                    <span style="font-size: 22px;">{{ $art->ikon ?? '📰' }}</span>
                                @endif
                            </div>
                        </td>
                        <td>
                            <div style="font-weight: 800; color: var(--text); font-size: 14.5px; margin-bottom: 4px; line-height: 1.35;">
                                {{ $art->judul }}
                            </div>
                            <div style="font-size: 12px; color: var(--text-muted); display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                                <span>✍️ {{ $art->penulis ?? 'DPC HILLSI' }}</span>
                                @if($art->sumber)
                                    <span>•</span>
                                    <a href="{{ $art->sumber }}" target="_blank" style="color: var(--brand); text-decoration: none;">
                                        🌐 {{ $art->sumber_teks ?: 'Sumber Resmi' }} ↗
                                    </a>
                                @endif
                            </div>
                        </td>
                        <td>
                            <span class="pill pill-brand" style="font-size: 11.5px;">
                                {{ $art->kategori }}
                            </span>
                        </td>
                        <td style="font-size: 13px; color: var(--text-muted); font-weight: 600;">
                            📅 {{ $art->tanggal }}
                        </td>
                        <td style="text-align: center;">
                            <button 
                                type="button" 
                                onclick="toggleArticleActive({{ $art->id }}, this)" 
                                class="badge {{ $art->aktif ? 'badge-success' : 'badge-danger' }}"
                                style="border: none; cursor: pointer; font-family: inherit; font-size: 11.5px; padding: 4px 10px;"
                                title="Klik untuk mengubah status publikasi"
                            >
                                {{ $art->aktif ? 'Aktif' : 'Sembunyi' }}
                            </button>
                        </td>
                        <td style="text-align: right;">
                            <div style="display: flex; gap: 6px; justify-content: flex-end;">
                                <a href="{{ route('admin.articles.edit', $art->id) }}" class="btn btn-secondary btn-sm" title="Edit Artikel">
                                    ✏️ Edit
                                </a>
                                <button type="button" class="btn btn-danger btn-sm" onclick="openDeleteModal({{ $art->id }}, '{{ addslashes($art->judul) }}')" title="Hapus Artikel">
                                    🗑️
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center; color: var(--text-muted); padding: 40px 20px;">
                            <div style="font-size: 42px; margin-bottom: 12px;">📰</div>
                            <h3 style="font-size: 16px; font-weight: 700; color: var(--text); margin-bottom: 6px;">Belum Ada Berita & Kegiatan</h3>
                            <p style="font-size: 13px; margin-bottom: 18px;">Silakan buat artikel atau berita dokumentasi kegiatan pertama Anda.</p>
                            <a href="{{ route('admin.articles.create') }}" class="btn btn-primary btn-sm">
                                + Tambah Berita Sekarang
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($articles->hasPages())
        <div style="margin-top: 24px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
            <div style="font-size: 13px; color: var(--text-muted);">
                Menampilkan {{ $articles->firstItem() }} - {{ $articles->lastItem() }} dari {{ $articles->total() }} berita
            </div>
            <div>
                {{ $articles->links() }}
            </div>
        </div>
    @endif
</div>

<!-- Modal Konfirmasi Hapus Artikel -->
<div class="modal-overlay" id="deleteModal">
    <div class="modal-box" style="max-width: 440px;">
        <div class="modal-header">
            <h3>Konfirmasi Hapus Berita</h3>
            <button type="button" class="modal-close" onclick="closeModal('deleteModal')">&times;</button>
        </div>
        <form id="deleteForm" method="POST" action="">
            @csrf
            @method('DELETE')
            <div class="modal-body">
                <p style="font-size: 14px; color: var(--text); line-height: 1.6;">
                    Apakah Anda yakin ingin menghapus artikel <b id="deleteTitle" style="color: var(--danger);"></b>?
                </p>
                <p style="font-size: 12.5px; color: var(--text-muted); margin-top: 8px;">
                    Tindakan ini tidak dapat dibatalkan. Artikel akan dihapus permanen dari sistem.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('deleteModal')">Batal</button>
                <button type="submit" class="btn btn-danger">Hapus Permanen</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function openDeleteModal(id, title) {
    document.getElementById('deleteTitle').textContent = '"' + title + '"';
    document.getElementById('deleteForm').action = "{{ url('admin/articles') }}/" + id;
    document.getElementById('deleteModal').classList.add('open');
}

function closeModal(id) {
    var m = document.getElementById(id);
    if (m) m.classList.remove('open');
}

function toggleArticleActive(id, btn) {
    btn.disabled = true;
    fetch("{{ url('admin/articles') }}/" + id + "/toggle-active", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}",
            "Accept": "application/json"
        }
    })
    .then(function(res) { return res.json(); })
    .then(function(data) {
        btn.disabled = false;
        if (data.success) {
            if (data.aktif) {
                btn.className = "badge badge-success";
                btn.textContent = "Aktif";
            } else {
                btn.className = "badge badge-danger";
                btn.textContent = "Sembunyi";
            }
            if (typeof showToast === 'function') {
                showToast(data.message || "Status berhasil diubah", "success");
            }
        }
    })
    .catch(function(err) {
        btn.disabled = false;
        alert("Gagal mengubah status: " + err);
    });
}
</script>
@endpush
@endsection
