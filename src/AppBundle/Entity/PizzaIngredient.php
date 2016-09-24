<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="pizza_ingredient")
 * @ORM\Entity()
 */
class PizzaIngredient
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="position", type="integer")
     */
    private $position;

    /**
     * @ORM\ManyToOne(targetEntity="Ingredient")
     * @ORM\JoinColumn(name="ingredient_id", referencedColumnName="id")
     */
    private $ingredient;

    /**
     * @ORM\ManyToOne(targetEntity="Pizza", inversedBy="ingredients")
     * @ORM\JoinColumn(name="pizza_id", referencedColumnName="id")
     */
    private $pizza;

    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    public function getPosition()
    {
        return $this->position;
    }

    public function setIngredient(Ingredient $ingredient)
    {
        $this->ingredient = $ingredient;

        return $this;
    }

    public function getIngredient()
    {
        return $this->ingredient;
    }

    public function setPizza(Pizza $pizza)
    {
        $this->pizza = $pizza;

        return $this;
    }

    public function getPizza()
    {
        return $this->pizza;
    }

    public function remove()
    {
        $this->pizza = null;
    }
}
