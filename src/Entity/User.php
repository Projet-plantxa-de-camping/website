<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\RoleRepository;
use Symfony\Component\Security\Core\User\UserInterface;
use ApiPlatform\Core\Annotation\ApiResource;



/**
 * @ORM\Entity
 * @ApiResource()
 * @UniqueEntity(
 *     fields={"email"},
 *     message="L'adresse email que vous avez tapée est déjà utilisée !" * )
 */

class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\Email
     */
    private string $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $username;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *      min = 8,
     *      minMessage = "Votre mot de passe doit comporter au minimum {{ limit }} caractères")
     */
    private string $password;
    /**
     * @Assert\EqualTo(propertyPath = "password",
     * message="Vous n'avez pas saisi le même mot de passe !" )
     */
    private string $confirm_password;

    /**
     * @ORM\Column(type="integer", options={"default" : 0})
     */
    public int $remaining_time=0;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Role")
     * @ORM\JoinColumn(nullable=false)
     */
    private Role $role;

    /**
     * @ORM\Column(type="integer")
     */
    private int $role_id;

    public function getConfirmPassword()
    {
        return $this->confirm_password;
    }

    public function setConfirmPassword($confirm_password)
    {
        $this->confirm_password = $confirm_password;
        return $this;
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

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getRemainingTime(): ?int
    {
        return $this->remaining_time;
    }

    public function setRemainingTime(int $remaining_time): self
    {
        $this->remaining_time = $remaining_time;

        return $this;
    }

    public function eraseCredentials(): void
    {
    }


    public function getSalt()
    {
    }

    public function getRoleId(): ?int
    {
        return $this->role_id;
    }

    public function setRoleId(int $role_id): self
    {
        $this->role_id = $role_id;

        return $this;
    }
    public function getRoles(): array
    {
        $roles[] =  $this->role->getLabel();
        return array_unique($roles);
    }

    public function setRole(Role $role): self
    {
        $this->role = $role;

        return $this;
    }




}
