<?php

namespace App\Form;

use App\Entity\Client;
use App\EventSubscriber\AddNewFieldClientSubscriber;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

use function Sodium\add;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom entreprise ou Formateur',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Il nous faut un nom d\'entreprise ou de formateur'
                    ])
                ],
                'required' => false
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'attr' => [
                    'placeholder' => 'Une petit description serai sympas...',
                    'rows' => 10
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Une petit description serait sympas'
                    ]),
                    new Length([
                        'min' => 50,
                        'minMessage' => 'Il me faut au moins {{ limit }} caractères.'
                    ])
                ],
                'required' => false
            ])
            ->add('contactName', TextType::class, [
                'label' => 'Nom et Prénom',
                'help' => 'exemple: Dupont John',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Il nous faut un nom et un prénom'
                    ])
                ],
                'required' => false
            ])
            ->add('contactEmail', EmailType::class, [
                'label' => 'Votre mail pro',
                'constraints' => [
                    new NotBlank([
                        'message' => 'L\'email j\'en est besoin'
                    ])
                ],
                'required' => false
            ])
            ->addEventSubscriber(new AddNewFieldClientSubscriber())
            ->add('submit', SubmitType::class, [
                'attr' => ['class' => 'btn-primary max-w-md']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
