<?php

namespace App\Entity;

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
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;


#[ORM\Entity(repositoryClass: RecetteRepository::class)]
#[ApiResource(
    operations: [
        new Get(),
        new Delete(),
        new Patch(),
        new Post(
            inputFormats: ['multipart' => ['multipart/form-data']],
            denormalizationContext: ["groups" => ["recette:write"]]
        ),
        new GetCollection(),
    ],
    normalizationContext: ["groups" => ["recette:read"]],
)]
#[Vich\Uploadable]
class Recette
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['recette:read', 'quantiteIngredient:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['recette:read', 'quantiteIngredient:read', 'recette:write'])]
    private ?string $titre = null;

    #[ORM\Column(length: 255)]
    #[Groups(['recette:read', 'quantiteIngredient:read', 'recette:write'])]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    #[Groups(['recette:read', 'quantiteIngredient:read', 'recette:write'])]
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

    public function __construct()
    {
        $this->ingredients = new ArrayCollection();
        $this->materiels = new ArrayCollection();
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
