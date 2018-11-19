<?php
/**
 * Created by PhpStorm.
 * User: KevinPC
 * Date: 16-11-2018
 * Time: 23:43
 */

namespace App\Api\Exceptions;

use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class InvalidCredentialsException extends UnauthorizedHttpException
{
    public function __construct($message = null, \Exception $previous = null, $code = 0)
    {
        parent::__construct('', $message, $previous, $code);
    }
}