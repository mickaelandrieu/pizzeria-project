<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Pizza;
use AppBundle\Entity\PizzaIngredient;

class LoadPizzaData extends AbstractFixture implements OrderedFixtureInterface
{
    public static $manager;

    public function load(ObjectManager $manager)
    {
        self::$manager = $manager;

        $this->createPizza('Fun Pizza', [
                'tomato',
                'sliced mushrooms',
                'feta cheese',
                'sausages',
                'sliced onion',
                'mozarella cheese',
                'oregano',
            ]
        );
        $this->createPizza('Super Mushroom', [
                'tomato',
                'bacon',
                'mozarella cheese',
                'sliced mushrooms',
                'oregano',
            ]
        );
    }

    public function getOrder()
    {
        return 2;
    }

    private function createPizza($name, $ingredients)
    {
        $pizza = new Pizza();
        $pizza->setName($name);

        foreach ($ingredients as $position => $ingredient) {
            ++$position; // start position at 1
            $pizzaIngredient = new PizzaIngredient();

            $pizzaIngredient
                ->setPizza($pizza)
                ->setIngredient($this->getReference($ingredient))
                ->setPosition($position)
            ;

            $pizza->addIngredient($pizzaIngredient);
        }

        self::$manager->persist($pizza);
        self::$manager->flush();
    }
}
