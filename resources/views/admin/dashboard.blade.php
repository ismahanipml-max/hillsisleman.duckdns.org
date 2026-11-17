@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard Administrasi')
@section('page-subtitle', 'Ringkasan data direktori Lembaga Pelatihan Kerja (LPK) Kabupaten Sleman')

@section('content')
<!-- 5 Kartu Statistik -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon" style="background: rgba(33, 58, 88, 0.12); color: #213A58;">
            🏢
        </div>
        <div class="stat-info">
            <h3>{{ $totalLpk }}</h3>
            <p>Total LPK</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon" style="background: rgba(70, 223, 177, 0.18); color: #0C6478;">
            ✅
        </div>
        <div class="stat-info">
            <h3>{{ $activeLpk }}</h3>
            <p>LPK Aktif (Publik)</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon" style="background: rgba(9, 209, 199, 0.16); color: #09D1C7;">
            🛠️
        </div>
        <div class="stat-info">
            <h3>{{ $totalServices }}</h3>
            <p>Layanan Pelatihan</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon" style="background: rgba(128, 238, 152, 0.22); color: #0C6478;">
            📸
        </div>
        <div class="stat-info">
            <h3>{{ $totalGalleries }}</h3>
            <p>Foto Kegiatan</p>
        </div>
    </div>
</div>

<!-- 2-Column Grid: Grafik Batang & 5 LPK Terbaru -->
<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; align-items: start;" class="dashboard-grid">
    
    <!-- Grafik Batang: LPK per Bidang -->
    <div class="card-box">
        <div class="card-header">
            <div>
                <h2>📊 Grafik LPK per Bidang</h2>
                <p>Distribusi lembaga pelatihan berdasarkan bidang keahlian</p>
            </div>
            <span class="pill pill-brand">{{ $bidangCounts->count() }} Bidang</span>
        </div>

        @php
            $maxCount = $bidangCounts->max('total') ?: 1;
        @endphp

        <div style="display: flex; flex-direction: column; gap: 14px; margin-top: 8px;">
            @forelse($bidangCounts as $b)
                @php
                    $percentage = round(($b->total / $maxCount) * 100);
                @endphp
                <div>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px; font-size: 13px;">
                        <span style="font-weight: 700; color: var(--text);">{{ $b->bidang }}</span>
                        <span style="font-weight: 800; color: var(--brand);">{{ $b->total }} LPK</span>
                    </div>
                    <div style="background: var(--bg); height: 10px; border-radius: 99px; overflow: hidden; border: 1px solid var(--border-subtle);">
                        <div style="background: linear-gradient(90deg, #0C6478, #15919B, #09D1C7, #46DFB1); height: 100%; width: {{ max($percentage, 8) }}%; border-radius: 99px; transition: width 0.6s ease;"></div>
                    </div>
                </div>
            @empty
                <p style="color: var(--text-muted); font-size: 13px; text-align: center; padding: 20px 0;">Belum ada data bidang pelatihan.</p>
            @endforelse
        </div>
    </div>

    <!-- 5 LPK Terbaru -->
    <div class="card-box">
        <div class="card-header">
            <div>
                <h2>🏢 5 LPK Terbaru</h2>
                <p>Lembaga yang baru diperbarui atau ditambahkan</p>
            </div>
            <a href="{{ route('admin.lpks.index') }}" class="btn btn-secondary btn-sm">
                Lihat Semua &rarr;
            </a>
        </div>

        <div class="table-container">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>LPK</th>
                        <th>Bidang</th>
                        <th>Status</th>
                        <th style="text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($latestLpks as $lpk)
                        <tr>
                            <td>
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    @if($lpk->logo_url)
                                        <img src="{{ $lpk->logo_url }}" alt="" style="width: 32px; height: 32px; border-radius: 8px; object-fit: contain; background: #fff; border: 1px solid var(--border); padding: 2px;">
                                    @else
                                        <span style="width: 32px; height: 32px; border-radius: 8px; background: color-mix(in srgb, var(--brand) 12%, transparent); color: var(--brand); display: grid; place-items: center; font-size: 16px;">
                                            {{ $lpk->ikon ?: '🏛️' }}
                                        </span>
                                    @endif
                                    <div>
                                        <strong style="display: block; font-size: 13px; line-height: 1.3;">{{ $lpk->nama }}</strong>
                                        <small style="color: var(--text-muted); font-size: 11px;">{{ $lpk->services->count() }} Layanan</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="pill pill-brand">{{ $lpk->bidang }}</span>
                            </td>
                            <td>
                                @if($lpk->aktif)
                                    <span class="pill pill-success">● Aktif</span>
                                @else
                                    <span class="pill pill-muted">○ Sembunyi</span>
                                @endif
                            </td>
                            <td style="text-align: right;">
                                <a href="{{ route('admin.lpks.index') }}?edit={{ $lpk->id }}" class="btn btn-secondary btn-sm" style="padding: 4px 10px; font-size: 12px;">
                                    Kelola
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align: center; color: var(--text-muted); padding: 24px;">
                                Belum ada data LPK.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

@push('styles')
<style>
@media (max-width: 960px) {
    .dashboard-grid {
        grid-template-columns: 1fr !important;
    }
}
</style>
@endpush
@endsection

