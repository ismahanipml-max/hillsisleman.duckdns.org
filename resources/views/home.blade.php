@extends('layouts.public')

@section('title', 'DPC HILLSI Kabupaten Sleman')

@section('content')
<div class="hero">
  <div class="wrap">
    <h1>Wadah Bersama <em>Lembaga Pelatihan Kerja</em> di Kabupaten Sleman</h1>
    <p class="lead">{{ $settings['hero_deskripsi'] ?? 'Mengoordinasikan LPK untuk meningkatkan mutu kompetensi SDM, bersinergi dengan pemerintah dan industri, serta menekan angka pengangguran.' }}</p>
    
    <div class="sbox">
      <div class="sbar">
        <input id="hq" placeholder="Cari pelatihan, mis. drone, tata boga, bahasa…" autocomplete="off" oninput="suggest()" onfocus="suggest()" onkeydown="if(event.key==='Enter')doSearch()">
        <button onclick="doSearch()">Cari</button>
      </div>
      <div class="sg" id="sg"></div>
    </div>

    <div class="hot">
      Populer: 
      <a onclick="quick('drone')">Drone</a>
      <a onclick="quick('tata')">Tata</a>
      <a onclick="quick('bahasa')">Bahasa</a>
      <a onclick="quick('komputer')">Komputer</a>
    </div>
  </div>
</div>

<section id="tentang">
  <div class="wrap">
    <div class="eye rv">Tentang Kami</div>
    <h2 class="rv">Mengenal HILLSI dan DPC Sleman</h2>
    <p class="sub rv" style="max-width:none">Himpunan yang menjadi jembatan antara lembaga pelatihan, pemerintah, dan dunia industri.</p>
    <div class="grid3">
      <div class="card rv">
        <div class="ic">🏛️</div>
        <h3>HILLSI</h3>
        <p style="text-align: left; line-height: 1.65;">Himpunan Lembaga Pelatihan Seluruh Indonesia yang berdiri sejak 1982 sebagai wadah komunikasi, konsultasi, dan standardisasi mutu pelatihan kerja secara nasional.</p>
      </div>
      <div class="card rv">
        <div class="ic">📍</div>
        <h3>DPC Kabupaten Sleman</h3>
        <p style="text-align: left; line-height: 1.65;">Dewan Pimpinan Cabang yang menaungi, membina, dan mengoordinasikan puluhan Lembaga Pelatihan Kerja (LPK) resmi di wilayah Kabupaten Sleman, D.I. Yogyakarta.</p>
      </div>
      <div class="card rv">
        <div class="ic">🎯</div>
        <h3>Tujuan Utama</h3>
        <p style="text-align: left; line-height: 1.65;">Meningkatkan kompetensi SDM unggul, memperkuat kemitraan dengan industri dan pemerintah (link and match), serta memperluas kesempatan kerja melalui vokasi.</p>
      </div>
    </div>
  </div>
</section>

<section id="lembaga" class="alt">
  <div class="wrap">
    <div class="eye rv">Direktori</div>
    <h2 class="rv">Lembaga Pelatihan</h2>
    <p class="sub rv" style="max-width:none">Lembaga Pelatihan Kerja di bawah koordinasi HILLSI Sleman. Gunakan kolom pencarian di bawah untuk menemukan layanan jasa pelatihan yang Anda butuhkan.</p>
    
    <!-- Fitur Pencarian Layanan Jasa Pelatihan -->
    <div class="dir-search-box rv">
      <div class="dir-search-input-wrap">
        <span class="dir-search-icon">🔍</span>
        <input 
          type="text" 
          id="dirQuery" 
          class="dir-search-input" 
          placeholder="Cari layanan jasa pelatihan (misal: drone, tata boga, komputer, menjahit, perhotelan)..." 
          autocomplete="off"
          oninput="onDirSearch(this.value)"
        >
      </div>
      <button type="button" class="btn p" id="dirResetBtn" onclick="resetQ()" style="display:none;padding:12px 20px;font-size:14px;white-space:nowrap;">
        Reset
      </button>
    </div>

    <div id="dirCountText" class="rv" style="margin:-10px 0 22px;font-size:13.5px;color:var(--muted);font-weight:600;"></div>

    <div class="lpk" id="list"></div>

    <!-- Navigasi Halaman Pagination (8 Lembaga Per Halaman) -->
    <div id="pagination" class="pagination-wrap"></div>
  </div>
</section>

