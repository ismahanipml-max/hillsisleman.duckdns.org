@extends('layouts.admin')

@section('title', 'Tambah Berita & Kegiatan Baru')
@section('page-title', 'Tambah Berita & Kegiatan')
@section('page-subtitle', 'Publikasikan dokumentasi kegiatan, pelatihan vokasi, atau kabar terkini DPC HILLSI Sleman')

@section('content')
<div style="max-width: 980px; margin: 0 auto;">
    <div style="margin-bottom: 20px;">
        <a href="{{ route('admin.articles.index') }}" class="btn btn-secondary btn-sm" style="display: inline-flex; align-items: center; gap: 6px;">
            &larr; Kembali ke Daftar Berita
        </a>
    </div>

    @if($errors->any())
        <div style="padding: 14px 20px; background: rgba(239, 68, 68, 0.15); border: 1px solid var(--danger); border-radius: 12px; color: var(--text); margin-bottom: 24px; font-size: 13.5px;">
            <div style="font-weight: 700; margin-bottom: 6px; display: flex; align-items: center; gap: 8px;">
                <span>⚠️</span>
                <span>Terdapat kesalahan pengisian formulir:</span>
            </div>
            <ul style="margin: 0; padding-left: 20px;">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.articles.store') }}" enctype="multipart/form-data">
        @csrf

        <!-- Card Import Artikel melalui Link URL -->
        <div class="card-box" style="border: 2px dashed var(--brand); background: color-mix(in srgb, var(--brand) 6%, var(--surface-card)); margin-bottom: 24px;">
            <div class="card-header" style="margin-bottom: 12px;">
                <div>
                    <h2>⚡ Import Artikel melalui Link URL</h2>
                    <p>Tempel tautan artikel dari website berita lain (contoh: slemankab.go.id, portal berita, kemnaker.go.id) untuk mengambil data secara otomatis.</p>
                </div>
            </div>

            <div class="form-group col-full">
                <label class="form-label" for="importUrlInput">Link URL Artikel</label>
                <div style="display: flex; gap: 10px; align-items: stretch; flex-wrap: wrap;">
                    <div style="flex: 1; min-width: 280px; position: relative;">
                        <input 
                            type="url" 
                            id="importUrlInput" 
                            class="form-control" 
                            placeholder="Tempelkan link URL artikel di sini (misal: https://slemankab.go.id/berita-pelatihan-drone)"
                            style="padding-left: 38px; height: 44px; font-size: 14px;"
                            onkeydown="if(event.key==='Enter'){event.preventDefault();fetchArticleFromUrl();}"
                        >
                        <span style="position: absolute; left: 13px; top: 50%; transform: translateY(-50%); font-size: 16px; color: var(--text-muted); pointer-events: none;">
                            🔗
                        </span>
                    </div>
                    <button type="button" id="btnFetchUrl" class="btn btn-primary" onclick="fetchArticleFromUrl()" style="padding: 0 24px; height: 44px; font-size: 14px; font-weight: 700; white-space: nowrap; display: inline-flex; align-items: center; gap: 8px;">
                        <span id="btnFetchIcon">📥</span>
                        <span id="btnFetchText">Ambil Artikel</span>
                    </button>
                </div>
                <div id="fetchStatusMsg" style="display: none; margin-top: 12px; font-size: 13px; padding: 10px 16px; border-radius: 10px; line-height: 1.5;"></div>
            </div>
        </div>

        <input type="hidden" name="remote_foto_url" id="remote_foto_url" value="">

        <div class="card-box">
            <div class="card-header">
                <div>
                    <h2>📝 Informasi Utama Berita</h2>
                    <p>Judul, kategori kejuruan, tanggal, dan penulis berita</p>
                </div>
            </div>

            <div class="form-grid">
                <div class="form-group col-full">
                    <label class="form-label" for="judul">Judul Berita & Kegiatan <span style="color:var(--danger)">*</span></label>
                    <input 
                        type="text" 
                        name="judul" 
                        id="judul" 
                        class="form-control" 
                        value="{{ old('judul') }}" 
                        placeholder="Misal: Sasar Peluang Kerja Digital, Pemkab Sleman Gelar Pelatihan Drone Aerial"
                        required
                        oninput="updatePreview()"
                    >
                </div>

                <div class="form-group">
                    <label class="form-label" for="kategori">Kategori Kegiatan <span style="color:var(--danger)">*</span></label>
                    <input 
                        type="text" 
                        name="kategori" 
                        id="kategori" 
                        class="form-control" 
                        value="{{ old('kategori', 'Pelatihan Vokasi') }}" 
                        placeholder="Misal: Pelatihan Vokasi, Koordinasi DPC, Sertifikasi Resmi"
                        required
                        list="kategoriList"
                        oninput="updatePreview()"
                    >
                    <datalist id="kategoriList">
                        <option value="Pelatihan Vokasi">
                        <option value="Koordinasi DPC">
                        <option value="Sertifikasi Resmi">
                        <option value="Manajemen LPK">
                        <option value="Praktik & K3">
                        <option value="Kemitraan Daerah">
                        <option value="Teknologi Digital">
                        <option value="Akreditasi Mutu">
                        <option value="Kewirausahaan">
                        <option value="Studi Lapangan">
                        <option value="Karir Global">
                        <option value="Mitra & Rekanan">
                    </datalist>
                </div>

                <div class="form-group">
                    <label class="form-label" for="tanggal">Tanggal Publikasi <span style="color:var(--danger)">*</span></label>
                    <input 
                        type="text" 
                        name="tanggal" 
                        id="tanggal" 
                        class="form-control" 
                        value="{{ old('tanggal', date('d F Y')) }}" 
                        placeholder="Misal: 10 Maret 2026"
                        required
                        oninput="updatePreview()"
                    >
                </div>

                <div class="form-group">
                    <label class="form-label" for="penulis">Penulis / Sumber Rilis</label>
                    <input 
                        type="text" 
                        name="penulis" 
                        id="penulis" 
                        class="form-control" 
                        value="{{ old('penulis', 'Disnaker & Humas Pemkab Sleman') }}" 
                        placeholder="Misal: Disnaker & Humas Pemkab Sleman / Humas DPC HILLSI"
                    >
                </div>

                <div class="form-group">
                    <label class="form-label" for="urutan">Nomor Urutan Tampil</label>
                    <input 
                        type="number" 
                        name="urutan" 
                        id="urutan" 
                        class="form-control" 
                        value="{{ old('urutan', 1) }}" 
                        min="0"
                    >
                    <span style="font-size: 11.5px; color: var(--text-muted);">Urutan prioritas tampil di beranda (angka lebih kecil = tampil lebih awal).</span>
                </div>
            </div>
        </div>

        <div class="card-box">
            <div class="card-header">
                <div>
                    <h2>🎨 Desain Banner & Ikon Visual Kartu</h2>
                    <p>Atur gradien warna latar, ikon emoji, dan foto dokumentasi</p>
                </div>
            </div>

            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label" for="ikon">Ikon Emoji Banner</label>
                    <div style="display: flex; gap: 8px; align-items: center;">
                        <input 
                            type="text" 
                            name="ikon" 
                            id="ikon" 
                            class="form-control" 
                            value="{{ old('ikon', '🚁') }}" 
                            style="width: 70px; text-align: center; font-size: 22px;"
                            maxlength="8"
                            oninput="updatePreview()"
                        >
                        <div style="display: flex; gap: 6px; flex-wrap: wrap;">
                            @foreach(['🚁', '🤝', '📜', '🏢', '🛡️', '🎪', '📱', '🏅', '💡', '🏭', '🌐', '🏆'] as $em)
                                <button type="button" class="btn btn-secondary btn-sm" style="padding: 6px 10px; font-size: 16px;" onclick="selectEmoji('{{ $em }}')">
                                    {{ $em }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="warna">Warna Utama Gradien Banner</label>
                    <div style="display: flex; gap: 10px; align-items: center;">
                        <input 
                            type="color" 
                            name="warna" 
                            id="warna" 
                            value="{{ old('warna', '#0e4c54') }}" 
                            style="width: 52px; height: 42px; border-radius: 8px; border: 1px solid var(--border); cursor: pointer;"
                            onchange="updatePreview()"
                        >
                        <input 
                            type="text" 
                            id="warnaText" 
                            class="form-control" 
                            value="{{ old('warna', '#0e4c54') }}" 
                            style="width: 110px;"
                            oninput="document.getElementById('warna').value = this.value; updatePreview();"
                        >
                        <div style="display: flex; gap: 6px; flex-wrap: wrap;">
                            @foreach(['#0e4c54', '#8a3314', '#1e40af', '#065f46', '#9a3412', '#155e75', '#701a75'] as $col)
                                <div onclick="selectColor('{{ $col }}')" style="width: 24px; height: 24px; border-radius: 6px; background: {{ $col }}; cursor: pointer; border: 2px solid #fff; box-shadow: 0 1px 4px rgba(0,0,0,0.3);"></div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="form-group col-full">
                    <label class="form-label" for="foto">Foto Dokumentasi Thumbnail (Opsional)</label>
                    <input 
                        type="file" 
                        name="foto" 
                        id="foto" 
                        class="form-control" 
                        accept="image/*"
                        onchange="previewImage(this)"
                    >
                    <span style="font-size: 11.5px; color: var(--text-muted);">
                        Format: JPG, PNG, WebP (Maks: 3MB). Jika dikosongkan, kartu akan otomatis menampilkan gradien warna dan ikon emoji seperti screenshot referensi.
                    </span>
                </div>
            </div>

            <!-- Live Card Preview -->
            <div style="margin-top: 24px; padding: 20px; background: #061017; border-radius: 16px; border: 1px solid rgba(255,255,255,0.08);">
                <div style="font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #8fa6b2; margin-bottom: 14px;">
                    👁️ Pratinjau Tampilan Kartu di Beranda:
                </div>
                <div style="max-width: 440px;">
                    <div style="background: #0f2129; border: 1px solid rgba(255,255,255,0.08); border-radius: 20px; overflow: hidden; box-shadow: 0 6px 20px rgba(0,0,0,0.25);">
                        <div id="previewThumb" style="position: relative; width: 100%; height: 200px; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #0e4c54, #051317); overflow: hidden;">
                            <div style="position: absolute; width: 180px; height: 180px; border-radius: 50%; background: rgba(255,255,255,0.07); right: -35px; top: -45px;"></div>
                            <span id="previewIcon" style="font-size: 58px; filter: drop-shadow(0 6px 14px rgba(0,0,0,.4));">🚁</span>
                            <img id="previewImgEl" src="" style="width: 100%; height: 100%; object-fit: cover; position: absolute; inset: 0; display: none;">
                        </div>
                        <div style="padding: 22px 24px;">
                            <div id="previewDate" style="font-size: 13px; color: #8fa6b2; font-weight: 600; margin-bottom: 10px;">
                                📅 10 Maret 2026
                            </div>
                            <h3 id="previewTitle" style="margin: 0 0 10px; font-size: 18px; line-height: 1.38; font-weight: 800; color: #ffffff;">
                                Sasar Peluang Kerja Digital, Pemkab Sleman Gelar Pelatihan Drone Aerial bagi Warga
                            </h3>
                            <p id="previewDesc" style="margin: 0 0 20px; color: #8fa6b2; font-size: 13.5px; line-height: 1.55; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                                Pemkab Sleman bersama LPK Pusat Pelatihan Drone Indonesia membuka pelatihan drone aerial bagi warga dalam rangka Program Jaringan Pengamanan Sosial (JPS)...
                            </p>
                            <button type="button" style="background: #2aa1ab; color: #ffffff; border: none; border-radius: 10px; padding: 9px 20px; font-size: 13.5px; font-weight: 700;">
                                Baca Selengkapnya &rarr;
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-box">
            <div class="card-header">
                <div>
                    <h2>📄 Konten Artikel & Tautan Sumber</h2>
                    <p>Ringkasan singkat, naskah isi lengkap berita per paragraf, dan link sumber resmi</p>
                </div>
            </div>

            <div class="form-grid">
                <div class="form-group col-full">
                    <label class="form-label" for="ringkasan">Ringkasan Singkat (3 Baris di Kartu) <span style="color:var(--danger)">*</span></label>
                    <textarea 
                        name="ringkasan" 
                        id="ringkasan" 
                        class="form-control" 
                        rows="3" 
                        required 
                        placeholder="Ringkasan padat 1-2 kalimat yang tampil pada kartu berita beranda..."
                        oninput="updatePreview()"
                    >{{ old('ringkasan') }}</textarea>
                </div>

                <div class="form-group col-full">
                    <label class="form-label" for="isi_text">Isi Lengkap Berita (Tampil Saat Pop-up / Modal Dibuka)</label>
                    <textarea 
                        name="isi_text" 
                        id="isi_text" 
                        class="form-control" 
                        rows="9" 
                        placeholder="Tuliskan naskah lengkap berita di sini. Pisahkan setiap paragraf dengan menekan tombol ENTER (baris baru)..."
                    >{{ old('isi_text') }}</textarea>
                    <span style="font-size: 11.5px; color: var(--text-muted);">
                        💡 Tips: Tekan <b>Enter</b> dua kali untuk membuat paragraf baru. Sistem otomatis merapikannya menjadi paragraf rapi pada pop-up pembaca.
                    </span>
                </div>

                <div class="form-group">
                    <label class="form-label" for="sumber">Tautan Link Sumber Berita Resmi (Opsional)</label>
                    <input 
                        type="url" 
                        name="sumber" 
                        id="sumber" 
                        class="form-control" 
                        value="{{ old('sumber') }}" 
                        placeholder="Misal: https://slemankab.go.id"
                    >
                </div>

                <div class="form-group">
                    <label class="form-label" for="sumber_teks">Label Teks Sumber</label>
                    <input 
                        type="text" 
                        name="sumber_teks" 
                        id="sumber_teks" 
                        class="form-control" 
                        value="{{ old('sumber_teks', 'slemankab.go.id') }}" 
                        placeholder="Misal: slemankab.go.id / kemnaker.go.id"
                    >
                </div>

                <div class="form-group col-full" style="margin-top: 8px;">
                    <label style="display: flex; align-items: center; gap: 10px; cursor: pointer; font-size: 14px; font-weight: 700; color: var(--text);">
                        <input type="checkbox" name="aktif" id="aktifCheckbox" value="1" {{ old('aktif', 1) ? 'checked' : '' }} style="width: 18px; height: 18px;">
                        <span>Publikasikan Sekarang (Tampilkan di Beranda)</span>
                    </label>
                </div>
            </div>

            <div style="margin-top: 28px; padding-top: 20px; border-top: 1px solid var(--border); display: flex; justify-content: flex-end; gap: 12px; flex-wrap: wrap;">
                <a href="{{ route('admin.articles.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" name="action_type" value="draft" class="btn btn-secondary" onclick="document.getElementById('aktifCheckbox').checked = false;" style="padding: 11px 22px; font-size: 14px;">
                    📁 Simpan sebagai Draft
                </button>
                <button type="submit" name="action_type" value="publish" class="btn btn-primary" onclick="document.getElementById('aktifCheckbox').checked = true;" style="padding: 11px 28px; font-size: 14px;">
                    🚀 Publikasikan Sekarang
                </button>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
function fetchArticleFromUrl() {
    var urlInput = document.getElementById('importUrlInput');
    var statusBox = document.getElementById('fetchStatusMsg');
    var btn = document.getElementById('btnFetchUrl');
    var btnIcon = document.getElementById('btnFetchIcon');
    var btnText = document.getElementById('btnFetchText');

    var url = urlInput.value.trim();
    if (!url) {
        showStatus('Harap masukkan link URL artikel terlebih dahulu.', 'error');
        urlInput.focus();
        return;
    }

    if (!url.startsWith('http://') && !url.startsWith('https://')) {
        showStatus('Format URL tidak valid. Harap sertakan http:// atau https://', 'error');
        urlInput.focus();
        return;
    }

    // Set loading state
    btn.disabled = true;
    btnIcon.textContent = '⏳';
    btnText.textContent = 'Mengambil Artikel...';
    showStatus('Sedang menghubungi website dan mengekstrak data artikel...', 'loading');

    fetch("{{ route('admin.articles.fetch-url') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}",
            "Accept": "application/json"
        },
        body: JSON.stringify({ url: url })
    })
    .then(function(res) {
        return res.json().then(function(json) {
            return { ok: res.ok, status: res.status, data: json };
        });
    })
    .then(function(result) {
        btn.disabled = false;
        btnIcon.textContent = '📥';
        btnText.textContent = 'Ambil Artikel';

        if (!result.ok || !result.data.success) {
            var errMsg = (result.data && result.data.message) ? result.data.message : 'Gagal mengambil data dari URL tersebut.';
            showStatus('⚠️ ' + errMsg + ' Anda tetap dapat mengisi artikel secara manual di bawah ini.', 'error');
            return;
        }

        var art = result.data.data;

        // Auto fill fields
        if (art.judul) document.getElementById('judul').value = art.judul;
        if (art.ringkasan) document.getElementById('ringkasan').value = art.ringkasan;
        if (art.isi_text) document.getElementById('isi_text').value = art.isi_text;
        if (art.tanggal) document.getElementById('tanggal').value = art.tanggal;
        if (art.penulis) document.getElementById('penulis').value = art.penulis;
        if (art.kategori) document.getElementById('kategori').value = art.kategori;
        if (art.sumber) document.getElementById('sumber').value = art.sumber;
        if (art.sumber_teks) document.getElementById('sumber_teks').value = art.sumber_teks;

        // Handle image preview
        if (art.foto_url) {
            document.getElementById('remote_foto_url').value = art.foto_url;
            var previewImg = document.getElementById('previewImgEl');
            previewImg.src = art.foto_url;
            previewImg.style.display = 'block';
        }

        updatePreview();

        showStatus('✅ Berhasil mengambil data artikel dari <b>' + (art.sumber_teks || url) + '</b>! Data telah otomatis dimasukkan ke kolom editor di bawah. Silakan periksa atau sesuaikan naskah sebelum menyimpan.', 'success');
        if (typeof showToast === 'function') {
            showToast('Data artikel berhasil diambil dari URL!', 'success');
        }
    })
    .catch(function(err) {
        btn.disabled = false;
        btnIcon.textContent = '📥';
        btnText.textContent = 'Ambil Artikel';
        showStatus('⚠️ Terjadi gangguan koneksi: ' + err.message + '. Anda dapat mengisi naskah artikel secara manual.', 'error');
    });

    function showStatus(msg, type) {
        statusBox.style.display = 'block';
        if (type === 'error') {
            statusBox.style.background = 'rgba(239, 68, 68, 0.15)';
            statusBox.style.border = '1px solid var(--danger)';
            statusBox.style.color = 'var(--text)';
        } else if (type === 'success') {
            statusBox.style.background = 'rgba(70, 223, 177, 0.18)';
            statusBox.style.border = '1px solid var(--accent)';
            statusBox.style.color = 'var(--text)';
        } else {
            statusBox.style.background = 'rgba(9, 209, 199, 0.12)';
            statusBox.style.border = '1px solid var(--brand)';
            statusBox.style.color = 'var(--text)';
        }
        statusBox.innerHTML = msg;
    }
}

