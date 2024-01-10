<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Identity;
use App\Entity\User;
use App\Form\ClientType;
use App\Repository\UserRepository;
use App\Security\EmailVerifier;
use App\Service\EmailService;
use App\Service\TimingTaskService;
use App\Service\ToolsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/client')]
class ClientController extends AbstractController
{
    public function __construct(
        readonly private ToolsService $toolsService,
        readonly private TimingTaskService $timingTaskService
    ) {
    }

    #[Route('/', name: 'app_client')]
    public function index(): Response
    {
        return $this->render('client/index.html.twig', [
            'controller_name' => 'ClientController',
        ]);
    }

    #[Route('/register_client', name: 'app_register_client')]
    public function registerClient(
        Request $request,
        UserPasswordHasherInterface $passwordHasher,
        UserRepository $userRepo,
        EmailService $emailService
    ): Response {
        $client = new Client();
        $user = new User();
        $identity = new Identity();

        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $nameClient = $form->get('name')->getData();
            $emailClient = $form->get('contactEmail')->getData();
            $usernameClient = $form->get('contactName')->getData();
            $userExist = $userRepo->findOneBy(['email' => $emailClient]);
            $identityClient = explode(' ', $usernameClient);

            if ($userExist) {
                $this->addFlash('danger', 'Cette email '.$emailClient.' existe déjà.');

                return $this->redirectToRoute('app_register_client');
            }

            $refNumber = $this->toolsService->getGeneratorRefNumber($nameClient);
            $slug = $this->toolsService->getGeneratorSlugger($nameClient);

            $client
                ->setRefNumber($refNumber)
                ->setSlug($slug);
            $this->timingTaskService->timingEntityManager('Register client', Client::class, $client);

            $user->setEmail($emailClient)
                ->setRoles(['ROLE_CLIENT'])
                ->setClient($client)
                ->setPassword($passwordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                ));
            $this->timingTaskService->timingEntityManager('Register user by client', User::class, $user);

            $identity
                ->setUserIdentity($user)
                ->setFirstname($identityClient[1])
                ->setLastname($identityClient[0]);

            $this->timingTaskService->timingEntityManager('Add identity by client', Identity::class, $identity);

            $emailService->emailVerifierService($user);

            return $this->redirectToRoute('app_render_verif_email', ['email' => $user->getEmail()]);
        }

        return $this->render('client/register_client.html.twig', [
            'clientForm' => $form,
        ]);
    }
}
