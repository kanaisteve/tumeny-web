<?php

namespace App\Form;

use App\Entity\Transaction;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;

class TransactionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ->add('txnDate')
            ->add('customerName', TextType::class, [
                'label' => false,
                'attr' => [
                    // 'autocomplete' => 'customerName',                     
                    'class' => 'form-control shadow-none',
                    'placeholder' => 'Enter customer name'
                ],
            ])
            ->add('txnType', TextType::class, [
                'label' => false,
                'attr' => [
                    // 'autocomplete' => 'txnType',                     
                    'class' => 'form-control shadow-none',
                    'placeholder' => 'Enter transaction type'
                ],
            ])
            ->add('txnId', TextType::class, [
                'label' => false,
                'attr' => [
                    // 'autocomplete' => 'txnId',                     
                    'class' => 'form-control shadow-none',
                    'placeholder' => 'Enter transaction ID'
                ],
            ])
            ->add('amount', IntegerType::class, [
                'label' => false,
                'attr' => [
                    // 'autocomplete' => 'txnId',                     
                    'class' => 'form-control shadow-none',
                    'placeholder' => 'Enter amount'
                ],
            ])
            ->add('txnDate', DateType::class, [
                'label' => false,
                'attr' => [
                    // 'autocomplete' => 'txnDate',                     
                    'class' => 'form-control',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Transaction::class,
        ]);
    }
}
