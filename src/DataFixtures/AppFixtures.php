<?php

namespace App\DataFixtures;

use App\Entity\Post;
use App\Entity\Image;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // On configure dans quelles langues nous voulons nos données

        $faker = Faker\Factory::create('fr_FR');
        // on créé 10 posts

        for ($i = 0; $i < 10; $i++) {

            $post = new Post();
            $post ->setTitle($faker->sentence($nbWords = 6, $variableNbWords = true));
            $post ->setLink('https://youtu.be/psaDHhZ0cPs');
            $post ->setDuration($faker->numberBetween($min = 15, $max = 1000));
            $post ->setDate($faker->dateTime($max = 'now', $timezone = null));
            $post ->setPrice($faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = 999.99));
            $post->setContent($faker->text($minNbChars = 300, $maxNbChars = 500));
            $post->setPostType($faker->randomElement($array = array ('video','post')));
            $post->setStatus($faker->randomElement($array = array ('open','close')));

            $image = new Image();
            $image->setTitle("Le titre de mon image $i");
            $image->setLink('https://picsum.photos/600/400/?random');
            $image->setDimension('600 x 400 px');

            $post->setImage($image);

            $manager->persist($post);
        }   
        $manager->flush();    
    }  
}