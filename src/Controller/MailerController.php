<?php

// src/Controller/MailerController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;



class MailerController extends AbstractController
{
    #[Route('/email', name: 'email')]
    public function sendEmail(MailerInterface $mailer): Response
    {
        $varSession = '';
        $session = new Session();
        $session->start();

        $softwareProvider = 'info@kanaitech.com';
        $clientMail = 'chiingam@gamil.com';
        
        $email = (new TemplatedEmail())
            ->from($clientMail)
            ->to(new Address('kanaistevew@gmail.com', 'Kanai Technologies'))
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Thanks for contacting us!')
        
            // path of the Twig template to render
            ->htmlTemplate('emails/contact_us.html.twig')
        
            // pass variables (name => value) to the template
            ->context([
                'expiration_date' => new \DateTime('+7 days'),
                'username' => 'Chiinga Musonda',
                'userMail' => $clientMail,
            ])
        ;

        try {
            $mailer->send($email);
        } catch (TransportExceptionInterface $e) {
            // some error prevented the email sending; display an
            // error message or try to resend the message

            // add flash messages
            $session->getFlashBag()->add(
                'danger',
                'Your email has not been sent! Something went wrong'
            );
        }

        // add flash messages
        $session->getFlashBag()->add(
            'success',
            'Your email has been sent successfully'
        );

        // display succs
        foreach ($session->getFlashBag()->get('success', []) as $message) {
            $varSession = '<div class="flash-warning">'.$message.'</div>';
        }

        return $this->redirectToRoute('home');
    }
}
