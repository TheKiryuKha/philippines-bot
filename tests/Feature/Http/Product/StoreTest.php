<?php

declare(strict_types=1);

use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

it("return's correct status code", function () {
    $this->post(
        route('api:v1:products:store'), get_product_data()
    )->assertStatus(
        201
    );
});

it("save's product's data in DB", function () {
    $data = get_product_data();

    $this->post(route('api:v1:products:store'), $data);

    $this->assertDatabaseHas('products', ['title' => $data['title']]);
});

it("save's media", function () {
    Storage::fake();

    $this->post(route('api:v1:products:store'), get_product_data());

    expect(Product::first()->getFirstMedia('image'))
        ->toBeInstanceOf(Media::class);
});

test('validation', function () {
    $response = $this->post(route('api:v1:products:store'));

    $response->assertInvalid([
        'image_link',
        'title',
        'description',
        'price',
    ]);
});
