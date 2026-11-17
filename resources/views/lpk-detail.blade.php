@extends('layouts.public')

@section('title', $lpk->nama . ' · DPC HILLSI Sleman')

@section('content')
<div class="wrap">
  <a class="back" href="{{ url('/') }}" style="display:inline-block">← Kembali ke Beranda</a>

  <div class="dcover" style="position:relative; background-color: {{ $lpk->warna ?? '#0b5d63' }}; @if($lpk->cover_url) background-image: linear-gradient(160deg, rgba(10,25,30,.38), rgba(15,23,42,.84)), url('{{ $lpk->cover_url }}'); background-size: cover; background-position: center; @else background-image: linear-gradient(160deg, {{ $lpk->warna ?? '#0b5d63' }}, #000c); @endif">
    @if($lpk->logo_url)
      <div style="position:absolute;right:30px;top:24px;display:grid;place-items:center;">
        <img src="{{ $lpk->logo_url }}" alt="Logo {{ $lpk->nama }}" style="height:78px;max-width:210px;object-fit:contain;display:block;filter:drop-shadow(0 2px 6px rgba(255,255,255,0.75)) drop-shadow(0 4px 14px rgba(0,0,0,0.85));">
      </div>
    @else
      <span class="big">{{ $lpk->ikon }}</span>
    @endif
    <div>
      <small style="text-shadow:0 1px 4px rgba(0,0,0,.9);font-weight:700;">{{ $lpk->bidang }} · Profil Resmi</small>
      <h1 style="text-shadow:0 2px 10px rgba(0,0,0,.9);">{{ $lpk->nama }}</h1>
      @if($lpk->tagline)
        <p style="margin:6px 0 0;font-size:15px;opacity:.95;font-style:italic;text-shadow:0 1px 4px rgba(0,0,0,.9);">"{{ $lpk->tagline }}"</p>
      @endif
    </div>
  </div>

  <div class="two">
    <div>
      <div class="card">
        <h3>Tentang LPK</h3>
        <div class="tentang-text" style="font-size: 15px; color: var(--muted); line-height: 1.75;">
          @php
            $paragraphs = preg_split('/(\r\n\s*){2,}|\n{2,}|\r{2,}/', trim($lpk->tentang ?? ''));
          @endphp
          @forelse($paragraphs as $paragraph)
            @if(trim($paragraph))
              <p style="margin: 0 0 14px 0; text-align: justify; line-height: 1.75;">{!! nl2br(e(trim($paragraph))) !!}</p>
            @endif
          @empty
            <p style="color: var(--muted); font-style: italic;">Belum ada deskripsi profil untuk lembaga ini.</p>
          @endforelse
        </div>
      </div>

      <div class="card" style="margin-top:20px">
        <h3>Layanan</h3>
        <ul class="svc">
          @foreach($lpk->services as $service)
            <li>{{ $service->nama_layanan }}</li>
          @endforeach
        </ul>
      </div>
    </div>

    <div>
      <div class="card">
        <h3>Kontak Admin</h3>
        <p>{{ $lpk->nama_admin ?? 'Admin' }}</p>
        <p style="margin:4px 0 14px">{{ $lpk->whatsapp ?? '-' }}</p>
        <div style="display:flex;gap:10px;flex-wrap:wrap">
          @if($lpk->whatsapp)
            <a class="btn s" target="_blank" rel="noopener" href="{{ $lpk->wa_link }}">Chat WhatsApp</a>
          @endif
          @if($lpk->website)
            <a class="btn p" target="_blank" rel="noopener" href="{{ $lpk->website }}">Kunjungi Website Resmi</a>
          @endif
        </div>
      </div>

      <div class="card" style="margin-top:20px">
        <h3>Info dan Media Sosial</h3>
        <div class="row"><span>📍</span><span>{{ $lpk->alamat ?? 'Kabupaten Sleman, D.I. Yogyakarta' }}</span></div>
        <div class="row">
          <span>
            <svg width="22" height="22" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M45 16.2V38C45 40.2 43.2 42 41 42H35V24.8L24 33L13 24.8V42H7C4.8 42 3 40.2 3 38V16.2C3 13.4 6.2 11.8 8.4 13.5L24 25.2L39.6 13.5C41.8 11.8 45 13.4 45 16.2Z" fill="#EA4335"/>
              <path d="M35 42H41C43.2 42 45 40.2 45 38V16.2L35 24.8V42Z" fill="#C5221F"/>
              <path d="M13 42V24.8L3 16.2V38C3 40.2 4.8 42 7 42H13Z" fill="#04844B"/>
              <path d="M3 16.2C3 13.4 6.2 11.8 8.4 13.5L24 25.2V11L18.4 6.8C15.6 4.7 11.6 5.3 9.5 8.1L3 16.2Z" fill="#4285F4"/>
              <path d="M45 16.2C45 13.4 41.8 11.8 39.6 13.5L24 25.2V11L29.6 6.8C32.4 4.7 36.4 5.3 38.5 8.1L45 16.2Z" fill="#FBBC04"/>
            </svg>
          </span>
          <a href="mailto:{{ $lpk->email }}">{{ $lpk->email ?? '-' }}</a>
        </div>
        <div class="row">
          <span>
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <defs>
                <radialGradient id="ig-grad-detail" cx="0.2" cy="1" r="1">
                  <stop offset="0%" stop-color="#FFDD55"/>
                  <stop offset="20%" stop-color="#FF543E"/>
                  <stop offset="50%" stop-color="#C837AB"/>
                  <stop offset="100%" stop-color="#4158D0"/>
                </radialGradient>
              </defs>
              <rect x="2" y="2" width="20" height="20" rx="5.5" fill="url(#ig-grad-detail)"/>
              <circle cx="12" cy="12" r="4.2" stroke="white" stroke-width="1.8"/>
              <circle cx="17.2" cy="6.8" r="1.1" fill="white"/>
            </svg>
          </span>
          <a href="{{ $lpk->ig_link }}" target="_blank" rel="noopener">{{ $lpk->instagram ?? '@dpc.hillsi.sleman' }}</a>
        </div>
        @if($lpk->website)
          <div class="row"><span>🌐</span><a href="{{ $lpk->website }}" target="_blank" rel="noopener">{{ preg_replace('#^https?://#', '', rtrim($lpk->website, '/')) }}</a></div>
        @endif
        <a target="_blank" rel="noopener" href="{{ $lpk->maps_link }}" style="display:inline-block;margin-top:8px">Buka di Google Maps →</a>
      </div>
    </div>
  </div>

  {{-- Bagian "Mengapa IDTC?" / Keunggulan (hanya muncul jika datanya ada) --}}
  @if($lpk->features->count() > 0)
    <h2 style="margin-top:40px">Mengapa {{ Str::contains($lpk->nama, 'IDTC') ? 'IDTC' : $lpk->nama }}?</h2>
    <div class="grid3" style="margin-top:16px">
      @foreach($lpk->features as $feature)
        <div class="card">
          <div class="ic">{{ $feature->ikon ?: '✨' }}</div>
          <h3>{{ $feature->judul }}</h3>
          <p>{{ $feature->deskripsi }}</p>
        </div>
      @endforeach
    </div>
  @endif

  {{-- Bagian "Mitra" (hanya muncul jika datanya ada) --}}
  @if($lpk->partners->count() > 0)
    <h2 style="margin-top:40px">Mitra</h2>
    <div class="roles" style="margin-top:16px">
      @foreach($lpk->partners as $partner)
        <span>{{ $partner->nama_mitra }}</span>
      @endforeach
    </div>
  @endif

  {{-- Galeri --}}
  @php
    $galleries = $lpk->galleries->take(36);
  @endphp
  <h2 style="margin-top:40px">
    @if($galleries->count() > 0)
      Galeri Sertifikasi dan Pelatihan ({{ $galleries->count() }} Foto)
    @else
      Galeri
    @endif
  </h2>

  @if($galleries->count() > 0)
    <div class="gal" id="gal-container">
      @foreach($galleries as $idx => $gallery)
        <div class="gal-item" onclick="openLb({{ $idx }})" title="Klik untuk memperbesar (Foto {{ $idx + 1 }})">
          <img src="{{ $gallery->foto_url }}" alt="{{ $gallery->keterangan ?? 'Foto Kegiatan ' . ($idx + 1) }}" loading="lazy">
          <div class="gal-overlay">🔍</div>
        </div>
      @endforeach
    </div>
    <p class="note" style="margin-top:14px">Dokumentasi kegiatan dan pelatihan resmi (maksimal 36 foto). Klik foto untuk memperbesar.</p>
  @else
    <div class="gal">
      @for($i = 1; $i <= 6; $i++)
        <div style="background:linear-gradient(135deg, {{ $lpk->warna }}, #000a)">
          {{ $lpk->ikon }}<br>Foto {{ $i }}
        </div>
      @endfor
    </div>
    <p class="note">Data dan foto masih contoh.</p>
  @endif

  <div style="height:60px"></div>
</div>
@endsection

@push('scripts')
<script>
window._galleryList = @json($galleries->map(fn($g) => $g->foto_url)->values());
</script>
@endpush

