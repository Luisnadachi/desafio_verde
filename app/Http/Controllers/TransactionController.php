<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidPayerException;
use App\Exceptions\InvalidTransactionException;
use App\Exceptions\TimeoutEmailException;
use App\Exceptions\WalletException;
use App\Http\Requests\TransactionRequest;
use App\Services\TransactionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class TransactionController extends Controller
{
    private TransactionService $service;

    public function __construct(TransactionService $service)
    {
        $this->service = $service;
    }

    public function pay(TransactionRequest $request): JsonResponse
    {
        $data = $request->validated();
        try {
            return response()->json($this->service->sendPayment($data), Response::HTTP_CREATED);
        } catch (InvalidPayerException|WalletException|InvalidTransactionException|TimeoutEmailException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        } catch (\Exception $e) {
            Log::error('Falha ao processar a transação!', [
                'message' => $e->getMessage(),
                'trace' => $e->getTrace(),
            ]);
            return response()->json(['message' => 'Houve um erro inesperado, tente novamente mais tarde!'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}
