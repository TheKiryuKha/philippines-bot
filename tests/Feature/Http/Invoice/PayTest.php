<?php

declare(strict_types=1);
use App\Enums\InvoiceStatus;
use App\Models\Invoice;

it("return's correct status code", function () {
    $invoice = Invoice::factory()->create();

    $this->patch(
        route('api:v1:invoices:pay', $invoice)
    )
        ->assertStatus(200);
});

it("mark's invoice as Paid", function () {
    $invoice = Invoice::factory()->create();

    $this->patch(
        route('api:v1:invoices:pay', $invoice)
    );

    $this->assertDatabaseHas('invoices', [
        'id' => $invoice->id,
        'status' => InvoiceStatus::Paid,
    ]);
});
