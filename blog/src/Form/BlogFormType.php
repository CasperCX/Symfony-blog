<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class BlogFormType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('title', TextType::class, 
                ['constraints' => [new NotBlank()],
                    'attr' => ['class' => 'form-control']
                ])
            ->add('slug', TextareaType::class, 
                ['constraints' => [new NotBlank()],
                    'attr' => ['class' => 'form-control']
                ])
            ->add('slug', TextareaType::class, 
                ['constraints' => [new NotBlank()],
                'attr' => ['class' => 'form-control']
                ])
            ->add('description', TextareaType::class, 
                ['constraints' => [new NotBlank()],
                'attr' => ['class' => 'form-control']
                ])
            ->add('body', TextareaType::class, 
                ['constraints' => [new NotBlank()],
                'attr' => ['class' => 'form-control']
                ])
            ->add('save', SubmitType::class,
                ['label' => 'Create', 
                    'attr' => ['class' => 'btn btn-primary mt-3'],
                    'label' => 'Create Blog'
                ]);
        }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => 'App\Entity\BlogPost'
        ]);
    }


    public function getName() {
        return 'blog_form';
    }
}
