<?php

namespace App\EventSubscriber;

use App\Entity\Group;
use App\Entity\Thematic;
use Doctrine\DBAL\Types\TextType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Event\PostSetDataEvent;
use Symfony\Component\Form\Event\PreSetDataEvent;
use Symfony\Component\Form\FormEvent;
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
        $group = $this->em->getRepository(Group::class)->findOneBy(['thematic' => $them ]);

        if($them instanceof Thematic && $group instanceof Group && $data){
            $form->get('thematic')->setData($them->getName());
            $form->get('description')->setData($them->getDescription());
            $form->get('groups')->setData(count($them->getGroups()));
            $form->get('maxPersonByGroup')->setData($group->getMaxPersonByGroup());
        }
    }
}
