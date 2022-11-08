<?php

namespace App\Exceptions;

use Symfony\Component\HttpFoundation\Response;

class InvalidTransactionException extends \Exception
{

    public static function unauthorizedTransaction(): InvalidTransactionException
    {
        return new static ('Transação não autorizada!', Response::HTTP_UNAUTHORIZED);
    }

}
