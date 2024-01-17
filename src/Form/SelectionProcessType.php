<?php

namespace App\Form;

use App\Entity\SelectionProcess;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\LessThan;
use Symfony\Component\Validator\Constraints\NotBlank;

class SelectionProcessType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Titre du parcours de sélection'
            ])
            ->add('startDate', DateTimeType::class, [
                'label' => 'Date de debut',
            ])
            ->add('endDate', DateTimeType::class, [
                'label' => 'Date de fin',
                'constraints' => [
                    new GreaterThanOrEqual([
                        'propertyPath' => 'parent.all[startDate].data',
                        'message' => 'La date de fin du {{ value }} doit être égale ou après la date de début.'
                    ])
                ]
            ])
            ->add('thematic', TextType::class, [
                'label' => 'Indiquez le Theme de votre parcours de sélection',
                'required' => false,
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez indiquer une Thematique à votre parcours'
                    ])
                ]
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description de la thematique',
                'required' => false,
                'mapped' => false,
                'attr' => ['rows' => 10],
                'help' => 'Une petite description de la thematique donnerai le ton au parcours de sélection',

            ])
            ->add('groups', IntegerType::class, [
                'label' => 'Nombre de groupe',
                'required' => false,
                'mapped' => false,
                'help' => 'Combien de groupe sera composé le parcour de sélection, afin que les binômes puissent s\'y répartir',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Pour la suite du parcours il me faut le nombre totale de groupe'
                    ])
                ]
            ])
            ->add('maxPersonByGroup', NumberType::class, [
                'label' => 'Nombre max par groupe',
                'required' => false,
                'mapped' => false,
                'help' => 'Indique un nombre maximale de binômes|participants dans un groupe afin d\'éviter une surcharge des groupes',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Pour la suite du parcours il me faut le nombre totale de binômes|participants par groupe'
                    ])
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SelectionProcess::class,
        ]);
    }
}