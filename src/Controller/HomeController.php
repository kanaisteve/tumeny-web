<?php

namespace App\Controller;

use App\Entity\ContactUs;
use App\Form\ContactUsType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

class HomeController extends AbstractController
{
    private $em;
    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
    }

    #[Route('/', methods: ['GET', 'POST'], name: 'home')]
    public function index(Request $request, MailerInterface $mailer): Response
    {
        $contactUs = new ContactUs();
        $form = $this->createForm(ContactUsType::class, $contactUs);
        // $contactUsForm = $this->createForm(ContactUsType::class, $contactUs, [
        //     'action' => $this->generateUrl('email'),
        //     'method' => 'POST'
        // ]);
        
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {

            // $contact = $form->getData();
            // dump($contact);
            // die();

            // $firstName = $contactUsForm->get('firstName')->getData();
            // $lastName = $contactUsForm->get('lastName')->getData();
            $name = $form->get('name')->getData();
            $userEmail = $form->get('email')->getData();
            $subject = $form->get('subject')->getData();
            $body = $form->get('body')->getData();

            // $contact = $form->getData();
            $this->em->persist($contactUs);
            $this->em->flush();

            // do anything else you need here, like send an email
            $email = (new TemplatedEmail())
                ->from(new Address($userEmail, $name))
                ->to(new Address('kanaistevew@gmail.com', 'Kanai Technologies'))
                //->cc('cc@example.com')
                //->bcc('bcc@example.com')
                //->replyTo('fabien@example.com')
                //->priority(Email::PRIORITY_HIGH)
                ->subject($subject)
            
                // path of the Twig template to render
                ->htmlTemplate('emails/contact_us.html.twig')
            
                // pass variables (name => value) to the template
                ->context([
                    'expiration_date' => new \DateTime('+7 days'),
                    'name' => $name,
                    'userEmail' => $userEmail,
                    'subject' => $subject,
                    'body' => $body,
                ])
            ;

            try {
                $mailer->send($email);
            } catch (TransportExceptionInterface $e) {
                // some error prevented the email sending; display an
                // error message or try to resend the message
            }

            return $this->redirectToRoute('home');
        }

        return $this->render('home/index.html.twig', [
            'contactUsForm' => $form->createView()
        ]);
    }

    #[Route('/pricing', methods: ['GET'], name: 'pricing')]
    public function pricing(): Response
    {
        return $this->render('home/pricing.html.twig');
    }

    #[Route('/pricing2', methods: ['GET'], name: 'pricing2')]
    public function pricing2(): Response
    {
        return $this->render('home/pricing2.html.twig');
    }
}
