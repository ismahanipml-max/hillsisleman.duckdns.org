@extends('layouts.admin')

@section('title', 'Data LPK')
@section('page-title', 'Kelola Lembaga Pelatihan Kerja (LPK)')
@section('page-subtitle', 'Daftar direktori LPK di Kabupaten Sleman, status publikasi, dan kelola profil')

@section('content')
<div class="card-box">
    <!-- Top Action Toolbar -->
    <div style="display: flex; gap: 14px; align-items: center; justify-content: space-between; flex-wrap: wrap; margin-bottom: 22px;">
        <div style="display: flex; gap: 12px; align-items: center; flex-wrap: wrap; flex: 1; min-width: 280px;">
            <!-- Live Search -->
            <div style="position: relative; flex: 1; min-width: 220px; max-width: 360px;">
                <input 
                    type="text" 
                    id="searchLpk" 
                    placeholder="Cari nama LPK, bidang, atau admin..." 
                    class="form-control"
                    style="padding-left: 36px;"
                    oninput="filterLpkTable()"
                >
                <span style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); font-size: 15px; color: var(--text-muted); pointer-events: none;">
                    🔍
                </span>
            </div>

            <!-- Filter Bidang -->
            <select id="filterBidang" class="form-control" style="width: auto; min-width: 170px;" onchange="filterLpkTable()">
                <option value="">Semua Bidang ({{ count($categories) }})</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat }}">{{ $cat }}</option>
                @endforeach
            </select>

            <!-- Filter Status -->
            <select id="filterStatus" class="form-control" style="width: auto; min-width: 140px;" onchange="filterLpkTable()">
                <option value="">Semua Status</option>
                <option value="1">Aktif (Tampil)</option>
                <option value="0">Sembunyi</option>
            </select>
        </div>

        <!-- Tombol Tambah LPK -->
        <button type="button" class="btn btn-primary" onclick="openF()">
            <span style="font-size: 16px;">+</span>
            <span>Tambah LPK Baru</span>
        </button>
    </div>

    <!-- Table of LPKs -->
    <div class="table-container">
        <table class="admin-table" id="lpkTable">
            <thead>
                <tr>
                    <th style="width: 50px; text-align: center;">#</th>
                    <th>Lembaga Pelatihan Kerja</th>
                    <th>Kontak & Admin</th>
                    <th style="text-align: center;">Statistik</th>
                    <th style="text-align: center;">Tampil / Sembunyi</th>
                    <th style="text-align: right; width: 140px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($lpks as $idx => $lpk)
                    <tr class="lpk-row" 
                        data-name="{{ strtolower($lpk->nama) }}" 
                        data-bidang="{{ strtolower($lpk->bidang) }}" 
                        data-admin="{{ strtolower($lpk->nama_admin ?? '') }}"
                        data-status="{{ $lpk->aktif ? '1' : '0' }}"
                        data-id="{{ $lpk->id }}"
                    >
                        <td style="text-align: center; color: var(--text-muted); font-weight: 700;">
                            {{ $idx + 1 }}
                        </td>
                        <td>
                            <div style="display: flex; align-items: flex-start; gap: 12px;">
                                @if($lpk->logo_url)
                                    <img src="{{ $lpk->logo_url }}" alt="" style="width: 44px; height: 44px; border-radius: 10px; object-fit: contain; background: #fff; border: 1px solid var(--border); padding: 3px; flex-shrink: 0;">
                                @else
                                    <span style="width: 44px; height: 44px; border-radius: 10px; background: color-mix(in srgb, var(--brand) 12%, transparent); color: var(--brand); display: grid; place-items: center; font-size: 20px; flex-shrink: 0;">
                                        {{ $lpk->ikon ?: '🏛️' }}
                                    </span>
                                @endif
                                <div>
                                    <a href="{{ url('/lpk/' . $lpk->slug) }}" target="_blank" style="color: var(--text); text-decoration: none; font-weight: 700; font-size: 14px; line-height: 1.3; display: inline-flex; align-items: center; gap: 4px;">
                                        <span>{{ $lpk->nama }}</span>
                                        <span style="font-size: 11px; color: var(--text-muted);">&nearr;</span>
                                    </a>
                                    @if($lpk->tagline)
                                        <p style="font-size: 12px; color: var(--text-muted); margin: 2px 0 4px; line-height: 1.3;">{{ $lpk->tagline }}</p>
                                    @endif
                                    <div style="display: flex; gap: 6px; align-items: center; flex-wrap: wrap; margin-top: 4px;">
                                        <span class="pill pill-brand">{{ $lpk->bidang }}</span>
                                        @if($lpk->website)
                                            <a href="{{ $lpk->website }}" target="_blank" style="font-size: 11px; color: var(--brand); text-decoration: none;">🌐 Website</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div style="font-size: 13px; line-height: 1.4;">
                                <strong style="display: block;">{{ $lpk->nama_admin ?: '-' }}</strong>
                                @if($lpk->whatsapp)
                                    <a href="{{ $lpk->wa_link }}" target="_blank" style="color: var(--success); font-size: 12px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 3px;">
                                        <span>💬</span>
                                        <span>{{ $lpk->whatsapp }}</span>
                                    </a>
                                @endif
                                @if($lpk->email)
                                    <div style="font-size: 11.5px; color: var(--text-muted);">{{ $lpk->email }}</div>
                                @endif
                            </div>
                        </td>
                        <td style="text-align: center;">
                            <div style="display: flex; gap: 6px; justify-content: center; flex-wrap: wrap;">
                                <span class="pill pill-muted" title="{{ $lpk->services_count }} Layanan">
                                    🛠️ {{ $lpk->services_count }}
                                </span>
                                <span class="pill pill-muted" title="{{ $lpk->partners_count }} Mitra">
                                    🤝 {{ $lpk->partners_count }}
                                </span>
                                <span class="pill pill-muted" title="{{ $lpk->galleries_count }} Foto">
                                    📸 {{ $lpk->galleries_count }}
                                </span>
                            </div>
                        </td>
                        <td style="text-align: center;">
                            <label class="switch" title="Klik untuk mengaktifkan atau menyembunyikan LPK">
                                <input 
                                    type="checkbox" 
                                    class="lpk-toggle" 
                                    data-id="{{ $lpk->id }}" 
                                    {{ $lpk->aktif ? 'checked' : '' }} 
                                    onchange="toggleLpkStatus({{ $lpk->id }}, this)"
                                >
                                <span class="slider"></span>
                            </label>
                            <div class="status-label-{{ $lpk->id }}" style="font-size: 11px; font-weight: 700; color: {{ $lpk->aktif ? 'var(--success)' : 'var(--text-muted)' }}; margin-top: 4px;">
                                {{ $lpk->aktif ? 'Tampil' : 'Sembunyi' }}
                            </div>
                        </td>
                        <td style="text-align: right;">
                            <div style="display: flex; gap: 6px; justify-content: flex-end;">
                                <button type="button" class="btn btn-secondary btn-sm" onclick="openF({{ $lpk->id }})" title="Edit LPK">
                                    ✏️ Edit
                                </button>
                                <button type="button" class="btn btn-danger btn-sm" onclick="openDeleteModal({{ $lpk->id }}, '{{ addslashes($lpk->nama) }}')" title="Hapus LPK">
                                    🗑️
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center; color: var(--text-muted); padding: 32px;">
                            Belum ada data LPK. Silakan klik tombol "Tambah LPK Baru".
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Empty state for search filter -->
    <div id="noResults" style="display: none; text-align: center; padding: 40px 20px; color: var(--text-muted);">
        <p style="font-size: 16px; font-weight: 700;">Tidak ada LPK yang cocok</p>
        <p style="font-size: 13px; margin-top: 4px;">Coba gunakan kata kunci pencarian lain atau ubah filter bidang/status.</p>
    </div>
