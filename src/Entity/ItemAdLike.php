<?php

namespace App\Entity;

use App\Entity\Tools\TimeStampTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ItemAdLikeRepository")
 */
class ItemAdLike
{
    use TimeStampTrait;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $liked;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="itemAdLikes")
     */
    private $author;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ItemAd", inversedBy="itemAdLikes")
     */
    private $itemAd;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLiked(): ?bool
    {
        return $this->liked;
    }

    public function setLiked(bool $liked): self
    {
        $this->liked = $liked;

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
