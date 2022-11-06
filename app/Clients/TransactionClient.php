<?php

namespace App\Clients;

use Illuminate\Support\Facades\Http;

class TransactionClient
{

    public function verify(): string
    {
        $response = Http::get('https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6');
        return $response->json('message');
    }

}
