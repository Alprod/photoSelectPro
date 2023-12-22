<?php

namespace App\Security\Authentication;

use App\Logger\SecurityLogger;
use App\Service\MessageGeneratorService;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;

class AuthenticationSuccessHandler implements AuthenticationSuccessHandlerInterface
{
    public function __construct(
        readonly private SecurityLogger $securityLogger,
        readonly private UrlGeneratorInterface $route,
        readonly private MessageGeneratorService $messageGenerator
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token): ?Response
    {
        $user = $token->getUser();
        $this->securityLogger->securityInfoLog('Connexion réussi : '.$user?->getUserIdentifier());

        /* @phpstan-ignore-next-line */
        $request->getSession()->getFlashBag()->add('success', $this->messageGenerator->getMessageSuccessLogin($user?->getUserIdentifier()));

        $homepage = $this->route->generate('app_home');

        return new RedirectResponse($homepage);
    }
}
