<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use App\Entity\Ingredient;
use App\Entity\Recipe;
use App\Entity\Admin;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use phpDocumentor\Reflection\DocBlock\Tags\Generic;
use App\Repository\IngredientRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{   


    private Generator $faker;

    public function __construct() 
    {
        $this->faker = Factory::create("fr_FR");
    }

    public function load(ObjectManager $manager): void
    {   
        $users = [];
        for ($i=1; $i < 50 ; $i++) { 
            $admin = new Admin();
            
            $admin->setName($this->faker->email())
                    ->setPseudonyme(mt_rand(0,1) === 1 ? $this->faker->firstName(): null)
                    ->setEmail($this->faker->email())
                    ->setPassword("password");
            $users[] = $admin;
            $manager->persist($admin);
        }
        $ingredients = [];
        for ($i=1; $i < 50 ; $i++) { 
            $ingredient = new Ingredient();
            $ingredient->setName($this->faker->word());
            $ingredient->setPrice(mt_rand(0,200));
            $ingredients[] = $ingredient;
            $manager->persist($ingredient);
        }

        for ($i=1; $i < 50 ; $i++) { 
            $recipe = new Recipe();
            $recipe->setName($this->faker->word())
                    ->setTime(mt_rand(1,1440))
                    ->setPeopleNb(mt_rand(0,1) == 1 ? mt_rand(1,50):null)
                    ->setDifficulty(mt_rand(0,1) == 1 ? mt_rand(1,5):null)
                    ->setDescription($this->faker->text(300))
                    ->setPrice(mt_rand(0,1) == 1 ? mt_rand(1,1000):null)
                    ->setIsFavorite(mt_rand(0,1) ==1 ? true:false);
            
            $recipe->setPrice(mt_rand(0,200));

            for ($j = 0; $j < mt_rand(5,15); $j++) {
                $recipe->addIngredient($ingredients[mt_rand(0, count($ingredients) - 1)]);

            }
            $manager->persist($recipe);
        }
                $manager->flush();
        
    }

}
