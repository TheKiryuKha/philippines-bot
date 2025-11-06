<?php

declare(strict_types=1);

namespace App\Http\Requests\V1\Invoice;

use Illuminate\Foundation\Http\FormRequest;

final class CreateInvoiceRequest extends FormRequest
{
    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'cart_id' => ['required', 'exists:carts,id'],
            'first_name' => ['required', 'string', 'min:2', 'max:32'],
            'last_name' => ['required', 'string', 'min:2', 'max:32'],
            'middle_name' => ['required', 'string', 'min:2', 'max:32'],
            'delivery_address' => ['required', 'string', 'min:2', 'max:100'],
            'phone' => ['required', 'string', 'min:2', 'max:32'],
        ];
    }

    /**
     * @return array{
     * cart_id: int,
     * first_name: string,
     * last_name: string,
     * middle_name: string,
     * delivery_address: string,
     * phone: string
     * }
     */
    public function validated($key = null, $default = null): array
    {
        /** @var array{
         * cart_id: int,
         * first_name: string,
         * last_name: string,
         * middle_name: string,
         * delivery_address: string,
         * phone: string
         * }
         * */
        $data = parent::validated($key, $default);

        return $data;
    }
}
