<?php

namespace App\Security;

use App\Service\MessageGeneratorService;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;

class EmailVerifier
{
    public function __construct(
        private readonly VerifyEmailHelperInterface $verifyEmailHelper,
        private readonly MailerInterface $mailer,
        private readonly EntityManagerInterface $entityManager,
        private readonly MessageGeneratorService $messageGenerator,
        private readonly LoggerInterface $emailSendLogger
    )
    {
    }

    /**
     * @throws \Exception
     */
    public function sendEmailConfirmation(string $verifyEmailRouteName, UserInterface $user, TemplatedEmail $email): void
    {
        $signatureComponents = $this->verifyEmailHelper->generateSignature($verifyEmailRouteName, $user->getId(), $user->getEmail(), ['id' => $user->getId()]);

        $context = $email->getContext();
        $context['signedUrl'] = $signatureComponents->getSignedUrl();
        $context['expiresAtMessageKey'] = $signatureComponents->getExpirationMessageKey();
        $context['expiresAtMessageData'] = $signatureComponents->getExpirationMessageData();
        $context['message'] = $this->messageGenerator->getMessageConfirmEmail();

        $email->context($context);

        try {

            $this->mailer->send($email);
            $this->emailSendLogger->info('Email envoyé avec success', ['user' => $user->getUserIdentifier()]);

        } catch (TransportExceptionInterface $te) {

            $this->emailSendLogger->error("Erreur lors de l'envoi d'email", [
                'Email user' => $user->getUserIdentifier(),
                'Message' => $te->getMessage(),
                'Code' => $te->getCode(),
                'File' => $te->getFile(),
                'Line' => $te->getLine()
            ]);

            throw new \RuntimeException($te->getMessage());
        }
    }

    /**
     * @throws VerifyEmailExceptionInterface
     */
    public function handleEmailConfirmation(Request $request, UserInterface $user): void
    {
        $this->verifyEmailHelper->validateEmailConfirmation($request->getUri(), $user->getId(), $user->getEmail());

        /* @phpstan-ignore-next-line */
        $user->setIsVerified(true);

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }
}
