<?php

namespace App\Security\Authentication;

use App\Entity\User as AppUser;
use App\Exception\AccountNotVerifeidAuthenticationException;
use App\Service\EmailService;
use App\Service\MessageGeneratorService;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactoryInterface;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

readonly class UserCheckAuthentication implements UserCheckerInterface
{
    public function __construct(
        private MessageGeneratorService $messageGenerator,
        private RequestStack $requestStack,
        private PasswordHasherFactoryInterface $hasherFactory,
        private EmailService $emailService
    ) {
    }

    /**
     * @throws \Exception
     */
    public function checkPreAuth(UserInterface $user): void
    {
        if (!$user instanceof AppUser) {
            return;
        }

        $date = new \DateTimeImmutable('now');
        $interval = $date->diff($user->getCreatedAt());
        $days = $interval->days;

        if (!$user->isVerified()) {
            if($days > 1){
                $this->emailService->emailVerifierService($user);
            }
            throw new AccountNotVerifeidAuthenticationException($this->messageGenerator->getMessageErrorEmailVerified());
        }

        $requestPassword = $this->requestStack->getCurrentRequest()->request->get('_password');

        if ('' === $requestPassword) {
            throw new BadCredentialsException($this->messageGenerator->getMessageFailureEmptyLogin());
        }

        if (!$this->hasherFactory->getPasswordHasher($user)->verify($user->getPassword(), $requestPassword)) {
            throw new BadCredentialsException($this->messageGenerator->getMessageErrorAuthenticationLogin());
        }
    }

    public function checkPostAuth(UserInterface $user): void
    {
        if (!$user instanceof AppUser) {
            return;
        }

        if (!$user->isVerified()) {
            throw new AccountNotVerifeidAuthenticationException('Aller a votre boite mail afin verfier votre email');
        }
    }
}
