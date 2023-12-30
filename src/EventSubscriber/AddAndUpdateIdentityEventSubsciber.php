<?php

namespace App\EventSubscriber;

use App\Logger\SecurityLogger;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Event\PostSubmitEvent;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

readonly class AddAndUpdateIdentityEventSubsciber implements EventSubscriberInterface
{
    public function __construct(private SecurityLogger $securityLogger)
    {
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
        $this->securityLogger->securityInfoLog('Ajout info complémentaire de '.$identity->getFirstname().' '.$identity->getLastname());
    }
}
