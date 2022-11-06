<?php

namespace Tests\Feature;

use App\Models\Shopkeeper;
use App\Models\User;
use App\Models\Wallet;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class TransactionControllerTest extends TestCase
{

    public function testUsuarioEfetuouPagamentoComSucessoParaOutraCarteira()
    {
        // Assign
        $payer = User::factory()->has(Wallet::factory()->state(['balance' => 500]))->create();
        $payee = User::factory()->has(Wallet::factory())->create();


        $body = [
            "amount" => 200,
            "payer_id" => $payer->wallet->id,
            "payee_id" => $payee->wallet->id,
        ];

        // Act
        $response = $this->post(route('transaction.pay'), $body);

        // Assert
        $response->assertOk();
        $this->assertDatabaseHas('transactions', $body);
        $this->assertDatabaseHas('wallets', [
            'id' => $payer->wallet->id,
            'balance' => ($payer->wallet->balance - $body['amount'])
        ]);

        $this->assertDatabaseHas('wallets', [
            'id' => $payee->wallet->id,
            'balance' => ($payee->wallet->balance + $body['amount'])
        ]);
    }

    public function testUmLojistaTentaTransferir()
    {
        // Assign

        $payer = Shopkeeper::factory()->has(Wallet::factory())->create();
        $payee = User::factory()->has(Wallet::factory())->create();

        $body = [
            "amount" => 123,
            "payer_id" => $payer->wallet->id,
            "payee_id" => $payee->wallet->id,
        ];

        // Act

        $response = $this->post(route('transaction.pay'), $body);

        // Assert

        $response->assertUnprocessable();
    }

    public function testUsuarioNãoTemSaldoSuficiente()
    {
        // Assign
        $payer = User::factory()->has(Wallet::factory())->create();
        $payee = User::factory()->has(Wallet::factory())->create();

        $body = [
            "amount" => 999999,
            "payer_id" => $payer->wallet->id,
            "payee_id" => $payee->wallet->id,
        ];

        // Act

        $response = $this->post(route('transaction.pay'), $body);

        // Assert
        $response->assertStatus(Response::HTTP_NOT_ACCEPTABLE);

    }

    public function testInconsistenciaNaTransacao()
    {

    }

    public function testEnviadaNotificacaoParaORecebedor()
    {

    }

}
