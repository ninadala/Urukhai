<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class EmailController extends AbstractController
{
    #[Route('/email', name: 'app_email')]
    public function index(MailerInterface $mailer): Response
    {
        $email = (new Email())
        ->from('nina.sellal@gmail.com')
        ->to('nina.sellal@hotmail.fr')
        ->subject('Test : création du mailing')
        ->text('This is the text version')
        ->html('<p> This is the HTML version</p>');

        $mailer->send($email);

        return $this->render('email/index.html.twig', [
            'controller_name' => 'EmailController',
        ]);
    }
}
