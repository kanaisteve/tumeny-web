<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Post;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => false,
                'attr' => [
                    // 'autocomplete' => 'title',
                    'class' => 'form-control form-control-sm shadow-none',
                    'placeholder' => 'Enter title'
                ],
            ])
//            ->add('slug', TextType::class, [
//                'label' => false,
//                'attr' => [
//                    // 'autocomplete' => 'slug',
//                    'class' => 'form-control form-control-sm shadow-none',
//                    'placeholder' => 'Enter slug name'
//                ],
//            ])
//            ->add('excerpt', TextareaType::class, [
//                'label' => false,
//                'attr' => [
//                    // 'autocomplete' => 'body',
//                    'class' => 'form-control form-control-sm shadow-none',
//                    'rows' => '3',
//                    'placeholder' => 'Enter post excerpt...'
//                ],
//            ])
            ->add('content', TextareaType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'form-control form-control-sm shadow-none',
                    'rows' => '3',
//                    'id' => 'content',
                    'placeholder' => 'Enter post content...'
                ],
            ])
//            ->add('string')
           ->add('status', ChoiceType::class, [
               'choices'  => [
                   'Draft' => 'draft',
                   'Published' => 'published',
                   'Review' => 'review',
               ],
                'attr' => [
                    'class' => 'form-select form-select-sm shadow-none',
                ],
           ])
//            ->add('createdAt')
//            ->add('publishedAt', DateType::class, [
//                'attr' => array(
//                    'class' => 'form-control shadow-none',
//                ),
//            ])
//            ->add('viewCount', IntegerType::class, [
//                'attr' => array(
//                    'class' => 'form-control shadow-none',
//                    'placeholder' => 'Enter view count'
//                ),
//                'label' => false
//            ])
//            ->add('category')
            ->add('category', EntityType::class, [
                'class'  => Category::class,
                'attr' => [
                    'class' => 'form-select form-select-sm shadow-none'
                ],
            ])
            ->add('imagePath', FileType::class, [
                'attr' => array(
                    'class' => 'form-control form-control-sm shadow-none'
                ),
                'label' => 'Thumbnail',

                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Post details
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
