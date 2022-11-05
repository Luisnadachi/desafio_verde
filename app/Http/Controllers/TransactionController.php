<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionRequest;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function __construct()
    {


    }

    public function pay(TransactionRequest $request)
    {
        $data = $request->validated();
        dump($data);

        Transaction::create($data);
    }

}
