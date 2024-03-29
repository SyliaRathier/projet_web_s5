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
use App\Repository\MaterielRepository;
use App\State\AuthorProcessor;
use App\State\UtilisateurProcessor;
use App\Validator\WriteLinkGroupGenerator;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MaterielRepository::class)]
#[ApiResource(
    operations: [
        new Get(),
        new Delete(security: "(is_granted('ROLE_USER') and object.getOwner() == user) or is_granted('ROLE_ADMIN')"),
            new Post(
                inputFormats: ['multipart' => ['multipart/form-data']],
                denormalizationContext: [
                    'groups' => ['write']
                ],
                validationContext: [
                    'groups' => WriteLinkGroupGenerator::class
                ],
                processor: AuthorProcessor::class
            ),
        new GetCollection(uriTemplate: 'utilisateurs/{idUtilisateur}/materiels',
            uriVariables: [
                'idUtilisateur' => new Link(
                    fromProperty: 'materiels',
                    fromClass: Utilisateur::class
                )
            ],
        ),
        new Patch(),
        new Patch(
            denormalizationContext: [
                'groups' => ['write']
            ],
            security: "object.getOwner() == user",
            validationContext: [
                'groups' => WriteLinkGroupGenerator::class
            ],
            processor: AuthorProcessor::class
        ),
        new GetCollection(),
    ],
    normalizationContext: ["groups" => ["materiel:read"]],
)]
#[Vich\Uploadable]
class Materiel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['materiel:read', 'recette:read'])]
    private ?int $id = null;

    #[Assert\NotNull]
    #[Assert\NotBlank]
    #[Assert\Length(
        min: 2,
        max: 50,
        minMessage: "Le nom est trop court! (2 caractères maximum)",
        maxMessage: "Le nom est trop long! (50 caractères maximum)"
    )]
    #[ORM\Column(length: 50)]
    #[Groups(['materiel:read', 'recette:read', 'write'])]
    private ?string $nom = null;

    #[Assert\Length(
        max: 255,
        maxMessage: "La description est trop longue! (25 caractères maximum)"
    )]
    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['materiel:read', 'recette:read', 'write'])]
    private ?string $description = null;


    #[ORM\Column(nullable: true)]
    #[Groups(['materiel:read', 'recette:read', 'write'])]
    private mixed $prix = null;

    #[Assert\Length(
        max: 255,
        maxMessage: "Le champs utilisation est trop long! (25 caractères maximum)"
    )]
    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['materiel:read', 'recette:read', 'write'])]
    private ?string $utilisation = null;

    #[Assert\Length(
        max: 255,
        maxMessage: "Le champs caractéristique est trop long! (25 caractères maximum)"
    )]
    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['materiel:read', 'recette:read', 'write'])]
    private ?string $caractéristique = null;

    #[ApiProperty(writable : false)]
    #[ORM\ManyToMany(targetEntity: Recette::class, mappedBy: 'materiels')]
    #[Groups(['materiel:read'])]
    private Collection $recettes;

    #[Vich\UploadableField(mapping: 'materiel', fileNameProperty: 'imageName', size: 'imageSize')]
    #[Groups(['write'])]
    private ?File $imageFile = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['materiel:read'])]
    private ?string $imageName = null;

    #[ORM\Column(nullable: true)]
    private ?int $imageSize = null;

    #[ORM\ManyToOne(fetch: "EAGER", inversedBy: 'materiels')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    #[ApiProperty(writable: false)]
    #[Groups(['materiel:read'])]
    private ?Utilisateur $utilisateur = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Blank(groups: ["write"], message: "Le lien ne peut pas être renseigné pour les utilisateurs non premium")]
    #[Assert\Url(message: "Le lien doit être une URL valide", protocols: ['http', 'https'], groups: ["premium"])]
    #[Groups(["materiel:read","write","premium"])]
    private ?string $lien = null;

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

    public function getOwner(): ?Utilisateur
    {
        return $this->utilisateur;
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
