<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;

final class EmailController extends AbstractController
{
    #[Route('/send-email', name: 'send_email')]
    public function sendEmail(MailerInterface $mailer): Response
    {
        $email = (new Email())
            ->from('aarrev4@gmail.com')
            ->to('shoghiiandryravelomanantsoa@gmail.com')
            ->subject('Test envoi email via Gmail')
             ->html(
           $this->renderView(
               'Fo/Common/email.html.twig',
           )
       );

        $mailer->send($email);

        return new Response('Email envoyé avec succès !');
    }
}

