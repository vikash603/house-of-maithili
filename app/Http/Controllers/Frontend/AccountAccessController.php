<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Services\AccountAccessService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class AccountAccessController extends Controller
{
    public function otpLogin()
    {
        return view('auth.otp-login');
    }

    public function sendLoginCode(Request $request, AccountAccessService $access)
    {
        $data = $request->validate(['email' => ['required', 'email', 'max:190']]);
        $email = Str::lower(trim($data['email']));

        if (User::where('email', $email)->exists()) {
            $cooldownKey = 'login-otp-email:'.hash('sha256', $email);
            if (!RateLimiter::tooManyAttempts($cooldownKey, 1)) {
                RateLimiter::hit($cooldownKey, 60);
                try {
                    $access->sendLoginCode($email);
                } catch (\Throwable $exception) {
                    RateLimiter::clear($cooldownKey);
                    report($exception);
                    // Keep this response identical to unknown-account and cooldown responses.
                    // Delivery failures are logged for operators without exposing account existence.
                    $request->session()->put('otp_login_email', $email);
                    return back()->with('status', 'If an account exists for this email, a sign-in code will be sent when available.');
                }
            }
        }

        $request->session()->put('otp_login_email', $email);

        return back()->with('status', 'If an account exists for this email, a sign-in code will be sent when available.');
    }

    public function verifyLoginCode(Request $request, AccountAccessService $access)
    {
        $data = $request->validate(['email' => ['required', 'email', 'max:190'], 'code' => ['required', 'digits:6']]);
        $email = Str::lower(trim($data['email']));
        $user = User::where('email', $email)->first();

        if (!$user || !$access->verify($email, $data['code'], 'login')) {
            return back()->withInput()->withErrors(['code' => 'That code is invalid or expired. Request a new code and try again.']);
        }

        $user->forceFill(['email_verified_at' => $user->email_verified_at ?: now()])->save();
        Auth::login($user, true);
        $request->session()->regenerate();
        $request->session()->forget('otp_login_email');

        return redirect()->intended(route('account.orders.index'))->with('status', 'You are signed in securely.');
    }

    public function verifyOrderAccount(Request $request, string $orderNumber, AccountAccessService $access)
    {
        $data = $request->validate(['code' => ['required', 'digits:6']]);
        $order = Order::where('order_number', $orderNumber)->firstOrFail();

        if (!$order->email) return back()->withErrors(['code' => 'This order has no email address to verify.']);
        $linkedUser = $order->user;
        if ($linkedUser && Str::lower($linkedUser->email) !== Str::lower($order->email)) {
            return back()->withErrors(['code' => 'The order email does not match the linked customer account.']);
        }
        if (Auth::check() && $linkedUser && Auth::id() !== $linkedUser->id) {
            return back()->withErrors(['code' => 'Please sign out before verifying another customer account.']);
        }
        if (Auth::check() && !$linkedUser && Str::lower(Auth::user()->email) !== Str::lower($order->email)) {
            return back()->withErrors(['code' => 'Please sign out before linking this order to a different account.']);
        }
        if (!$access->verify(Str::lower($order->email), $data['code'], 'order', $order->id)) {
            return back()->withErrors(['code' => 'That code is invalid or expired. Request a new code and try again.']);
        }

        $user = DB::transaction(function () use ($order) {
            $user = $order->user_id
                ? User::whereKey($order->user_id)->lockForUpdate()->first()
                : User::where('email', Str::lower($order->email))->lockForUpdate()->first();

            if (!$user) {
                $user = User::create([
                    'name' => $order->customer_name,
                    'email' => Str::lower($order->email),
                    'phone' => $order->phone,
                    'password' => Str::random(64),
                    'email_verified_at' => now(),
                ]);
            } else {
                $user->forceFill([
                    'email_verified_at' => $user->email_verified_at ?: now(),
                    'phone' => $user->phone ?: $order->phone,
                ])->save();
            }

            if ($order->user_id && $order->user_id !== $user->id) abort(409);
            $order->update(['user_id' => $user->id]);

            return $user;
        });

        Auth::login($user, true);
        $request->session()->regenerate();

        return redirect()->route('account.orders.index')->with('status', 'Your House Of Maithili profile is ready and this order is now saved in your account.');
    }

    public function resendOrderCode(string $orderNumber, AccountAccessService $access)
    {
        $order = Order::where('order_number', $orderNumber)->firstOrFail();
        if (!$order->email || $order->user?->email_verified_at) return back()->withErrors(['code' => 'This order does not need email verification.']);

        try {
            $access->sendOrderEmail($order);
        } catch (\Throwable $exception) {
            report($exception);
            return back()->withErrors(['code' => 'We could not send a new code right now. Please try again shortly.']);
        }

        return back()->with('status', 'A new one-time code has been sent to your email.');
    }

    public function invoice(string $orderNumber)
    {
        $order = Order::with('items')->where('order_number', $orderNumber)->firstOrFail();
        $invoicePdfUrl = \Illuminate\Support\Facades\URL::temporarySignedRoute('checkout.invoice.pdf', now()->addMonths(6), ['orderNumber' => $order->order_number]);

        $seller = config('house_of_maithili');

        return view('frontend.shop.invoice', compact('order', 'invoicePdfUrl', 'seller'));
    }

    public function invoicePdf(string $orderNumber)
    {
        $order = Order::with('items')->where('order_number', $orderNumber)->firstOrFail();
        $logoPath = public_path('frontend/images/house-of-maithili.png');
        $logoDataUri = is_file($logoPath)
            ? 'data:image/png;base64,'.base64_encode(file_get_contents($logoPath))
            : null;
        $seller = config('house_of_maithili');

        return Pdf::loadView('frontend.shop.invoice-pdf', compact('order', 'logoDataUri', 'seller'))
            ->setPaper('a4', 'portrait')
            ->setOptions(['isRemoteEnabled' => false, 'isHtml5ParserEnabled' => true])
            ->download('HOM-INV-'.$order->order_number.'.pdf');
    }
}
