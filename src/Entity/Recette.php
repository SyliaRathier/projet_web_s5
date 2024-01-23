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
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: RecetteRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ApiResource(
    operations: [
        new Get(),
        new Delete(security: "is_granted('ROLE_USER') and object.getOwner() == user"),
        new Patch(),
        new Post(
            inputFormats: ['multipart' => ['multipart/form-data']],
            denormalizationContext: ["groups" => ["recette:write"]],
            security: "is_granted('ROLE_USER')"
        ),
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
)]
#[Vich\Uploadable]
class Recette
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['recette:read', 'quantiteIngredient:read', 'categorie_recette:read'])]
    private ?int $id = null;

    #[Assert\NotNull]
    #[Assert\NotBlank]
    #[Assert\Length(
        min:2,
        max: 50,
        minMessage: "Le titre est trop court! (2 caractères maximum)",
        maxMessage: "Le titre est trop long! (50 caractères maximum)"
    )]
    #[ORM\Column(length: 50)]
    #[Groups(['recette:read', 'quantiteIngredient:read', 'recette:write', 'categorie_recette:read'])]
    private ?string $titre = null;

    #[Assert\Length(
        min:25,
        max: 255,
        minMessage: "La description est trop courte! (25 caractères maximum)",
        maxMessage: "La description est trop longue! (255 caractères maximum)"
    )]
    #[ORM\Column(length: 255)]
    #[Groups(['recette:read', 'quantiteIngredient:read', 'recette:write', 'categorie_recette:read'])]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['recette:read', 'quantiteIngredient:read', 'recette:write', 'categorie_recette:read'])]
    private ?string $conseil = null;

    #[ORM\OneToMany(mappedBy: 'recette', targetEntity: QuantiteIngredient::class)]
    #[Groups(['recette:read', 'recette:write'])]
    private Collection $ingredients;

    #[ORM\ManyToMany(targetEntity: Materiel::class, inversedBy: 'recettes')]
    #[Groups(['recette:read', 'recette:write'])]
    private Collection $materiels;

    #[ORM\Column(length: 255)]
    #[Groups(['recette:read', 'quantiteIngredient:read', 'recette:write'])]
    private ?string $duree = null;

    #[ORM\Column]
    #[Groups(['recette:read', 'quantiteIngredient:read', 'recette:write'])]
    private mixed $prix = null;

    #[Vich\UploadableField(mapping: 'recette', fileNameProperty: 'imageName', size: 'imageSize')]
    #[Groups(['recette:write'])]
    private ?File $imageFile = null;

    #[ORM\Column(nullable: true)]
    private ?string $imageName = null;

    #[ORM\Column(nullable: true)]
    private ?int $imageSize = null;

    #[ORM\ManyToOne(inversedBy: 'recettes')]
    private ?Utilisateur $utilisateur = null;

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

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): static
    {
        $this->utilisateur = $utilisateur;
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

    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageSize(?int $imageSize): void
    {
        $this->imageSize = $imageSize;
    }

    public function getImageSize(): ?int
    {
        return $this->imageSize;
    }

}
