<?php

namespace App\Services;

use App\Clients\CourierClient;
use App\Clients\TransactionClient;
use App\Exceptions\WalletException;
use App\Exceptions\InvalidPayerException;
use App\Exceptions\InvalidTransactionException;
use App\Exceptions\TimeoutEmailException;
use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Support\Facades\DB;
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

    public function sendPayment($data): Transaction
    {
        return DB::transaction(function () use($data){
            $payerWallet = Wallet::query()->find($data['payer_id']);
            $payeeWallet = Wallet::query()->find($data['payee_id']);

            if ($payerWallet->shopkeeper) {
                throw InvalidPayerException::shopkeeperCanNotTransfer();
            }

            if ($payerWallet->balance < $data['amount']) {
                throw WalletException::insufficientFunds();
            }

            if ($this->client->verify() != "Autorizado") {
                throw InvalidTransactionException::unauthorizedTransaction();
            }

            $payerWallet->update(['balance' => $payerWallet->balance - $data['amount']]);
            $payeeWallet->update(['balance' => $payeeWallet->balance + $data['amount']]);

            $transaction = Transaction::create($data);

            if ($this->courier->notifyEmail() != "Success") {
                throw TimeoutEmailException::providerTimeout();
            }

            return $transaction;
        });
    }
}
