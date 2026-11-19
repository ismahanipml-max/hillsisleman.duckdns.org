<?php

namespace Database\Seeders;

use App\Models\Lpk;
use App\Models\LpkService;
use App\Models\LpkFeature;
use Illuminate\Database\Seeder;

class DummyLpkSeeder extends Seeder
{
    public function run(): void
    {
        $dummies = [
            [
                'slug' => 'lpk-13',
                'nama' => 'LPK Contoh Robotika & Otomasi',
                'bidang' => 'Robotika',
                'ikon' => '🤖',
                'warna' => '#0284c7',
                'cover' => 'images/covers/cover-robotika.jpg',
                'tagline' => 'Pusat Pelatihan Robotika dan Otomasi Industri Berstandar Kompetensi',
                'tentang' => 'Lembaga Pelatihan Kerja yang berfokus pada pengembangan keahlian pemrograman robot, otomasi industri, dan Internet of Things (IoT) untuk mencetak teknisi masa depan siap kerja.',
                'alamat' => 'Jl. Kaliurang Km 9.5, Minomartani, Ngaglik, Kabupaten Sleman, D.I. Yogyakarta',
                'services' => [
                    'Pelatihan Perakitan & Pemrograman Robot',
                    'Otomasi Industri PLC & SCADA',
                    'Internet of Things (IoT) & Mikrokontroler',
                    'Sertifikasi Kompetensi Teknisi Robotika',
                ],
            ],
            [
                'slug' => 'lpk-14',
                'nama' => 'LPK Contoh Digital Marketing',
                'bidang' => 'Bisnis Digital',
                'ikon' => '📱',
                'warna' => '#e11d48',
                'cover' => 'images/covers/cover-kioss.jpg',
                'tagline' => 'Kuasai Strategi Pemasaran Digital dan Pertumbuhan Bisnis Modern',
                'tentang' => 'Lembaga pelatihan digital marketing terpadu yang membekali peserta dengan keterampilan praktis Meta Ads, Google Ads, SEO, Content Creation, dan optimasi Marketplace.',
                'alamat' => 'Jl. Palagan Tentara Pelajar Km 7, Sariharjo, Ngaglik, Kabupaten Sleman, D.I. Yogyakarta',
                'services' => [
                    'Pelatihan Iklan Berbayar (Meta & Google Ads)',
                    'Search Engine Optimization (SEO) & Copywriting',
                    'Manajemen Media Sosial & Pembuatan Konten',
                    'Strategi Jualan & Live Streaming Marketplace',
                ],
            ],
            [
                'slug' => 'lpk-15',
                'nama' => 'LPK Contoh Bahasa Korea',
                'bidang' => 'Bahasa Asing',
                'ikon' => '🇰🇷',
                'warna' => '#2563eb',
                'cover' => 'images/covers/cover-bahasa-jepang.jpg',
                'tagline' => 'Persiapan Bahasa Korea Terakreditasi untuk Studi dan Kerja (G to G)',
                'tentang' => 'Lembaga pelatihan Bahasa Korea profesional yang mengkhususkan diri pada pembekalan EPS-TOPIK dan persiapan penempatan tenaga kerja ke Korea Selatan.',
                'alamat' => 'Jl. Magelang Km 6.5, Sinduadi, Mlati, Kabupaten Sleman, D.I. Yogyakarta',
                'services' => [
                    'Pelatihan Intensif Bahasa Korea Dasar (Hangul)',
                    'Bimbingan & Tryout Ujian EPS-TOPIK',
                    'Pelatihan Percakapan Bisnis & Etos Kerja Korea',
                    'Pendampingan Program Penempatan Kerja G to G',
                ],
            ],
            [
                'slug' => 'lpk-16',
                'nama' => 'LPK Contoh Bahasa Inggris Komunikasi',
                'bidang' => 'Bahasa Asing',
                'ikon' => '🗣️',
                'warna' => '#0d9488',
                'cover' => 'images/covers/cover-bahasa-jepang.jpg',
                'tagline' => 'Tingkatkan Kepercayaan Diri Berkomunikasi Bahasa Inggris Global',
                'tentang' => 'Lembaga pelatihan Bahasa Inggris praktis untuk kebutuhan komunikasi internasional, perhotelan, kapal pesiar, dan dunia kerja profesional.',
                'alamat' => 'Jl. Gejayan, Condongcatur, Depok, Kabupaten Sleman, D.I. Yogyakarta',
                'services' => [
                    'General & Conversational English',
                    'English for Hospitality & Cruise Ship',
                    'Persiapan Tes TOEFL / IELTS / TOEIC',
                    'Public Speaking & Presentation Skills',
                ],
            ],
            [
                'slug' => 'lpk-17',
                'nama' => 'LPK Contoh Desain Grafis & Multimedia',
                'bidang' => 'Desain Kreatif',
                'ikon' => '🎨',
                'warna' => '#7c3aed',
                'cover' => 'images/covers/cover-komputer.jpg',
                'tagline' => 'Kreativitas Tanpa Batas dengan Penguasaan Software Desain Industri',
                'tentang' => 'Membina talenta desainer grafis dengan penguasaan software Adobe Illustrator, Photoshop, Figma, serta pembuatan identitas visual dan branding profesional.',
                'alamat' => 'Jl. Affandi No. 18, Caturtunggal, Depok, Kabupaten Sleman, D.I. Yogyakarta',
                'services' => [
                    'Dasar Desain Grafis & Teori Warna',
                    'Desain Vektor & Ilustrasi Digital',
                    'UI/UX Design & Prototyping Aplikasi',
                    'Portofolio Kreatif & Sertifikasi Desain',
                ],
            ],
            [
                'slug' => 'lpk-18',
                'nama' => 'LPK Contoh Teknik Pendingin & AC',
                'bidang' => 'Kelistrikan & Pendingin',
                'ikon' => '❄️',
                'warna' => '#0891b2',
                'cover' => 'images/covers/cover-konstruksi.jpg',
                'tagline' => 'Keahlian Instalasi, Perawatan, dan Perbaikan Mesin Pendingin',
                'tentang' => 'Pusat pelatihan teknisi pendingin udara (AC residensial dan industri) serta sistem refrigerasi komersial dengan simulasi bengkel kerja berstandar.',
                'alamat' => 'Jl. Tajem Km 2, Maguwoharjo, Depok, Kabupaten Sleman, D.I. Yogyakarta',
                'services' => [
                    'Instalasi & Pemasangan AC Split / Inverter',
                    'Perawatan Berkala & Pembersihan (Cuci AC)',
                    'Troubleshooting Kelistrikan Mesin Pendingin',
                    'Sistem Refrigerasi Industri & Cold Storage',
                ],
            ],
            [
                'slug' => 'lpk-19',
                'nama' => 'LPK Contoh Pemasaran & Ritel Modern',
                'bidang' => 'Perdagangan & Ritel',
                'ikon' => '🛒',
                'warna' => '#ea580c',
                'cover' => 'images/covers/cover-administrasi.jpg',
                'tagline' => 'Mencetak Tenaga Profesional Manajemen Ritel dan Layanan Pelanggan',
                'tentang' => 'Lembaga vokasi yang menyiapkan tenaga terampil di bidang ritel modern, penataan produk (visual merchandising), operasional kasir, dan layanan pelanggan.',
                'alamat' => 'Jl. Ring Road Utara, Condongcatur, Depok, Kabupaten Sleman, D.I. Yogyakarta',
                'services' => [
                    'Manajemen Operasional Toko Ritel',
                    'Visual Merchandising & Penataan Display',
                    'Pengoperasian Sistem POS Kasir & Inventori',
                    'Service Excellence & Komunikasi Pelanggan',
                ],
            ],
            [
                'slug' => 'lpk-20',
                'nama' => 'LPK Contoh Bartender & Tata Hidang',
                'bidang' => 'Tata Hidang (F&B)',
                'ikon' => '🍹',
                'warna' => '#db2777',
                'cover' => 'images/covers/cover-barista.jpg',
                'tagline' => 'Seni Meracik Minuman dan Layanan Restoran Berstandar Internasional',
                'tentang' => 'Pelatihan keterampilan Food and Beverage Service, seni mixology mocktail/cocktail, flair bartending, serta standar etika pelayanan restoran bintang lima.',
                'alamat' => 'Jl. Seturan Raya No. 45, Caturtunggal, Depok, Kabupaten Sleman, D.I. Yogyakarta',
                'services' => [
                    'Mixology & Pembuatan Mocktail Kreatif',
                    'Dasar & Teknik Pelayanan Food and Beverage',
                    'Table Setting & Tata Cara Jamuan Resmi',
                    'Flair Bartending & Keterampilan Bar',
                ],
            ],
            [
                'slug' => 'lpk-21',
                'nama' => 'LPK Contoh Akuntansi & Keuangan',
                'bidang' => 'Keuangan & Akuntansi',
                'ikon' => '💼',
                'warna' => '#475569',
                'cover' => 'images/covers/cover-administrasi.jpg',
                'tagline' => 'Keahlian Pembukuan Keuangan dan Aplikasi Akuntansi Komputer',
                'tentang' => 'Pelatihan praktis pembukuan usaha, perpajakan dasar, serta pengoperasian software akuntansi komputer (Accurate, Zahir, MYOB, Excel Accounting).',
                'alamat' => 'Jl. Godean Km 4, Banyuraden, Gamping, Kabupaten Sleman, D.I. Yogyakarta',
                'services' => [
                    'Pembukuan Siklus Akuntansi Perusahaan',
                    'Komputerisasi Akuntansi (Accurate & Zahir)',
                    'Pelaporan Pajak Praktis (PPh & PPN)',
                    'Analisis Laporan Keuangan UMKM',
                ],
            ],
            [
                'slug' => 'lpk-22',
                'nama' => 'LPK Contoh Spa & Terapi Relaksasi',
                'bidang' => 'Perawatan Tubuh',
                'ikon' => '💆',
                'warna' => '#9333ea',
                'cover' => 'images/covers/cover-kecantikan.jpg',
                'tagline' => 'Tradisi Wellness Nusantara dan Terapi Relaksasi Profesional',
                'tentang' => 'Membekali peserta dengan keterampilan pijat tradisional, reflexology, body scrub/spa aromaterapi, dan standar kebersihan higienis untuk spa dan wellness.',
                'alamat' => 'Jl. Kaliurang Km 5, Caturtunggal, Depok, Kabupaten Sleman, D.I. Yogyakarta',
                'services' => [
                    'Teknik Pijat Tradisional & Refleksi',
                    'Body Scrub, Masker Tubuh & Lulur',
                    'Perawatan Aromaterapi & Relaksasi',
                    'Standar Sanitasi & Manajemen Spa',
                ],
            ],
            [
                'slug' => 'lpk-23',
                'nama' => 'LPK Contoh Fotografi & Videografi',
                'bidang' => 'Media Kreatif',
                'ikon' => '📷',
                'warna' => '#16a34a',
                'cover' => 'images/covers/cover-komputer.jpg',
                'tagline' => 'Visual Storytelling Melalui Lensa Fotografi dan Produksi Video',
                'tentang' => 'Pusat pelatihan produksi visual mencakup pencahayaan studio, fotografi produk/wedding, videografi komersial, dan teknik editing video sinematik.',
                'alamat' => 'Jl. Monjali No. 78, Sariharjo, Ngaglik, Kabupaten Sleman, D.I. Yogyakarta',
                'services' => [
                    'Dasar Fotografi & Pengaturan Kamera Manual',
                    'Fotografi Produk Komersial & Model',
                    'Teknik Pengambilan Gambar Video (Sinematografi)',
                    'Video Editing & Color Grading (Premiere / DaVinci)',
                ],
            ],
            [
                'slug' => 'lpk-24',
                'nama' => 'LPK Contoh Menjahit & Pola Busana',
                'bidang' => 'Tata Busana',
                'ikon' => '👗',
                'warna' => '#c026d3',
                'cover' => 'images/covers/cover-tata-busana.jpg',
                'tagline' => 'Keahlian Membuat Pola Presisi dan Menjahit Busana Berkualitas',
                'tentang' => 'Pelatihan intensif pembuatan pola busana pria dan wanita, teknik jahit mesin industri, penyelesaian busana (finishing), hingga kreasi adibusana.',
                'alamat' => 'Jl. Kebon Agung, Sendangadi, Mlati, Kabupaten Sleman, D.I. Yogyakarta',
                'services' => [
                    'Pembuatan Pola Dasar & Pecah Pola Busana',
                    'Pengoperasian Mesin Jahit & Obras Industri',
                    'Menjahit Busana Kasual & Pesta',
                    'Teknik Finishing & Bordir Hiasan Busana',
                ],
            ],
        ];

        foreach ($dummies as $idx => $d) {
            $num = $idx + 13;
            $lpk = Lpk::updateOrCreate(
                ['slug' => $d['slug']],
                [
                    'nama' => $d['nama'],
                    'bidang' => $d['bidang'],
                    'ikon' => $d['ikon'],
                    'warna' => $d['warna'],
                    'cover' => $d['cover'],
                    'tagline' => $d['tagline'],
                    'tentang' => $d['tentang'],
                    'nama_admin' => 'Admin ' . $d['nama'],
                    'whatsapp' => '0812 0000 ' . str_pad($num, 4, '0', STR_PAD_LEFT),
                    'alamat' => $d['alamat'],
                    'email' => 'info@' . $d['slug'] . '.example',
                    'instagram' => '@' . str_replace('-', '_', $d['slug']),
                    'website' => null,
                    'link_maps' => null,
                    'urutan' => $num,
                    'aktif' => true,
                ]
            );

            // Layanan
            $lpk->services()->delete();
            foreach ($d['services'] as $sIdx => $sName) {
                LpkService::create([
                    'lpk_id' => $lpk->id,
                    'nama_layanan' => $sName,
                    'urutan' => $sIdx + 1,
                ]);
            }

            // Fitur / Keunggulan
            $lpk->features()->delete();
            $features = [
                [
                    't' => 'Instruktur Berpengalaman',
                    'd' => 'Dibimbing langsung oleh praktisi kompeten dan instruktur berlisensi di bidangnya.',
                    'i' => '👨‍🏫',
                ],
                [
                    't' => 'Fasilitas & Workshop Standar',
                    'd' => 'Didukung sarana praktik lengkap dan peralatan kerja modern sesuai kebutuhan industri.',
                    'i' => '🏢',
                ],
                [
                    't' => 'Sertifikat & Penyaluran Kerja',
                    'd' => 'Memiliki kurikulum berbasis kompetensi dan jaringan kemitraan untuk peluang kerja alumni.',
                    'i' => '📜',
                ],
            ];
            foreach ($features as $fIdx => $f) {
                LpkFeature::create([
                    'lpk_id' => $lpk->id,
                    'judul' => $f['t'],
                    'deskripsi' => $f['d'],
                    'ikon' => $f['i'],
                    'urutan' => $fIdx + 1,
                ]);
            }
        }
    }
}
