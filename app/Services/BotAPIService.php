<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

final readonly class BotAPIService
{
    private string $api_url;

    private PendingRequest $request;

    public function __construct()
    {
        $this->api_url = config()->string('api.bot.api_url');
        $this->request = Http::withHeaders([
            'Content-Type' => 'application/json',
        ]);
    }

    /**
     * @param  array{visas: array<mixed>}  $data
     */
    public function notify(array $data): void
    {
        $this->request->post($this->api_url.'/notify', $data);
    }
}
