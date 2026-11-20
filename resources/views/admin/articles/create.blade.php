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
                        <input type="checkbox" name="aktif" value="1" {{ old('aktif', 1) ? 'checked' : '' }} style="width: 18px; height: 18px;">
                        <span>Publikasikan Sekarang (Tampilkan di Beranda)</span>
                    </label>
                </div>
            </div>

            <div style="margin-top: 28px; padding-top: 20px; border-top: 1px solid var(--border); display: flex; justify-content: flex-end; gap: 12px;">
                <a href="{{ route('admin.articles.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary" style="padding: 11px 28px; font-size: 15px;">
                    💾 Simpan & Publikasikan Berita
                </button>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
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
