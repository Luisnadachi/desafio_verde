<?php

namespace App\Exceptions;

use Symfony\Component\HttpFoundation\Response;

class TimeoutEmailException extends \Exception
{

    public static function providerTimeout(): TimeoutEmailException
    {
        return new static('Tempo limite expirado!', Response::HTTP_REQUEST_TIMEOUT);
    }

}
