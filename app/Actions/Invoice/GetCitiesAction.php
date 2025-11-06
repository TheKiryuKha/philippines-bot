<?php

declare(strict_types=1);

namespace App\Actions\Invoice;

use App\Services\CDEKAPIService;

final readonly class GetCitiesAction
{
    public function __construct(
        private CDEKAPIService $service
    ) {}

    /**
     * @return array<array{city: string, code: int}>
     */
    public function handle(string $city): array
    {
        $response = $this->service->getCities($city);

        $cities = [];

        foreach ($response as $city) {
            $cities[] = [
                'city' => $city->getCountry().', '.$city->getRegion().', '.$city->getCity(),
                'code' => $city->getCode(),
            ];
        }

        return $cities;
    }
}
