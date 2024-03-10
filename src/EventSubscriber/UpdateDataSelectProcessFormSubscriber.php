<?php

namespace App\EventSubscriber;

use App\Entity\Group;
use App\Entity\Thematic;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Event\PostSetDataEvent;
use Symfony\Component\Form\FormEvents;

readonly class UpdateDataSelectProcessFormSubscriber implements EventSubscriberInterface
{
    public function __construct(private EntityManagerInterface $em)
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            FormEvents::POST_SET_DATA => 'onFormPreSetData',
        ];
    }

    public function onFormPreSetData(PostSetDataEvent $event): void
    {
        $data = $event->getData();
        $form = $event->getForm();
        $them = $this->em->getRepository(Thematic::class)->findOneBy(['selectionProcess' => $data]);

        if($them instanceof Thematic && $data){
            $form->get('thematic')->setData($them->getName());
            $form->get('description')->setData($them->getDescription());
        }
    }
}
