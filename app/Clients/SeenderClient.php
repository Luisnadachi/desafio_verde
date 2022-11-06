<?php

namespace App\Clients;


use Illuminate\Support\Facades\Http;

class SeenderClient
{

    public function send()
    {
        $response = Http::get('http://o4d9z.mocklab.io/notify');
        return $response->json('message');
    }

}
