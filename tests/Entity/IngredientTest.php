<?php

namespace App\Tests;

use App\Entity\Ingredient;
use PHPUnit\Framework\TestCase;

class IngredientTest extends TestCase
{
    public function testSomething(): void
    {   
        $ingredient = new Ingredient;
        $ingredient->setName("poivron");
        $this->assertEquals($ingredient->getName(),"poivron");
    }
}