@php
  $kegiatanArticles = [
    [
      'id' => 1,
      'ikon' => '🏛️',
      'warna' => '#0b5d63',
      'judul' => 'Rapat Koordinasi DPC HILLSI Sleman Perkuat Standardisasi dan Mutu Vokasi 2026',
      'kategori' => 'Koordinasi DPC',
      'tanggal' => '18 November 2026',
      'penulis' => 'Humas DPC HILLSI Sleman',
      'foto' => asset('images/idtc/foto1.jpg'),
      'ringkasan' => 'DPC HILLSI Kabupaten Sleman menyelenggarakan rapat koordinasi bersama seluruh pimpinan Lembaga Pelatihan Kerja (LPK) guna menyamakan visi peningkatan mutu kompetensi lulusan vokasi menghadapi dinamika industri modern.',
      'isi' => [
        'SLEMAN — Dewan Pimpinan Cabang Himpunan Lembaga Pelatihan Seluruh Indonesia (DPC HILLSI) Kabupaten Sleman menggelar rapat koordinasi dan pembinaan kelembagaan bersama puluhan pimpinan LPK di wilayah Sleman. Agenda utama pertemuan ini berfokus pada evaluasi kurikulum pelatihan serta penguatan akreditasi kelembagaan menuju standar nasional.',
        'Ketua DPC HILLSI Sleman menegaskan bahwa standarisasi mutu adalah kunci utama agar alumni LPK di Kabupaten Sleman mampu bersaing tidak hanya di tingkat regional namun juga di kancah nasional maupun internasional. Selain itu, ditekankan pentingnya transparansi informasi program dan penguatan tata kelola administrasi masing-masing lembaga.',
        'Melalui koordinasi ini, seluruh LPK anggota sepakat untuk saling bersinergi dalam pertukaran modul ajar, peningkatan kapasitas instruktur, serta penyusunan kalender pelatihan bersama yang dapat diakses dengan mudah oleh masyarakat luas.',
      ],
    ],
    [
      'id' => 2,
      'ikon' => '💻',
      'warna' => '#c2410c',
      'judul' => 'Pelatihan Berbasis Kompetensi Teknologi Terapan Sukses Diikuti Puluhan Instruktur',
      'kategori' => 'Pelatihan Vokasi',
      'tanggal' => '14 November 2026',
      'penulis' => 'Divisi Vokasi & Pelatihan',
      'foto' => asset('images/idtc/foto13.jpg'),
      'ringkasan' => 'Sebanyak 45 instruktur pelatihan kerja se-Kabupaten Sleman mengikuti program upgrading keterampilan teknologi terapan dan pengoperasian peralatan kerja modern berbasis standar industri.',
      'isi' => [
        'SLEMAN — Perkembangan teknologi di berbagai sektor menuntut adanya pembaruan kompetensi para tenaga pendidik dan instruktur pelatihan. Menjawab tantangan tersebut, DPC HILLSI Sleman menyelenggarakan workshop intensif Pelatihan Berbasis Kompetensi (PBK) yang berlangsung selama tiga hari penuh.',
        'Peserta pelatihan diberikan materi teori komprehensif yang dilanjutkan dengan praktik langsung pengoperasian teknologi terapan, mulai dari teknik digitalisasi operasional, simulasi kerja presisi, hingga metodologi evaluasi performa peserta didik di bengkel kerja.',
        'Diharapkan melalui kegiatan ini, para instruktur mampu menularkan ilmu dan etos kerja modern kepada para siswa di masing-masing LPK, sehingga melahirkan angkatan kerja yang terampil, produktif, dan adaptif terhadap transformasi digital.',
      ],
    ],
    [
      'id' => 3,
      'ikon' => '📜',
      'warna' => '#1d4ed8',
      'judul' => 'Asesmen dan Uji Kompetensi Nasional BNSP Resmi Digelar Serentak di Sleman',
      'kategori' => 'Sertifikasi Resmi',
      'tanggal' => '10 November 2026',
      'penulis' => 'LSP & Asesmen Kompetensi',
      'foto' => asset('images/idtc/foto7.jpg'),
      'ringkasan' => 'Penyelenggaraan uji kompetensi resmi berlisensi BNSP diikuti oleh ratusan peserta dari berbagai bidang kejuruan untuk menjamin pengakuan profesional sertifikasi kerja.',
      'isi' => [
        'SLEMAN — Guna memastikan legalitas keahlian dan daya saing tenaga kerja vokasi, DPC HILLSI Sleman memfasilitasi pelaksanaan uji kompetensi kerja nasional bekerja sama dengan Lembaga Sertifikasi Profesi (LSP) berlisensi Badan Nasional Sertifikasi Profesi (BNSP).',
        'Uji kompetensi ini mencakup berbagai skema kejuruan mulai dari bidang teknologi komputer informasi, teknik mekanik, perhotelan, kuliner, hingga bahasa asing. Asesor profesional diturunkan langsung untuk menguji portofolio, pengetahuan teknis, dan demonstrasi keahlian praktis para asesi.',
        'Sertifikat kompetensi yang diterbitkan berstandar nasional dan menjadi bukti pengakuan profesional yang berharga bagi para lulusan untuk melamar pekerjaan di korporasi swasta, industri BUMN, maupun bekal berkarier di mancanegara.',
      ],
    ],
    [
      'id' => 4,
      'ikon' => '🤝',
      'warna' => '#047857',
      'judul' => "Sinkronisasi Kurikulum 'Link and Match' Pererat Sinergi LPK dengan Mitra Industri",
      'kategori' => 'Kemitraan Industri',
      'tanggal' => '5 November 2026',
      'penulis' => 'Bidang Kerjasama Industri',
      'foto' => asset('images/idtc/foto2.jpg'),
      'ringkasan' => 'HILLSI Sleman bersama puluhan perwakilan perusahaan menggelar forum dialog guna memetakan kebutuhan riil dunia usaha dan menyelaraskan silabus pelatihan kerja.',
      'isi' => [
        'SLEMAN — Kesenjangan antara keterampilan yang diajarkan di lembaga pelatihan dengan kebutuhan riil dunia industri (job mismatch) terus diminimalisir oleh DPC HILLSI Sleman. Dalam forum sarasehan industri, pimpinan HRD dan perwakilan asosiasi usaha diundang untuk membedah silabus pelatihan kerja.',
        'Hasil dari forum ini merumuskan kurikulum berbasis kebutuhan nyata dunia industri (Link and Match). Pihak industri juga menyatakan komitmennya untuk membuka peluang magang kerja bersertifikat serta rekrutmen prioritas bagi para lulusan LPK di bawah naungan HILLSI Sleman.',
        'Langkah kolaboratif ini menjadi jembatan nyata bagi para pencari kerja agar tidak lagi kesulitan mencari jalur penyerapan kerja setelah menyelesaikan masa pelatihannya.',
      ],
    ],
    [
      'id' => 5,
      'ikon' => '🛡️',
      'warna' => '#b45309',
      'judul' => 'Penerapan SOP Keselamatan dan Kesehatan Kerja (K3) Jadi Standar Baku Seluruh LPK',
      'kategori' => 'Praktik & K3',
      'tanggal' => '28 Oktober 2026',
      'penulis' => 'Divisi K3 & Operasional',
      'foto' => asset('images/idtc/foto11.jpg'),
      'ringkasan' => 'Sosialisasi dan simulasi tanggap darurat keselamatan kerja di lingkungan bengkel latihan dicanangkan untuk menciptakan lingkungan belajar yang aman dan terstandar.',
      'isi' => [
        'SLEMAN — Keselamatan dan Kesehatan Kerja (K3) merupakan fondasi utama dalam setiap kegiatan vokasi dan perbengkelan. DPC HILLSI Sleman mengadakan sesi pembekalan dan simulasi K3 bagi penanggung jawab bengkel latihan di seluruh LPK binaan.',
        'Materi mencakup prosedur penggunaan alat pelindung diri (APD), pertolongan pertama pada kecelakaan kerja (P3K), pencegahan bahaya kebakaran, hingga manajemen penataan alat workshop berbasis 5S (Seiri, Seiton, Seiso, Seiketsu, Shitsuke).',
        'Dengan budaya K3 yang tertanam sejak masa pelatihan, lulusan LPK Sleman diharapkan memiliki disiplin tinggi dan kesadaran keselamatan yang matang saat memasuki lingkungan pabrik maupun proyek komersial.',
      ],
    ],
    [
      'id' => 6,
      'ikon' => '🏢',
      'warna' => '#7e22ce',
      'judul' => 'Kolaborasi DPC HILLSI dan Disnaker Sleman Sukses Gelar Bursa Pelatihan Vokasi',
      'kategori' => 'Sinergi Pemerintah',
      'tanggal' => '22 Oktober 2026',
      'penulis' => 'Humas DPC HILLSI Sleman',
      'foto' => asset('images/idtc/foto10.jpg'),
      'ringkasan' => 'Expo pelatihan dan informasi bursa kerja terpadu berhasil menarik antusiasme ribuan pemuda Sleman dalam mencari program pelatihan kejuruan yang tepat sasaran.',
      'isi' => [
        'SLEMAN — Kolaborasi erat antara Dinas Tenaga Kerja Kabupaten Sleman dan DPC HILLSI kembali membuahkan hasil positif melalui penyelenggaraan Bursa Pelatihan Vokasi Daerah. Acara ini menjadi wadah etalase program bagi puluhan LPK resmi di Kabupaten Sleman.',
        'Masyarakat dan pencari kerja dapat berkonsultasi langsung mengenai program beasiswa pelatihan gratis, fasilitas laboratorium kejuruan, hingga jalur penyaluran kerja yang disediakan masing-masing lembaga.',
        'Kepala Dinas Tenaga Kerja Sleman mengapresiasi peran aktif DPC HILLSI sebagai mitra strategis pemerintah daerah dalam menekan angka pengangguran terbuka dan mendongkrak indeks kualitas SDM di Kabupaten Sleman.',
      ],
    ],
    [
      'id' => 7,
      'ikon' => '📱',
      'warna' => '#0284c7',
      'judul' => 'Workshop Digital Marketing & Branding Lembaga Pelatihan untuk Pengelola LPK',
      'kategori' => 'Manajemen LPK',
      'tanggal' => '17 Oktober 2026',
      'penulis' => 'Bidang Humas & Media',
      'foto' => asset('images/idtc/foto3.jpg'),
      'ringkasan' => 'Program pembekalan strategi pemasaran digital, optimasi media sosial, dan branding institusi guna memperluas jangkauan pendaftaran calon peserta didik vokasi.',
      'isi' => [
        'SLEMAN — Di era serba digital, kemampuan branding institusi pelatihan menjadi aspek krusial dalam menarik minat calon peserta pelatihan. DPC HILLSI Sleman mengadakan workshop digital marketing yang diikuti para admin dan staf promosi LPK se-Sleman.',
        'Pelatihan ini membahas optimasi profil bisnis daring, pembuatan konten video edukatif di media sosial, strategi periklanan terarah, serta pemanfaatan analitik web untuk mengevaluasi efektivitas kampanye promosi kursus.',
        'Melalui pelatihan ini, setiap LPK diharapkan dapat meningkatkan visibilitas profil lembaganya dan mempermudah generasi muda menemukan pelatihan yang sesuai dengan minat dan bakat mereka.',
      ],
    ],
    [
      'id' => 8,
      'ikon' => '🏅',
      'warna' => '#059669',
      'judul' => 'Fasilitasi Akreditasi Lembaga Pelatihan Kerja Guna Tingkatkan Kredibilitas Mutu',
      'kategori' => 'Akreditasi Mutu',
      'tanggal' => '12 Oktober 2026',
      'penulis' => 'Divisi Penjaminan Mutu',
      'foto' => asset('images/idtc/foto8.jpg'),
      'ringkasan' => 'DPC HILLSI Sleman memberikan pendampingan intensif bagi pengelola LPK dalam penyusunan borang dan pemenuhan 8 standar akreditasi kelembagaan LA-LPK.',
      'isi' => [
        'SLEMAN — Status akreditasi merupakan tolok ukur kredibilitas dan jaminan kualitas layanan pelatihan suatu LPK. Guna mendorong percepatan akreditasi, DPC HILLSI menyelenggarakan klinik pendampingan borang akreditasi.',
        'Narasumber ahli membimbing peserta langkah demi langkah dalam memverifikasi 8 standar mutu akreditasi, meliputi kurikulum, sarana prasarana, kualifikasi instruktur, hingga tata kelola keuangan.',
        'Dengan bertambahnya LPK yang terakreditasi di Sleman, kepercayaan masyarakat dan industri terhadap mutu lulusan pelatihan kerja akan semakin meningkat secara signifikan.',
      ],
    ],
    [
      'id' => 9,
      'ikon' => '💡',
      'warna' => '#d97706',
      'judul' => 'Pemberdayaan Lulusan Vokasi Melalui Inkubasi Wirausaha Mandiri Kreatif',
      'kategori' => 'Kewirausahaan',
      'tanggal' => '5 Oktober 2026',
      'penulis' => 'Bidang Pengembangan Usaha',
      'foto' => asset('images/idtc/foto12.jpg'),
      'ringkasan' => 'Inisiatif pendampingan pasca-pelatihan bagi para alumni yang ingin merintis usaha mandiri dengan dukungan pembinaan mentor dan akses permodalan.',
      'isi' => [
        'SLEMAN — Tidak hanya berorientasi pada penempatan kerja formal di perusahaan, DPC HILLSI Sleman juga berkomitmen menumbuhkan wirausahawan baru melalui program inkubasi wirausaha mandiri.',
        'Program ini menyasar alumni dari kejuruan teknik, otomotif, tata boga, salon kecantikan, dan desain kreatif yang memiliki tekad membuka usaha jasa sendiri di lingkungan tempat tinggalnya.',
        'Selain mentoring bisnis dan manajemen permodalan sederhana, peserta juga diperkenalkan dengan skema bantuan pembiayaan perbankan dan penerbitan nomor induk berusaha resmi (NIB).',
      ],
    ],
    [
      'id' => 10,
      'ikon' => '🏭',
      'warna' => '#4f46e5',
      'judul' => 'Kunjungan Studi Lapangan Industri Manufaktur Modern di Kawasan Industri',
      'kategori' => 'Studi Lapangan',
      'tanggal' => '28 September 2026',
      'penulis' => 'Tim Pembina Vokasi',
      'foto' => asset('images/idtc/foto14.jpg'),
      'ringkasan' => 'Perwakilan instruktur dan siswa berprestasi berkesempatan mengamati langsung alur produksi presisi tinggi dan budaya kerja perusahaan manufaktur terkemuka.',
      'isi' => [
        'SLEMAN — Untuk memperkaya wawasan lapangan, rombongan instruktur dan siswa pilihan dari LPK anggota HILLSI Sleman melakukan company visit ke fasilitas pabrik manufaktur modern.',
        'Kunjungan ini memberikan gambaran riil mengenai standarisasi otomatisasi mesin industri, manajemen lini perakitan, serta implementasi ketat kedisiplinan kerja 5R di lantai pabrik.',
        'Pengalaman langsung ini sangat berharga untuk diselaraskan ke dalam materi praktikum di bengkel latih LPK agar suasana belajar semakin mendekati atmosfer kerja yang sesungguhnya.',
      ],
    ],
    [
      'id' => 11,
      'ikon' => '🌐',
      'warna' => '#0891b2',
      'judul' => 'Seminar Standardisasi Kurikulum Pelatihan Bahasa Asing dan Karir Global',
      'kategori' => 'Karir Luar Negeri',
      'tanggal' => '21 September 2026',
      'penulis' => 'Bidang Hubungan Luar Negeri',
      'foto' => asset('images/idtc/foto15.jpg'),
      'ringkasan' => 'Mengupas peluang penempatan tenaga kerja terampil di Jepang, Korea, dan Jerman melalui penguatan sertifikasi kompetensi bahasa dan etos kerja profesional.',
      'isi' => [
        'SLEMAN — Tingginya permintaan tenaga kerja berketerampilan khusus (specified skilled worker) di luar negeri menjadi peluang emas bagi generasi muda di Kabupaten Sleman.',
        'DPC HILLSI Sleman menghadirkan para konsultan penempatan tenaga kerja dan pakar bahasa dalam seminar karir internasional. Topik mencakup standar kelulusan JLPT/TOPIK, uji keterampilan kejuruan, hingga penyesuaian budaya kerja di negara tujuan.',
        'DPC HILLSI siap menjamin LPK bidang bahasa dan magang luar negeri di Sleman mematuhi seluruh regulasi ketenagakerjaan resmi dan memberikan perlindungan maksimal bagi calon tenaga kerja.',
      ],
    ],
    [
      'id' => 12,
      'ikon' => '🏆',
      'warna' => '#9333ea',
      'judul' => 'Temu Mitra Kerja Tahunan DPC HILLSI Sleman: Apresiasi Mitra Industri Terbaik',
      'kategori' => 'Mitra & Rekanan',
      'tanggal' => '15 September 2026',
      'penulis' => 'Sekretariat DPC HILLSI',
      'foto' => asset('images/idtc/foto16.jpg'),
      'ringkasan' => 'Malam penganugerahan penghargaan kepada puluhan perusahaan dan industri mitra atas kontribusi aktif dalam program magang dan penyerapan kerja alumni LPK.',
      'isi' => [
        'SLEMAN — Hubungan harmonis antara dunia pendidikan non-formal dan dunia usaha dipererat melalui agenda Temu Mitra Kerja Tahunan yang diselenggarakan oleh DPC HILLSI Sleman.',
        'Dalam acara ini, DPC memberikan plakat apresiasi kepada perusahaan-perusahaan yang dinilai paling konsisten membuka pintu magang berkualitas dan menyerap lulusan LPK Sleman dalam jumlah signifikan.',
        'Acara diakhiri dengan penandatanganan nota kesepahaman (MoU) baru untuk memperluas sektor kejuruan yang dikerjasamakan pada tahun mendatang.',
      ],
    ],
  ];
