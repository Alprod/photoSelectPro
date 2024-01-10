<?php

namespace App\Service;

use App\Entity\User;
use App\Security\EmailVerifier;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Address;

readonly class EmailService
{
    public function __construct(private EmailVerifier $emailVerifier)
    {
    }

    public function emailVerifierService(User $user): void
    {
        $this->emailVerifier->sendEmailConfirmation(
            'app_verify_email',
            $user,
            (new TemplatedEmail())
            ->from(new Address('no-reply@teampsp.fr', '�Team PhotoSelectPro'))
            ->to($user->getEmail())
            ->subject('Veuillez confirmer votre email')
            ->htmlTemplate('emails/confirmation_email.html.twig')
        );
    }
}
