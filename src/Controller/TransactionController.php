<?php

// src/Controller/TransactionController.php
namespace App\Controller;

use App\Entity\Transaction;
use App\Form\TransactionType;
use App\Repository\TransactionRepository;
use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TransactionController extends AbstractController
{
    private $em;
    private $transactionRepository;
    public function __construct(TransactionRepository $transactionRepository, EntityManagerInterface $em) {
        $this->transactionRepository = $transactionRepository;
        $this->em = $em;
    }

    #[Route('/transactions', name: 'transactions')]
    public function transactions(): Response
    {
        $transactions = $this->transactionRepository->findAll();
        return $this->render('dashboard/transactions.html.twig', [
            'pageTitle' => 'Transactions',
            'transactions' => $transactions,
        ]);
    }

    #[Route('/transactions/new-sale', methods: ['GET', 'POST'], name: 'create_sale')]
    public function new(Request $request, FileUploader $fileUploader)
    {
        $transaction = new Transaction();
        $form = $this->createForm(TransactionType::class, $transaction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $transaction = $form->getData();
            // dump($transaction);
            // die();

            /** @var UploadedFile $supplierFile */
            // $transactionile = $form->get(transactionImage')->getData();
            // if (transactionFile) {
            //     transactionFile = $fileUploader->upload(transactionFile);
            //     transaction->setTransactionImage(transactionFile);
            // }

            // ... persist the transaction variable or any other work
            $this->em->persist($transaction);
            $this->em->flush();

            return $this->redirectToRoute('transactions');
        }

        return $this->render('transaction/new.html.twig', [
            'pageTitle' => 'Add Sale',
            'transactionForm' => $form->createView()
        ]);
    }
}