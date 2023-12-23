<?php

namespace App\Security\Authentication;

use App\Logger\SecurityLogger;
use App\Repository\UserRepository;
use App\Service\MessageGeneratorService;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;

readonly class AuthenticationSuccessHandler implements AuthenticationSuccessHandlerInterface
{
    public function __construct(
        private SecurityLogger $securityLogger,
        private UrlGeneratorInterface $route,
        private MessageGeneratorService $messageGenerator,
        private UserRepository $userRepo
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token): ?Response
    {
        $userToken = $token->getUser();
        $user = $this->userRepo->findOneBy(['id'=> $userToken?->getId()]);
        if(!$user) {
            $loginPage = $this->route->generate('app_login');
            return new RedirectResponse($loginPage);
        }

        $this->securityLogger->securityInfoLog('Connexion réussi : '.$user->getEmail());

        /* @phpstan-ignore-next-line */
        $request->getSession()->getFlashBag()->add('success', $this->messageGenerator->getMessageSuccessLogin($user->getEmail()));

        $homepage = $this->route->generate('app_home');

        return new RedirectResponse($homepage);
    }
}
