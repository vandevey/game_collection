<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RequestRepository")
 */
class Request
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $itemName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $itemDescription;

    /**
     * @ORM\Column(type="integer")
     */
    private $minPrice;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $maxPrice;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\ItemAd", inversedBy="request")
     */
    private $itemAd;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getItemName(): ?string
    {
        return $this->itemName;
    }

    public function setItemName(string $itemName): self
    {
        $this->itemName = $itemName;

        return $this;
    }

    public function getItemDescription(): ?string
    {
        return $this->itemDescription;
    }

    public function setItemDescription(string $itemDescription): self
    {
        $this->itemDescription = $itemDescription;

        return $this;
    }

    public function getMinPrice(): ?int
    {
        return $this->minPrice / 100;
    }

    public function setMinPrice(int $minPrice): self
    {
        $this->minPrice = $minPrice * 100;

        return $this;
    }

    public function getMaxPrice(): ?int
    {
        return $this->maxPrice / 100;
    }

    public function setMaxPrice(?int $maxPrice): self
    {
        $this->maxPrice = $maxPrice * 100;

        return $this;
    }

    public function getItemAd(): ?ItemAd
    {
        return $this->itemAd;
    }

    public function setItemAd(?ItemAd $itemAd): self
    {
        $this->itemAd = $itemAd;

        return $this;
    }
}
