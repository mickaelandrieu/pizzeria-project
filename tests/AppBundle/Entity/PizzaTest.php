<?php

namespace Tests\AppBundle\Entity;

use AppBundle\Entity\Pizza;
use AppBundle\Entity\Ingredient;
use AppBundle\Entity\PizzaIngredient;
use AppBundle\Entity\ValueObject\Price;

class PizzaTest extends \PHPUnit_Framework_TestCase
{
    public function testGetSellingPriceWithoutIngredientsIsZero()
    {
        $pizza = new Pizza();
        $this->assertEquals(0, $pizza->getSellingPrice()->getAmount());
    }
    
    public function testGetSellingPriceWithIngredientsIsOk()
    {
        $pizza = new Pizza();
        $tomato = $this->createIngredient('tomato', 1.0);
        $pizza->addIngredient($this->createPizzaIngredient($tomato, 1));

        $this->assertEquals(1.5, $pizza->getSellingPrice()->getAmount());
    }
    
    private function createIngredient($name, $price)
    {
        $ingredient = new Ingredient();

        return $ingredient->setName($name)
            ->setCostPrice(new Price($price))
        ;
    }
    
    private function createPizzaIngredient(Ingredient $ingredient, $position)
    {
        $pizzaIngredient = new PizzaIngredient();

        return $pizzaIngredient->setIngredient($ingredient)
            ->setPosition($position)
        ;
    }
}