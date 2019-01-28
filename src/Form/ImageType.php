<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label'=>'Nom de l\'image', 
                'placeholder'=>'Choisissez un nom court et explicite'
                ])
            ->add('link', TextType::class, [
                'label'=>'URL de l\'image', 
                'placeholder'=>'Chemin de l\'image'
                ])
            ->add('dimension', TextType::class, [
                'label'=>'Taille de l\'image', 
                'placeholder'=>'ex : 300 x 200 px'
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Image::class,
        ]);
    }
}
