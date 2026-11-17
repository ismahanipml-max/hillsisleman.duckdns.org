<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Setting;
use App\Models\Lpk;
use App\Models\LpkService;
use App\Models\LpkGallery;
use App\Models\LpkPartner;
use App\Models\LpkFeature;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Initial Admin User
        $admin = User::updateOrCreate(
            ['email' => 'admin@hillsi.test'],
            [
                'name' => 'Administrator HILLSI',
                'password' => Hash::make('adminJCP'),
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('');
        $this->command->warn('=============================================');
        $this->command->info(' Akun Admin Berhasil Dikonfigurasi:');
        $this->command->warn(' Password Masuk : adminJCP (Tanpa Email)');
        $this->command->warn('=============================================');
        $this->command->info('');

        // 2. Settings
        $settings = [
            'alamat' => '[Alamat sekretariat DPC HILLSI Sleman — isi alamat lengkap]',
            'link_maps' => '',
            'telepon' => '(0274) 000 000',
            'email' => 'dpc.hillsi.sleman@example.com',
            'instagram' => 'https://www.instagram.com/dpc.hillsi.sleman/',
            'hero_judul' => 'Wadah Bersama Lembaga Pelatihan Kerja di Kabupaten Sleman',
            'hero_deskripsi' => 'Mengoordinasikan LPK untuk meningkatkan mutu kompetensi SDM, bersinergi dengan pemerintah dan industri, serta menekan angka pengangguran.',
            'tahun_berdiri' => '1982',
        ];
        foreach ($settings as $k => $v) {
            Setting::set($k, $v);
        }

        // 3. IDTC Data
        $idtc = Lpk::updateOrCreate(
            ['slug' => 'drone-indonesia'],
            [
                'nama' => 'Indonesia Drone Training Center (IDTC, PT Jogja Creative Production)',
                'bidang' => 'Teknologi Drone',
                'ikon' => '🚁',
                'warna' => '#0b5d63',
                'cover' => 'images/idtc/cover-drone.jpg',
                'logo' => 'images/idtc/logo.png',
                'tentang' => 'Lembaga pelatihan drone profesional yang fokus pada keterampilan terbang, pengoperasian kamera, dan keselamatan penerbangan langsung di lapangan. Founder: Franko Nero. Moto: "Berilmu untuk Berbagi."',
                'nama_admin' => 'Admin IDTC',
                'whatsapp' => '+62 856-0060-4388',
                'alamat' => 'Perum Jl. Griya Mlati Indah No. B4, Mulungan Kulon, Sendangadi, Mlati, Sleman, DIY 55285',
                'email' => 'jogjacreativeproduction@gmail.com',
                'instagram' => '@idtc.drone',
                'website' => 'https://pelatihandronejogja.my.id',
                'link_maps' => 'https://www.google.com/maps/search/?api=1&query=Indonesia+Drone+Training+Center+Mlati+Sleman',
                'urutan' => 1,
                'aktif' => true,
            ]
        );

        $idtcServices = [
            'Pelatihan drone dasar',
            'Pemetaan dan fotogrametri',
            'Pertanian',
            'Pertambangan',
            'Inspeksi industri',
            'Fotografi udara',
            'Pencarian dan penyelamatan (SAR)',
        ];
        $idtc->services()->delete();
        foreach ($idtcServices as $idx => $s) {
            LpkService::create([
                'lpk_id' => $idtc->id,
                'nama_layanan' => $s,
                'urutan' => $idx + 1,
            ]);
        }

        $idtcFeatures = [
            [
                't' => 'Instruktur Berpengalaman',
                'd' => 'Dibimbing langsung oleh praktisi dan instruktur drone profesional berlisensi dengan jam terbang tinggi di berbagai industri.',
                'i' => '👨‍✈️',
            ],
            [
                't' => 'Safety dan SOP Standar',
                'd' => 'Menjunjung tinggi standar keselamatan penerbangan ketat, regulasi resmi, serta manajemen operasional yang aman di lapangan.',
                'i' => '🛡️',
            ],
            [
                't' => 'Footage Stabil dan Presisi',
                'd' => 'Teknik navigasi akurat dan penguasaan kamera tingkat lanjut untuk menghasilkan visual sinematik serta data spasial presisi tinggi.',
                'i' => '🎯',
            ],
        ];
        $idtc->features()->delete();
        foreach ($idtcFeatures as $idx => $f) {
            LpkFeature::create([
                'lpk_id' => $idtc->id,
                'judul' => $f['t'],
                'deskripsi' => $f['d'],
                'ikon' => $f['i'],
                'urutan' => $idx + 1,
            ]);
        }

        $idtcPartners = [
            'UGM', 'AMIKOM', 'Mercu Buana Yogyakarta', 'Atma Jaya Yogyakarta',
            'UAD', 'UNU Yogyakarta', 'BSI', 'ISI Padangpanjang',
            'Pemkab Sleman', 'Dinas Pendidikan Sleman', 'Disnaker Sleman',
            'BPBD Bantul', 'BPBD Gunungkidul',
        ];
        $idtc->partners()->delete();
        foreach ($idtcPartners as $idx => $p) {
            LpkPartner::create([
                'lpk_id' => $idtc->id,
                'nama_mitra' => $p,
                'urutan' => $idx + 1,
            ]);
        }

        $idtc->galleries()->delete();
        // Dibatasi maksimal 36 foto per lembaga
        for ($i = 1; $i <= 36; $i++) {
            $fotoPath = 'images/idtc/foto' . $i . '.jpg';
            if (file_exists(public_path($fotoPath))) {
                LpkGallery::create([
                    'lpk_id' => $idtc->id,
                    'foto' => $fotoPath,
                    'keterangan' => 'Foto Kegiatan ' . $i,
                    'urutan' => $i,
                ]);
            }
        }

        // 4. Dummy LPKs
        $dummy = [
            ['n' => 'LPK Contoh Tata Boga', 'f' => 'Tata Boga', 'e' => '🍳', 'c' => '#c2410c', 'cover' => 'images/covers/cover-tata-boga.jpg'],
            ['n' => 'LPK Contoh Tata Busana', 'f' => 'Tata Busana', 'e' => '🧵', 'c' => '#4338ca', 'cover' => 'images/covers/cover-tata-busana.jpg'],
            ['n' => 'LPK Contoh Komputer dan Desain', 'f' => 'Teknologi Informasi', 'e' => '💻', 'c' => '#047857', 'cover' => 'images/covers/cover-komputer.jpg'],
            ['n' => 'LPK Contoh Bahasa Jepang', 'f' => 'Bahasa Asing', 'e' => '🗾', 'c' => '#b45309', 'cover' => 'images/covers/cover-bahasa-jepang.jpg'],
            ['n' => 'LPK Contoh Perhotelan', 'f' => 'Perhotelan', 'e' => '🏨', 'c' => '#be185d', 'cover' => 'images/covers/cover-perhotelan.jpg'],
            ['n' => 'LPK Contoh Otomotif', 'f' => 'Otomotif', 'e' => '🔧', 'c' => '#1d4ed8', 'cover' => 'images/covers/cover-otomotif.jpg'],
            ['n' => 'LPK Contoh Tata Rias', 'f' => 'Kecantikan', 'e' => '💄', 'c' => '#7e22ce', 'cover' => 'images/covers/cover-kecantikan.jpg'],
            ['n' => 'LPK Contoh Perawat Lansia', 'f' => 'Kesehatan', 'e' => '🩺', 'c' => '#0f766e', 'cover' => 'images/covers/cover-kesehatan.jpg'],
            ['n' => 'LPK Contoh Las dan Konstruksi', 'f' => 'Konstruksi', 'e' => '🏗️', 'c' => '#a16207', 'cover' => 'images/covers/cover-konstruksi.jpg'],
            ['n' => 'LPK Contoh Barista', 'f' => 'Kuliner dan Kafe', 'e' => '☕', 'c' => '#9f1239', 'cover' => 'images/covers/cover-barista.jpg'],
            ['n' => 'LPK Contoh Administrasi Perkantoran', 'f' => 'Administrasi', 'e' => '📊', 'c' => '#334155', 'cover' => 'images/covers/cover-administrasi.jpg'],
        ];

        foreach ($dummy as $idx => $d) {
            $num = $idx + 2;
            $slug = 'lpk-' . $num;
            $lpk = Lpk::updateOrCreate(
                ['slug' => $slug],
                [
                    'nama' => $d['n'],
                    'bidang' => $d['f'],
                    'ikon' => $d['e'],
                    'warna' => $d['c'],
                    'cover' => $d['cover'],
                    'tentang' => "[Deskripsi singkat {$d['n']}: profil, sejarah, dan keunggulan lembaga. Data contoh, ganti dengan data asli.]",
                    'nama_admin' => '[Nama Admin]',
                    'whatsapp' => '0812 0000 0000',
                    'alamat' => "[Alamat {$d['n']}, Kabupaten Sleman, D.I. Yogyakarta]",
                    'email' => 'info@lpk-contoh.example',
                    'instagram' => '@lpk_contoh',
                    'website' => null,
                    'link_maps' => null,
                    'urutan' => $num,
                    'aktif' => true,
                ]
            );

            $lpk->services()->delete();
            $services = [
                "Pelatihan {$d['f']} dasar",
                "Pelatihan {$d['f']} lanjutan",
                "Sertifikasi kompetensi",
                "Penyaluran kerja",
            ];
            foreach ($services as $sIdx => $sName) {
                LpkService::create([
                    'lpk_id' => $lpk->id,
                    'nama_layanan' => $sName,
                    'urutan' => $sIdx + 1,
                ]);
            }
        }
    }
}
