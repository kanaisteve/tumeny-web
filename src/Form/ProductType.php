<?php

namespace App\Form;

use App\Entity\Product;
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

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => false,
                'attr' => [
                    // 'autocomplete' => 'firstName',                     
                    'class' => 'form-control shadow-none',
                    'placeholder' => 'Enter product name'
                ],
            ])
            ->add('slug', TextType::class, [
                'label' => false,
                'attr' => [
                    // 'autocomplete' => 'firstName',                     
                    'class' => 'form-control shadow-none',
                    'placeholder' => 'Enter slug name'
                ],
            ])
            ->add('description', TextareaType::class, [
                'label' => false,
                'attr' => [
                    // 'autocomplete' => 'body',                     
                    'class' => 'form-control shadow-none',
                    'rows' => '3',
                    'placeholder' => 'Enter product description'
                ],
            ])
            ->add('price', IntegerType::class, [
                'attr' => array(
                    'class' => 'form-control shadow-none',
                    'placeholder' => 'Enter price'
                ),
                'label' => false
            ])
            ->add('vat', IntegerType::class, [
                'attr' => array(
                    'class' => 'form-control shadow-none',
                    'placeholder' => 'Enter vat'
                ),
                'label' => false
            ])
            ->add('priceWithVat', IntegerType::class, [
                'attr' => array(
                    'class' => 'form-control shadow-none',
                    'placeholder' => 'Enter total price with vat'
                ),
                'label' => false
            ])
            ->add('productImage', FileType::class, [
                'attr' => array(
                    'class' => 'form-control'
                ),
                'label' => 'Product Image (PDF file)',

                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,

                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'application/pdf',
                            'application/x-pdf',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid PDF document',
                    ])
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