@endphp

<section id="kegiatan" class="alt">
  <div class="wrap">
    <div class="eye rv">Berita & Kegiatan</div>
    <h2 class="rv">Berita & Kegiatan DPC Sleman</h2>
    <p class="sub rv" style="max-width:none">Dokumentasi koordinasi kelembagaan, pelatihan vokasi, sertifikasi kompetensi, dan sinergi kemitraan DPC HILLSI Kabupaten Sleman.</p>

    <!-- Kontainer Daftar Artikel Berita (Grid Card Bersebelahan) -->
    <div id="kegiatanCardList" class="news-grid"></div>

    <!-- Navigasi Halaman Artikel: Previous | 1 | 2 | 3 | 4 | 5 | 6 | Next -->
    <div id="kegiatanPagination" class="news-pagination"></div>
    <div id="kegiatanCountText" class="rv" style="text-align:center;margin-top:16px;font-size:13.5px;color:var(--muted);font-weight:600;"></div>
  </div>
</section>

<!-- Modal Pop-up Baca Artikel Lengkap -->
<div id="artModal" class="art-modal" onclick="closeArtModal(event)">
  <div class="art-modal-box">
    <button type="button" class="art-modal-close" onclick="closeArtModal()" aria-label="Tutup">&times;</button>
    <div class="art-modal-header">
      <img id="artModalImg" src="" alt="Foto Kegiatan">
    </div>
    <div class="art-modal-content">
      <div class="art-meta">
        <span id="artModalTag" class="art-tag"></span>
        <span id="artModalDate" class="art-date"></span>
      </div>
      <h2 id="artModalTitle"></h2>
      <div class="art-modal-author">
        <span>✍️ Ditulis oleh: <b id="artModalAuthor"></b></span>
        <span>•</span>
        <span>📍 DPC HILLSI Kabupaten Sleman</span>
      </div>
      <div id="artModalBody" class="art-modal-body"></div>
    </div>
    <div class="art-modal-footer">
      <button type="button" class="btn s" onclick="closeArtModal()">Tutup Artikel</button>
    </div>
  </div>
