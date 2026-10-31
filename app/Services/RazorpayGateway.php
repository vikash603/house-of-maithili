<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use RuntimeException;

class RazorpayGateway
{
    private const API_URL = 'https://api.razorpay.com/v1';

    public function configured(): bool
    {
        return filled(config('services.razorpay.key_id')) && filled(config('services.razorpay.key_secret'));
    }

    public function keyId(): string
    {
        return (string) config('services.razorpay.key_id');
    }

    public function createOrder(int $amountPaise, string $receipt, array $notes = []): array
    {
        $response = $this->request()->post(self::API_URL.'/orders', [
            'amount' => $amountPaise,
            'currency' => 'INR',
            'receipt' => $receipt,
            'notes' => $notes,
        ]);

        if (!$response->successful()) throw new RuntimeException('Razorpay could not create the payment order.');

        return $response->json();
    }

    public function fetchPayment(string $paymentId): array
    {
        $response = $this->request()->get(self::API_URL.'/payments/'.rawurlencode($paymentId));
        if (!$response->successful()) throw new RuntimeException('Could not verify the payment with Razorpay.');

        return $response->json();
    }

    public function capturePayment(string $paymentId, int $amountPaise): array
    {
        $response = $this->request()->post(self::API_URL.'/payments/'.rawurlencode($paymentId).'/capture', [
            'amount' => $amountPaise,
            'currency' => 'INR',
        ]);
        if (!$response->successful()) throw new RuntimeException('Razorpay has not confirmed payment capture.');

        return $response->json();
    }

    public function verifyCheckoutSignature(string $gatewayOrderId, string $paymentId, string $signature): bool
    {
        $secret = (string) config('services.razorpay.key_secret');
        if ($secret === '') return false;
        $expected = hash_hmac('sha256', $gatewayOrderId.'|'.$paymentId, $secret);

        return hash_equals($expected, $signature);
    }

    public function verifyWebhookSignature(string $rawBody, string $signature): bool
    {
        $secret = (string) config('services.razorpay.webhook_secret');
        if ($secret === '') return false;
        $expected = hash_hmac('sha256', $rawBody, $secret);

        return hash_equals($expected, $signature);
    }

    private function request()
    {
        $keyId = (string) config('services.razorpay.key_id');
        $keySecret = (string) config('services.razorpay.key_secret');
        if ($keyId === '' || $keySecret === '') throw new RuntimeException('Razorpay API credentials are not configured.');

        return Http::acceptJson()->asJson()->withBasicAuth($keyId, $keySecret)->timeout(20)->connectTimeout(8);
    }
}
