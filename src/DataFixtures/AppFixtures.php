<?php

namespace App\DataFixtures;

use App\Entity\Post;
use App\Entity\Image;
use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // faker language
        $faker = Faker\Factory::create('fr_FR');
        // table category data
        $names = [
            'Initiation',
            'Perfectionnement',
            'Introduction',
            'Les structures de données',
            'Les classes',
            'Init cat 4',
            'Lambda',
            'Compréhension de liste',
            'Décorateur',
            'Perf cat 4'
        ];
        $parent_ids = [
            null,
            null,
            1,
            1,
            1,
            1,
            2,
            2,
            2,
            2
        ];
        
        // creation of 10 posts
        for ($i = 0; $i < 10; $i++) {

            $post = new Post();
            $post ->setTitle($faker->sentence($nbWords = 6, $variableNbWords = true));
            $post ->setLink('https://www.youtube.com/embed/pgRsKEUcikc');
            $post ->setDuration($faker->numberBetween($min = 15, $max = 1000));
            $post ->setDate($faker->dateTime($max = 'now', $timezone = null));
            $post ->setPrice($faker->randomFloat($nbMaxDecimals = null, $min = 0.00, $max = 999.99));
            $post ->setContent($faker->text($minNbChars = 700, $maxNbChars = 800));
            $post ->setPostType($faker->randomElement($array = array ('Vidéo','Post')));
            $post ->setStatus($faker->randomElement($array = array ('open','close')));

            $image = new Image();
            $image ->setTitle("Le titre de mon image $i");
            $image ->setLink("https://picsum.photos/600/400?image=$i");
            $image ->setDimension('600 x 400 px');

            $post ->setImage($image);

            $category = new Category();
            $category ->setName($names[$i]);
            $category ->setParentId($parent_ids[$i]);
            $category ->setPhoto("/images/home-$i.png");

            $post ->addCategory($category);

            $manager->persist($post);
        }   
        $manager->flush();    
    }  
}