<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $labelAttr = ['class' => 'block text-base text-gray-700'];
        $builder
            ->add('email', EmailType::class, [
                'label'      => 'Email',
                'label_attr' => $labelAttr,
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'label'       => 'Ok avec les terms',
                'label_attr'  => $labelAttr,
                'mapped'      => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez accepter nos conditions.',
                    ]),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
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
            ])
            ->add('refClientNumber', TextType::class, [
                'label'       => 'Référence',
                'label_attr'  => $labelAttr,
                'mapped'      => false,
                'required'    => false,
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez indiquer la référence transmit par mail de votre formateur ou entreprise']),
                ],
                'help'        => 'Veuillez indiquer le numéro de reference transmis par mail',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
