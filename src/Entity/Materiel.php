<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Repository\MaterielRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: MaterielRepository::class)]
#[ApiResource(
    operations: [
        new Get(),
        new Delete(),
        new Post(),
        new Patch(),
    ],
    normalizationContext: ["groups" => ["materiel:read"]],
)]class Materiel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['materiel:read', 'recette:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['materiel:read', 'recette:read'])]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    #[Groups(['materiel:read', 'recette:read'])]
    private ?string $description = null;

    #[ORM\Column]
    #[Groups(['materiel:read', 'recette:read'])]
    private ?float $prix = null;

    #[ORM\Column(length: 255)]
    #[Groups(['materiel:read', 'recette:read'])]
    private ?string $utilisation = null;

    #[ORM\Column(length: 255)]
    #[Groups(['materiel:read', 'recette:read'])]
    private ?string $caractéristique = null;

    #[ApiProperty(writable : false)]
    #[ORM\ManyToMany(targetEntity: Recette::class, mappedBy: 'materiels')]
    private Collection $recettes;

    public function __construct()
    {
        $this->recettes = new ArrayCollection();
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

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getUtilisation(): ?string
    {
        return $this->utilisation;
    }

    public function setUtilisation(string $utilisation): static
    {
        $this->utilisation = $utilisation;

        return $this;
    }

    public function getCaractéristique(): ?string
    {
        return $this->caractéristique;
    }

    public function setCaractéristique(string $caractéristique): static
    {
        $this->caractéristique = $caractéristique;

        return $this;
    }

    /**
     * @return Collection<int, Recette>
     */
    public function getRecettes(): Collection
    {
        return $this->recettes;
    }

    public function addRecette(Recette $recette): static
    {
        if (!$this->recettes->contains($recette)) {
            $this->recettes->add($recette);
            $recette->addMateriel($this);
        }

        return $this;
    }

    public function removeRecette(Recette $recette): static
    {
        if ($this->recettes->removeElement($recette)) {
            $recette->removeMateriel($this);
        }

        return $this;
    }
}
