<?php

namespace App\Logger;

use Psr\Log\LoggerInterface;

class TimingLogger
{
    public function __construct(readonly private LoggerInterface $timingLogger)
    {}

    public function timingInfoLogger(int|float $duration, int $memory, array $data = []): void
    {
        $this->timingLogger->info('Temps d\'exécution : '.$duration.' ms | Mémoire utilisée : '.$memory.' bytes', $data);
    }
}