</div>

<section id="kontak">
  <div class="wrap">
    <div class="eye rv">Kontak</div>
    <h2 class="rv">Hubungi Kami</h2>
    <p class="sub rv">Sekretariat DPC HILLSI Kabupaten Sleman</p>
    <div class="contact">
      @php
        $rawAlamat = $settings['alamat'] ?? '69R7+5HQ, Jl. Popongan, Kutu Dukuh, Sinduadi, Kec. Mlati, Kabupaten Sleman, Daerah Istimewa Yogyakarta 55284';
        $linkMaps = trim($settings['link_maps'] ?? '');

        // Cek jika link Google Maps dimasukkan langsung ke dalam teks alamat
        if (empty($linkMaps) && preg_match('#https?://[^\s]+#i', $rawAlamat, $urlMatches)) {
            $linkMaps = $urlMatches[0];
            $displayAlamat = trim(str_replace($urlMatches[0], '', $rawAlamat));
        } else {
            $displayAlamat = $rawAlamat;
        }

        // Tentukan URL tujuan Google Maps & Query untuk Peta Embed
        if (!empty($linkMaps)) {
            $mapsUrl = $linkMaps;
            $embedQuery = !empty($displayAlamat) ? $displayAlamat : 'Sleman Yogyakarta';
        } else {
            $embedQuery = $displayAlamat ?: 'Sleman Yogyakarta';
            $mapsUrl = 'https://www.google.com/maps/search/?api=1&query=' . urlencode($embedQuery);
        }
      @endphp

      <div class="card rv">
        <div class="row">
          <span>📍</span>
          <a href="{{ $mapsUrl }}" target="_blank" rel="noopener" style="color:var(--text);text-decoration:none;" title="Klik untuk membuka lokasi di Google Maps" onmouseover="this.style.color='var(--brand)'" onmouseout="this.style.color='var(--text)'">
            {{ $displayAlamat ?: 'Kabupaten Sleman, D.I. Yogyakarta' }}
          </a>
        </div>
        <div class="row">
          <span>
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91C2.13 13.66 2.59 15.36 3.45 16.86L2.05 22L7.3 20.62C8.75 21.41 10.38 21.83 12.04 21.83C17.5 21.83 21.95 17.38 21.95 11.92C21.95 9.27 20.92 6.78 19.05 4.91C17.18 3.03 14.69 2 12.04 2Z" fill="#25D366"/>
              <path d="M17.52 14.33C17.22 14.18 15.75 13.45 15.47 13.35C15.2 13.25 15 13.2 14.81 13.5C14.61 13.79 14.04 14.47 13.87 14.67C13.7 14.86 13.52 14.89 13.22 14.74C12.93 14.59 11.98 14.28 10.86 13.28C9.98 12.5 9.39 11.53 9.22 11.23C9.05 10.94 9.2 10.78 9.35 10.63C9.48 10.5 9.65 10.28 9.79 10.11C9.94 9.94 9.99 9.82 10.09 9.62C10.19 9.42 10.14 9.25 10.06 9.1C9.99 8.95 9.42 7.55 9.19 6.98C8.96 6.43 8.72 6.5 8.54 6.49C8.38 6.49 8.19 6.48 8 6.48C7.8 6.48 7.49 6.55 7.22 6.85C6.95 7.14 6.19 7.85 6.19 9.3C6.19 10.75 7.25 12.15 7.39 12.35C7.54 12.55 9.47 15.52 12.44 16.8C13.14 17.11 13.7 17.29 14.12 17.43C14.83 17.65 15.48 17.62 15.99 17.54C16.56 17.46 17.75 16.82 18 16.12C18.25 15.42 18.25 14.82 18.17 14.7C18.1 14.57 17.92 14.49 17.62 14.33H17.52Z" fill="white"/>
            </svg>
          </span>
          @php
            $cleanTel = preg_replace('/[^0-9]/', '', $settings['telepon'] ?? '');
            if (str_starts_with($cleanTel, '0')) {
                $waNum = '62' . substr($cleanTel, 1);
            } else {
                $waNum = $cleanTel;
            }
          @endphp
          @if($cleanTel)
            <a href="https://wa.me/{{ $waNum }}" target="_blank" rel="noopener">{{ $settings['telepon'] ?? '(0274) 000 000' }}</a>
          @else
            <span>{{ $settings['telepon'] ?? '(0274) 000 000' }}</span>
          @endif
        </div>
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
          <a href="mailto:{{ $settings['email'] ?? 'dpc.hillsi.sleman@example.com' }}">{{ $settings['email'] ?? 'dpc.hillsi.sleman@example.com' }}</a>
        </div>
        <div class="row">
          <span>
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <defs>
                <radialGradient id="ig-grad-home" cx="0.2" cy="1" r="1">
                  <stop offset="0%" stop-color="#FFDD55"/>
                  <stop offset="20%" stop-color="#FF543E"/>
                  <stop offset="50%" stop-color="#C837AB"/>
                  <stop offset="100%" stop-color="#4158D0"/>
                </radialGradient>
              </defs>
              <rect x="2" y="2" width="20" height="20" rx="5.5" fill="url(#ig-grad-home)"/>
              <circle cx="12" cy="12" r="4.2" stroke="white" stroke-width="1.8"/>
              <circle cx="17.2" cy="6.8" r="1.1" fill="white"/>
            </svg>
          </span>
          <a href="{{ $settings['instagram'] ?? 'https://www.instagram.com/dpc.hillsi.sleman/' }}" target="_blank" rel="noopener">@dpc.hillsi.sleman</a>
        </div>
        <p class="note">Sekretariat resmi DPC HILLSI Kabupaten Sleman.</p>
      </div>

      <div class="mapbox rv" style="padding:0;overflow:hidden;position:relative;min-height:280px;border-radius:18px;border:1px solid var(--line);background:#132226;">
        <iframe 
          title="Peta Lokasi Sekretariat DPC HILLSI Sleman"
          src="https://maps.google.com/maps?q={{ urlencode($embedQuery) }}&t=&z=16&ie=UTF8&iwloc=&output=embed" 
          width="100%" 
          height="100%" 
          style="border:0;width:100%;height:100%;min-height:280px;display:block;" 
          allowfullscreen="" 
          loading="lazy" 
          referrerpolicy="no-referrer-when-downgrade">
        </iframe>
        <div style="position:absolute;bottom:14px;right:14px;z-index:2;">
          <a class="btn p" target="_blank" rel="noopener" href="{{ $mapsUrl }}" style="box-shadow:0 4px 14px rgba(0,0,0,0.5);font-size:12.5px;padding:9px 16px;background:var(--brand);color:#fff;border-radius:10px;font-weight:700;display:inline-flex;align-items:center;gap:6px;backdrop-filter:blur(4px);">
            <span>🗺️</span>
            <span>Buka di Google Maps ↗</span>
          </a>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

