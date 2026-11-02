<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Fortify\Features;
use Laravel\Jetstream\Jetstream;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        if (! Features::enabled(Features::registration())) {
            $this->markTestSkipped('Registration support is not enabled.');
        }

        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_registration_screen_cannot_be_rendered_if_support_is_disabled(): void
    {
        if (Features::enabled(Features::registration())) {
            $this->markTestSkipped('Registration support is enabled.');
        }

        $response = $this->get('/register');

        $response->assertStatus(404);
    }

    public function test_new_users_can_register(): void
    {
        if (! Features::enabled(Features::registration())) {
            $this->markTestSkipped('Registration support is not enabled.');
        }

        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'phone' => '+918226803011',
            'password' => 'password',
            'password_confirmation' => 'password',
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature(),
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('account.orders.index', absolute: false));
        $this->assertDatabaseHas('users', ['email' => 'test@example.com']);
        $this->assertAuthenticated();
        $response->assertRedirect(route('account.orders.index', absolute: false));
        $this->assertDatabaseHas('users', ['email' => 'test@example.com', 'phone'=>'+918226803011', 'is_admin' => false]);
    }

    public function test_public_registration_cannot_grant_admin_access_even_for_the_authorized_address(): void
    {
        if (! Features::enabled(Features::registration())) $this->markTestSkipped('Registration support is not enabled.');

        $this->post('/register', [
            'name'=>'House Admin',
            'email'=>'HOUSEOFMAITHILI@GMAIL.COM',
            'password'=>'password',
            'password_confirmation'=>'password',
            'terms'=>Jetstream::hasTermsAndPrivacyPolicyFeature(),
        ])->assertRedirect(route('account.orders.index',absolute:false));

        $user = \App\Models\User::query()->where('email','houseofmaithili@gmail.com')->firstOrFail();
        $this->assertFalse($user->is_admin);
        $this->assertNull($user->email_verified_at);
        $this->assertFalse($user->canAccessAdmin());
        $this->get(route('admin.orders.dashboard'))->assertRedirect(route('verification.notice'));
    }

    public function test_registration_rejects_existing_email_case_insensitively(): void
    {
        if (! Features::enabled(Features::registration())) $this->markTestSkipped('Registration support is not enabled.');
        \App\Models\User::factory()->create(['email'=>'duplicate@example.test']);

        $this->from('/register')->post('/register', [
            'name'=>'Duplicate',
            'email'=>'DUPLICATE@example.test',
            'password'=>'password',
            'password_confirmation'=>'password',
            'terms'=>Jetstream::hasTermsAndPrivacyPolicyFeature(),
        ])->assertRedirect('/register')->assertSessionHasErrors('email');

        $this->assertSame(1,\App\Models\User::query()->whereRaw('LOWER(email) = ?', ['duplicate@example.test'])->count());
    }
}
