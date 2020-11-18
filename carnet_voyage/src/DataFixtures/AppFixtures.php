<?php

namespace App\DataFixtures;

use DateTime;
use App\Entity\Article;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        // $product = new Product();
        // $manager->persist($product);
        for ($i = 1; $i < 10; $i++) {
            $article = new Article();
            $article->setTitle($faker->sentence($nbWords = 6, $variableNbWords = true));
            $article->setUrlPhoto($faker->imageUrl($width = 640, $height = 480));
            $article->setUrlVideo('https://www.youtube.com/watch?v=i3mIs4TQZtY');
            $article->setDescription($faker->text);
            $article->setCreatedAt($faker->dateTime($max = 'now', $timezone = null));
            $manager->persist($article);
        }
    $manager->flush();
    }
}
