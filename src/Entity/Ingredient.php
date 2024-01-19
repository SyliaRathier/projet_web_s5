<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\IngredientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: IngredientRepository::class)]
#[ApiResource]
class Ingredient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'idIngredient', targetEntity: QuantiteIngredient::class)]
    private Collection $quantiteIngredients;

    public function __construct()
    {
        $this->quantiteIngredients = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

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

    /**
     * @return Collection<int, QuantiteIngredient>
     */
    public function getQuantiteIngredients(): Collection
    {
        return $this->quantiteIngredients;
    }

    public function addQuantiteIngredient(QuantiteIngredient $quantiteIngredient): static
    {
        if (!$this->quantiteIngredients->contains($quantiteIngredient)) {
            $this->quantiteIngredients->add($quantiteIngredient);
            $quantiteIngredient->setIdIngredient($this);
        }

        return $this;
    }

    public function removeQuantiteIngredient(QuantiteIngredient $quantiteIngredient): static
    {
        if ($this->quantiteIngredients->removeElement($quantiteIngredient)) {
            // set the owning side to null (unless already changed)
            if ($quantiteIngredient->getIdIngredient() === $this) {
                $quantiteIngredient->setIdIngredient(null);
            }
        }

        return $this;
    }
}
