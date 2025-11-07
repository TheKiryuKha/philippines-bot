<?php

declare(strict_types=1);

namespace App\Http\Requests\V1\Visa;

use App\Rules\OneVisaForUser;
use Illuminate\Foundation\Http\FormRequest;

final class CreateVisaRequest extends FormRequest
{
    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'chat_id' => ['required', 'int', 'exists:users,chat_id', new OneVisaForUser],
            'expiration_date' => ['required', 'date_format:d.m.Y'],
        ];
    }

    /**
     * @return array{chat_id: int, expiration_date: string}
     */
    public function validated($key = null, $default = null): array
    {
        /**
         * @var array{
         * chat_id: int,
         * expiration_date: string
         * } $data
         */
        $data = parent::validated($key, $default);

        return $data;
    }
}
