<?php

namespace App\Entity\Tools;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\DateTime;

trait TimeStampTrait
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     */
    protected $created_at;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     */
    protected $updatedAt;

    public function getCreatedAt(): ?\DateTime
    {
        return $this->created_at;
    }


    public function setCreatedAt(): void
    {
        if (null !== $this->created_at) {
            return;
        }

        $this->created_at = new \DateTime('now');
    }

    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = new \DateTime('now');
    }
}