@push('scripts')
<script>
var L = {!! json_encode($lpksJson) !!};
var ARTICLES = @json($kegiatanArticles);
var ART_PAGE = 1;
var ART_PER_PAGE = 2;

function renderArticles() {
  var total = ARTICLES.length;
  var totalPages = Math.ceil(total / ART_PER_PAGE) || 1;
  if (ART_PAGE > totalPages) ART_PAGE = totalPages;
  if (ART_PAGE < 1) ART_PAGE = 1;

  var start = (ART_PAGE - 1) * ART_PER_PAGE;
  var items = ARTICLES.slice(start, start + ART_PER_PAGE);

  var h = "";
  items.forEach(function(a) {
    h += '<article class="news-card rv in">' +
           '<div class="news-thumb" onclick="openArticle(' + a.id + ')" title="Klik untuk membaca selengkapnya">' +
             '<img src="' + a.foto + '" alt="' + esc(a.judul) + '" loading="lazy">' +
             '<span class="news-badge">' + esc(a.kategori) + '</span>' +
           '</div>' +
           '<div class="news-content">' +
             '<div class="news-meta">' +
               '<span class="news-date">📅 ' + esc(a.tanggal) + '</span>' +
               '<span class="news-author">✍️ ' + esc(a.penulis) + '</span>' +
             '</div>' +
             '<h3 class="news-title" onclick="openArticle(' + a.id + ')" title="' + esc(a.judul) + '">' + esc(a.judul) + '</h3>' +
             '<p class="news-desc">' + esc(a.ringkasan) + '</p>' +
             '<div class="news-footer">' +
               '<button type="button" class="news-btn-read" onclick="openArticle(' + a.id + ')" title="Buka artikel ' + esc(a.judul) + '">' +
                 '<span>Baca Selengkapnya</span>' +
                 '<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' +
               '</button>' +
             '</div>' +
           '</div>' +
         '</article>';
  });

  if ($("kegiatanCardList")) {
    $("kegiatanCardList").innerHTML = h;
  }

  // Format Pagination: Previous | 1 | 2 | 3 | 4 | 5 | 6 | Next
  var pagiHtml = "";
  if (totalPages > 1) {
    pagiHtml += '<button type="button" class="news-pagi-btn" onclick="kegiatanGoPage(' + (ART_PAGE - 1) + ')" ' + (ART_PAGE === 1 ? 'disabled' : '') + ' aria-label="Previous">Previous</button>';
    for (var p = 1; p <= totalPages; p++) {
      pagiHtml += '<button type="button" class="news-pagi-btn ' + (p === ART_PAGE ? 'active' : '') + '" onclick="kegiatanGoPage(' + p + ')" aria-label="Halaman ' + p + '">' + p + '</button>';
    }
    pagiHtml += '<button type="button" class="news-pagi-btn" onclick="kegiatanGoPage(' + (ART_PAGE + 1) + ')" ' + (ART_PAGE === totalPages ? 'disabled' : '') + ' aria-label="Next">Next</button>';
  }

  if ($("kegiatanPagination")) {
    $("kegiatanPagination").innerHTML = pagiHtml;
  }

  if ($("kegiatanCountText")) {
    var from = total > 0 ? (start + 1) : 0;
    var to = Math.min(start + ART_PER_PAGE, total);
    $("kegiatanCountText").innerHTML = 'Menampilkan artikel ' + from + ' - ' + to + ' dari ' + total + ' artikel · Halaman ' + ART_PAGE + ' dari ' + totalPages;
  }
}

