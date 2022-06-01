<?php

namespace App\Form;

use App\Entity\Customer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;

class CustomerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('businessName', TextType::class, [
                'label' => false,
                'attr' => [
                    // 'autocomplete' => 'firstName',                     
                    'class' => 'form-control shadow-none',
                    'placeholder' => 'Enter business name'
                ],
            ])
            ->add('contactPerson', TextType::class, [
                'label' => false,
                'attr' => [
                    // 'autocomplete' => 'firstName',                     
                    'class' => 'form-control shadow-none',
                    'placeholder' => 'Enter contact person'
                ],
            ])
            ->add('mobileNumber', IntegerType::class, [
                'label' => false,
                'attr' => [
                    // 'autocomplete' => 'mobileNumber',                     
                    'class' => 'form-control shadow-none',
                    'placeholder' => 'Enter mobile number'
                ],
            ])
            ->add('email', TextType::class, [
                'label' => false,
                'attr' => [
                    // 'autocomplete' => 'email',                     
                    'class' => 'form-control shadow-none',
                    'placeholder' => 'Enter email'
                ],
            ])
            ->add('address', TextType::class, [
                'label' => false,
                'attr' => [
                    // 'autocomplete' => 'address',                     
                    'class' => 'form-control shadow-none',
                    'placeholder' => 'Enter address'
                ],
            ])
            ->add('city', TextType::class, [
                'label' => false,
                'attr' => [
                    // 'autocomplete' => 'city',                     
                    'class' => 'form-control shadow-none',
                    'placeholder' => 'Enter city'
                ],
            ])
            ->add('country', TextType::class, [
                'label' => false,
                'attr' => [
                    // 'autocomplete' => 'country',                     
                    'class' => 'form-control shadow-none',
                    'placeholder' => 'Enter country'
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Customer::class,
        ]);
    }
}
