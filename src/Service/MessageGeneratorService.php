<?php

namespace App\Service;

class MessageGeneratorService
{
    public function getMessageSuccessEmailIsVerified(string $email): string
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

    public function getMessageErrorEmailVerified(): string
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

    public function getMessageErrorAuthenticationLogin(): string
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

    public function getMessageEmailIsVerified(string $email): string
    {
        return 'Merci, mais '.$email.' est déjà Vérifier';
    }

    public function getMessageUpdatePassword(): string
    {
        $message = [
            'Félicitations ! Votre mot de passe a été mis à jour avec succès.',
            'Bravo ! Vous venez de sécuriser votre compte en mettant à jour votre mot de passe.',
            'Excellent travail ! Votre mot de passe a été changé avec succès. Votre compte est maintenant plus sécurisé.',
            'Succès ! Vous avez accompli la mise à jour de votre mot de passe avec succès. Votre compte est entre de bonnes mains.',
            "C'est officiel ! Votre mot de passe a été modifié avec succès. Merci de veiller à la sécurité de votre compte.",
        ];

        $index = array_rand($message);

        return $message[$index];
    }

    public function getMessageNotFoundUser(string $email): string
    {
        return "On a essayé de dénicher l'e-mail ".$email.", mais on dirait qu'il joue à cache-cache. Peut-être une faute de frappe ? Si tu as une autre adresse, on la trouvera sûrement !";
    }

    public function getMessageEmailSending(string $email): string
    {
        return 'Bonne nouvelle : un email important vient de partir a cette adresse '.$email.". C'est au sujet de la mise à jour de ton compte. 🚀 <br/>
                ⏳ Regarde vite ! Consulte ta boîte de réception pour tous les détails.";
    }
}
