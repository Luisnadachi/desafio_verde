<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Wallet;
use Tests\TestCase;

class TransactionControllerTest extends TestCase
{

    public function testUsuarioEfetuouPagamentoComSucesso()
    {
        $this->withoutExceptionHandling();
        // Assign
        $payer = User::factory()->has(Wallet::factory())->create();
        $payee = User::factory()->has(Wallet::factory())->create();


        $body = [
            "amount" => 123,
            "payer_id" => $payer->wallet->id,
            "payee_id" => $payee->wallet->id,
        ];

        // Act
        $response = $this->post(route('transaction.pay'), $body);

        // Assert
        $response->assertOk();
        $this->assertDatabaseHas('transactions', $body);
    }


}
