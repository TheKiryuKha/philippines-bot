<?php

declare(strict_types=1);

namespace App\Http\Requests\V1\Invoice;

use Illuminate\Foundation\Http\FormRequest;

final class GetCitiesRequest extends FormRequest
{
    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'city' => ['required', 'string', 'min:1', 'max:32'],
        ];
    }
}
