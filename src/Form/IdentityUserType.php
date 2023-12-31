<?php

namespace App\Form;

use App\Entity\Identity;
use App\EventSubscriber\AddAndUpdateIdentityEventSubsciber;
use App\Logger\SecurityLogger;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class IdentityUserType extends AbstractType
{
    public function __construct(
        readonly private SecurityLogger $securityLogger,
        readonly private RequestStack $requestStack
    )
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
            ->add('avatar', FileType::class, [
                'label' => 'Ajouter votre avatar',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'maxSizeMessage' => 'Votre image est trop lourde ({{ size }} {{ suffix }}).Taille maximum est de {{ limit }} {{ suffix }}.',
                        'extensions' => ['png', 'jpg', 'jpeg', 'gif'],
                        'extensionsMessage' => "L'extension du fichier n'est pas valide ({{ extension }}). Les extensions autorisées sont {{ extensions }}.",
                        'filenameMaxLength' => 30,
                        'filenameTooLongMessage' => 'Le nom de fichier est trop long. Il doit contenir {{ filename_max_length }} caractères ou moins.'
                    ])
                ],
                'help' => 'Attention veuillez definir un court nom a vos fichier maximum 30 caractères'
            ])
            ->addEventSubscriber(new AddAndUpdateIdentityEventSubsciber($this->securityLogger, $this->requestStack));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Identity::class,
        ]);
    }
}
