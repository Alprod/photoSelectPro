<?php

namespace App\Logger\Processor;

use Monolog\LogRecord;
use Monolog\Processor\ProcessorInterface;
use Symfony\Component\HttpFoundation\Exception\SessionNotFoundException;
use Symfony\Component\HttpFoundation\RequestStack;

class SessionRequestProcessor implements ProcessorInterface
{
    public function __construct(readonly private RequestStack $requestStack)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function __invoke(LogRecord $record): LogRecord
    {
        try {
            $session = $this->requestStack->getSession();
        } catch (SessionNotFoundException $e) {
            return $record;
        }

        if (!$session->isStarted()) {
            return $record;
        }
        $sessionId = substr($session->getId(), 0, 8) ?: '????????';
        $record->extra['token'] = $sessionId.'-SessionId-'.substr(uniqid('', true), -8);

        return $record;
    }
}
