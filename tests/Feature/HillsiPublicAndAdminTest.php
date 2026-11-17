<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Lpk;
use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HillsiPublicAndAdminTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }
    public function test_home_page_displays_lpks_and_settings(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('HILLSI Sleman');
        $response->assertSee('Indonesia Drone Training Center');
        $response->assertSee('maps.google.com');
    }

    public function test_lpk_detail_idtc_displays_features_and_partners(): void
    {
        $response = $this->get('/lpk/drone-indonesia');
        $response->assertStatus(200);
        $response->assertSee('Indonesia Drone Training Center');
        $response->assertSee('Mengapa IDTC');
        $response->assertSee('Instruktur Berpengalaman');
        $response->assertSee('Mitra');
        $response->assertSee('UGM');
        $response->assertSee('Kunjungi Website Resmi');
        $response->assertSee('Galeri Sertifikasi dan Pelatihan (36 Foto)');
    }

    public function test_lpk_galleries_cannot_exceed_36(): void
    {
        $idtc = Lpk::where('slug', 'drone-indonesia')->first();
        $this->assertLessThanOrEqual(36, $idtc->galleries()->count());
    }

    public function test_lpk_detail_dummy_does_not_display_features(): void
    {
        $response = $this->get('/lpk/lpk-2');
        $response->assertStatus(200);
        $response->assertSee('LPK Contoh Tata Boga');
        $response->assertDontSee('Mengapa IDTC');
    }

    public function test_guest_cannot_access_admin_panel(): void
    {
        $response = $this->get('/admin');
        $response->assertRedirect('/login');

        $response2 = $this->get('/admin/lpks');
        $response2->assertRedirect('/login');

        $response3 = $this->get('/admin/settings');
        $response3->assertRedirect('/login');
    }

    public function test_admin_can_access_lpk_crud_and_settings(): void
    {
        $admin = User::where('email', 'admin@hillsi.test')->first();
        if (!$admin) {
            $admin = User::factory()->create();
        }

        $response = $this->actingAs($admin)->get('/admin/lpks');
        $response->assertStatus(200);
        $response->assertSee('Kelola Lembaga Pelatihan Kerja');
        $response->assertSee('Indonesia Drone Training Center');

        $responseSettings = $this->actingAs($admin)->get('/admin/settings');
        $responseSettings->assertStatus(200);
        $responseSettings->assertSee('Pengaturan Beranda', false);
        $responseSettings->assertSee('Ganti Password Admin');

        // Test Dashboard
        $responseDash = $this->actingAs($admin)->get('/admin');
        $responseDash->assertStatus(200);
        $responseDash->assertSee('Dashboard Administrasi');
        $responseDash->assertSee('Grafik LPK per Bidang');

        // Test Toggle Active
        $lpk = Lpk::first();
        $this->assertTrue((bool)$lpk->aktif);

        $toggleResponse = $this->actingAs($admin)->postJson('/admin/lpks/' . $lpk->id . '/toggle-active');
        $toggleResponse->assertStatus(200);
        $toggleResponse->assertJson(['success' => true, 'aktif' => false]);
        $this->assertFalse((bool)$lpk->fresh()->aktif);

        // Verify inactive LPK is NOT in public home
        $publicHome = $this->get('/');
        $publicHome->assertDontSee($lpk->nama);

        // Toggle back to active
        $toggleResponse2 = $this->actingAs($admin)->postJson('/admin/lpks/' . $lpk->id . '/toggle-active');
        $toggleResponse2->assertStatus(200);
        $toggleResponse2->assertJson(['success' => true, 'aktif' => true]);
        $this->assertTrue((bool)$lpk->fresh()->aktif);
    }
}
