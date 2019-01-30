<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use App\Entity\Post;
use App\Form\ImageType;

//use Symfony\Component\Form\Extension\Core\Type\ImageType;
//use Symfony\Component\Form\Extension\Core\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label'=>'Titre', 
                'attr' => [
                    'placeholder'=>'Choisir un titre court et explicite',
                    ],
                'required' => true
                ])
                
            ->add('post_type', ChoiceType::class, [
                'label'=>'Type',
                'choices'  => [
                    'Post' => 'Post',
                    'Vidéo' => 'Vidéo',
                    ],
                'multiple' =>false,
                'expanded' =>true,
                'required' => true
                ])
              
            ->add('link', UrlType::class, [
                'label'=>'URL', 
                'attr' => [
                    'placeholder'=>'URL absolue de la vidéo'
                    ],
                'required'=>false
                ])

            ->add('duration', NumberType::class, [
                'label'=>'Durée', 
                'attr' => [
                    'placeholder'=>'Durée de la vidéo en minutes'
                    ],
                'required'=>false
                ])

            ->add('price', MoneyType::class, [
                'label'=>'Prix', 
                'attr' => [
                    'placeholder'=>'Utiliser le point et pas la virgule pour les décimales (ex : 20.00)'
                    ],
                'required'=>false
                ])

            ->add('content', TextareaType::class, [
                'label'=>'Contenu',
                'required' => true 
                ])
                
            ->add('status', ChoiceType::class, [
                'label'=>'Statut',
                'choices'  => [
                    'Publié' => 'open',
                    'Non publié' => 'close',
                    ],
                'multiple' =>false,
                'expanded' =>true,
                ])
                
            //->add('image', ImageType::class)
            /*
            ->add('file', FileType::class, [
                'required' => true
            ])
                */
                /*
            ->add('categories', ChoiceType::class, [
                'label'=>'Catégories',
                'choices'  => [
                    'Initiation' => 'Initiation',
                    'Perfectionnement' => 'Perfectionnement',
                    'Introduction' => 'Introduction',
                    'Les structures de données' => 'Les structures de données',
                    'Les classes' => 'Les classes',
                    'Init cat 4' => 'Init cat 4',
                    'Lambda' => 'Lambda',
                    'Compréhension de liste' => 'Compréhension de liste',
                    'Décorateur' => 'Décorateur',
                    'Perf cat 4' => 'Perf cat 4',
                    ],
                'multiple' =>true,
                'expanded' =>false,
                ])
                */
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
