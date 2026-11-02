<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $html = $response->getContent();
        $this->assertStringNotContainsString('Sign in with an email code', $html);
        $this->assertStringContainsString('id="remember_me"', $html);
        $this->assertStringContainsString('href="'.route('password.request').'"', $html);
        $this->assertStringContainsString('href="'.route('register').'"', $html);
    }

    public function test_email_otp_login_routes_are_disabled_while_deferred(): void
    {
        $this->get('/login/otp')->assertNotFound();
        $this->post('/login/otp/send')->assertNotFound();
        $this->post('/login/otp/verify')->assertNotFound();
    }

    public function test_password_reset_registration_and_verification_routes_remain_available(): void
    {
        $this->assertTrue(\Illuminate\Support\Facades\Route::has('login'));
        $this->assertTrue(\Illuminate\Support\Facades\Route::has('password.request'));
        $this->assertTrue(\Illuminate\Support\Facades\Route::has('register'));
        $this->assertTrue(\Illuminate\Support\Facades\Route::has('verification.notice'));
    }

    public function test_users_can_authenticate_using_the_login_screen(): void
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('account.orders.index', absolute: false));
    }

    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }
}
