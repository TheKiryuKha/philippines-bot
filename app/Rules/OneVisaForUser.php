<?php

declare(strict_types=1);

namespace App\Rules;

use App\Models\User;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

final class OneVisaForUser implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  int  $value
     * @param  Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $chat_id = (int) $value;
        $user = User::findByChatId($chat_id);

        if ($user->visa()->count() !== 0) {
            $fail('user can have only 1 visa');
        }
    }
}
