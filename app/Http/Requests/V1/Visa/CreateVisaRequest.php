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
}