function kegiatanGoPage(p) {
  var totalPages = Math.ceil(ARTICLES.length / ART_PER_PAGE);
  if (p < 1 || p > totalPages) return;
  ART_PAGE = p;
  renderArticles();
  var sec = $("kegiatan");
  if (sec) sec.scrollIntoView({ behavior: 'smooth' });
}

function openArticle(id) {
  var art = ARTICLES.find(function(item) { return item.id === id; });
  if (!art) return;
  if ($("artModalImg")) {
    $("artModalImg").src = art.foto;
    $("artModalImg").alt = art.judul;
  }
  if ($("artModalTag")) $("artModalTag").textContent = art.kategori;
  if ($("artModalDate")) $("artModalDate").textContent = '📅 ' + art.tanggal;
  if ($("artModalTitle")) $("artModalTitle").textContent = art.judul;
  if ($("artModalAuthor")) $("artModalAuthor").textContent = art.penulis;

  if ($("artModalBody")) {
    var bodyHtml = "";
    art.isi.forEach(function(paragraph) {
      bodyHtml += '<p>' + esc(paragraph) + '</p>';
    });
    $("artModalBody").innerHTML = bodyHtml;
  }

  var m = $("artModal");
  if (m) m.classList.add("on");
}

function closeArtModal(e) {
  if (e && e.target && e.target.closest(".art-modal-box") && !e.target.classList.contains("art-modal-close") && e.target.innerText !== "Tutup Artikel") {
    return;
  }
  var m = $("artModal");
  if (m) m.classList.remove("on");
}

