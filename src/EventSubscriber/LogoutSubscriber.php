<?php

namespace App\EventSubscriber;

use App\Service\MessageGeneratorService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Http\Event\LogoutEvent;

readonly class LogoutSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private UrlGeneratorInterface $urlGenerator,
        private MessageGeneratorService $messageGenerator
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public static function getSubscribedEvents(): array
    {
        return [LogoutEvent::class => 'onLogout'];
    }

    public function onLogout(LogoutEvent $event): void
    {
        $session = $event->getRequest()->getSession();

        /* @phpstan-ignore-next-line */
        $session->getFlashBag()->add('success', $this->messageGenerator->getMessageLogout());
        $response = new RedirectResponse(
            $this->urlGenerator->generate('app_home'),
            RedirectResponse::HTTP_SEE_OTHER
        );

        $event->setResponse($response);
    }
}
