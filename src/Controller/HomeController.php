<?php

namespace App\Controller;

use App\Entity\ContactUs;
use App\Form\ContactUsType;
use App\Repository\ContactUsRepository;
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
    public function index(Request $request, MailerInterface $mailer, ContactUsRepository $contactUsRepository): Response
    {
        $msg = new ContactUs();
        $form = $this->createForm(ContactUsType::class, $msg);
        // $contactUsForm = $this->createForm(ContactUsType::class, $contactUs, [
        //     'action' => $this->generateUrl('email'),
        //     'method' => 'POST'
        // ]);
        
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            // collect customer query and save in db
            $contactUsRepository->add($msg, $form, true);

            // customer sends mail to us.
            $contactUsRepository->sendEmail($form, $mailer);

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
