<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pseudo;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Item", mappedBy="author")
     */
    private $items;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Score", mappedBy="author")
     */
    private $scores;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ItemAd", mappedBy="author")
     */
    private $itemAds;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Message", inversedBy="author")
     */
    private $messages;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ItemAdLike", mappedBy="author")
     */
    private $itemAdLikes;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_deleted;

    public function __construct()
    {
        $this->items = new ArrayCollection();
        $this->scores = new ArrayCollection();
        $this->itemAds = new ArrayCollection();
        $this->messages = new ArrayCollection();
        $this->itemAdLikes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    /**
     * @return Collection|Item[]
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(Item $item): self
    {
        if (!$this->items->contains($item)) {
            $this->items[] = $item;
            $item->setAuthor($this);
        }

        return $this;
    }

    public function removeItem(Item $item): self
    {
        if ($this->items->contains($item)) {
            $this->items->removeElement($item);
            // set the owning side to null (unless already changed)
            if ($item->getAuthor() === $this) {
                $item->setAuthor(null);
            }
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
            $score->setAuthor($this);
        }

        return $this;
    }

    public function removeScore(Score $score): self
    {
        if ($this->scores->contains($score)) {
            $this->scores->removeElement($score);
            // set the owning side to null (unless already changed)
            if ($score->getAuthor() === $this) {
                $score->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ItemAd[]
     */
    public function getItemAds(): Collection
    {
        return $this->itemAds;
    }

    public function addItemAd(ItemAd $itemAd): self
    {
        if (!$this->itemAds->contains($itemAd)) {
            $this->itemAds[] = $itemAd;
            $itemAd->setAuthor($this);
        }

        return $this;
    }

    public function getMessage(): ?ArrayCollection
    {
        return $this->messages;
    }

    public function addMessage(Message $message): self
    {
        if (!$this->messages->contains($message)) {
            $this->messages[] = $message;
            $message->setAuthor($this);
        }

        return $this;
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
            $itemAdLike->setAuthor($this);
        }

        return $this;
    }

    public function removeItemAdLike(ItemAdLike $itemAdLike): self
    {
        if ($this->itemAdLikes->contains($itemAdLike)) {
            $this->itemAdLikes->removeElement($itemAdLike);
            // set the owning side to null (unless already changed)
            if ($itemAdLike->getAuthor() === $this) {
                $itemAdLike->setAuthor(null);
            }
        }

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
}
