<?php

namespace App\Form;

use App\Entity\Group;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class GroupType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom du groupe',
                'help' => 'Faite au plus simple pour les noms de groupe exemple: Groupe 1',
                'required' => false
            ])
            ->add('maxPersonByGroup', NumberType::class, [
                'label' => 'Personne par groupe',
                'help' => 'Indique un nombre maximale de binômes|participants dans un groupe afin d\'éviter une surcharge des groupes',
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Group::class,
        ]);
    }
}
