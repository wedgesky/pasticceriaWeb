<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ingredient
 *
 * @ORM\Table(name="ingredient", indexes={@ORM\Index(name="Dessert_ID", columns={"Dessert_ID"})})
 * @ORM\Entity(repositoryClass="App\Repository\IngredientRepository")
 */
class Ingredient
{
    /**
     * @var int
     *
     * @ORM\Column(name="Id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="Name", type="string", length=256, nullable=false)
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="Amount", type="integer", nullable=false)
     */
    private $amount;

    /**
     * @var string
     *
     * @ORM\Column(name="UM", type="string", length=24, nullable=false)
     */
    private $um;

    /**
     * @var \Dessert
     *
     * @ORM\ManyToOne(targetEntity="Dessert")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Dessert_ID", referencedColumnName="Id")
     * })
     */
    private $dessert;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getUm(): ?string
    {
        return $this->um;
    }

    public function setUm(string $um): self
    {
        $this->um = $um;

        return $this;
    }

    public function getDessert(): ?Dessert
    {
        return $this->dessert;
    }

    public function setDessert(?Dessert $dessert): self
    {
        $this->dessert = $dessert;

        return $this;
    }


}
