<?php

namespace App\Clients;


use Illuminate\Support\Facades\Http;

class CourierClient
{

    public function notifyEmail(): string
    {
        $response = Http::get('http://o4d9z.mocklab.io/notify');
        return $response->json('message');
    }

}