</div>

<!-- Modal Form Tambah / Edit LPK (openF & saveF) -->
<div class="modal-overlay" id="lpkModal">
    <div class="modal-box" style="max-width: 840px;">
        <div class="modal-header">
            <h3 id="modalTitle">Tambah LPK Baru</h3>
            <button type="button" class="modal-close" onclick="closeModal('lpkModal')">&times;</button>
        </div>

        <form id="lpkForm" method="POST" action="{{ route('admin.lpks.store') }}" enctype="multipart/form-data" onsubmit="return saveF(event)">
            @csrf
            <div id="methodField"></div>
            <input type="hidden" id="currentLpkId" value="">

            <div class="modal-body" style="max-height: calc(85vh - 130px); overflow-y: auto;">
                
                <!-- Section 1: Profil & Identitas Lembaga -->
                <div style="margin-bottom: 24px;">
                    <h4 style="font-size: 14px; font-weight: 800; color: var(--brand); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 12px; display: flex; align-items: center; gap: 6px;">
                        <span>🏢</span>
                        <span>Identitas Lembaga</span>
                    </h4>

                    <div class="form-grid">
                        <!-- Nama LPK (wajib) -->
                        <div class="form-group col-full">
                            <label class="form-label" for="formNama">Nama LPK <span class="req">* (Wajib)</span></label>
                            <input type="text" name="nama" id="formNama" class="form-control" required placeholder="Contoh: Indonesia Drone Training Center (IDTC)">
                        </div>

                        <!-- Bidang -->
                        <div class="form-group">
                            <label class="form-label" for="formBidang">Bidang Pelatihan</label>
                            <input type="text" name="bidang" id="formBidang" class="form-control" placeholder="Contoh: Teknologi Drone, Tata Boga, dll" list="categoryOptions">
                            <datalist id="categoryOptions">
                                @foreach($categories as $cat)
                                    <option value="{{ $cat }}">
                                @endforeach
                            </datalist>
                        </div>

                        <!-- Tagline -->
                        <div class="form-group">
                            <label class="form-label" for="formTagline">Tagline / Moto</label>
                            <input type="text" name="tagline" id="formTagline" class="form-control" placeholder="Contoh: Berilmu untuk Berbagi">
                        </div>

                        <!-- Tentang LPK (textarea) -->
                        <div class="form-group col-full">
                            <label class="form-label" for="formTentang">
                                Tentang LPK <span class="form-hint">(Bisa dibuat beberapa paragraf rapi dengan spasi/enter antar paragraf)</span>
                            </label>
                            <textarea name="tentang" id="formTentang" class="form-control" rows="6" style="min-height: 140px; line-height: 1.65; font-size: 14px; white-space: pre-wrap;" placeholder="Deskripsi lengkap mengenai profil lembaga pelatihan, kurikulum, dan keunggulan langsung di lapangan..."></textarea>
                        </div>
                    </div>
                </div>

                <!-- Section 2: Layanan & Mitra -->
                <div style="margin-bottom: 24px; padding-top: 18px; border-top: 1px solid var(--border);">
                    <h4 style="font-size: 14px; font-weight: 800; color: var(--brand); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 12px; display: flex; align-items: center; gap: 6px;">
                        <span>🛠️</span>
                        <span>Program & Kerjasama</span>
                    </h4>

                    <div class="form-grid">
                        <!-- Layanan (textarea, satu per baris) -->
                        <div class="form-group">
                            <label class="form-label" for="formLayanan">
                                Layanan Pelatihan <span class="form-hint">(Satu layanan per baris)</span>
                            </label>
                            <textarea name="layanan" id="formLayanan" class="form-control" rows="5" placeholder="Pelatihan drone dasar&#10;Pemetaan dan fotogrametri&#10;Pertanian&#10;Pertambangan&#10;Inspeksi industri"></textarea>
                        </div>

                        <!-- Mitra, opsional (textarea, satu per baris) -->
                        <div class="form-group">
                            <label class="form-label" for="formMitra">
                                Mitra Kerjasama <span class="form-hint">(Opsional, satu mitra per baris)</span>
                            </label>
                            <textarea name="mitra" id="formMitra" class="form-control" rows="5" placeholder="UGM&#10;AMIKOM&#10;Dinas Pendidikan Sleman&#10;Disnaker Sleman&#10;BPBD Bantul"></textarea>
                        </div>
                    </div>
                </div>

                <!-- Section 3: Kontak & Alamat -->
                <div style="margin-bottom: 24px; padding-top: 18px; border-top: 1px solid var(--border);">
                    <h4 style="font-size: 14px; font-weight: 800; color: var(--brand); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 12px; display: flex; align-items: center; gap: 6px;">
                        <span>📞</span>
                        <span>Kontak & Lokasi</span>
                    </h4>

                    <div class="form-grid">
                        <!-- Nama Admin -->
                        <div class="form-group">
                            <label class="form-label" for="formAdmin">Nama Admin / Pengelola</label>
                            <input type="text" name="nama_admin" id="formAdmin" class="form-control" placeholder="Contoh: Franko Nero">
                        </div>

                        <!-- WhatsApp -->
                        <div class="form-group">
                            <label class="form-label" for="formWa">Nomor WhatsApp</label>
                            <input type="text" name="whatsapp" id="formWa" class="form-control" placeholder="Contoh: +62 856-0060-4388 atau 085600604388">
                        </div>

                        <!-- Email -->
                        <div class="form-group">
                            <label class="form-label" for="formEmail">Email</label>
                            <input type="email" name="email" id="formEmail" class="form-control" placeholder="info@lembaga.example">
                        </div>

                        <!-- Instagram -->
                        <div class="form-group">
                            <label class="form-label" for="formIg">Instagram</label>
                            <input type="text" name="instagram" id="formIg" class="form-control" placeholder="Contoh: @idtc.drone">
                        </div>

                        <!-- Link Website Resmi -->
                        <div class="form-group">
                            <label class="form-label" for="formWebsite">Link Website Resmi</label>
                            <input type="text" name="website" id="formWebsite" class="form-control" placeholder="https://pelatihandronejogja.my.id">
                        </div>

                        <!-- Link Google Maps -->
                        <div class="form-group">
                            <label class="form-label" for="formMaps">Link Google Maps</label>
                            <input type="text" name="link_maps" id="formMaps" class="form-control" placeholder="https://www.google.com/maps/search/?api=1&query=...">
                        </div>

                        <!-- Alamat -->
                        <div class="form-group col-full">
                            <label class="form-label" for="formAlamat">Alamat Lengkap</label>
                            <textarea name="alamat" id="formAlamat" class="form-control" rows="2" placeholder="Nama jalan, nomor rumah/kantor, dusun, kelurahan, kecamatan, Sleman..."></textarea>
                        </div>
                    </div>
                </div>

                <!-- Section 4: Gambar Cover, Logo, dan Galeri Foto -->
                <div style="margin-bottom: 24px; padding-top: 18px; border-top: 1px solid var(--border);">
                    <h4 style="font-size: 14px; font-weight: 800; color: var(--brand); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 12px; display: flex; align-items: center; gap: 6px;">
                        <span>🖼️</span>
                        <span>Media & Galeri Foto</span>
                    </h4>

                    <div class="form-grid">
                        <!-- Upload Background Cover Banner -->
                        <div class="form-group col-full" style="background: rgba(14, 124, 133, 0.06); padding: 14px 16px; border-radius: 12px; border: 1px dashed var(--brand);">
                            <label class="form-label" for="formCover" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                                <span style="font-weight: 800; color: var(--text);">🌄 Background Banner Cover Lembaga</span>
                                <span class="form-hint" style="color: var(--brand); font-weight: 600;">(Format JPG / PNG / WebP, maks 2 MB)</span>
                            </label>
                            <p style="font-size: 12px; color: var(--text-muted); margin: 0 0 10px 0; line-height: 1.45;">
                                Gambar ini akan tampil sebagai latar belakang (background banner) header pada halaman profil publik lembaga.
                            </p>
                            <input type="file" name="cover" id="formCover" class="form-control" accept="image/*" onchange="previewSingleFile(this, 'coverPreviewBox', 'coverPreviewImg')">
                            
                            <!-- Pratinjau Cover Banner -->
                            <div id="coverPreviewBox" style="margin-top: 10px; display: none; align-items: center; gap: 14px; background: var(--surface); padding: 10px 14px; border-radius: 10px; border: 1px solid var(--border);">
                                <img id="coverPreviewImg" src="" alt="Pratinjau Cover" style="height: 70px; width: 130px; object-fit: cover; border-radius: 8px; border: 1px solid var(--border); box-shadow: 0 2px 8px rgba(0,0,0,0.15);">
                                <div>
                                    <div style="font-size: 12px; font-weight: 700; color: var(--text);" id="coverStatusText">Cover dipilih</div>
                                    <div style="font-size: 11px; color: var(--text-muted); margin-top: 2px;">Pilih file baru jika ingin mengganti gambar latar belakang.</div>
                                </div>
                            </div>
                        </div>

                        <!-- Upload Logo -->
                        <div class="form-group">
                            <label class="form-label" for="formLogo">
                                Upload Logo LPK <span class="form-hint">(Gambar maks 2 MB)</span>
                            </label>
                            <input type="file" name="logo" id="formLogo" class="form-control" accept="image/*" onchange="previewSingleFile(this, 'logoPreviewBox', 'logoPreviewImg')">
                            
                            <!-- Pratinjau Logo -->
                            <div id="logoPreviewBox" style="margin-top: 8px; display: none; align-items: center; gap: 10px; background: var(--bg); padding: 8px 12px; border-radius: 10px; border: 1px solid var(--border);">
                                <img id="logoPreviewImg" src="" alt="Pratinjau Logo" style="height: 44px; width: 44px; object-fit: contain; background: #fff; border-radius: 6px; border: 1px solid var(--border); padding: 2px;">
                                <div style="font-size: 12px; color: var(--text-muted);" id="logoStatusText">Logo dipilih</div>
                            </div>
                        </div>

                        <!-- Upload Banyak Foto Galeri -->
                        <div class="form-group col-full">
                            <label class="form-label" for="formGalleries">
                                Upload Banyak Foto Galeri <span class="form-hint">(Maksimal 36 foto per lembaga, maks 2 MB per foto)</span>
                            </label>
                            <input type="file" name="galleries[]" id="formGalleries" class="form-control" accept="image/*" multiple onchange="previewGalleryUploads(this)">
                            <div id="newGalleryPreviewGrid" style="display: flex; gap: 8px; flex-wrap: wrap; margin-top: 8px;"></div>
                        </div>

                        <!-- Pratinjau Foto Galeri Tersimpan & Tombol Hapus per Foto (Khusus Edit) -->
                        <div class="form-group col-full" id="existingGallerySection" style="display: none;">
                            <label class="form-label" style="display: flex; justify-content: space-between; align-items: center;">
                                <span>Foto Galeri Tersimpan (<span id="existingGalleryCount">0</span> Foto)</span>
                                <span class="form-hint">Klik tombol 🗑️ pada foto untuk menghapus</span>
                            </label>
                            
                            <div id="existingGalleryGrid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(90px, 1fr)); gap: 10px; margin-top: 8px; max-height: 220px; overflow-y: auto; padding: 10px; background: var(--bg); border: 1px solid var(--border); border-radius: 12px;">
                                <!-- Item foto dimuat via JavaScript -->
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 5: Saklar Tampil / Sembunyi -->
                <div style="padding: 14px 18px; background: color-mix(in srgb, var(--brand) 6%, var(--bg)); border: 1px solid var(--border); border-radius: 14px; display: flex; align-items: center; justify-content: space-between; margin-top: 10px;">
                    <div>
                        <strong style="font-size: 14px; display: block; color: var(--text);">Tampilkan di Website Publik</strong>
                        <span style="font-size: 12px; color: var(--text-muted);">Bila saklar aktif, LPK akan muncul di beranda dan hasil pencarian publik.</span>
                    </div>
                    <label class="switch">
                        <input type="checkbox" name="aktif" id="formAktif" value="1" checked>
                        <span class="slider"></span>
                    </label>
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('lpkModal')">Batal</button>
                <button type="submit" class="btn btn-primary" id="btnSubmitForm">Simpan LPK</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Konfirmasi Hapus LPK -->
