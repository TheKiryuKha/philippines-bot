<?php

declare(strict_types=1);

namespace App\Actions\Visa;

use App\Models\User;
use App\Models\Visa;
use Illuminate\Support\Facades\DB;

final readonly class CreateVisaAction
{
    /**
     * @param  array{chat_id: int, expiration_date: string}  $attr
     */
    public function handle(array $attr): Visa
    {
        return DB::transaction(function () use ($attr): Visa {

            $user = User::findByChatId($attr['chat_id']);

            return $user->visa()->create([
                'expiration_date' => $attr['expiration_date'],
            ]);
        });
    }
}
