<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Ingredient;
use AppBundle\Entity\ValueObject\Price;

class LoadIngredientData extends AbstractFixture implements OrderedFixtureInterface
{
    public static $manager;

    public function load(ObjectManager $manager)
    {
        self::$manager = $manager;

        $this->createIngredient('tomato', 0.5, 'EUR');
        $this->createIngredient('sliced mushrooms', 0.5, 'EUR');
        $this->createIngredient('feta cheese', 1.0, 'EUR');
        $this->createIngredient('sausages', 1.0, 'EUR');
        $this->createIngredient('sliced onion', 0.5, 'EUR');
        $this->createIngredient('mozarella cheese', 0.5, 'EUR');
        $this->createIngredient('oregano', 1.0, 'EUR');
        $this->createIngredient('bacon', 1.0, 'EUR');
    }

    public function getOrder()
    {
        return 1;
    }

    private function createIngredient($name, $price, $currency)
    {
        $ingredient = new Ingredient();
        $price = new Price($price, $currency);

        $ingredient->setName($name);
        $ingredient->setCostPrice($price);

        self::$manager->persist($ingredient);
        self::$manager->flush();

        $this->addReference($name, $ingredient);
    }
}
