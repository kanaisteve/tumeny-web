<?php

namespace App\Controller;

use App\Entity\Tag;
use App\Form\TagType;
use App\Repository\TagRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Require ROLE_ADMIN for all the actions of this controller
 */
#[IsGranted('ROLE_ADMIN', message: 'You do not have permission to access this page')]
#[Route('/admin/tags', name: 'tags.')]
class TagController extends AbstractController
{
//    #[Route('/', name: 'index', methods: ['GET'])]
//    public function index(TagRepository $tagRepository): Response
//    {
//        return $this->render('tag/index.html.twig', [
//            'tags' => $tagRepository->findAll(),
//            'pageTitle' => 'Blog Tags',
//        ]);
//    }

    #[Route('/', name: 'index', methods: ['GET', 'POST'])]
    public function list(Request $request, TagRepository $tagRepository, SluggerInterface $slugger): Response
    {
        $tag = new Tag();
        $form = $this->createForm(TagType::class, $tag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tagRepository->add($tag, $slugger, $form, true);

            return $this->redirectToRoute('tags.index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('tag/index.html.twig', [
            'tags' => $tagRepository->findAll(),
            'pageTitle' => 'Blog Tags',
            'tag' => $tag,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, TagRepository $tagRepository): Response
    {
        $tag = new Tag();
        $form = $this->createForm(TagType::class, $tag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tagRepository->add($tag, true);

            return $this->redirectToRoute('app_tag_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('tag/new.html.twig', [
            'tag' => $tag,
            'form' => $form,
        ]);
    }

    #[Route('/show/{id}', name: 'show', methods: ['GET'])]
    public function show(Tag $tag): Response
    {
        return $this->render('tag/show.html.twig', [
            'tag' => $tag,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Tag $tag, TagRepository $tagRepository, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(TagType::class, $tag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tagRepository->add($tag, $slugger, $form, true);

            return $this->redirectToRoute('tags.index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('tag/edit.html.twig', [
            'tag' => $tag,
            'form' => $form,
            'pageTitle' => 'Edit Tag',
        ]);
    }

    #[Route('/delete/{id}', name: 'delete', methods: ['GET'])]
    public function delete(Request $request, Tag $tag, TagRepository $tagRepository): Response
    {
        $tagRepository->remove($tag, true);

        return $this->redirectToRoute('tags.index', [], Response::HTTP_SEE_OTHER);
    }
}
