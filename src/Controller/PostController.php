<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/admin/post', name: 'post.')]
class PostController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(PostRepository $postRepository): Response
    {
        return $this->render('post/index.html.twig', [
            'posts' => $postRepository->findAll(),
            'pageTitle' => 'All Posts',
        ]);
    }

    #[Route('/create', name: 'create', methods: ['GET', 'POST'])]
    public function new(Request $request, PostRepository $postRepository, UserInterface $user): Response
    {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $postRepository->add($post, $form, true);

            $userId = $this->getUser()->getId();
            $postsDirectory = $this->getParameter('posts_directory');
            $postRepository->addWithFile($post, $form, $user, $postsDirectory, true);

            return $this->redirectToRoute('post.index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('post/new.html.twig', [
            'post' => $post,
            'form' => $form,
            'pageTitle' => 'Create Post',
        ]);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(Post $post): Response
    {
        return $this->render('post/show.html.twig', [
            'post' => $post,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Post $post, PostRepository $postRepository, UserInterface $user): Response
    {
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $postRepository->add($post, true);
            $userId = $this->getUser()->getId();
            $postsDirectory = $this->getParameter('posts_directory');
            $postRepository->addWithFile($post, $form, $user, $postsDirectory, true);

            return $this->redirectToRoute('post.index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('post/edit.html.twig', [
            'post' => $post,
            'form' => $form,
            'pageTitle' => 'Edit Post',
        ]);
    }

    #[Route('/delete/{id}', name: 'delete', methods: ['GET'])]
    public function delete(Request $request, Post $post, PostRepository $postRepository): Response
    {
        // if ($this->isCsrfTokenValid('delete'.$post->getId(), $request->request->get('_token'))) {
        $postRepository->remove($post, true);
        //}

        return $this->redirectToRoute('post.index', [], Response::HTTP_SEE_OTHER);
    }
}
