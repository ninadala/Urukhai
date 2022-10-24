<?php

namespace App\Controller;

use App\Entity\Franchise;
use App\Entity\Salle;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class EmailController extends AbstractController
{
    public function sendEmailNewUser(MailerInterface $mailer, User $user)
    {
        $email = (new Email())
        ->from('nina.sellal@gmail.com')
        ->to($user->getEmail())
        ->subject('Nouvel utilisateur-trice')
        ->text('Bienvenue chez URUKHAI')
        ->html('
        <h1>Bienvenue chez URUKHAI</h1>
        <p>Votre compte utilisateur a été créé par un administrateur URUKHAI</p></br>
        <ul>
            <li>Votre nom d\'utilisateur est : '.$user->getUsername().'</li>
            <li>Votre mot de passe temporaire est : '.$user->getUsername().'</li>
        </ul></br>
        <p>Veuillez s\'il vous plait changer ce mot de passe dès votre première connexion</p>
        <a href="https://www.urukhai.ninasellal.fr" target="_blank" title="site URUKHAI">www.urukhai.ninasellal.fr</a>
        ');

        $mailer->send($email);
    }

    public function sendEmailEditUser(MailerInterface $mailer, User $user)
    {
        $email = (new Email())
        ->from('nina.sellal@gmail.com')
        ->to($user->getEmail())
        ->subject('Modification utilisateur-trice')
        ->text('Bienvenue chez URUKHAI')
        ->html('
        <h1>Bienvenue chez URUKHAI</h1>
        <p>Votre compte utilisateur a été modifié par un administrateur URUKHAI</br>
        Vous pouvez retrouver ces changements en vous connectant sur notre plateforme :</p>
        <a href="https://www.urukhai.ninasellal.fr" target="_blank" title="site URUKHAI">www.urukhai.ninasellal.fr</a>
        ');

        $mailer->send($email);
    }

    public function sendEmailDeleteUser(MailerInterface $mailer, User $user)
    {
        $email = (new Email())
        ->from('nina.sellal@gmail.com')
        ->to($user->getEmail())
        ->subject('Suppression utilisateur-trice')
        ->text('A bientôt chez URUKHAI')
        ->html('
        <p>Votre compte utilisateur a été supprimé par un administrateur URUKHAI</p></br>
        ');

        $mailer->send($email);
    }

    public function sendEmailNewFranchise(MailerInterface $mailer, User $user, Franchise $franchise)
    {
        $email = (new Email())
        ->from('nina.sellal@gmail.com')
        ->to($user->getEmail())
        ->subject('Création de votre structure')
        ->html('
        <h1>Création de votre franchise : '.$franchise->getName().'</h1>
        <p>Votre structure a bien été créée par un administrateur URUKHAI</br>
        Vous pouvez retrouver toutes les informations concernant vos structures en suivant le lien ci-dessous :</p>
        <a href="https://www.urukhai.ninasellal.fr" target="_blank" title="site URUKHAI">www.urukhai.ninasellal.fr</a>
        ');

        $mailer->send($email);
    }

    public function sendEmailEditFranchise(MailerInterface $mailer, User $user, Franchise $franchise)
    {
        $email = (new Email())
        ->from('nina.sellal@gmail.com')
        ->to($user->getEmail())
        ->subject('Modification de votre structure')
        ->html('
        <h1>Modification de votre franchise : '.$franchise->getName().'</h1>
        <p>Les informations ou les permissions de votre structure ont été modifiées par un administrateur URUKHAI</br>
        Vous pouvez retrouver ces changements en vous connectant sur notre plateforme :</p>
        <a href="https://www.urukhai.ninasellal.fr" target="_blank" title="site URUKHAI">www.urukhai.ninasellal.fr</a>
        ');

        $mailer->send($email);
    }

    public function sendEmailDeleteFranchise(MailerInterface $mailer, User $user, Franchise $franchise)
    {
        $email = (new Email())
        ->from('nina.sellal@gmail.com')
        ->to($user->getEmail())
        ->subject('Suppression de votre structure')
        ->text('A bientôt chez URUKHAI')
        ->html('
        <h1>Suppression de votre franchise : '.$franchise->getName().'</h1>
        <p>Votre structure a été supprimée par un administrateur URUKHAI</p></br>
        ');

        $mailer->send($email);
    }

    public function sendEmailNewSalle(MailerInterface $mailer, User $user, Salle $salle)
    {
        $email = (new Email())
        ->from('nina.sellal@gmail.com')
        ->to($user->getEmail())
        ->subject('Création de votre structure')
        ->html('
        <h1>Création de votre salle : '.$salle->getName().'</h1>
        <p>Votre structure a bien été créée par un administrateur URUKHAI</br>
        Vous pouvez retrouver toutes les informations concernant vos structures en suivant le lien ci-dessous :</p>
        <a href="https://www.urukhai.ninasellal.fr" target="_blank" title="site URUKHAI">www.urukhai.ninasellal.fr</a>
        ');

        $mailer->send($email);
    }

    public function sendEmailEditSalle(MailerInterface $mailer, User $user, Salle $salle)
    {
        $email = (new Email())
        ->from('nina.sellal@gmail.com')
        ->to($user->getEmail())
        ->subject('Modification de votre structure')
        ->html('
        <h1>Modification de votre salle : '.$salle->getName().'</h1>
        <p>Les informations ou les permissions de votre structure ont été modifiées par un administrateur URUKHAI</br>
        Vous pouvez retrouver ces changements en vous connectant sur notre plateforme :</p>
        <a href="https://www.urukhai.ninasellal.fr" target="_blank" title="site URUKHAI">www.urukhai.ninasellal.fr</a>
        ');

        $mailer->send($email);
    }

    public function sendEmailDeleteSalle(MailerInterface $mailer, User $user, Salle $salle)
    {
        $email = (new Email())
        ->from('nina.sellal@gmail.com')
        ->to($user->getEmail())
        ->subject('Suppression de votre structure')
        ->text('A bientôt chez URUKHAI')
        ->html('
        <h1>Suppression de votre salle : '.$salle->getName().'</h1>
        <p>Votre structure a été supprimée par un administrateur URUKHAI</p></br>
        ');

        $mailer->send($email);
    }

}
