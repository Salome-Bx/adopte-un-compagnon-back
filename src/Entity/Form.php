<?php

namespace App\Entity;

use App\Repository\FormRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: FormRepository::class)]
class Form
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['api_forms','api_home_asso_forms'])]
    private ?int $id = null;

    #[Groups(['api_forms','api_home_asso_forms'])]
    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateForm = null;

    #[Groups(['api_forms','api_home_asso_forms'])]
    #[ORM\Column(length: 255)]
    private ?string $lastname = null;

    #[Groups(['api_forms','api_home_asso_forms'])]
    #[ORM\Column(length: 255)]
    private ?string $firstname = null;

    #[Groups(['api_forms','api_home_asso_forms'])]
    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[Groups(['api_forms','api_home_asso_forms'])]
    #[ORM\Column(length: 5)]
    private ?string $postalCode = null;

    #[Groups(['api_forms','api_home_asso_forms'])]
    #[ORM\Column(length: 255)]
    private ?string $phone = null;

    #[Groups(['api_forms','api_home_asso_forms'])]
    #[ORM\Column(type: Types::TEXT)]
    private ?string $message = null;

    #[ORM\ManyToOne(inversedBy: 'form')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Pet $pet = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateForm(): ?\DateTimeInterface
    {
        return $this->dateForm;
    }

    public function setDateForm(?\DateTimeInterface $dateForm): static
    {
        $this->dateForm = $dateForm;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(string $postalCode): static
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): static
    {
        $this->message = $message;

        return $this;
    }

    public function getPet(): ?Pet
    {
        return $this->pet;
    }

    public function setPet(?Pet $pet): static
    {
        $this->pet = $pet;

        return $this;
    }
}
