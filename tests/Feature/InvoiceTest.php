<?php

use App\Enums\InvoiceTypeEnum;
use App\Models\Invoice;
use App\Models\Tenant;
use App\Models\User;

beforeEach(function() {

});

test('set invoice type to session and redirect to create', function () {
    $user = User::factory()->create();

    @unlink(base_path("dbs/tenant_testing.sqlite"));
    $tenant = \App\Models\Tenant::create(['id'=>'testing','email'=>'test@test.test']);
    $tenant->createDomain("localhost");
    tenancy()->initialize($tenant);

    $config = \App\Models\Config::factory()->create();

    /**
     * \Tests\TestCase $this
     */
    $response = $this->actingAs($user)
            ->get('/invoices/create/'. InvoiceTypeEnum::Debit->value);

    $response->assertStatus(302);
    $response->assertRedirect("/invoices/create");
    $response->assertSessionHas("invoice.type", InvoiceTypeEnum::Debit->value);
});

test('mark invoice as paid updates paid flag and redirects to invoices index', function () {
    $user = User::factory()->create();

    @unlink(base_path("dbs/tenant_testing.sqlite"));
    $tenant = \App\Models\Tenant::create(['id' => 'testing', 'email' => 'test@test.test']);
    $tenant->createDomain("localhost");
    tenancy()->initialize($tenant);

    \App\Models\Config::factory()->create();

    $invoice = Invoice::create([
        'invoice_type' => InvoiceTypeEnum::Debit->value,
        'invoice_series' => 'SF',
        'invoice_number' => 1,
        'contrahent_name' => 'UAB Testas',
        'contrahent_code' => '123456789',
        'contrahent_address' => 'Vilnius',
        'invoice_author' => 'Admin',
        'document_date' => '2024-07-17',
        'paid' => false,
    ]);

    expect($invoice->paid)->toBeFalse();

    $response = $this->actingAs($user)
        ->patch('/invoices/' . $invoice->id . '/pay');

    $response->assertStatus(302);
    $response->assertRedirect('/invoices');

    expect($invoice->fresh()->paid)->toBeTrue();
});
