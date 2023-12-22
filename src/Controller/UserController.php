<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/profile/{id}', name: 'app_user')]
    public function index(User $id): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
}
