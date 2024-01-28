<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Repository\IngredientRepository;
use App\State\AuthorProcessor;
use App\Validator\WriteLinkGroupGenerator;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Security\Core\Exception\AuthenticationCredentialsNotFoundException;
use Symfony\Component\Serializer\Annotation\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: IngredientRepository::class)]
#[ApiResource(
    operations: [
        new Get(),
        new GetCollection(),
        new Delete(security: "(is_granted('ROLE_USER') and object.getOwner() == user) or is_granted('ROLE_ADMIN')"),
        new Post(
            inputFormats: ['multipart' => ['multipart/form-data']],
            denormalizationContext: ["groups" => ["write"]],
            security: "is_granted('ROLE_USER')",
            validationContext: ["groups" => WriteLinkGroupGenerator::class],
            processor: AuthorProcessor::class
        ),
        new GetCollection(uriTemplate: 'utilisateurs/{idUtilisateur}/ingredients',
            uriVariables: [
                'idUtilisateur' => new Link(
                    fromProperty: 'ingredients',
                    fromClass: Utilisateur::class
                )
            ],
        ),
        new Patch(
            denormalizationContext: ["groups" => ["write"]],
            security: "is_granted('ROLE_USER') and object.getOwner() == user",
            validationContext: ["groups" => WriteLinkGroupGenerator::class],
            processor: AuthorProcessor::class
        ),
    ],
    normalizationContext: ["groups" => ["ingredient:read"]],
)]
#[Vich\Uploadable]
class Ingredient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['ingredient:read', "quantiteIngredient:read", "recette:read", 'categorie_ingredient:read'])]
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
    #[Groups(['ingredient:read', "quantiteIngredient:read", "recette:read", "write", 'categorie_ingredient:read'])]
    private ?string $nom = null;

    #[Assert\Length(
        max: 255,
        maxMessage: "La description est trop longue! (255 caractères maximum)"
    )]
    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['ingredient:read', "quantiteIngredient:read", "recette:read", "write", 'categorie_ingredient:read'])]
    private ?string $description = null;

    #[ApiProperty(writable: false)]
    #[ORM\OneToMany(mappedBy: 'idIngredient', targetEntity: QuantiteIngredient::class)]
    #[ORM\JoinColumn(onDelete: "CASCADE")]
    #[Groups(['ingredient:read'])]
    private Collection $quantiteIngredients;

    #[ORM\Column(nullable: true)]
    #[Groups(['ingredient:read', "quantiteIngredient:read", "recette:read", "write", 'categorie_ingredient:read'])]
    private mixed $prix = null;

    #[Vich\UploadableField(mapping: 'ingredient', fileNameProperty: 'imageName', size: 'imageSize')]
    #[Groups(['write', 'ingredient:read'])]
    private ?File $imageFile = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['ingredient:read', "quantiteIngredient:read", "recette:read", 'categorie_ingredient:read'])]
    private ?string $imageName = null;

    #[ORM\Column(nullable: true)]
    private ?int $imageSize = null;

    #[ORM\ManyToMany(targetEntity: CategorieIngredient::class, mappedBy: 'ingredients')]
    #[Groups(['ingredient:read', 'write'])]
    private Collection $categorieIngredients;

    #[ORM\ManyToOne(fetch: "EAGER", inversedBy: 'ingredients')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    #[ApiProperty(writable: false)]
    #[Groups(['ingredient:read'])]
    private ?Utilisateur $utilisateur = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Blank(groups: ["write"], message: "Le lien ne peut pas être renseigné pour les utilisateurs non premium")]
    #[Assert\Url(message: "Le lien doit être une URL valide", protocols: ['http', 'https'], groups: ["premium"])]
    #[Groups(["materiel:read","write","premium"])]
    private ?string $lien = null;

    public function __construct()
    {
        $this->quantiteIngredients = new ArrayCollection();
        $this->categorieIngredients = new ArrayCollection();
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

    /**
     * @return Collection<int, CategorieIngredient>
     */
    public function getCategorieIngredients(): Collection
    {
        return $this->categorieIngredients;
    }

    public function addCategorieIngredient(CategorieIngredient $categorieIngredient): static
    {
        if (!$this->categorieIngredients->contains($categorieIngredient)) {
            $this->categorieIngredients->add($categorieIngredient);
            $categorieIngredient->addIngredient($this);
        }

        return $this;
    }

    public function removeCategorieIngredient(CategorieIngredient $categorieIngredient): static
    {
        if ($this->categorieIngredients->removeElement($categorieIngredient)) {
            $categorieIngredient->removeIngredient($this);
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

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function getOwner(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): static
    {
        $this->utilisateur = $utilisateur;
        return $this;
    }

    public function getLien(): ?string
    {
        return $this->lien;
    }

    public function setLien(?string $lien): static
    {
        $this->lien = $lien;

        return $this;
    }
}
