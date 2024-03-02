<?php

namespace App\EventSubscriber;

use App\Logger\SecurityLogger;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\KernelEvents;

readonly class AccessDeniedExceptionSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private SecurityLogger $securityLogger,
        private Security $security
    )
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException',
        ];
    }
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        $user = $this->security->getUser();
        if ($exception instanceof AccessDeniedHttpException){
            $this->securityLogger->securityErrorLog('Accés non autorisé',[
                'code' => Response::HTTP_FORBIDDEN,
                'userCurrent' => $user?->getUserIdentifier()
                ]);
        }
    }

}
