<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/admin/category', name: 'category.')]
class CategoryController extends AbstractController
{
//    #[Route('/', name: 'index', methods: ['GET'])]
//    public function index(CategoryRepository $categoryRepository): Response
//    {
//        return $this->render('category/index.html.twig', [
//            'categories' => $categoryRepository->findAll(),
//            'pageTitle' => 'Blog Categories',
//        ]);
//    }

    #[Route('/', name: 'index', methods: ['GET', 'POST'])]
    public function list(Request $request, CategoryRepository $categoryRepository, SluggerInterface $slugger): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $categoryRepository->add($category, $slugger, $form, true);

            return $this->redirectToRoute('category.index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('category/index.html.twig', [
            'categories' => $categoryRepository->findAll(),
            'pageTitle' => 'Blog Categories',
            'category' => $category,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, CategoryRepository $categoryRepository): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $categoryRepository->add($category, true);

            return $this->redirectToRoute('post.index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('category/new.html.twig', [
            'category' => $category,
            'form' => $form,
        ]);
    }

    #[Route('/show/{id}', name: 'show', methods: ['GET'])]
    public function show(Category $category): Response
    {
        return $this->render('category/show.html.twig', [
            'category' => $category,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Category $category, CategoryRepository $categoryRepository, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $categoryRepository->add($category, $slugger, $form, true);

            return $this->redirectToRoute('category.index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('category/edit.html.twig', [
            'category' => $category,
            'form' => $form,
            'pageTitle' => 'Edit Category',
        ]);
    }

    #[Route('/delete/{id}', name: 'delete', methods: ['GET'])]
    public function delete(Request $request, Category $category, CategoryRepository $categoryRepository): Response
    {
        $categoryRepository->remove($category, true);

        return $this->redirectToRoute('category.index', [], Response::HTTP_SEE_OTHER);
    }
}
