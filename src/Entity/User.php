<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];
 
    /**
     * @var string The hashed password
     */
    
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $lastname = null;

    #[ORM\Column(length: 255)]
    private ?string $firstname = null;

    #[Groups(['api_users', 'api_user_id', 'api_pet_id'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $address = null;

    #[Groups(['api_users', 'api_user_id', 'api_pet_id'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $city = null;

    #[Groups(['api_users', 'api_user_id', 'api_pet_id'])]
    #[ORM\Column(length: 5, nullable: true)]
    private ?string $postalCode = null;

    #[Groups(['api_users', 'api_user_id', 'api_pet_id'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $phone = null;

    #[Groups(['api_users', 'api_user_id'])]
    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $registerDate = null;

    #[Groups(['api_users', 'api_user_id', 'api_pet_id'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nameAsso = null;

    #[Groups(['api_users', 'api_user_id'])]
    #[ORM\Column(length: 14, nullable: true)]
    private ?string $siret = null;

    #[Groups(['api_users', 'api_user_id'])]
    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $gdpr = null;

    #[Groups(['api_users', 'api_user_id', 'api_pet_id'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $website = null;

    /**
     * @var Collection<int, Pet>
     */
    #[ORM\OneToMany(targetEntity: Pet::class, mappedBy: 'asso', orphanRemoval: true)]
    private Collection $pet;
    
    #[Groups(['api_users', 'api_user_id', 'api_pet_id'])]
    #[ORM\Column(length: 255)]
    private ?string $image = null;

    public function __construct()
    {
        $this->pet = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(?string $postalCode): static
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getRegisterDate(): ?\DateTimeInterface
    {
        return $this->registerDate;
    }

    public function setRegisterDate(?\DateTimeInterface $registerDate): static
    {
        $this->registerDate = $registerDate;

        return $this;
    }

    public function getNameAsso(): ?string
    {
        return $this->nameAsso;
    }

    public function setNameAsso(?string $nameAsso): static
    {
        $this->nameAsso = $nameAsso;

        return $this;
    }

    public function getSiret(): ?string
    {
        return $this->siret;
    }

    public function setSiret(?string $siret): static
    {
        $this->siret = $siret;

        return $this;
    }

    public function getGdpr(): ?\DateTimeInterface
    {
        return $this->gdpr;
    }

    public function setGdpr(?\DateTimeInterface $gdpr): static
    {
        $this->gdpr = $gdpr;

        return $this;
    }

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    public function setWebsite(?string $website): static
    {
        $this->website = $website;

        return $this;
    }

    /**
     * @return Collection<int, Pet>
     */
    public function getPet(): Collection
    {
        return $this->pet;
    }

    public function addPet(Pet $pet): static
    {
        if (!$this->pet->contains($pet)) {
            $this->pet->add($pet);
            $pet->setAsso($this);
        }

        return $this;
    }

    public function removePet(Pet $pet): static
    {
        if ($this->pet->removeElement($pet)) {
            // set the owning side to null (unless already changed)
            if ($pet->getAsso() === $this) {
                $pet->setAsso(null);
            }
        }

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }
}
