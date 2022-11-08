<?php

namespace App\Exceptions;

use Symfony\Component\HttpFoundation\Response;

class InvalidPayerException extends \Exception
{

    public static function shopkeeperCanNotTransfer(): InvalidPayerException
    {
        return new static('Lojista não pode transferir!', Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
