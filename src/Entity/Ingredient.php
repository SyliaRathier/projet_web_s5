<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Repository\IngredientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: IngredientRepository::class)]
#[ApiResource(
    operations: [
        new Get(),
        new GetCollection(),
        new Delete(),
        new Post(),
        new Patch(),
    ],
    normalizationContext: ["groups" => ["ingredient:read"]],
)]
class Ingredient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['ingredient:read', "quantiteIngredient:read", "recette:read"])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['ingredient:read', "quantiteIngredient:read", "recette:read"])]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    #[Groups(['ingredient:read', "quantiteIngredient:read", "recette:read"])]
    private ?string $description = null;

    #[ApiProperty(writable : false)]
    #[ORM\OneToMany(mappedBy: 'idIngredient', targetEntity: QuantiteIngredient::class)]
    #[ORM\JoinColumn(onDelete: "CASCADE")]
    //#[Groups(['ingredient:read'])]
    private Collection $quantiteIngredients;

    #[ORM\Column]
    #[Groups(['ingredient:read', "quantiteIngredient:read", "recette:read"])]
    private ?float $prix = null;

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

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): static
    {
        $this->prix = $prix;

        return $this;
    }
}
