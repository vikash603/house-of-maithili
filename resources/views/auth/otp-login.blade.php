<x-guest-layout>
    <main style="min-height:100vh;display:grid;place-items:center;padding:24px;background:#f8f5ef;font-family:Arial,sans-serif;color:#302a27">
        <section style="width:min(460px,100%);padding:clamp(24px,6vw,42px);border:1px solid #e8e0d7;border-radius:14px;background:#fffdfa;box-shadow:0 18px 55px #39271c12">
            <a href="{{ url('/') }}" style="display:block;margin-bottom:26px;color:#641d2b;font:24px Georgia,serif;text-decoration:none">House Of Maithili</a>
            <p style="margin:0 0 8px;color:#a0835d;font-size:10px;font-weight:700;letter-spacing:.16em">SECURE CUSTOMER SIGN IN</p>
            <h1 style="margin:0;color:#641d2b;font:32px Georgia,serif">Sign in with email</h1>
            <p style="margin:10px 0 22px;color:#756b62;font-size:13px;line-height:1.6">We will email you a one-time code. No password needed.</p>
            @if(session('status'))<div role="status" style="margin-bottom:16px;padding:12px;border:1px solid #c9ddce;border-radius:7px;background:#f2faf4;color:#285a38;font-size:12px">{{ session('status') }}</div>@endif
            @if($errors->any())<div role="alert" style="margin-bottom:16px;padding:12px;border:1px solid #e6c8c7;border-radius:7px;background:#fff4f2;color:#8c252b;font-size:12px">{{ $errors->first() }}</div>@endif
            @if(session('otp_login_email'))
                <form method="POST" action="{{ route('login.otp.verify') }}" style="display:grid;gap:12px">@csrf
                    <input type="hidden" name="email" value="{{ session('otp_login_email') }}">
                    <label for="login-code" style="font-size:12px;font-weight:700">6-digit code sent to {{ session('otp_login_email') }}</label>
                    <input id="login-code" name="code" inputmode="numeric" autocomplete="one-time-code" pattern="[0-9]{6}" maxlength="6" required autofocus style="width:100%;padding:13px;border:1px solid #ded6cc;border-radius:7px;font-size:20px;letter-spacing:.25em">
                    <button type="submit" style="padding:14px;border:0;border-radius:7px;background:#641d2b;color:white;font-weight:700;cursor:pointer">Verify &amp; sign in</button>
                </form>
                <form method="POST" action="{{ route('login.otp.send') }}" style="margin-top:12px">@csrf<input type="hidden" name="email" value="{{ session('otp_login_email') }}"><button type="submit" style="padding:0;border:0;background:none;color:#641d2b;font-size:12px;font-weight:700;text-decoration:underline;cursor:pointer">Send a new code</button></form>
            @else
                <form method="POST" action="{{ route('login.otp.send') }}" style="display:grid;gap:12px">@csrf
                    <label for="login-email" style="font-size:12px;font-weight:700">Email address</label>
                    <input id="login-email" name="email" type="email" value="{{ old('email') }}" autocomplete="email" required autofocus style="width:100%;padding:13px;border:1px solid #ded6cc;border-radius:7px;font-size:14px">
                    <button type="submit" style="padding:14px;border:0;border-radius:7px;background:#641d2b;color:white;font-weight:700;cursor:pointer">Send sign-in code</button>
                </form>
            @endif
            <p style="margin:22px 0 0;text-align:center;font-size:12px"><a href="{{ route('login') }}" style="color:#641d2b;font-weight:700">Back to password sign in</a></p>
        </section>
    </main>
</x-guest-layout>
