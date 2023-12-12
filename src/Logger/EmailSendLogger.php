<?php

namespace App\Logger;

use Psr\Log\LoggerInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

class EmailSendLogger
{
    public function __construct(readonly private LoggerInterface $emailSendLogger)
    {}

    public function emailSendError(string $message, TransportExceptionInterface $te,string $emailUser): void
    {
        $this->emailSendLogger->error($message, [
            'Email user' => $emailUser,
            'Message' => $te->getMessage(),
            'Code' => $te->getCode(),
            'File' => $te->getFile(),
            'Line' => $te->getLine()
        ]);
    }

    public function emailSendInfo(string $message, string $userMail): void
    {
        $this->emailSendLogger->info($message, ['user mail' => $userMail]);
    }
}