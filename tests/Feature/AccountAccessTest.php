<?php

namespace Tests\Feature;

use App\Mail\AccountAccessCodeMail;
use App\Models\AccountAccessCode;
use App\Models\User;
use App\Services\AccountAccessService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Tests\TestCase;

class AccountAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_deferred_login_code_service_remains_hashed_and_single_use_for_future_reenablement(): void
    {
        config(['mail.default'=>'array']);
        Mail::fake();
        $user = User::factory()->create(['email'=>'otp-customer@example.test','email_verified_at'=>null]);

        app(AccountAccessService::class)->sendLoginCode($user->email);
        Mail::assertQueued(AccountAccessCodeMail::class, fn (AccountAccessCodeMail $mail) => $mail->hasTo($user->email));
        $mailCode = null;
        Mail::assertQueued(AccountAccessCodeMail::class, function (AccountAccessCodeMail $mail) use (&$mailCode): bool { $mailCode = $mail->code; return true; });
        $challenge = AccountAccessCode::query()->where('email',$user->email)->firstOrFail();
        $this->assertNotSame($mailCode,$challenge->code_hash);

        $this->assertTrue(app(AccountAccessService::class)->verify($user->email,$mailCode,'login'));
        $this->assertNotNull($challenge->fresh()->consumed_at);
        $this->assertNull($user->fresh()->email_verified_at);
        $this->assertFalse(app(AccountAccessService::class)->verify($user->email,$mailCode,'login'));
    }

    public function test_otp_expires_and_locks_after_five_invalid_attempts(): void
    {
        config(['mail.default'=>'array']);
        Mail::fake();
        $user = User::factory()->create(['email'=>'otp-limits@example.test']);
        $access = app(AccountAccessService::class);

        $access->sendLoginCode($user->email);
        $validCode = null;
        Mail::assertQueued(AccountAccessCodeMail::class, function (AccountAccessCodeMail $mail) use (&$validCode): bool { $validCode = $mail->code; return true; });
        $challenge = AccountAccessCode::query()->where('email',$user->email)->firstOrFail();

        for ($attempt=0; $attempt<5; $attempt++) $this->assertFalse($access->verify($user->email,'000000','login'));
        $this->assertFalse($access->verify($user->email,$validCode,'login'));
        $this->assertSame(5,$challenge->fresh()->attempts);

        $access->sendLoginCode($user->email);
        $newChallenge = AccountAccessCode::query()->where('email',$user->email)->whereNull('consumed_at')->latest('id')->firstOrFail();
        $newChallenge->update(['expires_at'=>now()->subSecond()]);
        $this->assertFalse($access->verify($user->email,'123456','login'));
        $this->assertNull($newChallenge->fresh()->consumed_at);
    }

    public function test_login_otp_is_not_persisted_when_mail_transport_would_log_it(): void
    {
        config(['mail.default'=>'log']);
        $this->expectException(\RuntimeException::class);
        try {
            app(AccountAccessService::class)->sendLoginCode('secure@example.test');
        } finally {
            $this->assertDatabaseCount('account_access_codes',0);
        }
    }

    public function test_login_otp_http_endpoints_are_not_available_while_feature_is_deferred(): void
    {
        $this->get('/login/otp')->assertNotFound();
        $this->post('/login/otp/send', ['email'=>'missing@example.test'])->assertNotFound();
        $this->post('/login/otp/verify', ['email'=>'missing@example.test','code'=>'123456'])->assertNotFound();
        $this->assertDatabaseCount('account_access_codes',0);
    }

}
