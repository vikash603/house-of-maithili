<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CaptureOrderAttribution
{
    public function handle(Request $request, Closure $next)
    {
        $attribution = (array) $request->session()->get('hom_attribution', []);
        foreach (['utm_source','utm_medium','utm_campaign','utm_content'] as $key) {
            if ($request->query($key) && empty($attribution[$key])) $attribution[$key] = mb_substr(trim((string) $request->query($key)), 0, 190);
        }
        if (empty($attribution['referrer_url']) && $request->headers->has('referer')) {
            $referrer = (string) $request->headers->get('referer');
            if (!str_contains($referrer, $request->getHost())) {
                $parts = parse_url($referrer);
                if (is_array($parts) && isset($parts['host'])) {
                    $attribution['referrer_url'] = mb_substr(($parts['scheme'] ?? 'https').'://'.$parts['host'].($parts['path'] ?? ''), 0, 2000);
                }
            }
        }
        if ($attribution) $request->session()->put('hom_attribution', $attribution);
        return $next($request);
    }
}
