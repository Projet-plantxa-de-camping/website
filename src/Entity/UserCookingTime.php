<?php

namespace App\Entity;

use App\Repository\UserCookingTimeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserCookingTimeRepository::class)
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
     * @ORM\Column(type="integer")
     */
    private ?int $user_id;

    /**
     * @ORM\Column(type="integer")
     */
    private ?int $cooking_time_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    public function setUserId(int $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getCookingTimeId(): ?int
    {
        return $this->cooking_time_id;
    }

    public function setCookingTimeId(int $cooking_time_id): self
    {
        $this->cooking_time_id = $cooking_time_id;

        return $this;
    }
}
