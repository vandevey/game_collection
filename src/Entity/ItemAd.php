<?php

namespace App\Entity;

use App\Entity\Tools\TimeStampTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Doctrine\ORM\Mapping\DiscriminatorMap;
use Doctrine\ORM\Mapping\InheritanceType;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ItemAdRepository")
 */
class ItemAd
{
    use TimeStampTrait;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_deleted = false;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_visible = true;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Offer", mappedBy="itemAd", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $offer;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Request", mappedBy="itemAd", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $request;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Score", mappedBy="itemAd")
     */
    private $scores;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="itemAds")
     */
    private $author;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\MessageThread", mappedBy="itemAd")
     */
    private $messageThreads;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ItemAdLike", mappedBy="itemAd")
     */
    private $itemAdLikes;

    public function __construct()
    {
        $this->scores = new ArrayCollection();
        $this->messageThreads = new ArrayCollection();
        $this->itemAdLikes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getIsDeleted(): ?bool
    {
        return $this->is_deleted;
    }

    public function setIsDeleted(bool $is_deleted): self
    {
        $this->is_deleted = $is_deleted;

        return $this;
    }

    public function getIsVisible(): ?bool
    {
        return $this->is_visible;
    }

    public function setIsVisible(bool $is_visible): self
    {
        $this->is_visible = $is_visible;

        return $this;
    }

    public function getOffer(): ?Offer
    {
        return $this->offer;
    }

    public function setOffer(Offer $offer): self
    {
        $this->offer = $offer;

        // set the owning side of the relation if necessary
        if ($offer->getItemAd() !== $this) {
            $offer->setItemAd($this);
        }

        return $this;
    }

    public function getRequest(): ?Request
    {
        return $this->request;
    }

    public function setRequest(?Request $request): self
    {
        $this->request = $request;

        // set (or unset) the owning side of the relation if necessary
        $newItemAd = null === $request ? null : $this;
        if ($request->getItemAd() !== $newItemAd) {
            $request->setItemAd($newItemAd);
        }

        return $this;
    }

    /**
     * @return Collection|Score[]
     */
    public function getScores(): Collection
    {
        return $this->scores;
    }

    public function addScore(Score $score): self
    {
        if (!$this->scores->contains($score)) {
            $this->scores[] = $score;
            $score->setItemAd($this);
        }

        return $this;
    }

    public function removeScore(Score $score): self
    {
        if ($this->scores->contains($score)) {
            $this->scores->removeElement($score);
            // set the owning side to null (unless already changed)
            if ($score->getItemAd() === $this) {
                $score->setItemAd(null);
            }
        }

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

    /**
     * @return Collection|MessageThread[]
     */
    public function getMessageThreads(): Collection
    {
        return $this->messageThreads;
    }

    public function addMessageThread(MessageThread $messageThread): self
    {
        if (!$this->messageThreads->contains($messageThread)) {
            $this->messageThreads[] = $messageThread;
            $messageThread->setItemAd($this);
        }

        return $this;
    }

    public function isOffer()
    {
        return null === $this->offer;
    }

    public function __toString()
    {
        return $this->title;
    }

    /**
     * @return Collection|ItemAdLike[]
     */
    public function getItemAdLikes(): Collection
    {
        return $this->itemAdLikes;
    }

    public function addItemAdLike(ItemAdLike $itemAdLike): self
    {
        if (!$this->itemAdLikes->contains($itemAdLike)) {
            $this->itemAdLikes[] = $itemAdLike;
            $itemAdLike->setItemAd($this);
        }

        return $this;
    }

    public function removeItemAdLike(ItemAdLike $itemAdLike): self
    {
        if ($this->itemAdLikes->contains($itemAdLike)) {
            $this->itemAdLikes->removeElement($itemAdLike);
            // set the owning side to null (unless already changed)
            if ($itemAdLike->getItemAd() === $this) {
                $itemAdLike->setItemAd(null);
            }
        }

        return $this;
    }
}
