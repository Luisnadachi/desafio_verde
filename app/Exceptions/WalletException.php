<?php

namespace App\Exceptions;

use Symfony\Component\HttpFoundation\Response;

class WalletException extends \Exception
{

    public static function insufficientFunds(): WalletException
    {
        return new static('Saldo insuficiente!', Response::HTTP_NOT_ACCEPTABLE);
    }
}
