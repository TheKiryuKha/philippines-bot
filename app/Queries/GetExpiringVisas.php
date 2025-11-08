<?php

declare(strict_types=1);

namespace App\Queries;

use App\Models\Visa;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

final readonly class GetExpiringVisas
{
    /**
     * @return Collection<int, Visa>
     */
    public function handle(): Collection
    {
        $target_dates = [
            Carbon::today()->addWeeks(2)->format('Y-m-d'),
            Carbon::today()->addWeek()->format('Y-m-d'),
            Carbon::today()->addDay()->format('Y-m-d'),
        ];

        return Visa::whereIn('expiration_date', $target_dates)->get();
    }
}
