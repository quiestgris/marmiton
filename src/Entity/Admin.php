<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use App\Repository\AdminRepository;

#[UniqueEntity('email')]
#[ORM\Entity(repositoryClass: AdminRepository::class)]
#[ORM\EntityListeners(['App\EntityListener\UserListener'])]
class Admin implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank()]
    #[Assert\Length(min:2, max: 50)]
    private ?string $name = null;

    #[Assert\Length(min:2, max: 50)]
    #[ORM\Column(length: 50, nullable: true)]
    private ?string $pseudonyme = null;

    #[ORM\Column(length: 600, nullable: true)]
    private ?string $password = null;

    private ?string $plainPassword = null;

    #[ORM\Column]
    #[Assert\NotNull()]
    private ?array $roles = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(length: 50)]
    #[Assert\Email()]
    private ?string $email = null;

    /**
     * @var Collection<int, Ingredient>
     */
    #[ORM\OneToMany(targetEntity: Ingredient::class, mappedBy: 'user', orphanRemoval: true)]
    private Collection $ingredients;

    

    public function __construct() {
        
        $this->roles = ["ROLE_USER"];
        $this->createdAt = new \DateTimeImmutable();
        $this->ingredients = new ArrayCollection();
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



    public function getPseudonyme(): ?string
    {
        return $this->pseudonyme;
    }

    public function setPseudonyme(?string $pseudonyme): static
    {
        $this->pseudonyme = $pseudonyme;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

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

    public function getPlainPassword() {
        return $this->plainPassword;
    }

    public function setPlainPassword($plainPassword) :static {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    public function getRoles() :array {
        return $this->roles;
    }

    public function setRoles(array $roles) :static {
        $this->roles = $roles;

        return $this;
    } 

    public function eraseCredentials(): void
    {
        // Ici tu peux nettoyer des données sensibles
    }

    public function getUserIdentifier(): string
    {
        return $this->email; // ou username, selon ton app
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword($password) :static {
        $this->password = $password;

        return $this;
    }

    /**
     * @return Collection<int, Ingredient>
     */
    public function getIngredients(): Collection
    {
        return $this->ingredients;
    }

    public function addIngredient(Ingredient $ingredient): static
    {
        if (!$this->ingredients->contains($ingredient)) {
            $this->ingredients->add($ingredient);
            $ingredient->setUser($this);
        }

        return $this;
    }

    public function removeIngredient(Ingredient $ingredient): static
    {
        if ($this->ingredients->removeElement($ingredient)) {
            // set the owning side to null (unless already changed)
            if ($ingredient->getUser() === $this) {
                $ingredient->setUser(null);
            }
        }

        return $this;
    }

}
