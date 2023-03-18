<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserCookingTimeRepository")
 */
class UserCookingTime
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="userCookingTimes")
     * @ORM\JoinColumn(nullable=false)
     */
    private ?User $user;

    /**
     * @ORM\ManyToOne(targetEntity=CookingTime::class, inversedBy="userCookingTimes")
     * @ORM\JoinColumn(nullable=false)
     */
    private ?CookingTime $cookingTime;

    /**
     * @ORM\Column(type="datetime", options={"default": "CURRENT_TIMESTAMP"})
     */
    private ?\DateTimeInterface $date;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getCookingTime(): ?CookingTime
    {
        return $this->cookingTime;
    }

    public function setCookingTime(?CookingTime $cookingTime): self
    {
        $this->cookingTime = $cookingTime;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }
}