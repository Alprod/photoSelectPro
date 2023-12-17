<?php

namespace App\Logger;

use Psr\Log\LoggerInterface;

class SecurityLogger
{
    public function __construct(readonly private LoggerInterface $securityLogger)
    {
    }

    public function securityErrorLog(string $message, array $context = []): void
    {
        $this->securityLogger->error($message, $context);
    }

    public function securityInfoLog(string $message): void
    {
        $this->securityLogger->info($message);
    }
}
