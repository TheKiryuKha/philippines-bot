<?php

declare(strict_types=1);

namespace App\Actions\Visa;

use App\Models\Visa;

final readonly class ExtendVisaAction
{
    public function handle(Visa $visa): Visa
    {
        $visa->update([
            'expiration_date' => $visa->expiration_date->addMonth(),
        ]);

        return $visa;
    }
}
