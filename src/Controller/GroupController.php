<?php

namespace App\Controller;

use App\Entity\Group;
use App\Entity\SelectionProcess;
use App\Entity\Thematic;
use App\Form\GroupType;
use App\Repository\GroupRepository;
use App\Repository\SelectionProcessRepository;
use App\Repository\ThematicRepository;
use App\Service\MessageGeneratorService;
use App\Service\TimingTaskService;
use App\Service\ToolsService;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/group')]
class GroupController extends AbstractController
{
    public function __construct(
        readonly private EntityManagerInterface $em,
        readonly private TimingTaskService $timingTask,
        readonly private MessageGeneratorService $messageGenerator
        ){}

    #[Route('/new/{process}/group', name: 'app_new_group')]
    #[Route('/update/{process}/group/{group}', name: 'app_update_group')]
    public function newGroup(
        Request $request, 
        int $process,
        SelectionProcessRepository $selectionProcessRepo,
        ThematicRepository $thematicRepo,
        GroupRepository $groupRepo,
        Group $group = null
        ): Response
    {
        if(!$group){
            $group = new Group();
        }
        $message = $this->messageGenerator;
        $processSelect = $selectionProcessRepo->findOneBy([ 'id' => $process ]);
        $thematic = $thematicRepo->findOneBy(['selectionProcess' => $processSelect]);

        $formGroup = $this->createForm(GroupType::class, $group);
        $formGroup->handleRequest($request);

        if($formGroup->isSubmitted() && $formGroup->isValid()){
            /*$groupExist = $groupRepo->findByNameGroupExist($group->getName());

            if($groupExist){
                $this->addFlash('danger','Le '.$group->getName().' existe déjà');
                return $this->redirectToRoute('app_new_group', ['process' => $process]);
            }*/

            $group->setThematic($thematic);
            $this->timingTask->timingEntityManager('Add new group', Group::class, $group);
            $this->addFlash('success', $message->getMessageAddNewGroup($group->getName()));

            return $this->redirectToRoute('app_selection_process', [
                'id' => $processSelect?->getId(),
                'slug' => $processSelect?->getClient()?->getSlug()
            ]);
        }

        return $this->render('group/groupForm.html.twig', [
            'formGroup' => $formGroup,
        ]);
    }


    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    #[Route('/delete/{id}', name: 'app_delete_group')]
    public function deletedGroup(Group $id, Request $request): RedirectResponse
    {
        $this->denyAccessUnlessGranted('ROLE_CLIENT');
        $idProcessSelect = $id->getThematic()?->getSelectionProcess()?->getId();
        $slugClient = $id->getThematic()?->getSelectionProcess()?->getClient()?->getSlug();

        $submitedToken = $request->query->get('token');

        if($this->isCsrfTokenValid('deleted_group', $submitedToken)){
            $this->em->remove($id);
            $this->em->flush();
            $this->addFlash('success','Groupe supprimer');

            return $this->redirectToRoute('app_selection_process',
                [
                    'id' => $idProcessSelect,
                    'slug' => $slugClient
                ]);
        }
        $this->addFlash('danger', 'Erreur de suppréssion');

        return $this->redirectToRoute('app_selection_process', [
            'id' => $idProcessSelect,
            'slug' => $slugClient
        ]);
    }
}