<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Table(name="pizza")
 * @ORM\Entity()
 */
class Pizza
{
    const COOKING_COST = 0.5;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    private $sellingPrice;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     * @ORM\OneToMany(targetEntity="PizzaIngredient", mappedBy="pizza", cascade={"persist"})
     * @ORM\JoinTable(name="pizzas_ingredients",
     *     joinColumns={@ORM\JoinColumn(name="pizza_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="ingredient_id", referencedColumnName="id")}
     * )
     * @ORM\OrderBy({"position" = "ASC"})
     */
    private $ingredients;

    public function __construct()
    {
        $this->ingredients = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getSellingPrice()
    {
        $priceAmount = 0;

        foreach ($this->ingredients as $ingredient) {
            $priceAmount += $ingredient->getIngredient()
                ->GetCostPrice()
                ->getAmount()
            ;
        }

        $sellingAmount = $priceAmount + self::COOKING_COST * $priceAmount;

        return new ValueObject\Price($sellingAmount);
    }

    public function addIngredient(PizzaIngredient $ingredient)
    {
        $this->ingredients->add($ingredient);

        return $this;
    }

    public function removeIngredient(PizzaIngredient $ingredient)
    {
        $this->ingredients->remove($ingredient);

        return $this;
    }

    public function getIngredients()
    {
        return $this->ingredients;
    }
}
