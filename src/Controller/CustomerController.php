<?php

// src/Controller/ProductController.php
namespace App\Controller;

use App\Entity\Customer;
use App\Form\CustomerType;
use App\Repository\CustomerRepository;
use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CustomerController extends AbstractController
{
    private $em;
    private $customerRepository;
    public function __construct(CustomerRepository $customerRepository, EntityManagerInterface $em) {
        $this->customerRepository = $customerRepository;
        $this->em = $em;
    }

    #[Route('/customers', name: 'customers')]
    public function customers(): Response
    {
        $customers = $this->customerRepository->findAll();
        return $this->render('dashboard/customers.html.twig', [
            'pageTitle' => 'Customers',
            'customers' => $customers,
        ]);
    }

    #[Route('/customers/new', methods: ['GET', 'POST'], name: 'create_customer')]
    public function new(Request $request, FileUploader $fileUploader)
    {
        $customer = new Customer();
        $form = $this->createForm(CustomerType::class, $customer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $customer = $form->getData();
            // dump($customer);
            // die();

            /** @var UploadedFile $customerFile */
            // $customerFile = $form->get('customerImage')->getData();
            // if ($customerFile) {
            //     $customerFile = $fileUploader->upload($customerFile);
            //     $customer->setProductImage($customerFile);
            // }

            // ... persist the $customer variable or any other work
            $this->em->persist($customer);
            $this->em->flush();

            return $this->redirectToRoute('customers');
        }

        return $this->render('customer/new.html.twig', [
            'pageTitle' => 'Add New Customer',
            'customerForm' => $form->createView()
        ]);
    }
}