<div class="modal-overlay" id="deleteModal">
    <div class="modal-box" style="max-width: 460px;">
        <div class="modal-header">
            <h3>Konfirmasi Hapus LPK</h3>
            <button type="button" class="modal-close" onclick="closeModal('deleteModal')">&times;</button>
        </div>

        <form id="deleteForm" method="POST" action="">
            @csrf
            @method('DELETE')
            <div class="modal-body" style="text-align: center; padding: 30px 20px;">
                <div style="width: 56px; height: 56px; border-radius: 50%; background: rgba(239, 68, 68, 0.12); color: var(--danger); font-size: 26px; display: grid; place-items: center; margin: 0 auto 16px;">
                    ⚠️
                </div>
                <h4 style="font-size: 17px; font-weight: 800; color: var(--text); margin-bottom: 8px;">
                    Hapus LPK Ini?
                </h4>
                <p style="font-size: 13.5px; color: var(--text-muted); line-height: 1.5;">
                    Apakah Anda yakin ingin menghapus <strong id="deleteLpkName" style="color: var(--text);"></strong>? Seluruh layanan, mitra, dan foto galeri terkait akan ikut terhapus secara permanen.
                </p>
            </div>

            <div class="modal-footer" style="justify-content: center; gap: 12px;">
                <button type="button" class="btn btn-secondary" onclick="closeModal('deleteModal')">Batal</button>
                <button type="submit" class="btn btn-danger">Ya, Hapus Permanen</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // Live Search and Filters
    function filterLpkTable() {
        var query = (document.getElementById('searchLpk').value || '').toLowerCase().trim();
        var filterBidang = (document.getElementById('filterBidang').value || '').toLowerCase().trim();
        var filterStatus = document.getElementById('filterStatus').value;

        var rows = document.querySelectorAll('.lpk-row');
        var visibleCount = 0;

        rows.forEach(function(row) {
            var name = row.getAttribute('data-name') || '';
            var bidang = row.getAttribute('data-bidang') || '';
            var admin = row.getAttribute('data-admin') || '';
            var status = row.getAttribute('data-status') || '';

            var matchQuery = !query || name.includes(query) || bidang.includes(query) || admin.includes(query);
            var matchBidang = !filterBidang || bidang === filterBidang;
            var matchStatus = (filterStatus === '') || (status === filterStatus);

            if (matchQuery && matchBidang && matchStatus) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        var noResults = document.getElementById('noResults');
        if (noResults) {
            noResults.style.display = visibleCount === 0 ? 'block' : 'none';
        }
    }

    // Modal open / close helpers
    function openModal(id) {
        var el = document.getElementById(id);
        if (el) el.classList.add('open');
    }

    function closeModal(id) {
        var el = document.getElementById(id);
        if (el) el.classList.remove('open');
    }

    // openF: Fungsi pembuka modal Tambah/Edit sesuai referensi hillsi-admin.html
    function openF(id = null) {
        var form = document.getElementById('lpkForm');
        form.reset();
        document.getElementById('newGalleryPreviewGrid').innerHTML = '';

        if (!id) {
            // Mode Tambah LPK Baru
            document.getElementById('modalTitle').textContent = 'Tambah LPK Baru';
            form.action = "{{ route('admin.lpks.store') }}";
            document.getElementById('methodField').innerHTML = '';
            document.getElementById('btnSubmitForm').textContent = 'Simpan LPK Baru';
            document.getElementById('currentLpkId').value = '';

            document.getElementById('formAktif').checked = true;
            document.getElementById('coverPreviewBox').style.display = 'none';
            document.getElementById('logoPreviewBox').style.display = 'none';
            document.getElementById('existingGallerySection').style.display = 'none';
            document.getElementById('existingGalleryGrid').innerHTML = '';

            openModal('lpkModal');
        } else {
            // Mode Edit LPK
            document.getElementById('modalTitle').textContent = 'Edit Data LPK';
            form.action = "/admin/lpks/" + id;
            document.getElementById('methodField').innerHTML = '@method("PUT")';
            document.getElementById('btnSubmitForm').textContent = 'Perbarui Data LPK';
            document.getElementById('currentLpkId').value = id;

            // Fetch data LPK lengkap via AJAX
            fetch('/admin/lpks/' + id, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(function(res) { return res.json(); })
            .then(function(data) {
                document.getElementById('formNama').value = data.nama || '';
                document.getElementById('formBidang').value = data.bidang || '';
                document.getElementById('formTagline').value = data.tagline || '';
                document.getElementById('formTentang').value = data.tentang || '';
                document.getElementById('formLayanan').value = data.layanan || '';
                document.getElementById('formMitra').value = data.mitra || '';
                document.getElementById('formAdmin').value = data.nama_admin || '';
                document.getElementById('formWa').value = data.whatsapp || '';
                document.getElementById('formEmail').value = data.email || '';
                document.getElementById('formIg').value = data.instagram || '';
                document.getElementById('formWebsite').value = data.website || '';
                document.getElementById('formMaps').value = data.link_maps || '';
                document.getElementById('formAlamat').value = data.alamat || '';
                document.getElementById('formAktif').checked = !!data.aktif;

                // Cover Preview
                var coverBox = document.getElementById('coverPreviewBox');
                var coverImg = document.getElementById('coverPreviewImg');
                var coverText = document.getElementById('coverStatusText');
                if (data.cover_url) {
                    coverBox.style.display = 'flex';
                    coverImg.src = data.cover_url;
                    coverText.innerHTML = 'Cover saat ini. <a href="' + data.cover_url + '" target="_blank" style="color:var(--brand);font-weight:700">Lihat</a>';
                } else {
                    coverBox.style.display = 'none';
                }

                // Logo Preview
                var logoBox = document.getElementById('logoPreviewBox');
                var logoImg = document.getElementById('logoPreviewImg');
                var logoText = document.getElementById('logoStatusText');
                if (data.logo_url) {
                    logoBox.style.display = 'flex';
                    logoImg.src = data.logo_url;
                    logoText.innerHTML = 'Logo saat ini. <a href="' + data.logo_url + '" target="_blank" style="color:var(--brand);font-weight:700">Lihat</a>';
                } else {
                    logoBox.style.display = 'none';
                }

                // Gallery Grid with Delete Buttons
                var gallerySection = document.getElementById('existingGallerySection');
                var galleryGrid = document.getElementById('existingGalleryGrid');
                var galleryCount = document.getElementById('existingGalleryCount');

                if (data.galleries && data.galleries.length > 0) {
                    gallerySection.style.display = 'block';
                    galleryCount.textContent = data.galleries.length;
                    
                    var html = '';
                    data.galleries.forEach(function(g, idx) {
                        html += '<div id="galItem-' + g.id + '" style="position:relative; aspect-ratio:4/3; border-radius:8px; overflow:hidden; border:1px solid var(--border); background:#000;">' +
                            '<img src="' + g.foto_url + '" alt="Foto ' + (idx + 1) + '" style="width:100%; height:100%; object-fit:cover;">' +
                            '<button type="button" onclick="deleteGalleryPhoto(' + id + ', ' + g.id + ')" title="Hapus foto ini" ' +
                                'style="position:absolute; top:4px; right:4px; width:22px; height:22px; border-radius:50%; background:rgba(239,68,68,0.85); color:#fff; border:none; cursor:pointer; font-size:11px; display:grid; place-items:center; line-height:1; transition:0.2s;">' +
                                '🗑️' +
                            '</button>' +
                        '</div>';
                    });
                    galleryGrid.innerHTML = html;
                } else {
                    gallerySection.style.display = 'none';
                    galleryGrid.innerHTML = '';
                    galleryCount.textContent = '0';
                }

                openModal('lpkModal');
            })
            .catch(function(err) {
                showToast('Gagal memuat data LPK untuk diedit.', 'error');
            });
        }
    }

    // saveF: Validasi dan pengiriman form LPK
    function saveF(event) {
        var nama = document.getElementById('formNama').value.trim();
        if (!nama) {
            event.preventDefault();
            showToast('Nama LPK wajib diisi.', 'error');
            document.getElementById('formNama').focus();
            return false;
        }

        // Tampilkan indikator proses pada tombol submit
        var btn = document.getElementById('btnSubmitForm');
        btn.disabled = true;
        btn.textContent = 'Menyimpan data...';
        return true;
    }

    // Preview Single File (Cover & Logo)
    function previewSingleFile(input, boxId, imgId) {
        var box = document.getElementById(boxId);
        var img = document.getElementById(imgId);
        if (input.files && input.files[0]) {
            var file = input.files[0];
            if (file.size > 2 * 1024 * 1024) {
                showToast('Ukuran file melebihi 2 MB!', 'error');
                input.value = '';
                return;
            }
            var reader = new FileReader();
            reader.onload = function(e) {
                img.src = e.target.result;
                box.style.display = 'flex';
            };
            reader.readAsDataURL(file);
        }
    }

    // Preview Newly Selected Gallery Files
    function previewGalleryUploads(input) {
        var grid = document.getElementById('newGalleryPreviewGrid');
        grid.innerHTML = '';
        if (input.files && input.files.length) {
            Array.from(input.files).forEach(function(file, i) {
                if (file.size > 2 * 1024 * 1024) {
                    showToast('File "' + file.name + '" melebihi 2 MB!', 'error');
                    return;
                }
                var reader = new FileReader();
                reader.onload = function(e) {
                    var thumb = document.createElement('div');
                    thumb.style.cssText = 'width:60px; height:60px; border-radius:6px; overflow:hidden; border:1px solid var(--brand); position:relative;';
                    thumb.innerHTML = '<img src="' + e.target.result + '" style="width:100%; height:100%; object-fit:cover;">';
                    grid.appendChild(thumb);
                };
                reader.readAsDataURL(file);
            });
        }
    }

    // Delete a single gallery photo via AJAX inside the modal
    function deleteGalleryPhoto(lpkId, galleryId) {
        if (!confirm('Hapus foto ini dari galeri?')) return;

        var token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        fetch('/admin/lpks/' + lpkId + '/gallery/' + galleryId, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': token,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(function(res) { return res.json(); })
        .then(function(data) {
            if (data.success) {
                var item = document.getElementById('galItem-' + galleryId);
                if (item) {
                    item.style.transition = 'opacity 0.3s, transform 0.3s';
                    item.style.opacity = '0';
                    item.style.transform = 'scale(0.8)';
                    setTimeout(function() {
                        if (item.parentNode) item.parentNode.removeChild(item);
                        var countEl = document.getElementById('existingGalleryCount');
                        if (countEl) {
                            var cur = parseInt(countEl.textContent, 10) || 1;
                            countEl.textContent = Math.max(0, cur - 1);
                        }
                    }, 300);
                }
                showToast(data.message || 'Foto galeri berhasil dihapus.', 'success');
            } else {
                showToast('Gagal menghapus foto.', 'error');
            }
        })
        .catch(function(err) {
            showToast('Terjadi kesalahan jaringan saat menghapus foto.', 'error');
        });
    }

    // Open Delete Modal
    function openDeleteModal(id, name) {
        document.getElementById('deleteLpkName').textContent = name;
        document.getElementById('deleteForm').action = "/admin/lpks/" + id;
        openModal('deleteModal');
    }

    // Toggle LPK Active status via AJAX
    function toggleLpkStatus(id, checkbox) {
        var token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        fetch('/admin/lpks/' + id + '/toggle-active', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(function(res) { return res.json(); })
        .then(function(data) {
            if (data.success) {
                checkbox.checked = data.aktif;
                var row = checkbox.closest('.lpk-row');
                if (row) {
                    row.setAttribute('data-status', data.aktif ? '1' : '0');
                }
                var label = document.querySelector('.status-label-' + id);
                if (label) {
                    label.textContent = data.aktif ? 'Tampil' : 'Sembunyi';
                    label.style.color = data.aktif ? 'var(--success)' : 'var(--text-muted)';
                }
                showToast(data.message, 'success');
            } else {
                checkbox.checked = !checkbox.checked;
                showToast('Gagal mengubah status LPK.', 'error');
            }
        })
        .catch(function(err) {
            checkbox.checked = !checkbox.checked;
            showToast('Terjadi kesalahan jaringan.', 'error');
        });
    }

    // Auto open edit if query param ?edit=ID exists
    document.addEventListener('DOMContentLoaded', function() {
        var urlParams = new URLSearchParams(window.location.search);
        var editId = urlParams.get('edit');
        if (editId) {
            openF(editId);
        }
    });
</script>
@endpush
@endsection
