@extends('layouts.admin')

@section('title', 'Pengaturan')
@section('page-title', 'Pengaturan Website & Akun')
@section('page-subtitle', 'Kelola informasi publik DPC HILLSI Sleman dan keamanan password administrator')

@section('content')
<div style="display: grid; grid-template-columns: 3fr 2fr; gap: 24px; align-items: start;" class="settings-grid">
    
    <!-- Kolom Kiri: Pengaturan Beranda & Kontak -->
    <div class="card-box">
        <div class="card-header">
            <div>
                <h2>🏛️ Pengaturan Beranda & Kontak DPC HILLSI Sleman</h2>
                <p>Data kontak resmi dan konten yang tampil di halaman publik</p>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.settings.update') }}">
            @csrf

            <div class="form-grid">
                <!-- Judul Hero -->
                <div class="form-group col-full">
                    <label class="form-label">Judul Utama Hero</label>
                    <input type="text" name="hero_judul" class="form-control" value="{{ old('hero_judul', $settings['hero_judul'] ?? '') }}" placeholder="Wadah Bersama Lembaga Pelatihan Kerja di Kabupaten Sleman">
                </div>

                <!-- Deskripsi Hero -->
                <div class="form-group col-full">
                    <label class="form-label">Deskripsi Singkat Hero</label>
                    <textarea name="hero_deskripsi" class="form-control" rows="3">{{ old('hero_deskripsi', $settings['hero_deskripsi'] ?? '') }}</textarea>
                </div>

                <!-- Tahun Berdiri -->
                <div class="form-group">
                    <label class="form-label">Tahun Berdiri HILLSI</label>
                    <input type="text" name="tahun_berdiri" class="form-control" value="{{ old('tahun_berdiri', $settings['tahun_berdiri'] ?? '1982') }}" placeholder="1982">
                </div>

                <!-- Telepon -->
                <div class="form-group">
                    <label class="form-label">Nomor Telepon / Hotline</label>
                    <input type="text" name="telepon" class="form-control" value="{{ old('telepon', $settings['telepon'] ?? '') }}" placeholder="(0274) 000 000">
                </div>

                <!-- Email -->
                <div class="form-group">
                    <label class="form-label">Email Sekretariat</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $settings['email'] ?? '') }}" placeholder="dpc.hillsi.sleman@example.com">
                </div>

                <!-- Instagram -->
                <div class="form-group">
                    <label class="form-label">Instagram Resmi (URL atau @username)</label>
                    <input type="text" name="instagram" class="form-control" value="{{ old('instagram', $settings['instagram'] ?? '') }}" placeholder="https://www.instagram.com/dpc.hillsi.sleman/">
                </div>

                <!-- Alamat Lengkap -->
                <div class="form-group col-full">
                    <label class="form-label">Alamat Lengkap Sekretariat</label>
                    <textarea name="alamat" class="form-control" rows="3" placeholder="Alamat kantor sekretariat DPC HILLSI Sleman...">{{ old('alamat', $settings['alamat'] ?? '') }}</textarea>
                </div>

                <!-- Link Google Maps -->
                <div class="form-group col-full" style="background: rgba(14, 124, 133, 0.05); padding: 14px 16px; border-radius: 12px; border: 1px dashed var(--brand);">
                    <label class="form-label" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                        <span style="font-weight: 800; color: var(--text);">🗺️ Link Google Maps Sekretariat</span>
                        <span class="form-hint" style="color: var(--brand); font-weight: 600;">(Bisa pakai Link Maps / Share Lokasi)</span>
                    </label>
                    <p style="font-size: 12px; color: var(--text-muted); margin: 0 0 8px 0; line-height: 1.45;">
                        Peta interaktif di halaman utama akan otomatis menampilkan titik lokasi ini. Anda bisa menempelkan link Google Maps (misal <code>https://maps.app.goo.gl/...</code> atau <code>https://goo.gl/maps/...</code>). Jika dikosongkan, peta akan otomatis melacak teks <b>Alamat Lengkap Sekretariat</b> di atas.
                    </p>
                    <input type="text" name="link_maps" class="form-control" value="{{ old('link_maps', $settings['link_maps'] ?? '') }}" placeholder="Contoh: https://maps.app.goo.gl/... atau https://maps.google.com/?q=...">
                </div>
            </div>

            <div style="margin-top: 24px; padding-top: 18px; border-top: 1px solid var(--border); display: flex; justify-content: flex-end;">
                <button type="submit" class="btn btn-primary">
                    💾 Simpan Pengaturan Website
                </button>
            </div>
        </form>
    </div>

    <!-- Kolom Kanan: Ganti Password Admin -->
    <div class="card-box">
        <div class="card-header">
            <div>
                <h2>🔐 Ganti Password Admin</h2>
                <p>Password ini digunakan saat login ke panel admin tanpa email</p>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.settings.password') }}">
            @csrf

            <div style="display: flex; flex-direction: column; gap: 16px;">
                <div class="form-group">
                    <label class="form-label">Password Saat Ini <span class="req">*</span></label>
                    <input type="password" name="current_password" class="form-control" required placeholder="Masukkan password saat ini...">
                    @error('current_password')
                        <span style="color: var(--danger); font-size: 12px; font-weight: 600;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Password Baru <span class="req">*</span></label>
                    <input type="password" name="password" class="form-control" required placeholder="Minimal 6 karakter...">
                    @error('password')
                        <span style="color: var(--danger); font-size: 12px; font-weight: 600;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Konfirmasi Password Baru <span class="req">*</span></label>
                    <input type="password" name="password_confirmation" class="form-control" required placeholder="Ulangi password baru...">
                </div>

                <div style="background: color-mix(in srgb, var(--brand) 8%, transparent); border: 1px solid color-mix(in srgb, var(--brand) 20%, transparent); border-radius: 12px; padding: 14px; font-size: 12.5px; color: var(--text-muted); line-height: 1.4;">
                    <strong style="color: var(--brand); display: block; margin-bottom: 2px;">Catatan Keamanan:</strong>
                    Password akan otomatis di-hash dengan aman di database. Pastikan Anda mengingat password baru untuk login berikutnya.
                </div>

                <div style="margin-top: 8px;">
                    <button type="submit" class="btn btn-primary" style="width: 100%;">
                        🔒 Perbarui Password
                    </button>
                </div>
            </div>
        </form>
    </div>

</div>

@push('styles')
<style>
@media (max-width: 960px) {
    .settings-grid {
        grid-template-columns: 1fr !important;
    }
}
</style>
@endpush
@endsection
