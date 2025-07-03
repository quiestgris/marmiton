<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use App\Entity\Recipe;
use App\Entity\Ingredient;
use Doctrine\Common\Collections\Collection;

class RecipeTest extends TestCase
{
    public function testSomething(): void
    {
        $firstIngredient = new Ingredient();
        $secondIngredient = new Ingredient();
        $recipe = new Recipe();

        $recipe->addIngredient($firstIngredient);
        $recipe->addIngredient($secondIngredient);
        
        for ($i=0; $i < count($recipe->getIngredients()); $i++) { 
            $this->assertInstanceOf(Ingredient::class, $recipe->getIngredients()[$i]);
        }

        $this->assertEquals(2, count($recipe->getIngredients()));


    }
}
