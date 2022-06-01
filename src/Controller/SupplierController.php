<?php

// src/Controller/SupplierController.php
namespace App\Controller;

use App\Entity\Supplier;
use App\Form\SupplierType;
use App\Repository\SupplierRepository;
use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SupplierController extends AbstractController
{
    private $em;
    private $supplierRepository;
    public function __construct(SupplierRepository $supplierRepository, EntityManagerInterface $em) {
        $this->supplierRepository = $supplierRepository;
        $this->em = $em;
    }

    #[Route('/suppliers', name: 'suppliers')]
    public function suppliers(): Response
    {
        $suppliers = $this->supplierRepository->findAll();
        return $this->render('dashboard/suppliers.html.twig', [
            'pageTitle' => 'Suppliers',
            'suppliers' => $suppliers,
        ]);
    }

    #[Route('/suppliers/new', methods: ['GET', 'POST'], name: 'create_supplier')]
    public function new(Request $request, FileUploader $fileUploader)
    {
        $supplier = new Supplier();
        $form = $this->createForm(SupplierType::class, $supplier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $supplier = $form->getData();
            // dump($supplier);
            // die();

            /** @var UploadedFile $supplierFile */
            // $supplierFile = $form->get('supplierImage')->getData();
            // if ($supplierFile) {
            //     $supplierFile = $fileUploader->upload($supplierFile);
            //     $supplier->setProductImage($supplierFile);
            // }

            // ... persist the $supplier variable or any other work
            $this->em->persist($supplier);
            $this->em->flush();

            return $this->redirectToRoute('suppliers');
        }

        return $this->render('supplier/new.html.twig', [
            'pageTitle' => 'Add New Supplier',
            'supplierForm' => $form->createView()
        ]);
    }
}