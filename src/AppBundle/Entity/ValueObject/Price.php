<?php

namespace AppBundle\Entity\ValueObject;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable
 */
class Price
{
    /**
     * @var float
     *
     * @ORM\Column(name="amount", type="float")
     */
    private $amount;

    /**
     * @var float
     *
     * @ORM\Column(name="currency", type="string")
     */
    private $currency;

    public function __construct($amount, $currency = 'EUR')
    {
        $this->amount = $amount;
        $this->currency = $currency;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function getCurrency()
    {
        return $this->currency;
    }

    public function __toString()
    {
        return $this->amount.' '.$this->currency;
    }
}
