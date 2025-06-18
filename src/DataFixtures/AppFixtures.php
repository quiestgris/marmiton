<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use App\Entity\Ingredient;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i=1; $i < 200 ; $i++) { 
            $ingredient = new Ingredient();
            $ingredient->setName("Ingredient: " . $i);
            $ingredient->setPrice(mt_rand(0,200));
            $manager->persist($ingredient);
        }

        $manager->flush();
    }
}
