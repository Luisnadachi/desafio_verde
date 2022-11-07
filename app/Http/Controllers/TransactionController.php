<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionRequest;
use App\Services\TransactionService;

class TransactionController extends Controller
{
    private TransactionService $service;

    public function __construct(TransactionService $service)
    {
        $this->service = $service;
    }

    public function pay(TransactionRequest $request)
    {
        $data = $request->validated();
        try {
            $this->service->enviandoDinheiroPraPessoa($data);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage(), 'code' => $e->getCode()]);
        }
    }

}
