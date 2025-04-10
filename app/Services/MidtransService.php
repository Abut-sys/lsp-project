<?php

namespace App\Services;

use Midtrans\Config;
use Illuminate\Support\Facades\Http;

class MidtransService
{
    protected string $serverKey;
    protected string $baseUrl;

    public function __construct()
    {
        $this->serverKey = config('services.midtrans.server_key');
        $this->baseUrl = config('services.midtrans.is_production')
            ? 'https://app.midtrans.com/snap/v1'
            : 'https://app.sandbox.midtrans.com/snap/v1';
    }

    private function configureMidtrans()
    {
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$clientKey = config('services.midtrans.client_key'); // Tambahkan ini
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function createTransaction(array $data)
    {
        $response = Http::withBasicAuth($this->serverKey, '')
            ->withHeaders(['Content-Type' => 'application/json'])
            ->post("{$this->baseUrl}/transactions", $data);

        return $response->json();
    }

}
