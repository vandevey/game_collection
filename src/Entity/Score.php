<?php

namespace App\Entity;

use App\Entity\Tools\TimeStampTrait;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ScoreRepository")
 */
class Score
{
    use TimeStampTrait;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Range(
     *     min = 0,
     *     max = 5,
     * )
     */
    private $value;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="scores")
     */
    private $author;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ItemAd", inversedBy="scores")
     */
    private $itemAd;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValue(): ?int
    {
        return $this->value;
    }

    public function setValue(int $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

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
