<?php

namespace App\Controller;

use App\Entity\Identity;
use App\Entity\User;
use App\Form\ChangePasswordType;
use App\Form\IdentityUserType;
use App\Repository\UserRepository;
use App\Service\MessageGeneratorService;
use App\Service\TimingTaskService;
use App\Service\Uploader\AvatarUploadFile;
use Doctrine\ORM\EntityManagerInterface;
use Random\RandomException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    public function __construct(
        readonly private TimingTaskService $timingTask,
        readonly private EntityManagerInterface $entity,
        readonly private MessageGeneratorService $messageGenerator
    ) {
    }

    /**
     * @throws RandomException
     */
    #[Route('/profile/{id}', name: 'app_user')]
    public function index(User $id, Request $request, AvatarUploadFile $avatarUploadFile): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Veuillez vous connectez si vous souhaitez avoir accès au contenu');
        $repo = $this->entity->getRepository(Identity::class);
        $newIdentity = $repo->findOneBy(['userIdentity' => $id]);

        if (!$newIdentity) {
            $newIdentity = new Identity();
        }
        $identityForm = $this->createForm(IdentityUserType::class, $newIdentity);
        $identityForm->handleRequest($request);

        if ($identityForm->isSubmitted() && $identityForm->isValid()) {
            $newIdentity->setUserIdentity($id);
            /** @var UploadedFile $avatarFile */
            $avatarFile = $identityForm->get('avatar')->getData();

            /* @phpstan-ignore-next-line */
            if ($avatarFile) {
                $newFilename = $avatarUploadFile->upload($avatarFile, 'avatar', 'app_user', ['id' => $id->getId()]);
                $newIdentity->setAvatarFilename($newFilename);
            }

            $this->timingTask->timingEntityManager('Add new identity User', Identity::class, $newIdentity);

            $this->addFlash('success', 'Les info complémentaire ont été enregistré');

            return $this->redirectToRoute('app_user', ['id' => $id->getId()]);
        }

        return $this->render('user/index.html.twig', [
            'user'         => $id,
            'identityForm' => $identityForm,
        ]);
    }

   
    #[Route('/updatePassword/{user}', name: 'app_updatepassword')]
    public function updatePassword(User $user, Request $request, UserRepository $repo, UserPasswordHasherInterface $hasher): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $form = $this->createForm(ChangePasswordType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newPassword = $form->get('newPassword')->getData();
            $hasherPassword = $hasher->hashPassword($user, $newPassword);
            $repo->upgradePassword($user, $hasherPassword);
            $this->addFlash('success', $this->messageGenerator->getMessageUpdatePassword());

            return $this->redirectToRoute('app_user', [
                'id' => $user->getId(),
            ]);
        }

        return $this->render('user/update_password.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }
}
