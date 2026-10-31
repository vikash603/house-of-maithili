<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

class NewsletterController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'string', 'email:rfc', 'max:255'],
        ]);

        try {
            $email = mb_strtolower(trim($validated['email']));
            $subscription = NewsletterSubscription::firstOrCreate(['email' => $email]);

            return redirect('/#maithili-newsletter')->with(
                'newsletter_success',
                $subscription->wasRecentlyCreated
                    ? 'Thank you. Your email has been saved for House Of Maithili updates.'
                    : 'This email is already subscribed to House Of Maithili updates.'
            );
        } catch (Throwable $exception) {
            Log::warning('Newsletter subscription could not be saved.', ['exception' => $exception]);

            return redirect('/#maithili-newsletter')->with(
                'newsletter_error',
                'Signup is temporarily unavailable. Please try again later.'
            );
        }
    }
}
