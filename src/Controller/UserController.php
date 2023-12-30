<?php

namespace App\Controller;

use App\Entity\Identity;
use App\Entity\User;
use App\Form\IdentityUserType;
use App\Service\TimingTaskService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    public function __construct(
        readonly private TimingTaskService $timingTask,
        readonly private EntityManagerInterface $entity
    ) {
    }

    #[Route('/profile/{id}', name: 'app_user')]
    public function index(User $id, Request $request): Response
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

            $this->timingTask->timingEntityManager('Add new identity User', Identity::class, $newIdentity);

            $this->addFlash('success', 'Les info complémentaire ont été enregistré');

            return $this->redirectToRoute('app_user', ['id' => $id->getId()]);
        }

        return $this->render('user/index.html.twig', [
            'user'         => $id,
            'identityForm' => $identityForm,
        ]);
    }
}
