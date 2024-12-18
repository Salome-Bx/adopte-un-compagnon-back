<?php

namespace App\Entity;

use App\Repository\PetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PetRepository::class)]
class Pet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['api_pets', 'api_home_asso_pets', 'api_pet_edit', 'api_home_asso_forms', 'api_pet_new','api_pet_filter'])]
    private ?int $id = null;

    #[Groups(['api_pet_sos', 'api_pets', 'api_pet_id', 'api_pet_new', 'api_home_asso_pets', 'api_pet_edit', 'api_home_asso_forms','api_pet_filter'])]
    #[ORM\Column(length: 255)]
    private ?string $name = null;


    #[Groups(['api_pet_sos', 'api_pets', 'api_pet_id', 'api_pet_new', 'api_home_asso_pets', 'api_pet_edit','api_pet_filter'])]
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $birthyear = null;


    #[Groups(['api_pet_sos', 'api_pets', 'api_pet_id', 'api_pet_new', 'api_home_asso_pets', 'api_pet_edit','api_pet_filter'])]
    #[ORM\Column(length: 255)]
    private ?string $gender = null;

    #[Assert\Length(min: 30, minMessage:"Le message doit faire au minimum 30 caractères.", max: 120 , maxMessage:"Le message doit faire au plus 120 caractères.")]
    #[Groups(['api_pet_sos', 'api_pets', 'api_pet_id', 'api_pet_new', 'api_home_asso_pets', 'api_pet_edit', 'api_pet_filter'])]
    #[ORM\Column(length: 255)]
    private ?string $quickDescription = null;

    #[Assert\Length(min: 30, minMessage:"Le message doit faire au minimum 30 caractères.", max: 255 , maxMessage:"Le message doit faire au plus 255 caractères.")]
    #[Groups(['api_pet_sos', 'api_pets', 'api_pet_id', 'api_pet_new', 'api_home_asso_pets', 'api_pet_edit', 'api_pet_filter'])]
    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;
    

    #[Groups(['api_pet_sos', 'api_pets', 'api_pet_id', 'api_pet_new', 'api_home_asso_pets', 'api_pet_edit','api_pet_filter'])]
    #[ORM\Column]
    private ?bool $getAlongCats = null;

    
    #[Groups(['api_pet_sos', 'api_pets', 'api_pet_id', 'api_pet_new', 'api_home_asso_pets', 'api_pet_edit','api_pet_filter'])]
    #[ORM\Column]
    private ?bool $getAlongDogs = null;

    
    #[Groups(['api_pet_sos', 'api_pets', 'api_pet_id', 'api_pet_new', 'api_home_asso_pets', 'api_pet_edit','api_pet_filter'])]
    #[ORM\Column]
    private ?bool $getAlongChildren = null;
    
    
    #[Groups(['api_pet_new'])]
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $entryDate = null;

    #[Groups(['api_pet_new', 'api_home_asso_pets'])]
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $registerDate = null;

    #[Groups(['api_pet_new', 'api_home_asso_pets'])]
    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updateDate = null;
    
    #[Groups(['api_pets', 'api_pet_id', 'api_pet_new', 'api_home_asso_pets', 'api_pet_edit', 'api_pet_filter'])]
    #[ORM\Column]
    private ?bool $sos = null;

    #[Groups(['api_pets', 'api_pet_id', 'api_pet_new', 'api_home_asso_pets', 'api_pet_edit', 'api_pet_filter'])]
    #[ORM\Column(length: 255)]
    private ?string $race = null;

    #[Groups(['api_pets', 'api_pet_id', 'api_pet_new', 'api_home_asso_pets', 'api_pet_edit','api_pet_filter'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $categorisedDog = null;


    #[Groups(['api_pets', 'api_pet_id', 'api_pet_new', 'api_home_asso_pets', 'api_pet_edit','api_pet_filter'])]
    #[ORM\Column]
    private ?bool $sos = null;

    #[Groups(['api_pets', 'api_pet_id', 'api_pet_new', 'api_home_asso_pets', 'api_pet_edit', 'api_pet_filter'])]
    #[ORM\Column(length: 255)]
    private ?string $race = null;

    #[Groups(['api_pets', 'api_pet_id', 'api_pet_new', 'api_home_asso_pets', 'api_pet_edit','api_pet_filter'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $categorisedDog = null;

    #[Groups(['api_pets', 'api_pet_id', 'api_pet_new', 'api_home_asso_pets', 'api_pet_edit','api_pet_filter'])]
    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[Groups(['api_pets'])]
    #[ORM\ManyToOne(inversedBy: 'pets')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Species $species = null;

    /**
     * @var Collection<int, Form>
     */
    
    #[Groups([ 'api_home_asso_forms'])]
    #[ORM\OneToMany(targetEntity: Form::class, mappedBy: 'pet')]
    private Collection $form;
    
    #[Groups(['api_pet_id', 'api_pets', 'api_pet_filter'])]
    #[ORM\ManyToOne(inversedBy: 'pet')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $asso = null;

    /**
     * @var Collection<int, Behavior>
     */
    #[ORM\ManyToMany(targetEntity: Behavior::class, inversedBy: 'pets')]
    private Collection $behavior;

    public function __construct()
    {
        $this->form = new ArrayCollection();
        $this->behavior = new ArrayCollection();
    }

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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getSpecies(): ?Species
    {
        return $this->species;
    }

    public function setSpecies(?Species $species): static
    {
        $this->species = $species;

        return $this;
    }

    /**
     * @return Collection<int, Form>
     */
    public function getForm(): Collection
    {
        return $this->form;
    }

    public function addForm(Form $form): static
    {
        if (!$this->form->contains($form)) {
            $this->form->add($form);
            $form->setPet($this);
        }

        return $this;
    }

    public function removeForm(Form $form): static
    {
        if ($this->form->removeElement($form)) {
            // set the owning side to null (unless already changed)
            if ($form->getPet() === $this) {
                $form->setPet(null);
            }
        }

        return $this;
    }

    public function getAsso(): ?User
    {
        return $this->asso;
    }

    public function setAsso(?User $asso): static
    {
        $this->asso = $asso;

        return $this;
    }

    /**
     * @return Collection<int, Behavior>
     */
    public function getBehavior(): Collection
    {
        return $this->behavior;
    }

    public function addBehavior(Behavior $behavior): static
    {
        if (!$this->behavior->contains($behavior)) {
            $this->behavior->add($behavior);
        }

        return $this;
    }

    public function removeBehavior(Behavior $behavior): static
    {
        $this->behavior->removeElement($behavior);

        return $this;
    }
}
