<?php

namespace App\Service;

use App\Logger\TimingLogger;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Stopwatch\Stopwatch;

class TimingTaskService
{
    public function __construct(
        readonly private Stopwatch $stopwatch,
        readonly private EntityManagerInterface $entityManager,
        readonly private TimingLogger $timingLogger
    ) {
    }

    /**
     * Visuel en log du temps de sauvgarde en BDD.
     *
     */
    public function timingEntityManager(string $action, string $section, object $object): void
    {
        $this->stopwatch->start($section);

        $this->entityManager->persist($object);
        $this->entityManager->flush();

        $event = $this->stopwatch->stop($section);
        $duration = round($event->getDuration(), 3);
        $memory = $event->getMemory();
        $this->timingLogger->timingInfoLogger(
            $duration,
            $memory,
            [
            'action'  => $action,
            'section' => $section,
        ]
        );
    }
}
