<?php

namespace App\Controller;

use App\Entity\ContactUs;
use App\Form\ContactUsType;
use App\Repository\ContactUsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/customer-queries', name: 'customer_queries.')]
class ContactUsController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(ContactUsRepository $contactUsRepository): Response
    {
        return $this->render('contact_us/index.html.twig', [
            'contactuses' => $contactUsRepository->latestQueries(),
            'pageTitle' => 'Customer Queries',
        ]);
    }

    #[Route('/compose-message', name: 'compose.msg', methods: ['GET', 'POST'])]
    public function new(Request $request, ContactUsRepository $contactUsRepository, MailerInterface $mailer): Response
    {
        $msg = new ContactUs();
        $form = $this->createForm(ContactUsType::class, $msg);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contactUsRepository->add($msg, $form, true);
            // $contactUsRepository->sendEmail($form, $mailer);

            return $this->redirectToRoute('customer_queries.index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('contact_us/new.html.twig', [
            'contact_u' => $msg,
            'form' => $form,
            'pageTitle' => 'Compose Message',
        ]);
    }

    #[Route('/reply', name: 'reply', methods: ['GET', 'POST'])]
    public function reply(Request $request, ContactUsRepository $contactUsRepository): Response
    {
        $contactU = new ContactUs();
        $form = $this->createForm(ContactUsType::class, $contactU);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contactUsRepository->add($contactU, true);

            return $this->redirectToRoute('app_contact_us_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('contact_us/new.html.twig', [
            'contact_u' => $contactU,
            'form' => $form,
            'pageTitle' => 'Reply to:',
        ]);
    }

    #[Route('/show/{id}', name: 'show', methods: ['GET'])]
    public function show(ContactUs $contactU): Response
    {
        return $this->render('contact_us/show.html.twig', [
            'contact_u' => $contactU,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ContactUs $contactU, ContactUsRepository $contactUsRepository): Response
    {
        $form = $this->createForm(ContactUsType::class, $contactU);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contactUsRepository->add($contactU, true);

            return $this->redirectToRoute('customer_queries.index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('contact_us/edit.html.twig', [
            'contact_u' => $contactU,
            'form' => $form,
        ]);
    }

    #[Route('/delete/{id}', name: 'delete', methods: ['GET'])]
    public function delete(Request $request, ContactUs $contactUs, ContactUsRepository $contactUsRepository): Response
    {
        //if ($this->isCsrfTokenValid('delete'.$contactU->getId(), $request->request->get('_token'))) {
        $contactUsRepository->remove($contactUs, true);
        //}

        return $this->redirectToRoute('customer_queries.index', [], Response::HTTP_SEE_OTHER);
    }
}
