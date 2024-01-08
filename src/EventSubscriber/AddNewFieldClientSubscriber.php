<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class AddNewFieldClientSubscriber implements EventSubscriberInterface
{

    /**
     * @inheritDoc
     */
    #[\Override] public static function getSubscribedEvents()
    {
        return [ FormEvents::PRE_SUBMIT => 'onPreSubmit' ];
    }

    public function onPreSubmit(FormEvent $event): void
    {
        $client = $event->getData();
        $form = $event->getForm();

        $labelAttr = ['class' => 'block text-base text-gray-700'];

        if(isset($client['contactEmail']) && $client['contactEmail']){
            $form->add('plainPassword', PasswordType::class, [
                'label'       => 'Mot de passe',
                'label_attr'  => $labelAttr,
                'mapped'      => false,
                'attr'        => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir un mot de passe',
                    ]),
                    new Length([
                        'min'        => 8,
                        'minMessage' => 'Votre mot de passe doit comporter au moins {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max'        => 4096,
                    ]),
                ],
            ]);
        }
    }
}