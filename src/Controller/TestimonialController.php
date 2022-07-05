<?php

namespace App\Controller;

use App\Entity\Testimonial;
use App\Form\TestimonialType;
use App\Repository\TestimonialRepository;
use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * Require ROLE_ADMIN for all the actions of this controller
 */
//#[IsGranted('ROLE_ADMIN')]
#[Route('/admin/testimonials', name: 'testimonials.')]
class TestimonialController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(TestimonialRepository $testimonialRepository): Response
    {
        return $this->render('testimonial/index.html.twig', [
            'testimonials' => $testimonialRepository->findAll(),
            'pageTitle' => 'Testimonials',
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, TestimonialRepository $testimonialRepository, FileUploader $fileUploader): Response
    {
        $testimonial = new Testimonial();
        $form = $this->createForm(TestimonialType::class, $testimonial);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $testimonialRepository->add($testimonial, $form, true);

            return $this->redirectToRoute('testimonials.index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('testimonial/new.html.twig', [
            'testimonial' => $testimonial,
            'form' => $form,
            'pageTitle' => 'Create Testimonial',
        ]);
    }

    #[Route('/show/{id}', name: 'show', methods: ['GET'])]
    public function show(Testimonial $testimonial): Response
    {
        return $this->render('testimonial/show.html.twig', [
            'testimonial' => $testimonial,
            'pageTitle' => 'Create Testimonial',
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Testimonial $testimonial, TestimonialRepository $testimonialRepository, FileUploader $fileUploader): Response
    {
        $form = $this->createForm(TestimonialType::class, $testimonial);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $testimonialRepository->add($testimonial, $form, true);

            return $this->redirectToRoute('testimonials.index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('testimonial/edit.html.twig', [
            'testimonial' => $testimonial,
            'form' => $form,
            'pageTitle' => 'Edit Testimonial',
        ]);
    }

    #[Route('/delete/{id}', name: 'delete', methods: ['GET'])]
    public function delete(Request $request, Testimonial $testimonial, TestimonialRepository $testimonialRepository): Response
    {
        //if ($this->isCsrfTokenValid('delete'.$testimonial->getId(), $request->request->get('_token'))) {
        $testimonialRepository->remove($testimonial, true);
        //}

        return $this->redirectToRoute('testimonials.index', [], Response::HTTP_SEE_OTHER);
    }
}