function selectEmoji(em) {
    document.getElementById('ikon').value = em;
    updatePreview();
}

function selectColor(col) {
    document.getElementById('warna').value = col;
    document.getElementById('warnaText').value = col;
    updatePreview();
}

function previewImage(input) {
    var imgEl = document.getElementById('previewImgEl');
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            imgEl.src = e.target.result;
            imgEl.style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    } else {
        imgEl.style.display = 'none';
    }
}

function updatePreview() {
    var judul = document.getElementById('judul').value || 'Judul Berita & Kegiatan Anda';
    var tgl = document.getElementById('tanggal').value || '10 Maret 2026';
    var ringkasan = document.getElementById('ringkasan').value || 'Ringkasan singkat berita akan tampil di sini sebanyak maksimal 3 baris...';
    var ikon = document.getElementById('ikon').value || '📰';
    var warna = document.getElementById('warna').value || '#0e4c54';

    document.getElementById('previewTitle').textContent = judul;
    document.getElementById('previewDate').textContent = '📅 ' + tgl;
    document.getElementById('previewDesc').textContent = ringkasan;
    document.getElementById('previewIcon').textContent = ikon;
    document.getElementById('previewThumb').style.background = 'linear-gradient(135deg, ' + warna + ', #051317)';
    document.getElementById('warnaText').value = warna;
}
</script>
@endpush
@endsection
