<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Dessert
 *
 * @ORM\Table(name="dessert")
 * @ORM\Entity(repositoryClass="App\Repository\DessertRepository")
 */
class Dessert
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
     * @var string
     *
     * @ORM\Column(name="Price", type="decimal", precision=19, scale=2, nullable=false)
     */
    private $price;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="Date_Sell", type="date", nullable=true, options={"default"="NULL"})
     */
    private $dateSell = null;

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

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getDateSell(): ?\DateTimeInterface
    {
        return $this->dateSell;
    }

    public function setDateSell(?\DateTimeInterface $dateSell): self
    {
        $this->dateSell = $dateSell;

        return $this;
    }


}
