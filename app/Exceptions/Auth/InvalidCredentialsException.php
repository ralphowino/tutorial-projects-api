<?php

namespace App\Exceptions\Auth;


use Symfony\Component\HttpKernel\Exception\HttpException;

class InvalidCredentialsException extends HttpException
{
    public function __construct($message = 'Invalid credentials provided', \Exception $previous = null, array $headers = array(), $code = 0)
    {
        parent::__construct(401, $message, $previous, $headers, $code);
    }

}