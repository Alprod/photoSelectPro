<?php

namespace App\Security\Authentication;

use App\Entity\User;
use App\Logger\SecurityLogger;
use App\Service\MessageGeneratorService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;

readonly class AuthenticationFailedHandler implements AuthenticationFailureHandlerInterface
{
    public function __construct(
        private SecurityLogger $securityLogger,
        private UrlGeneratorInterface $urlGenerator,
        private MessageGeneratorService $messageGenerator,
        private EntityManagerInterface $entity
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): Response
    {
        $em = $this->entity;
        $session = $request->getSession();
        $reqUser = $request->request->get('_username');

        $user = $em->getRepository(User::class)->findOneBy(['email' => $reqUser]);

        if (!$user) {
            $session->getFlashBag()->add('danger', message: $this->messageGenerator->getMessageErrorAuthenticationLogin());

            throw new UserNotFoundException('Utilisateur non trouvé');
        }
        $route = $this->urlGenerator->generate('app_login');
        $this->securityLogger->securityErrorLog('Tantative de connexion echoué', [
            'message' => $exception->getMessage(),
            'code'    => $exception->getCode(),
            'file'    => $exception->getFile(),
        ]);

        /* @phpstan-ignore-next-line */
        $session->getFlashBag()->add('danger', $this->messageGenerator->getMessageFailureLogin($exception->getMessage()));

        return new RedirectResponse($route);
    }
}
