<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Identity;
use App\Entity\User;
use App\Form\ClientType;
use App\Repository\UserRepository;
use App\Service\EmailService;
use App\Service\TimingTaskService;
use App\Service\ToolsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/client')]
class ClientController extends AbstractController
{
    public function __construct( 
        readonly private ToolsService $toolsService, 
        readonly private TimingTaskService $timingTaskService,
        readonly private UserPasswordHasherInterface $passwordHasher,
        readonly private EmailService $emailService ) {
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
        UserRepository $userRepo,
    ): Response {
        $client = new Client();
        $newUser = new User();
        $identity = new Identity();

        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $emailClient = $form->get('contactEmail')->getData();
            $plainPassword = $form->get('plainPassword')->getData();

            $userExist = $userRepo->findOneBy(['email' => $emailClient]);

            if ($userExist) {
                $this->addFlash('danger', 'Cette email '.$emailClient.' existe déjà.');
                return $this->redirectToRoute('app_register_client');
            }

            $user = $this->regiseterEntityClient($client, $newUser, $identity, $plainPassword);

            return $this->redirectToRoute('app_render_verif_email', ['email' => $user->getEmail()]);
        }

        return $this->render('client/register_client.html.twig', [
            'clientForm' => $form,
        ]);
    }

    private function regiseterEntityClient(Client $client, User $user, Identity $identity, string $plainPassword): User
    {
        $refNumber = $this->toolsService->getGeneratorRefNumber($client->getName());
        $slug = $this->toolsService->getGeneratorSlugger($client->getName());

        $client->setRefNumber($refNumber)
                ->setSlug($slug);

        $user->setEmail($client->getContactEmail())
            ->setRoles(["ROLE_CLIENT"])
            ->setClient($client)
            ->setPassword($this->passwordHasher->hashPassword(
                $user,
                $plainPassword
            ));
        $client->addUser($user);
        $this->timingTaskService->timingEntityManager('Register new client', Client::class, $client);

        $usernameClient = explode(' ', $client->getContactName());
        $identity->setUserIdentity($user)
            ->setFirstname($usernameClient[1])
            ->setLastname($usernameClient[0]);

        $this->timingTaskService->timingEntityManager('Add identity by client', Identity::class, $identity);
        $this->emailService->emailVerifierService($user);

        return $user;
    }
}
