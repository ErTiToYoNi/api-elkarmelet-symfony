<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name:'`user`')]
#[ORM\UniqueConstraint(name: 'idx_username',columns: ['username'])]
#[UniqueEntity(fields: ['username'], message: 'Ya existe alguien con ese usuario')]
#[UniqueEntity(fields: ['email'], message: 'Ya existe alguien con ese email')]
class User implements UserInterface ,PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Este campo no puede estar vacio')]
    #[Assert\Length(
        min: 2,
        max: 100,
        minMessage: 'Tu nombre debe tener al menos {{ limit }} caracteres ',
        maxMessage: 'Tu nombre no puede tener más de {{ limit }} caracteres',
    )]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Este campo no puede estar vacio')]
    #[Assert\Email(
        message: 'El email {{ value }} no es un email valido',
    )]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Este campo no puede estar vacio')]
    #[Assert\Length(
        min: 6,
        max: 255,
        minMessage: 'Tu contraseña debe tener al menos {{ limit }} caracteres ',
        maxMessage: 'Tu contraseña no puede tener más de {{ limit }} caracteres',
    )]
    private ?string $passwd = null;

    #[ORM\Column(length: 32)]
    #[Assert\NotBlank(message: 'Este campo no puede estar vacio')]
    #[Assert\Length(
        min: 5,
        max: 12,
        minMessage: 'El numero de telefono es muy corto ',
        maxMessage: 'l numero de telefono es muy largo',
    )]
    private ?string $phoneNumber = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message: 'Este campo no puede estar vacio')]
    private ?string $role = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message: 'Este campo no puede estar vacio')]
    #[Assert\Length(
        min: 2,
        max: 50,
        minMessage: 'Tu nombre debe tener al menos {{ limit }} caracteres ',
        maxMessage: 'Tu nombre no puede tener más de {{ limit }} caracteres',
    )]
    private ?string $username = null;

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
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

    public function getPasswd(): ?string
    {
        return $this->passwd;
    }

    public function setPasswd(string $passwd): self
    {
        $this->passwd = $passwd;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }
    public function getRoles():array
    {
        return [$this->getRole()];
    }

    public function getPassword(): ?string
    {
        return $this->passwd;
    }

    public function getSalt(): string
    {
        return "";
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function getUserIdentifier(): ?string
    {
        return $this->getUsername();
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

}