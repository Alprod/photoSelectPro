<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\SelectionProcess;
use App\Entity\Thematic;
use App\Enum\RolesEnum;
use App\Form\SelectionProcessType;
use App\Repository\ClientRepository;
use App\Service\MessageGeneratorService;
use App\Service\TimingTaskService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

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

    #[Route('/parcours/show/{slug}/{id}', name: 'app_selection_process', requirements: ['id' => '\d+'])]
    public function index(string $slug, $id): Response
    {
        $this->denyAccessUnlessGranted("IS_AUTHENTICATED_FULLY");
        $client = $this->entity->getRepository(Client::class)->findOneBy(['slug' => $slug]);
        $selectionProcess = $this->entity->getRepository(SelectionProcess::class)->findOneBy(['id' => $id ]);

        $theme = [];
        foreach ($selectionProcess->getThematics() as $th => $thematic){
            $theme[$th] = $thematic;
        }
        return $this->render('selection_process/index.html.twig', [
            'title' => $selectionProcess->getName(),
            'parcour' => $selectionProcess,
            'client' => $client,
            'theme' => $theme
        ]);
    }

    #[Route('/{slug}/new-parcours', name: 'app_new_selection_process')]
    #[Route('/{slug}/edit-parcours/{idParcours<\d+>}', name: 'app_edit_selection_process')]
    public function newSelectionProcess(
        string $slug,
        Request $request,
        ClientRepository $clientRepo,
        SelectionProcess $idParcours = null,
    ): Response
    {
        $this->denyAccessUnlessGranted("ROLE_CLIENT");
        $user = $this->getUser();
        $client = $clientRepo->findOneBy(['slug' => $slug]);
        $message = "Votre parcour a été mise a jour";

        if(!$client && !$user) {
            $this->addFlash('danger', $this->messageGenerator->getMessageFailureLogin('Nous ne parvenons pas à vous trouver'));
            return $this->redirectToRoute('app_login');
        }
        if(!$idParcours){
            $idParcours = new SelectionProcess();
            $message = "Votre parcour a été créé";
        }
        $thematic = $this->entity->getRepository(Thematic::class)->findOneBy(['selectionProcess'=> $idParcours]);

        if(!$thematic){
            $thematic = new Thematic();
        }

        $formSelectProcess = $this->createForm(SelectionProcessType::class, $idParcours);

        $formSelectProcess->handleRequest($request);

        if($formSelectProcess->isSubmitted() && $formSelectProcess->isValid()){

            $inputThematicName = $formSelectProcess->get('thematic')->getData();
            $inputThematicDescription = $formSelectProcess->get('description')->getData();

            $thematic->setName($inputThematicName)
                ->setSelectionProcess($idParcours)
                ->setDescription($inputThematicDescription);

            $idParcours->setClient($client)
                ->addThematic($thematic);

            $this->timingTask->timingEntityManager('Created new parcours',SelectionProcess::class,$idParcours);
            $this->addFlash('success', $message);

            return $this->redirectToRoute('app_user', ['id' => $user->getId()]);

        }

        return $this->render('selection_process/new_process.html.twig', [
            'formSelectProcess' => $formSelectProcess
        ]);
    }

    #[Route('/delete/{id}', name: 'app_delete_selection_process')]
    public function deletedSelectionProcess(SelectionProcess $id, Request $request): Response
    {
        $this->denyAccessUnlessGranted("ROLE_CLIENT");

        $submitToken = $request->query->get(('token'));
        if ($this->isCsrfTokenValid('deleted_process', $submitToken)){
            $this->entity->remove($id);
            $this->entity->flush();
            $this->addFlash('success','Parcours supprimer');

            return $this->redirectToRoute('app_user',
                ['id' => $this->getUser()?->getId()]);
        }

    }
}
