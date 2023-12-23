<?php

namespace App\Exception;

use Symfony\Component\Security\Core\Exception\AuthenticationException;

class AccountNotVerifeidAuthenticationException extends AuthenticationException
{
    public function __construct(string $message = "", int $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function setMessageKey(string $message): void
    {
        $this->message = $message;
    }

    public function getMessageKey(): string
    {
        return $this->message;
    }

}