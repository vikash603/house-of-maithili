<x-guest-layout>
    <style>
        :root { --hom-ivory: #f8f5ef; --hom-paper: #fffdfa; --hom-maroon: #641d2b; --hom-maroon-dark: #4d1420; --hom-gold: #b58a52; --hom-ink: #302a27; --hom-muted: #77706a; --hom-line: #e8e0d7; }
        body { background: var(--hom-ivory); color: var(--hom-ink); font-family: 'Figtree', 'Avenir Next', sans-serif; }
        .hom-login-shell { min-height: 100vh; display: grid; place-items: center; padding: 34px; background: radial-gradient(ellipse at 85% 10%, #eee5d8 0, transparent 34%), var(--hom-ivory); }
        .hom-login-card { width: min(1120px, 100%); min-height: 650px; display: grid; grid-template-columns: 1fr 0.88fr; overflow: hidden; background: var(--hom-paper); border: 1px solid rgba(100,29,43,.09); border-radius: 20px; box-shadow: 0 24px 70px rgba(54,35,25,.12); }
        .hom-visual { min-height: 650px; position: relative; overflow: hidden; background: #6a4a3d; }
        .hom-visual::before { content: ''; position: absolute; inset: 0; background: linear-gradient(180deg, rgba(26,20,17,.06) 25%, rgba(28,17,16,.68) 100%); z-index: 1; }
        .hom-visual img { width: 100%; height: 100%; object-fit: cover; object-position: 50% center; position: absolute; inset: 0; }
        .hom-visual-copy { position: absolute; z-index: 2; left: 48px; right: 42px; bottom: 44px; color: white; }
        .hom-eyebrow { display: inline-flex; align-items: center; gap: 10px; color: #f1d8b0; font-size: 11px; font-weight: 700; letter-spacing: .2em; text-transform: uppercase; }
        .hom-eyebrow::before { content: ''; width: 28px; height: 1px; background: currentColor; }
        .hom-visual-copy h2 { margin: 16px 0 9px; color: white; font-family: Georgia, serif; font-size: clamp(30px, 3vw, 43px); font-weight: 400; line-height: 1.1; }
        .hom-visual-copy p { max-width: 360px; margin: 0; color: rgba(255,255,255,.83); font-size: 14px; line-height: 1.7; }
        .hom-form-panel { display: flex; flex-direction: column; justify-content: center; padding: 58px clamp(34px, 5vw, 72px); }
        .hom-brand { display: inline-flex; align-items: center; align-self: flex-start; gap: 12px; margin-bottom: 48px; text-decoration: none; }
        .hom-brand img { width: 58px; height: 58px; object-fit: contain; }
        .hom-brand span { color: var(--hom-maroon); font-family: Georgia, serif; font-size: 20px; letter-spacing: .045em; line-height: 1.1; }
        .hom-brand small { display: block; margin-top: 5px; color: var(--hom-gold); font-family: 'Figtree', sans-serif; font-size: 9px; font-weight: 700; letter-spacing: .23em; text-transform: uppercase; }
        .hom-heading { margin: 0; color: var(--hom-maroon); font-family: Georgia, 'Times New Roman', serif; font-size: clamp(34px, 4vw, 42px); font-weight: 400; letter-spacing: -.025em; }
        .hom-intro { margin: 10px 0 32px; color: var(--hom-muted); font-size: 14px; line-height: 1.6; }
        .hom-alert { margin: 0 0 20px; padding: 12px 14px; border: 1px solid #e6c8c7; border-radius: 9px; background: #fff4f2; color: #8c252b; font-size: 13px; line-height: 1.5; }
        .hom-success { border-color: #c9ddce; background: #f2faf4; color: #285a38; }
        .hom-field { margin-bottom: 21px; }
        .hom-field label { display: block; margin-bottom: 8px; color: #443a36; font-size: 12px; font-weight: 700; letter-spacing: .055em; }
        .hom-control-wrap { position: relative; }
        .hom-control { width: 100%; min-height: 51px; padding: 13px 15px; border: 1px solid var(--hom-line); border-radius: 9px; outline: none; background: #fff; color: var(--hom-ink); font: inherit; font-size: 14px; transition: border-color .18s ease, box-shadow .18s ease, background .18s ease; }
        .hom-control::placeholder { color: #aaa19a; }
        .hom-control:focus { border-color: var(--hom-gold); background: white; box-shadow: 0 0 0 3px rgba(181,138,82,.14); }
        .hom-control.is-invalid { border-color: #b83b43; }
        .hom-control.has-toggle { padding-right: 76px; }
        .hom-toggle { position: absolute; top: 50%; right: 14px; transform: translateY(-50%); border: 0; background: transparent; color: var(--hom-maroon); cursor: pointer; font: inherit; font-size: 11px; font-weight: 700; }
        .hom-toggle:focus-visible, .hom-forgot:focus-visible, .hom-register a:focus-visible { outline: 2px solid var(--hom-gold); outline-offset: 3px; border-radius: 3px; }
        .hom-error { margin: 7px 0 0; color: #a3242c; font-size: 12px; }
        .hom-options { display: flex; align-items: center; justify-content: space-between; gap: 14px; margin: 3px 0 25px; }
        .hom-remember { display: inline-flex; align-items: center; gap: 9px; color: #625a55; font-size: 13px; cursor: pointer; }
        .hom-remember input { width: 16px; height: 16px; margin: 0; accent-color: var(--hom-maroon); }
        .hom-forgot { color: var(--hom-maroon); font-size: 12px; font-weight: 700; text-decoration: none; }
        .hom-forgot:hover, .hom-register a:hover { color: var(--hom-gold); }
        .hom-submit { width: 100%; min-height: 52px; border: 0; border-radius: 9px; background: var(--hom-maroon); color: white; cursor: pointer; font: inherit; font-size: 13px; font-weight: 700; letter-spacing: .11em; text-transform: uppercase; transition: background .2s ease, transform .2s ease; }
        .hom-submit:hover { background: var(--hom-maroon-dark); transform: translateY(-1px); }
        .hom-submit:focus-visible { outline: 3px solid rgba(181,138,82,.48); outline-offset: 3px; }
        .hom-submit:disabled { cursor: wait; opacity: .78; transform: none; }
        .hom-register { margin: 24px 0 0; color: var(--hom-muted); text-align: center; font-size: 13px; }
        .hom-register a { color: var(--hom-maroon); font-weight: 700; text-decoration: none; }
        .hom-otp-link { display: block; margin: 14px 0 0; color: var(--hom-maroon); text-align: center; font-size: 13px; font-weight: 700; text-decoration: none; }
        .hom-otp-link:hover { color: var(--hom-gold); }
        .hom-privacy { margin-top: 48px; color: #9a9189; text-align: center; font-size: 11px; letter-spacing: .025em; }
        @media (max-width: 850px) { .hom-login-shell { padding: 22px; } .hom-login-card { max-width: 650px; min-height: 0; grid-template-columns: 1fr; } .hom-visual { min-height: 235px; } .hom-visual img { object-position: center 42%; } .hom-visual-copy { left: 30px; bottom: 25px; } .hom-visual-copy h2 { margin: 8px 0 4px; font-size: 29px; } .hom-visual-copy p { font-size: 12px; } .hom-form-panel { padding: 38px clamp(28px, 8vw, 60px); } .hom-brand { margin-bottom: 30px; } .hom-privacy { margin-top: 30px; } }
        @media (max-width: 480px) { .hom-login-shell { display: block; padding: 0; background: var(--hom-paper); } .hom-login-card { min-height: 100vh; border: 0; border-radius: 0; box-shadow: none; } .hom-visual { min-height: 190px; } .hom-visual-copy { left: 22px; right: 20px; bottom: 18px; } .hom-visual-copy h2 { font-size: 25px; } .hom-visual-copy p { display: none; } .hom-form-panel { padding: 28px 24px 24px; } .hom-brand { margin-bottom: 28px; } .hom-brand img { width: 48px; height: 48px; } .hom-heading { font-size: 34px; } .hom-intro { margin-bottom: 25px; } }
        @media (prefers-reduced-motion: reduce) { *, *::before, *::after { scroll-behavior: auto !important; transition-duration: .01ms !important; } }
    </style>

    <main class="hom-login-shell">
        <section class="hom-login-card" aria-label="Sign in to House Of Maithili">
            <div class="hom-visual" aria-hidden="true">
                <img src="{{ asset('frontend/images/Elegant Saree Portrait in Heritage Courtyard.png') }}" alt="">
                <div class="hom-visual-copy">
                    <span class="hom-eyebrow">The art of Maithili</span>
                    <h2>Tradition, beautifully<br>made yours.</h2>
                    <p>Discover thoughtful craftsmanship and timeless pieces, rooted in the spirit of Mithila.</p>
                </div>
            </div>

            <div class="hom-form-panel">
                <a class="hom-brand" href="{{ url('/') }}" aria-label="House Of Maithili home">
                    <img src="{{ asset('frontend/images/Logo%20Final.png') }}" alt="">
                    <span>House Of Maithili<small>Rooted in tradition</small></span>
                </a>

                <h1 class="hom-heading">Welcome Back</h1>
                <p class="hom-intro">Sign in to your House Of Maithili account.</p>

                @if ($errors->any())
                    <div class="hom-alert" role="alert" aria-live="polite">
                        <p>{{ $errors->first('email') ?: $errors->first() }}</p>
                    </div>
                @endif

                @session('status')
                    <div class="hom-alert hom-success" role="status">{{ $value }}</div>
                @endsession

                <form id="hom-login-form" method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="hom-field">
                        <label for="email">Email address</label>
                        <input id="email" class="hom-control @error('email') is-invalid @enderror" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" inputmode="email" placeholder="you@example.com" aria-describedby="email-error" @error('email') aria-invalid="true" @enderror>
                        @error('email')<p class="hom-error" id="email-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="hom-field">
                        <label for="password">Password</label>
                        <div class="hom-control-wrap">
                            <input id="password" class="hom-control has-toggle @error('password') is-invalid @enderror" type="password" name="password" required autocomplete="current-password" placeholder="Enter your password" aria-describedby="password-error" @error('password') aria-invalid="true" @enderror>
                            <button class="hom-toggle" type="button" id="password-toggle" aria-controls="password" aria-pressed="false">Show</button>
                        </div>
                        @error('password')<p class="hom-error" id="password-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="hom-options">
                        <label class="hom-remember" for="remember_me">
                            <input id="remember_me" type="checkbox" name="remember" value="1" @checked(old('remember'))>
                            <span>Remember me</span>
                        </label>
                        @if (Route::has('password.request'))
                            <a class="hom-forgot" href="{{ route('password.request') }}">Forgot password?</a>
                        @endif
                    </div>

                    <button class="hom-submit" id="hom-submit" type="submit"><span>Sign In</span></button>
                </form>

                <a class="hom-otp-link" href="{{ route('login.otp') }}">Sign in with an email code</a>

                @if (Route::has('register'))
                    <p class="hom-register">New to House Of Maithili? <a href="{{ route('register') }}">Create an account</a></p>
                @endif
                <p class="hom-privacy">A more personal way to shop, crafted with care.</p>
            </div>
        </section>
    </main>

    <script>
        (() => {
            const password = document.getElementById('password');
            const toggle = document.getElementById('password-toggle');
            const form = document.getElementById('hom-login-form');
            const submit = document.getElementById('hom-submit');

            toggle?.addEventListener('click', () => {
                const isVisible = password.type === 'text';
                password.type = isVisible ? 'password' : 'text';
                toggle.textContent = isVisible ? 'Show' : 'Hide';
                toggle.setAttribute('aria-pressed', String(!isVisible));
            });

            form?.addEventListener('submit', () => {
                if (!form.reportValidity()) return;
                submit.disabled = true;
                submit.querySelector('span').textContent = 'Signing in…';
            });
        })();
    </script>
</x-guest-layout>
