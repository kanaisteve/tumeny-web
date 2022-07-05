<?php

namespace App\Form;

use App\Entity\ContactUs;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class ContactUsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ->add('firstName')
            // ->add('lastName')
            ->add('name', TextType::class, [
                'label' => false,
                'attr' => [
                    // 'autocomplete' => 'firstName',                     
                    'class' => 'form-control shadow-none',
                    'placeholder' => 'Your Full Names'
                ],
            ])
            ->add('email', TextType::class, [
                'label' => false,
                'attr' => [
                    // 'autocomplete' => 'firstName',                     
                    'class' => 'form-control shadow-none',
                    'placeholder' => 'Your Email'
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
            ->add('subject', TextType::class, [
                'label' => false,
                'attr' => [
                    // 'autocomplete' => 'subject',                     
                    'class' => 'form-control shadow-none',
                    'placeholder' => 'Subject'
                ],
            ])
            ->add('body', TextareaType::class, [
                'label' => false,
                'attr' => [
                    // 'autocomplete' => 'body',                     
                    'class' => 'form-control shadow-none',
                    'rows' => '6',
                    'placeholder' => 'Message'
                ],
            ])
            // ->add('status')
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
            'data_class' => ContactUs::class,
        ]);
    }
}
