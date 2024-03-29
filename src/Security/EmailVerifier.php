<?php

namespace App\Security;

use App\Logger\EmailSendLogger;
use App\Service\MessageGeneratorService;
use App\Service\TimingTaskService;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;

readonly class EmailVerifier
{
    public function __construct(
        private VerifyEmailHelperInterface $verifyEmailHelper,
        private MailerInterface $mailer,
        private MessageGeneratorService $messageGenerator,
        private EmailSendLogger $emailSendLogger,
        private TimingTaskService $timingTaskService
    ) {
    }

    public function sendEmailConfirmation(
        string $verifyEmailRouteName,
        UserInterface $user,
        TemplatedEmail $email
    ): void {
        $signatureComponents = $this->verifyEmailHelper->generateSignature($verifyEmailRouteName, $user->getId(), $user->getEmail(), ['id' => $user->getId()]);

        $context = $email->getContext();
        $context['signedUrl'] = $signatureComponents->getSignedUrl();
        $context['expiresAtMessageKey'] = $signatureComponents->getExpirationMessageKey();
        $context['expiresAtMessageData'] = $signatureComponents->getExpirationMessageData();
        $context['message'] = $this->messageGenerator->getMessageConfirmEmail();

        $email->context($context);

        try {
            $this->mailer->send($email);
            $this->emailSendLogger->emailSendInfo('Email envoyé avec success', $user->getUserIdentifier());
        } catch (TransportExceptionInterface $te) {
            $this->emailSendLogger->emailSendError("Erreur lors de l'envoi d'email", $te, $user->getUserIdentifier());

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

        $this->timingTaskService->timingEntityManager('Confirmation Email', __CLASS__, $user);
    }
}
