<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Logger\SecurityLogger;
use App\Repository\ClientRepository;
use App\Repository\UserRepository;
use App\Security\EmailVerifier;
use App\Service\EmailService;
use App\Service\MessageGeneratorService;
use App\Service\TimingTaskService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class RegistrationController extends AbstractController
{
    public function __construct(
        readonly private EmailVerifier $emailVerifier,
        readonly private SecurityLogger $securityLogger,
        readonly private MessageGeneratorService $messageGenerator
    ) {
    }

    /**
     * Enregistrement d'un utilisateur seulement s'il détient le numéro code client.
     *
     */
    #[Route('/register', name: 'app_register')]
    public function register(
        Request $request,
        UserPasswordHasherInterface $userPasswordHasher,
        TimingTaskService $timingTask,
        ClientRepository $clientRepo,
        EmailService $emailService
    ): Response {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $emailUserData = $form->get('email')->getData();
            $refClientNumber = $form->get('refClientNumber')->getData();
            $plainPassword = $form->get('plainPassword')->getData();

            $client = $clientRepo->findOneBy(['refNumber' => $refClientNumber]);

            if (null === $client) {
                $this->securityLogger->securityErrorLog("Tantative de d'inscriptoin non autorisé", ['user email' => $emailUserData, 'route_name' => 'app_register']);
                $this->addFlash('danger', $this->messageGenerator->getMessageFailure());

                return $this->redirectToRoute('app_register');
            }
            $user->setClient($client)
                ->setPassword(
                    $userPasswordHasher->hashPassword(
                        $user,
                        $plainPassword
                    )
                );
            $timingTask->timingEntityManager('Register user', User::class, $user);

            $emailService->emailVerifierService($user);

            return $this->redirectToRoute('app_render_verif_email', ['email' => $user->getEmail()]);
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    /**
     * Valide le lien de confirmation par courrier électronique.
     * Définit User::isVerified=true et persiste.
     *
     */
    #[Route('/verify/email', name: 'app_verify_email')]
    public function verifyUserEmail(
        Request $request,
        TranslatorInterface $translator,
        UserRepository $userRepository,
    ): Response {
        $id = $request->query->get('id');

        if (null === $id) {
            $this->addFlash('danger', $this->messageGenerator->getMessageErrorEmailVerified());

            return $this->redirectToRoute('app_register');
        }

        $user = $userRepository->find($id);

        if (null === $user) {
            $this->addFlash('danger', $this->messageGenerator->getMessageErrorEmailVerified());

            return $this->redirectToRoute('app_register');
        }

        if (true === $user->isVerified()) {
            $this->addFlash('success', $this->messageGenerator->getMessageEmailIsVerified($user->getEmail()));

            return $this->redirectToRoute('app_home');
        }

        try {
            $this->emailVerifier->handleEmailConfirmation($request, $user);
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->securityLogger->securityInfoLog('Utilisateur tarder de veifier son email');
            $this->addFlash('verify_email_error', $translator->trans($exception->getReason(), [], 'VerifyEmailBundle'));

            return $this->redirectToRoute('app_register');
        }

        $this->addFlash('success', $this->messageGenerator->getMessageSuccessEmailIsVerified($user->getEmail()));

        return $this->redirectToRoute('app_login');
    }

    #[Route('/renderVerfiedEmail/{email}', name: 'app_render_verif_email')]
    public function renderAfterRegister(string $email): Response
    {
        return $this->render('registration/render_verif_email.html.twig', ['email' => $email]);
    }
}
