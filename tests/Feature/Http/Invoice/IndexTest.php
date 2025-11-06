<?php

declare(strict_types=1);
use App\Models\Invoice;

it("return's correct status code", function () {
    $this->get(
        route('api:v1:invoices:index')
    )->assertStatus(
        200
    );
});

it("return's correct data", function () {
    Invoice::factory(3)->withItems()->create();

    $this->get(
        route('api:v1:invoices:index')
    )
        ->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'type',
                    'attributes' => [
                        'user_chat_id',
                        'username',
                        'first_name',
                        'last_name',
                        'middle_name',
                        'delivery_address',
                        'phone',
                        'price',
                        'formatted_price',
                        'items' => [
                            '*' => [
                                'id',
                                'attributes' => [
                                    'amount',
                                    'title',
                                    'description',
                                    'option_id',
                                    'price',
                                    'formatted_price',
                                    'total_price',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ]);
});

test('filter[status]=paid', function () {
    Invoice::factory()->paid()->create();
    Invoice::factory()->create();

    $response = $this->get(
        route('api:v1:invoices:index').'?filter[status]=paid'
    );

    $response->assertJsonCount(1, 'data');
});
