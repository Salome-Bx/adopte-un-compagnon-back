<?php

namespace App\Entity;

use App\Repository\PetRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PetRepository::class)]
class Pet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $birthyear = null;

    #[ORM\Column(length: 255)]
    private ?string $gender = null;

    #[ORM\Column(length: 255)]
    private ?string $quickDescription = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    private ?bool $getAlongCats = null;

    #[ORM\Column]
    private ?bool $getAlongDogs = null;

    #[ORM\Column]
    private ?bool $getAlongChildren = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $entryDate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $registerDate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updateDate = null;

    #[ORM\Column]
    private ?bool $sos = null;

    #[ORM\Column(length: 255)]
    private ?string $race = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $categorisedDog = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getBirthyear(): ?\DateTimeInterface
    {
        return $this->birthyear;
    }

    public function setBirthyear(\DateTimeInterface $birthyear): static
    {
        $this->birthyear = $birthyear;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(string $gender): static
    {
        $this->gender = $gender;

        return $this;
    }

    public function getQuickDescription(): ?string
    {
        return $this->quickDescription;
    }

    public function setQuickDescription(string $quickDescription): static
    {
        $this->quickDescription = $quickDescription;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function isGetAlongCats(): ?bool
    {
        return $this->getAlongCats;
    }

    public function setGetAlongCats(bool $getAlongCats): static
    {
        $this->getAlongCats = $getAlongCats;

        return $this;
    }

    public function isGetAlongDogs(): ?bool
    {
        return $this->getAlongDogs;
    }

    public function setGetAlongDogs(bool $getAlongDogs): static
    {
        $this->getAlongDogs = $getAlongDogs;

        return $this;
    }

    public function isGetAlongChildren(): ?bool
    {
        return $this->getAlongChildren;
    }

    public function setGetAlongChildren(bool $getAlongChildren): static
    {
        $this->getAlongChildren = $getAlongChildren;

        return $this;
    }

    public function getEntryDate(): ?\DateTimeInterface
    {
        return $this->entryDate;
    }

    public function setEntryDate(\DateTimeInterface $entryDate): static
    {
        $this->entryDate = $entryDate;

        return $this;
    }

    public function getRegisterDate(): ?\DateTimeInterface
    {
        return $this->registerDate;
    }

    public function setRegisterDate(\DateTimeInterface $registerDate): static
    {
        $this->registerDate = $registerDate;

        return $this;
    }

    public function getUpdateDate(): ?\DateTimeInterface
    {
        return $this->updateDate;
    }

    public function setUpdateDate(?\DateTimeInterface $updateDate): static
    {
        $this->updateDate = $updateDate;

        return $this;
    }

    public function isSos(): ?bool
    {
        return $this->sos;
    }

    public function setSos(bool $sos): static
    {
        $this->sos = $sos;

        return $this;
    }

    public function getRace(): ?string
    {
        return $this->race;
    }

    public function setRace(string $race): static
    {
        $this->race = $race;

        return $this;
    }

    public function getCategorisedDog(): ?string
    {
        return $this->categorisedDog;
    }

    public function setCategorisedDog(?string $categorisedDog): static
    {
        $this->categorisedDog = $categorisedDog;

        return $this;
    }
}
