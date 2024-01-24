<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Repository\UtilisateurRepository;
use App\State\UtilisateurProcessor;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Nullable;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
#[UniqueEntity('login', message: 'Cette valeur est déjà prise !')]
#[UniqueEntity('adresseEmail', message: 'Cette valeur est déjà prise !')]
#[ApiResource(
    operations: [
        new Get(),
        new GetCollection(),
        new Delete(security: "object.getOwner() == user"),
        new Post(
            denormalizationContext: ["groups" => ["utilisateur:create"]],
            validationContext: ["groups" => ["Default", "utilisateur:create"]],
            processor: UtilisateurProcessor::class),

        new Patch(
            denormalizationContext: ["groups" => ["utilisateur:update"]],
            security: "object.getOwner() == user",
            validationContext: ["groups" => ["Default", "utilisateur:update"]],
            processor: UtilisateurProcessor::class,
        ),

    ],
    normalizationContext: ["groups" => ["utilisateur:read"]],

)]
class Utilisateur implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['utilisateur:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Assert\NotBlank(groups: ["utilisateur:create"])]
    #[Assert\NotNull(groups: ["utilisateur:create"])]
    #[Assert\Length (min: 4, max: 20,
        minMessage: 'Login trop court',
        maxMessage: 'Login trop long')]
    #[Groups(['utilisateur:read', 'utilisateur:create', 'utilisateur:update'])]
    private ?string $login = null;

    #[ORM\Column(nullable: true)]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    #[ApiProperty(readable: false, writable: false)]
    private ?string $password = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Assert\NotBlank(groups: ["utilisateur:create"])]
    #[Assert\NotNull(groups: ["utilisateur:create"])]
    #[Assert\Email(message: 'Email non valide')]
    #[Groups(['utilisateur:read', 'utilisateur:create', 'utilisateur:update'])]
    private ?string $adresseEmail = null;

    #[ApiProperty(readable: true, writable: false)]
    #[ORM\Column(options: ["default" => false])]
    #[Groups(['utilisateur:read'])]
    private ?bool $premium = false;


    #[Assert\NotBlank(groups: ["utilisateur:create"])]
    #[Assert\NotNull(groups: ["utilisateur:create"])]
    #[Assert\Length (min: 8, max: 30,
        minMessage: 'Mot de passe trop court',
        maxMessage: 'Mot de passe trop long')]
    #[ApiProperty(readable: false)]
    #[Assert\Regex(
        pattern : "#^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,30}$#",
        message : "Mot de passe non valide. Celui-ci doit contenir au moins une minuscule, une majuscule et un chiffre"
    )]
    #[Assert\PasswordStrength]
    #[Groups(['utilisateur:create', 'utilisateur:update'])]
    private ?string $plainPassword= null;

    #[ORM\Column(length: 50, nullable: true)]
    #[Groups(['utilisateur:read', 'utilisateur:create', 'utilisateur:update'])]
    private ?string $nom = null;

    #[ORM\Column(length: 50, nullable: true)]
    #[Groups(['utilisateur:read', 'utilisateur:create', 'utilisateur:update'])]
    private ?string $prenom = null;

    #[ORM\OneToMany(mappedBy: 'utilisateur', targetEntity: Recette::class)]
    #[Groups(['utilisateur:read'])]
    private Collection $recettes;

    public function __construct()
    {
        $this->recettes = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(string $login): static
    {
        $this->login = $login;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->login;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        //If you store any temporary, sensitive data on the user, clear it here
        $this->plainPassword = null;
    }

    public function getAdresseEmail(): ?string
    {
        return $this->adresseEmail;
    }

    public function setAdresseEmail(string $adresseEmail): static
    {
        $this->adresseEmail = $adresseEmail;

        return $this;
    }


    public function isPremium(): ?bool
    {
        return $this->premium;
    }

    public function setPremium(bool $premium): static
    {
        $this->premium = $premium;

        return $this;
    }

    /**
     * @return string
     */
    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    /**
     * @param string $plainPassword
     */
    public function setPlainPassword(?string $plainPassword): void
    {
        $this->plainPassword = $plainPassword;
    }

    public function getOwner(){
        return $this;
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

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
            $recette->setUtilisateur($this);
        }

        return $this;
    }

    public function removeRecette(Recette $recette): static
    {
        if ($this->recettes->removeElement($recette)) {
            // set the owning side to null (unless already changed)
            if ($recette->getUtilisateur() === $this) {
                $recette->setUtilisateur(null);
            }
        }

        return $this;
    }

}