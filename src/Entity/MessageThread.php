<?php

namespace App\Entity;

use App\Entity\Tools\TimeStampTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MessageThreadRepository")
 */
class MessageThread
{
    use TimeStampTrait;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ItemAd", inversedBy="messageThreads")
     */
    private $itemAd;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Message", mappedBy="messageThread")
     */
    private $messageUser;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Message", mappedBy="messageThread")
     */
    private $messageOwner;

    public function __construct()
    {
        $this->messageUser = new ArrayCollection();
        $this->messageOwner = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection|Message[]
     */
    public function getMessageUser(): Collection
    {
        return $this->messageUser;
    }

    public function addMessageUser(Message $messageUser): self
    {
        if (!$this->messageUser->contains($messageUser)) {
            $this->messageUser[] = $messageUser;
            $messageUser->setMessageThread($this);
        }

        return $this;
    }

    public function removeMessageUser(Message $messageUser): self
    {
        if ($this->messageUser->contains($messageUser)) {
            $this->messageUser->removeElement($messageUser);
            // set the owning side to null (unless already changed)
            if ($messageUser->getMessageThread() === $this) {
                $messageUser->setMessageThread(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Message[]
     */
    public function getMessageOwner(): Collection
    {
        return $this->messageOwner;
    }

    public function addMessageOwner(Message $messageOwner): self
    {
        if (!$this->messageOwner->contains($messageOwner)) {
            $this->messageOwner[] = $messageOwner;
            $messageOwner->setMessageThread($this);
        }

        return $this;
    }

    public function removeMessageOwner(Message $messageOwner): self
    {
        if ($this->messageOwner->contains($messageOwner)) {
            $this->messageOwner->removeElement($messageOwner);
            // set the owning side to null (unless already changed)
            if ($messageOwner->getMessageThread() === $this) {
                $messageOwner->setMessageThread(null);
            }
        }

        return $this;
    }
}
