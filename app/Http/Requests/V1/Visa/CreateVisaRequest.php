<?php

declare(strict_types=1);

namespace App\Http\Requests\V1\Visa;

use Illuminate\Foundation\Http\FormRequest;

final class CreateVisaRequest extends FormRequest
{
    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => ['required', 'int', 'exists:users,id', 'unique:visas,id'],
            'expiration_date' => ['required', 'date_format:d.m.Y'],
        ];
    }
}
