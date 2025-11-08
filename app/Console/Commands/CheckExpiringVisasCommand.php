<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Visa;
use App\Queries\GetExpiringVisas;
use App\Services\BotAPIService;
use Illuminate\Console\Command;

final class CheckExpiringVisasCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'check-visas';

    /**
     * @var string
     */
    protected $description = "It check's expiring visas and send POST request to telegram bot api";

    /**
     * Execute the console command.
     */
    public function handle(GetExpiringVisas $query, BotAPIService $service): void
    {
        $visas = $query->handle();

        $data = [
            'visas' => $visas->map(fn (Visa $visa): array => [
                'chat_id' => (string) $visa->user->chat_id,
                'time_until_expiration' => $visa->expiration_date->diffForHumans(),
            ])->toArray(),
        ];

        $service->notify($data);
    }
}
