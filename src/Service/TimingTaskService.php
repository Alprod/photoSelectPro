<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Stopwatch\Stopwatch;

class TimingTaskService
{
    public function __construct(
        readonly private Stopwatch $stopwatch,
        readonly private LoggerInterface $timingLogger,
        readonly private EntityManagerInterface $entityManager
    ) {
    }

    public function timingEntityManager(string $section, object $object): void
    {
        $this->stopwatch->start($section);

        $this->entityManager->persist($object);
        $this->entityManager->flush();

        $event = $this->stopwatch->stop($section);
        $duration = round($event->getDuration(), 3);
        $memory = $event->getMemory();
        $this->timingLogger->info('Temps d\'exécution : '.$duration.' ms | Mémoire utilisée : '.$memory.' bytes', [
            'action'  => 'Register',
            'section' => $section,
        ]);
    }
}
