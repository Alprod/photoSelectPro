<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Group;
use App\Entity\SelectionProcess;
use App\Entity\Thematic;
use App\Form\SelectionProcessType;
use App\Repository\ClientRepository;
use App\Repository\SelectionProcessRepository;
use App\Service\MessageGeneratorService;
use App\Service\TimingTaskService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/selection')]
class SelectionProcessController extends AbstractController
{
    public function __construct(
        readonly private TimingTaskService $timingTask,
        readonly private MessageGeneratorService $messageGenerator,
        readonly private EntityManagerInterface $entity
    )
    {
    }

    #[Route('/{slug}/{id}', name: 'app_selection_process', requirements: ['id' => '\d+'])]
    public function index(string $slug, SelectionProcess $id): Response
    {
        $client = $this->entity->getRepository(Client::class)->findOneBy(['slug' => $slug]);
        $theme = [];
        foreach ($id->getThematics() as $th => $thematic){
            $theme[$th] = $thematic;
        }
        return $this->render('selection_process/index.html.twig', [
            'title' => 'Parcours '. $id->getName(),
            'parcour' => $id,
            'client' => $client,
            'theme' => $theme
        ]);
    }

    #[Route('/{slug}/new-parcours', name: 'app_new_selection_process')]
    public function newSelectionProcess(string $slug, Request $request, ClientRepository $clientRepo): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();

        $client = $clientRepo->findOneBy(['slug' => $slug]);

        $selectProcess = new SelectionProcess();
        $thematic = new Thematic();
        if(!$client && !$user) {
            $this->addFlash('danger', $this->messageGenerator->getMessageFailureLogin('Nous ne parvions pas à vous trouver'));
            return $this->redirectToRoute('app_login');
        }

        $formSelectProcess = $this->createForm(SelectionProcessType::class, $selectProcess);
        $formSelectProcess->handleRequest($request);

        if($formSelectProcess->isSubmitted() && $formSelectProcess->isValid()){
            $inputThematicName = $formSelectProcess->get('thematic')->getData();
            $inputThematicDescription = $formSelectProcess->get('description')->getData();
            $inputNumGroups = $formSelectProcess->get('groups')->getData();
            $inputNumMAxPersByGroups = $formSelectProcess->get('maxPersonByGroup')->getData();
            $thematic->setName($inputThematicName)
                ->setSelectionProcess($selectProcess)
                ->setDescription($inputThematicDescription);

            for($i = 1; $i <= $inputNumGroups; $i++){
                $groups = new Group();
                $name = 'Groupe '.$i;
                $groups->setName($name)
                    ->setMaxPersonByGroup($inputNumMAxPersByGroups)
                    ->setThematic($thematic);
                $thematic->addGroup($groups);
            }

            $selectProcess->setClient($client)
                ->addThematic($thematic);

            $this->timingTask->timingEntityManager('Created new parcours',SelectionProcess::class,$selectProcess);
            $this->addFlash('success', 'Votre parcours vient d\'être créé');

            return $this->redirectToRoute('app_user', ['id' => $user->getId()]);

        }

        return $this->render('selection_process/new_process.html.twig', [
            'formSelectProcess' => $formSelectProcess
        ]);
    }
}
