<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertSee('Login Admin');
        $response->assertSee('Password Admin');
    }

    public function test_admin_can_authenticate_with_password_only(): void
    {
        User::factory()->create([
            'email' => 'admin@hillsi.test',
            'password' => Hash::make('adminJCP'),
        ]);

        $response = $this->post('/login', [
            'password' => 'adminJCP',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('dashboard', absolute: false));
    }

    public function test_admin_cannot_authenticate_with_invalid_password(): void
    {
        User::factory()->create([
            'email' => 'admin@hillsi.test',
            'password' => Hash::make('adminJCP'),
        ]);

        $response = $this->post('/login', [
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors('password');
    }

    public function test_users_can_logout(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $this->assertGuest();
        $response->assertRedirect('/');
    }
}
