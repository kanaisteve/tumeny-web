<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Post;
use App\Entity\User;
use App\Repository\CategoryRepository;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/articles', name: 'articles.')]
class BlogController extends AbstractController
{
    private $em;
    private $postRepository;
    private $categoryRepository;
    public function __construct(
        EntityManagerInterface $em,
        PostRepository $postRepository,
        CategoryRepository $categoryRepository,
    ) {
        $this->em = $em;
        $this->postRepository = $postRepository;
        $this->categoryRepository = $categoryRepository;
    }

    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('blog/index.html.twig', [
            'pageTitle' => 'Blog',
            'posts' => $this->postRepository->findAll(),
            'latest_posts' => $this->postRepository->getPublishedPosts(),
            'categories' => $this->categoryRepository->findAll(),
        ]);
    }

    #[Route('/{slug}', name: 'single', methods: ['GET'])]
    public function single(Post $post): Response
    {
        return $this->render('blog/single.html.twig', [
            'post' => $post,
            'latest_posts' => $this->postRepository->getPublishedPosts(),
            'categories' => $this->categoryRepository->findAll(),
        ]);
    }

    #[Route('/categories/{slug}', name: 'singleCategory', methods: ['GET'])]
    public function singleCategory(Category $category): Response
    {
        //$category = Category::where('slug', $slug)->first();
        return $this->render('blog/category.html.twig', [
            'category' => $category,
            'latest_posts' => $this->postRepository->getPublishedPosts(),
            'categories' => $this->categoryRepository->findAll(),
        ]);
    }

    #[Route('/authors/{id}', name: 'singleAuthor', methods: ['GET'])]
    public function singleAuthor(User $user): Response
    {
        //$author = User::where('username', $username)->first();
        return $this->render('blog/author.html.twig', [
            'user' => $user,
            'latest_posts' => $this->postRepository->getPublishedPosts(),
            'categories' => $this->categoryRepository->findAll(),
        ]);
    }
}
