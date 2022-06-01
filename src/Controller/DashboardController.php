<?php

namespace App\Controller;

use App\Entity\Transaction;
use App\Form\TransactionType;
use App\Repository\SupplierRepository;
use App\Repository\CustomerRepository;
use App\Repository\TransactionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class DashboardController extends AbstractController
{
    private $em;
    private $transactionRepository;
    public function __construct(CustomerRepository $cR, TransactionRepository $tR, SupplierRepository $sR, EntityManagerInterface $em) {
        $this->transactionRepository = $tR;
        $this->customerRepository = $cR;
        $this->supplierRepository = $sR;
        $this->em = $em;
    }

    #[Route('/dashboard', name: 'dashboard')]
    public function index(): Response
    {
        $transactions = $this->transactionRepository->findAll();
        $suppliers = $this->supplierRepository->findAll();
        $customers = $this->customerRepository->findAll();
        return $this->render('dashboard/index.html.twig', [
            'pageTitle' => 'Dashboard',
            'customers' => $customers,
            'suppliers' => $suppliers,
            'transactions' => $transactions
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
