<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

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
        <p>Votre compte utilisateur a été modifié par un administrateur URUKHAI</p></br>
        <p>Vous pouvez retrouver ces changement en vous connectant sur notre plateforme :</p>
        <a href="https://www.urukhai.ninasellal.fr" target="_blank" title="site URUKHAI">www.urukhai.ninasellal.fr</a>
        ');

        $mailer->send($email);
    }

    // public function sendEmailNewStructure(MailerInterface $mailer, User $user)
    // {
    //     $email = (new Email())
    //     ->from('nina.sellal@gmail.com')
    //     ->to($user->getEmail())
    //     ->subject('Création de votre structure')
    //     ->text('Votre structure a été créée')
    //     ->html('
    //     <h1>Votre structure : </h1>
    //     <p> Les informations ou permissions liées à votre structure ont été mises à jour par un administrateur URUKHAI</p></br>
    //     <p>Vous pouvez retrouver toutes les informations concernant vos structures en suivant le lien ci-dessous :</p>
    //     <a href="https://www.urukhai.ninasellal.fr" target="_blank" title="site URUKHAI">www.urukhai.ninasellal.fr</a>
    //     ');

    //     $mailer->send($email);
    // }
}
