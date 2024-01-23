<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Repository\CategorieRecetteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CategorieRecetteRepository::class)]
#[ApiResource(
    operations: [
        new Get(),
        new Delete(),
        new Patch(),
        new Post(),
        new GetCollection(),
    ],
    normalizationContext: ["groups" => ["categorie_recette:read"]],
)]
class CategorieRecette
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['categorie_recette:read'])]
    private ?int $id = null;

    #[Assert\NotNull]
    #[Assert\NotBlank]
    #[Assert\Length(
        min: 2,
        max: 50,
        minMessage: "Le nom est trop court! (2 caractères minimum)",
        maxMessage: "Le nom est trop long! (50 caractères maximum)"
    )]
    #[ORM\Column(length: 50)]
    #[Groups(['categorie_recette:read'])]
    private ?string $nom = null;

    #[ORM\ManyToMany(targetEntity: Recette::class, inversedBy: 'categorieRecettes')]
    #[Groups(['categorie_recette:read'])]
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
        }

        return $this;
    }

    public function removeRecette(Recette $recette): static
    {
        $this->recettes->removeElement($recette);

        return $this;
    }
}
