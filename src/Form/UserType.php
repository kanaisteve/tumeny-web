<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, [
                'label' => false,
                'attr' => [
                    // 'autocomplete' => 'firstName',
                    'class' => 'form-control form-control-sm shadow-none',
                    'placeholder' => 'First Name'
                ],
            ])
            ->add('lastName', TextType::class, [
                'label' => false,
                'attr' => [
                    // 'autocomplete' => 'lastName',
                    'class' => 'form-control form-control-sm shadow-none',
                    'placeholder' => 'Last Name'
                ],
            ])
            ->add('email', TextType::class, [
                'label' => false,
                'attr' => [
                    'autocomplete' => 'email',
                    'class' => 'form-control form-control-sm shadow-none',
                    'placeholder' => 'Email'
                ],
            ])
            ->add('mobileNumber', IntegerType::class, [
                'label' => false,
                'attr' => [
                    'autocomplete' => 'mobileNumber',
                    'class' => 'form-control form-control-sm shadow-none',
                    'placeholder' => 'Mobile Number'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter your mobile number.',
                    ]),
                    new Length([
                        'min' => 9,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 9,
                        'maxMessage' => 'Your password should be of {{ limit }} characters',
                    ]),
                ],
            ])
//            ->add('roles')
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'The password fields must match',
                'required' => true,
                'first_options' => [
//                    'label' => 'Password'
                    'label' =>false,
                    'attr' => [
                        'placeholder' => 'Password',
                        'class' => 'form-control form-control-sm shadow-none mb-4'
                    ]
                ],
                'second_options' => [
//                    'label' => 'Repeat Password',
                    'label' =>false,
                    'attr' => [
                        'placeholder' => 'Repeat Password',
                        'class' => 'form-control form-control-sm shadow-none'
                    ]

                ],
            ])
//            ->add('profile')
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
            'data_class' => User::class,
        ]);
    }
}
