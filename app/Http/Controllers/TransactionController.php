<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionRequest;
use App\Models\Transaction;
use App\Models\Wallet;
use Symfony\Component\HttpFoundation\Response;

class TransactionController extends Controller
{
    public function pay(TransactionRequest $request)
    {
        $data = $request->validated();
        try {
            $payerWallet = Wallet::query()->find($data['payer_id']);
            $payeeWallet = Wallet::query()->find($data['payee_id']);

            if ($payerWallet->shopkeeper){
                return response([
                    'message' => 'Lojista não pode transferir!',
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            if ($payerWallet->balance < $data['amount']){
                return response([
                    'message' => 'Saldo insuficiente!',
                ], Response::HTTP_NOT_ACCEPTABLE);
            }

            Wallet::query()->find($data['payer_id'])
                ->update(['balance' => $payerWallet->balance - $data['amount']]);
            Wallet::query()->find($data['payee_id'])
                ->update(['balance' => $payeeWallet->balance + $data['amount']]);

            Transaction::create($data);
        } catch (\Exception $e){
            return response()->json(['message' => $e->getMessage(), 'code' => $e->getCode()]);
        }
    }

}
