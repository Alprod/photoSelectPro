<?php

namespace App\Form;

use App\Entity\Identity;
use App\EventSubscriber\AddAndUpdateIdentityEventSubsciber;
use App\Logger\SecurityLogger;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class IdentityUserType extends AbstractType
{
    public function __construct(readonly private SecurityLogger $securityLogger)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Nom',
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Prénom',
            ])
            ->add('gender', ChoiceType::class, [
                'label'       => 'Genre',
                'choices'     => [
                    'Femme'        => 'f',
                    'Homme'        => 'H',
                    'Non-binaire'  => 'N-Bi-R',
                    'Agenre'       => 'A-genre',
                    'Bigenre'      => 'B-genre',
                    'Fluide'       => 'fluide',
                    'Queer'        => 'Q',
                    'Non conforme' => 'N-conf',
                    'Deux-spirit'  => 'D-spirit',
                    'DemiBoy'      => 'D-B',
                    'DemiGril'     => 'D-G',
                    'Neutre'       => 'neutre',
                    'Androgyne'    => 'androgyne',
                    'Tiers-genre'  => 'T-genre',
                ],
                'placeholder' => 'Choisir votre genre...',
            ])
            ->add('service', TextType::class, [
                'label' => 'Votre Service',
            ])
            ->add('job', TextType::class, [
                'label' => 'Poste Actuel',
            ])
            ->addEventSubscriber(new AddAndUpdateIdentityEventSubsciber($this->securityLogger));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Identity::class,
        ]);
    }
}
