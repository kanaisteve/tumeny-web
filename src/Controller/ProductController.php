<?php
// src/Controller/ProductController.php
namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    private $em;
    private $productRepository;
    public function __construct(ProductRepository $productRepository, EntityManagerInterface $em) {
        $this->productRepository = $productRepository;
        $this->em = $em;
    }

    #[Route('/products-and-services', name: 'products')]
    public function products(): Response
    {
        $products = $this->productRepository->findAll();
        return $this->render('dashboard/products.html.twig', [
            'pageTitle' => 'Products/Services',
            'products' => $products
        ]);
    }

    #[Route('/product/new', methods: ['GET', 'POST'], name: 'create_product')]
    public function new(Request $request, FileUploader $fileUploader)
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $product = $form->getData();
            // dump($product);
            // die();

            /** @var UploadedFile $productFile */
            $productFile = $form->get('productImage')->getData();
            if ($productFile) {
                $productFile = $fileUploader->upload($productFile);
                $product->setProductImage($productFile);
            }

            // ... persist the $product variable or any other work
            $this->em->persist($product);
            $this->em->flush();

            return $this->redirectToRoute('products');
        }

        return $this->render('product/new.html.twig', [
            'pageTitle' => 'Add New Product',
            'form' => $form->createView()
        ]);
    }
}