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
}
