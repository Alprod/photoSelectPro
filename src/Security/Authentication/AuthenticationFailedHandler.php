<?php

namespace App\Security\Authentication;

use App\Logger\SecurityLogger;
use App\Service\MessageGeneratorService;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;

class AuthenticationFailedHandler implements AuthenticationFailureHandlerInterface
{
    public function __construct(
        readonly private SecurityLogger $securityLogger,
        readonly private UrlGeneratorInterface $urlGenerator,
        readonly private MessageGeneratorService $messageGenerator
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): Response
    {
        $session = $request->getSession();
        $route = $this->urlGenerator->generate('app_login');
        $this->securityLogger->securityErrorLog('Tantative de connexion echoué', [
            'messege' => $exception->getMessage(),
            'code'    => $exception->getCode(),
            'file'    => $exception->getFile(),
            ]);
        /* @phpstan-ignore-next-line */
        $session->getFlashBag()->add('danger', $this->messageGenerator->getMessageFailureLogin());

        return new RedirectResponse($route);
    }
}
