<?php

namespace App\Controller;

use App\Entity\Transaction;
use App\Form\TransactionType;
use App\Repository\CategoryRepository;
use App\Repository\ContactUsRepository;
use App\Repository\PostRepository;
use App\Repository\SupplierRepository;
use App\Repository\CustomerRepository;
use App\Repository\TagRepository;
use App\Repository\TestimonialRepository;
use App\Repository\TransactionRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class DashboardController extends AbstractController
{
    private $em;
    private $postRepository;
    private $categoryRepository;
    private $testimonialRepository;
    private $userRepository;
    private $tagRepository;
    private $queriesRepository;
    public function __construct(
        PostRepository $postRepository,
        CategoryRepository $categoryRepository,
        TagRepository $tagRepository,
        TestimonialRepository $testimonialRepository,
        ContactUsRepository $queriesRepository,
        UserRepository $userRepository,
        EntityManagerInterface $em
    ) {
        $this->postRepository = $postRepository;
        $this->categoryRepository = $categoryRepository;
        $this->tagRepository = $tagRepository;
        $this->testimonialRepository = $testimonialRepository;
        $this->queriesRepository = $queriesRepository;
        $this->userRepository = $userRepository;
        $this->em = $em;
    }

    #[Route('/dashboard', name: 'dashboard')]
    public function index(): Response
    {

        // $currentDate  = new \DateTime();
        $currentDate  = new \DateTimeImmutable();

        $posts = $this->postRepository->findAll();
        $categories = $this->categoryRepository->findAll();
        $tags = $this->tagRepository->findAll();
        $testimonials = $this->testimonialRepository->findAll();
        $queries = $this->queriesRepository->findAll();
        $users = $this->userRepository->findAll();

        return $this->render('dashboard/index.html.twig', [
            'pageTitle' => 'Dashboard',
            'currentDate' => $currentDate,
            'posts' => $posts,
            'categories' => $categories,
            'tags' => $tags,
            'testimonials' => $testimonials,
            'queries' => $queries,
            'users' => $users,
        ]);
    }

    #[Route('/collections', name: 'collections')]
    public function collections(): Response
    {
        return $this->render('dashboard/collections.html.twig', [
            'pageTitle' => 'Collections',
        ]);
    }

    #[Route('/faqs', name: 'faqs')]
    public function faqs(): Response
    {
        return $this->render('dashboard/faqs.html.twig', [
            'pageTitle' => 'Frequently Asked Questions',
        ]);
    }

    #[Route('/contact', name: 'contact')]
    public function contact(): Response
    {
        return $this->render('dashboard/contact.html.twig', [
            'pageTitle' => 'Contact',
        ]);
    }

    #[Route('/settings', name: 'settings')]
    public function settings(): Response
    {
        return $this->render('dashboard/settings.html.twig', [
            'pageTitle' => 'settings',
        ]);
    }
}
