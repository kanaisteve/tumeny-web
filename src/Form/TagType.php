<?php

namespace App\Form;

use App\Entity\Tag;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TagType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => false,
                'attr' => [
                    // 'autocomplete' => 'firstName',
                    'class' => 'form-control shadow-none mb-3',
                    'placeholder' => 'Enter tag name'
                ],
            ])
//            ->add('slug', TextType::class, [
//                'label' => false,
//                'attr' => [
//                    'class' => 'form-control shadow-none mb-3',
//                    'placeholder' => 'Enter slug name'
//                ],
//            ])
            ->add('save', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-sm btn-success float-end',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tag::class,
        ]);
    }
}
