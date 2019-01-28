<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\Extension\Core\Type\ImageType;
use Symfony\Component\Form\Extension\Core\Type\EntityType;

use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label'=>'Nom du post', 
                'placeholder'=>'Choisissez un nom court et explicite'
                ])
            ->add('post_type', CheckboxType::class, [
                'label'=>'Cochez si c\'est une vidéo'
                ])
            ->add('link', TextType::class, [
                'label'=>'URL de la vidéo', 
                'placeholder'=>'Chemin de la vidéo',
                'required'=>false
                ])
            ->add('duration', IntegerType::class, [
                'label'=>'Durée de la vidéo', 
                'placeholder'=>'Durée en minutes',
                'required'=>false
                ])
            ->add('price', NumberType::class, [
                'label'=>'Prix', 
                'placeholder'=>'ex : 20.00',
                'required'=>false
                ])
            ->add('content', TextareaType::class, [
                'label'=>'Texte du post', 
                ])
            ->add('status', CheckboxType::class, [
                'label'=>'Mettre en ligne'
                ])
            ->add('image', ImageType::class)
            ->add('categories', EntityType::class, [
                'class'=>'App:Category',
                'choice_label'=>'name',
                'multiple'=>true,
                'expanded'=>false
            ])
            ->add('save', SubmitType::class);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
