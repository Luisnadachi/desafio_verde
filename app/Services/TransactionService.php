<?php

namespace App\Services;

use App\Clients\CourierClient;
use App\Clients\TransactionClient;
use App\Models\Transaction;
use App\Models\Wallet;
use Symfony\Component\HttpFoundation\Response;

class TransactionService
{
    private TransactionClient $client;
    private CourierClient $courier;

    public function __construct(TransactionClient $client, CourierClient $courier)
    {
        $this->client = $client;
        $this->courier = $courier;
    }

    public function enviandoDinheiroPraPessoa($data)
    {
        $payerWallet = Wallet::query()->find($data['payer_id']);
        $payeeWallet = Wallet::query()->find($data['payee_id']);

        try {
            if ($payerWallet->shopkeeper) {
                throw new \Exception('Lojista não pode transferir!', Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        } catch (\Exception $e) {
            return $e->getMessage() . $e->getCode();
        }

        try {
            if ($payerWallet->balance < $data['amount']) {
                throw new \Exception('Saldo insuficiente!', Response::HTTP_NOT_ACCEPTABLE);
            }
        } catch (\Exception $e) {
            return $e->getMessage() . $e->getCode();
        }

        try {
            if ($this->client->verify() != "Autorizado") {
                throw new \Exception('Transação não autorizada!', Response::HTTP_UNAUTHORIZED);
            }
        } catch (\Exception $e) {
            return $e->getMessage() . $e->getCode();
        }

        Wallet::query()->find($data['payer_id'])
            ->update(['balance' => $payerWallet->balance - $data['amount']]);
        Wallet::query()->find($data['payee_id'])
            ->update(['balance' => $payeeWallet->balance + $data['amount']]);

        Transaction::create($data);

        try {
            if ($this->courier->notifyEmail() != "Success") {
                throw new \Exception('Tempo limite expirado!', Response::HTTP_REQUEST_TIMEOUT);
            }
        } catch (\Exception $e) {
            return $e->getMessage() . $e->getCode();
        }
    }
}
