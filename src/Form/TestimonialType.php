<?php

namespace App\Form;

use App\Entity\Testimonial;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class TestimonialType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'form-control form-control-sm shadow-none',
                    'placeholder' => 'Enter customer names'
                ],
            ])
            ->add('content', TextareaType::class, [
                'label' => false,
                'attr' => [
                    // 'autocomplete' => 'body',
                    'class' => 'form-control form-control-sm shadow-none',
                    'rows' => '3',
                    'placeholder' => 'What the client said about the product?'
                ],
            ])
            ->add('position', TextType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'form-control form-control-sm shadow-none',
                    'placeholder' => 'Enter position'
                ],
            ])
            ->add('company', TextType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'form-control form-control-sm shadow-none',
                    'placeholder' => 'Enter company'
                ],
            ])
            ->add('city', TextType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'form-control form-control-sm shadow-none',
                    'placeholder' => 'Enter city'
                ],
            ])
            ->add('country', TextType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'form-control form-control-sm shadow-none',
                    'placeholder' => 'Enter country'
                ],
            ])
            ->add('status', ChoiceType::class, [
                'choices'  => [
                    'Draft' => 'draft',
                    'Published' => 'published',
                    'Review' => 'review',
                ],
                'attr' => [
                    'class' => 'form-select shadow-none form-select-sm',
                ],
            ])
            ->add('avatar', FileType::class, [
                'attr' => array(
                    'class' => 'form-control form-control-sm shadow-none'
                ),
                'label' => 'Customer Image',

                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Post details
                'required' => false,

                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
//                'constraints' => [
//                    new File([
//                        'maxSize' => '1024k',
//                        'mimeTypes' => [
//                            'application/pdf',
//                            'application/x-pdf',
//                        ],
//                        'mimeTypesMessage' => 'Please upload a valid PDF document',
//                    ])
//                ],
            ])
//            ->add('createdAt', DateType::class, [
//                'attr' => [
//                    'class' => 'form-control shadow-none'
//                ],
//            ])
            ->add('save', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-sm btn-success',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Testimonial::class,
        ]);
    }
}
