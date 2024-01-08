<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\User;
use App\Form\ClientType;
use App\Security\EmailVerifier;
use App\Service\TimingTaskService;
use App\Service\ToolsService;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/client')]
class ClientController extends AbstractController
{
    public function __construct(
        readonly private ToolsService $toolsService,
        readonly private TimingTaskService $timingTaskService,
        readonly private EmailVerifier $emailVerifier
        )
    {

    }
        

    #[Route('/', name: 'app_client')]
    public function index(): Response
    {
        return $this->render('client/index.html.twig', [
            'controller_name' => 'ClientController',
        ]);
    }

    #[Route('/register_client', name: 'app_register_client')]
    public function registerClient(Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        $client = new Client;
        $user = new User();
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $nameClient = $form->get('name')->getData();

            $refNumber = $this->toolsService->getGeneratorRefNumber($nameClient);
            $slug = $this->toolsService->getGeneratorSlugger($nameClient);

            $client
                ->setRefNumber($refNumber)
                ->setSlug($slug);
            $this->timingTaskService->timingEntityManager('Register client', Client::class, $client);

            $user->setEmail($form->get('contactEmail')->getData())
                ->setRoles(['ROLE_CLIENT'])
                ->setClient($client)
                ->setPassword($passwordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                ));
            $this->timingTaskService->timingEntityManager('Register user by client', User::class, $user);

            $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user, (new TemplatedEmail())
                ->from(new Address('no-reply@teampsp.fr', '�Team PhotoSelectPro'))
                ->to($user->getEmail())
                ->subject('Veuillez confirmer votre email')
                ->htmlTemplate('emails/confirmation_email.html.twig')
            );
            return $this->redirectToRoute('app_render_verif_email', [ 'email' => $user->getEmail() ]);
        }

        return $this->render('client/register_client.html.twig', [
            'clientForm' => $form
        ]);
    }
}