document.addEventListener("keydown", function(e) {
  if (e.key === "Escape") {
    var m = $("artModal");
    if (m && m.classList.contains("on")) closeArtModal();
  }
});

var Q = "", CAT = "Semua";
var PAGE = 1;
var PER_PAGE = 8;
var $ = function(i) { return document.getElementById(i); };

function esc(s) {
  return String(s).replace(/[&<>"]/g, function(c) {
    return {"&":"&amp;","<":"&lt;",">":"&gt;",'"':"&quot;"}[c];
  });
}

function match(x, q) {
  q = q.trim().toLowerCase();
  return !q || q.split(/\s+/).every(function(w) { return x.k.indexOf(w) > -1; });
}

function draw() {
  var filtered = L.filter(function(x) {
    return (CAT === "Semua" || x.f === CAT) && match(x, Q);
  });

  var total = filtered.length;
  var totalPages = Math.ceil(total / PER_PAGE) || 1;
  if (PAGE > totalPages) PAGE = totalPages;
  if (PAGE < 1) PAGE = 1;

  var start = (PAGE - 1) * PER_PAGE;
  var pageItems = filtered.slice(start, start + PER_PAGE);

  var h = "";
  pageItems.forEach(function(x) {
    var media = x.logo ? 
      '<img src="' + x.logo + '" alt="' + esc(x.n) + '" style="max-height:76px;max-width:80%;object-fit:contain;position:relative;z-index:1;filter:drop-shadow(0 2px 6px rgba(0,0,0,.45))">' : 
      x.e;

    var svcSnippet = (x.s && x.s.length) ? 
      '<p style="font-size:12px;color:var(--muted);margin:6px 0 0;line-height:1.35;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden">🛠️ ' + esc(x.s.slice(0, 3).join(', ')) + (x.s.length > 3 ? ', dsb' : '') + '</p>' : '';

    h += '<a class="lc" href="' + x.url + '">' +
         '<div class="cv" style="background:linear-gradient(135deg,' + x.c + ',#000a)">' + media + '</div>' +
         '<div class="b"><h4>' + esc(x.n) + '</h4><span class="pill">' + esc(x.f) + '</span>' + svcSnippet + '</div>' +
         '</a>';
  });

  $("list").innerHTML = h || '<div class="empty">😕 Tidak ada lembaga atau layanan jasa yang cocok. Coba gunakan kata kunci pencarian lain.</div>';
  
  // Render Navigasi Pagination
  var pagiHtml = "";
  if (totalPages > 1) {
    pagiHtml += '<button class="pagi-btn" onclick="goToPage(' + (PAGE - 1) + ')" ' + (PAGE === 1 ? 'disabled' : '') + ' aria-label="Halaman Sebelumnya">&laquo; Sebelumnya</button>';
    for (var p = 1; p <= totalPages; p++) {
      pagiHtml += '<button class="pagi-btn ' + (p === PAGE ? 'active' : '') + '" onclick="goToPage(' + p + ')">' + p + '</button>';
    }
    pagiHtml += '<button class="pagi-btn" onclick="goToPage(' + (PAGE + 1) + ')" ' + (PAGE === totalPages ? 'disabled' : '') + ' aria-label="Halaman Berikutnya">Berikutnya &raquo;</button>';
  }
  if ($("pagination")) {
    $("pagination").innerHTML = pagiHtml;
  }

  // Info Jumlah & Halaman
  if ($("dirCountText")) {
    var rangeText = total > 0 ? (start + 1) + '-' + Math.min(start + PER_PAGE, total) + ' dari ' + total + ' lembaga' : '0 lembaga';
    $("dirCountText").innerHTML = rangeText + (totalPages > 1 ? ' · Halaman ' + PAGE + ' dari ' + totalPages : '') + (Q.trim() ? ' · Hasil pencarian untuk “<b>' + esc(Q.trim()) + '</b>”' : '');
  }

  if ($("dirResetBtn")) {
    $("dirResetBtn").style.display = Q.trim() ? "inline-flex" : "none";
  }
  if ($("dirQuery") && $("dirQuery").value !== Q) {
    $("dirQuery").value = Q;
  }
}

