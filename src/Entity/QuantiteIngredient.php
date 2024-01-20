<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Repository\QuantiteIngredientRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: QuantiteIngredientRepository::class)]
#[ApiResource(
    operations: [
        new Get(),
        new Delete(),
        new Patch(),
        new Post(),
        new GetCollection(),
    ],
    normalizationContext: ["groups" => ["quantiteIngredient:read"]],
)]
class QuantiteIngredient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['quantiteIngredient:read', "recette:read"])]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups(['quantiteIngredient:read', "recette:read"])]
    private ?float $quantite = null;

    #[ORM\Column(length: 255)]
    #[Groups(['quantiteIngredient:read', "recette:read"])]
    private ?string $unite = null;

    #[ORM\ManyToOne(inversedBy: 'quantiteIngredients')]
    #[Groups(['quantiteIngredient:read', "recette:read"])]
    private ?Ingredient $idIngredient = null;

    #[ApiProperty(writable : false)]
    #[ORM\ManyToOne(inversedBy: 'ingredients')]
    private ?Recette $recette = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantite(): ?float
    {
        return $this->quantite;
    }

    public function setQuantite(float $quantite): static
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getUnite(): ?string
    {
        return $this->unite;
    }

    public function setUnite(string $unite): static
    {
        $this->unite = $unite;

        return $this;
    }

    public function getIdIngredient(): ?Ingredient
    {
        return $this->idIngredient;
    }

    public function setIdIngredient(?Ingredient $idIngredient): static
    {
        $this->idIngredient = $idIngredient;

        return $this;
    }

    public function getRecette(): ?Recette
    {
        return $this->recette;
    }

    public function setRecette(?Recette $recette): static
    {
        $this->recette = $recette;

        return $this;
    }
}
