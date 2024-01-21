<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Repository\RecetteRepository;
use ApiPlatform\Metadata\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: RecetteRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ApiResource(
    operations: [
        new Get(),
        new Delete(),
        new Patch(),
        new Post(),
        new GetCollection(),
        new GetCollection(
            uriTemplate: '/ingredients/{idIngredient}/quantite_ingredients/recettes',
            uriVariables: [
                'idIngredient' => new Link(
                    fromProperty: 'quantiteIngredients',
                    fromClass: Ingredient::class
                )
            ],
        ),
    ],
    normalizationContext: ["groups" => ["recette:read"]],
)]class Recette
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['recette:read', 'quantiteIngredient:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['recette:read', 'quantiteIngredient:read'])]
    private ?string $titre = null;

    #[ORM\Column(length: 255)]
    #[Groups(['recette:read', 'quantiteIngredient:read'])]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    #[Groups(['recette:read', 'quantiteIngredient:read'])]
    private ?string $conseil = null;

    #[ORM\OneToMany(mappedBy: 'recette', targetEntity: QuantiteIngredient::class)]
    #[Groups(['recette:read'])]
    private Collection $ingredients;

    #[ORM\ManyToMany(targetEntity: Materiel::class, inversedBy: 'recettes')]
    #[Groups(['recette:read'])]
    private Collection $materiels;

    #[ORM\Column(length: 255)]
    #[Groups(['recette:read', 'quantiteIngredient:read'])]
    private ?string $duree = null;

    #[ORM\Column]
    #[Groups(['recette:read', 'quantiteIngredient:read'])]
    private ?float $prix = null;

    #[ApiProperty(writable: false)]
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['recette:read', 'quantiteIngredient:read'])]
    private ?\DateTimeInterface $datePublication = null;

    #[ORM\ManyToMany(targetEntity: CategorieRecette::class, mappedBy: 'recettes')]
    private Collection $categorieRecettes;

    public function __construct()
    {
        $this->ingredients = new ArrayCollection();
        $this->materiels = new ArrayCollection();
        $this->categorieRecettes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

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

    public function getConseil(): ?string
    {
        return $this->conseil;
    }

    public function setConseil(string $conseil): static
    {
        $this->conseil = $conseil;

        return $this;
    }

    /**
     * @return Collection<int, QuantiteIngredient>
     */
    public function getIngredients(): Collection
    {
        return $this->ingredients;
    }

    /**
     * @param Collection $ingredients
     */
    public function setIngredients(Collection $ingredients): void
    {
        $this->ingredients = $ingredients;
    }

    public function addIngredient(QuantiteIngredient $ingredient): static
    {
        if (!$this->ingredients->contains($ingredient)) {
            $this->ingredients->add($ingredient);
            $ingredient->setRecette($this);
        }

        return $this;
    }

    public function removeIngredient(QuantiteIngredient $ingredient): static
    {
        if ($this->ingredients->removeElement($ingredient)) {
            // set the owning side to null (unless already changed)
            if ($ingredient->getRecette() === $this) {
                $ingredient->setRecette(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Materiel>
     */
    public function getMateriels(): Collection
    {
        return $this->materiels;
    }

    public function addMateriel(Materiel $materiel): static
    {
        if (!$this->materiels->contains($materiel)) {
            $this->materiels->add($materiel);
        }

        return $this;
    }

    public function removeMateriel(Materiel $materiel): static
    {
        $this->materiels->removeElement($materiel);

        return $this;
    }

    public function getDuree(): ?string
    {
        return $this->duree;
    }

    public function setDuree(string $duree): static
    {
        $this->duree = $duree;

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

    public function getDatePublication(): ?\DateTimeInterface
    {
        return $this->datePublication;
    }

    public function setDatePublication(\DateTimeInterface $datePublication): static
    {
        $this->datePublication = $datePublication;

        return $this;
    }

    /**
     * @return Collection<int, CategorieRecette>
     */
    public function getCategorieRecettes(): Collection
    {
        return $this->categorieRecettes;
    }

    public function addCategorieRecette(CategorieRecette $categorieRecette): static
    {
        if (!$this->categorieRecettes->contains($categorieRecette)) {
            $this->categorieRecettes->add($categorieRecette);
            $categorieRecette->addRecette($this);
        }

        return $this;
    }

    public function removeCategorieRecette(CategorieRecette $categorieRecette): static
    {
        if ($this->categorieRecettes->removeElement($categorieRecette)) {
            $categorieRecette->removeRecette($this);
        }

        return $this;
    }


}
