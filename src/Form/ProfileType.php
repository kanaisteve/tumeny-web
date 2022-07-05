<?php

namespace App\Form;

use App\Entity\Profile;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('avatar')
            ->add('about', TextareaType::class, [
                    'constraints' => [new NotBlank()],
                    'attr' => ['class' => 'form-control form-select-sm shadow-none']
                ]
            )
//            ->add('birthDate')
//            ->add('idNumber')
            ->add('gender', ChoiceType::class, [
                'choices'  => [
                    'Male' => 'male',
                    'Female' => 'female',
                ],
                'attr' => [
                    'class' => 'form-select form-select-sm shadow-none',
                ],
            ])
//            ->add('firstName', TextType::class, [
//                    'constraints' => [new NotBlank()],
//                    'attr' => ['class' => 'form-control']
//                ]
//            )
//            ->add('lastName', TextType::class, [
//                    'constraints' => [new NotBlank()],
//                    'attr' => ['class' => 'form-control']
//                ]
//            )
            ->add('country', TextType::class, [
//                    'constraints' => [new NotBlank()],
                    'attr' => ['class' => 'form-control form-select-sm shadow-none']
                ]
            )
            ->add('province', TextType::class, [
//                    'constraints' => [new NotBlank()],
                    'attr' => ['class' => 'form-control form-select-sm shadow-none']
                ]
            )
            ->add('city', TextType::class, [
//                    'constraints' => [new NotBlank()],
                    'attr' => ['class' => 'form-control form-select-sm shadow-none']
                ]
            )
            ->add('address', TextType::class, [
//                    'constraints' => [new NotBlank()],
                    'attr' => ['class' => 'form-control form-select-sm shadow-none']
                ]
            )
//            ->add('user')
            ->add('facebook',TextType::class, [
                    'attr' => ['class' => 'form-control form-select-sm shadow-none'],
                    'required' => false
                ]
            )
            ->add('twitter', TextType::class, [
                    'attr' => ['class' => 'form-control form-select-sm shadow-none'],
                    'required' => false
                ]
            )
            ->add('linkedin', TextType::class, [
                    'attr' => ['class' => 'form-control form-select-sm shadow-none'],
                    'required' => false
                ]
            )
            ->add('instagram', TextType::class, [
                    'attr' => ['class' => 'form-control form-select-sm shadow-none'],
                    'required' => false
                ]
            )
            ->add('avatar', FileType::class, [
                'attr' => array(
                    'class' => 'form-control form-control-sm shadow-none'
                ),
//                'label' => 'Staff Avatar',

                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // make it optional so you don't have to re-upload the avatar img
                // every time you edit the profile details
                'required' => false,
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
            'data_class' => Profile::class,
        ]);
    }
}