function goToPage(p) {
  PAGE = p;
  draw();
  var el = $("lembaga");
  if (el) el.scrollIntoView({ behavior: 'smooth' });
}

function onDirSearch(v) {
  Q = v;
  PAGE = 1;
  if ($("hq")) $("hq").value = v;
  draw();
}

function setCat(c) {
  CAT = c;
  PAGE = 1;
  draw();
}

function resetQ() {
  Q = "";
  CAT = "Semua";
  PAGE = 1;
  if ($("hq")) $("hq").value = "";
  if ($("dirQuery")) $("dirQuery").value = "";
  draw();
}

function suggest() {
  var v = $("hq").value, box = $("sg");
  if (!v.trim()) { box.classList.remove("on"); return; }
  var r = L.filter(function(x) { return match(x, v); }).slice(0, 5);
  box.innerHTML = r.length ? r.map(function(x) {
    return '<div onclick="location.href=\'' + x.url + '\'">' +
           '<span class="e">' + (x.logo ? '📌' : x.e) + '</span>' +
           '<span><b>' + esc(x.n) + '</b><small>' + esc(x.f) + '</small></span>' +
           '</div>';
  }).join("") : '<div class="none">Tidak ditemukan</div>';
  box.classList.add("on");
}

function doSearch() {
  Q = $("hq").value;
  CAT = "Semua";
  PAGE = 1;
  if ($("dirQuery")) $("dirQuery").value = Q;
  $("sg").classList.remove("on");
  draw();
  $("lembaga").scrollIntoView({ behavior: 'smooth' });
}

function quick(w) {
  $("hq").value = w;
  if ($("dirQuery")) $("dirQuery").value = w;
  doSearch();
}

document.addEventListener("click", function(e) {
  var s = $("sg");
  if (s && !e.target.closest(".sbox")) s.classList.remove("on");
});

document.addEventListener("DOMContentLoaded", function() {
  draw();
  renderArticles();
});
</script>
@endpush
