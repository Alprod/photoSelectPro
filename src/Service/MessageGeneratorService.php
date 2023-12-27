<?php

namespace App\Service;

class MessageGeneratorService
{
    public function getSuccessEmailIsVerified(string $email): string
    {
        return 'Bravo! Vous avez réussi à vérifier votre adresse '.$email.'. Vous êtes maintenant près pour votre parcours de selection de photo. Bienvenu à bord';
    }

    public function getMessageConfirmEmail(): string
    {
        $message = [
            "Bonjour! Pour que nous puissions rester en contact, pourriez-vous s'il vous plaît vérifier et confirmer votre adresse e-mail ? Merci beaucoup !",
            'Salut! Nous voulons nous assurer que toutes nos communications atteignent la bonne adresse. Pourriez-vous confirmer votre e-mail lorsque vous aurez un moment ? Merci !',
            'Hello! Nous voulons être certains que vous ne manquez aucune information passionnante. Pourriez-vous confirmer votre adresse e-mail lorsque vous aurez un instant? Merci beaucoup !',
            "Coucou ! Afin de garantir que vous receviez nos dernières nouvelles, pourriez-vous s'il vous plaît vérifier et confirmer votre adresse e-mail ? Merci infiniment !",
            'Bonjour cher utilisateur ! Nous voudrions nous assurer que vous êtes bien connecté(e) avec nous. Pourriez-vous confirmer votre adresse e-mail ? Merci pour votre coopération !',
        ];

        $index = array_rand($message);

        return $message[$index];
    }

    public function getErrorMessageEmailVerified(): string
    {
        return "Nous nous excusons, mais nous n'avons pas réussi à vous localiser. Veuillez vérifier votre boite mail afin de validé votre email et réessayer.";
    }

    public function getMessageFailure(): string
    {
        return 'Cet élément doit être fourni par la partie concernée, que ce soit une entreprise, un formateur ou toute autre source appropriée.';
    }

    public function getMessageFailureLogin(string $message): string
    {
        return $message;
    }

    public function getMessageFailureEmptyLogin(): string
    {
        return 'Veuillez vous assurer que certains champs ne sont pas laissés vides afin de garantir une soumission complète et précise du formulaire.';
    }

    public function getErrorAuthenticationLogin(): string
    {
        return "La saisie ne correspond pas aux informations attendues. Veuillez vérifier vos données d'accès";
    }

    public function getMessageSuccessLogin(string $value): string
    {
        return 'Bienvenue ! '.$value.' Vous êtes maintenant connecté(e).';
    }

    public function getMessageLogout(): string
    {
        return "Merci pour votre participation j'éspère vous revoir bientôt";
    }

    public function getEmailIsVerified(string $email): string
    {
        return 'Merci, mais '.$email.' est déjà Vérifier';
    }
}
