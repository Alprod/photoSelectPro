<?php

namespace App\EventSubscriber;

use App\Logger\SecurityLogger;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Event\PostSubmitEvent;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\RequestStack;

readonly class AddAndUpdateIdentityEventSubsciber implements EventSubscriberInterface
{
    public function __construct(
        private SecurityLogger $securityLogger,
        private RequestStack $requestStack
    ) {
    }

    #[\Override] public static function getSubscribedEvents(): array
    {
        return [
            FormEvents::PRE_SET_DATA => 'onPreSetData',
            FormEvents::POST_SUBMIT  => 'onPostSubmit',
        ];
    }

    public function onPreSetData(FormEvent $event): void
    {
        $identity = $event->getData();

        if (!$identity) {
            $this->securityLogger->securityInfoLog('Nouvelle info complémentaire');
        } else {
            $this->securityLogger->securityInfoLog('MAJ info complémentaire de '.$identity->getFirstname().' '.$identity->getLastname());
        }
    }

    public function onPostSubmit(PostSubmitEvent $event): void
    {
        $identity = $event->getData();
        $form = $event->getForm();
        $errorAvatar = $form->get('avatar')->getErrors();

        if (count($errorAvatar) > 0) {
            $this->requestStack->getSession()->getFlashBag()->add('danger', $errorAvatar->current()->getMessage());
        }
        $this->securityLogger->securityInfoLog('Ajout info complémentaire de '.$identity->getFirstname().' '.$identity->getLastname());
    }
}
