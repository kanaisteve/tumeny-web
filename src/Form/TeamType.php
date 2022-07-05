<?php

namespace App\Form;

use App\Entity\Team;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class TeamType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'form-control form-control-sm shadow-none',
                    'placeholder' => 'Enter first name'
                ],
            ])
            ->add('lastName', TextType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'form-control form-control-sm shadow-none',
                    'placeholder' => 'Enter last name'
                ],
            ])
            ->add('jobTitle', TextType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'form-control form-control-sm shadow-none',
                    'placeholder' => 'Enter job title'
                ],
            ])
            ->add('about', TextareaType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'form-control form-control-sm shadow-none',
                    'rows' => '3',
                    'placeholder' => 'About staff member...'
                ],
            ])
            ->add('facebook', TextType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'form-control form-control-sm shadow-none',
                    'placeholder' => 'https://facebook.com/username'
                ],
            ])
            ->add('twitter', TextType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'form-control form-control-sm shadow-none',
                    'placeholder' => 'https://twitter.com/username'
                ],
            ])
            ->add('linkedin', TextType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'form-control form-control-sm shadow-none',
                    'placeholder' => 'https://linkedin.com/username'
                ],
            ])
            ->add('instagram', TextType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'form-control form-control-sm shadow-none',
                    'placeholder' => 'https://instagram.com/username'
                ],
            ])
            ->add('imagePath', FileType::class, [
                'attr' => array(
                    'class' => 'form-control form-control-sm shadow-none'
                ),
                'label' => 'Staff Avatar',

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
            'data_class' => Team::class,
        ]);
    }
}
