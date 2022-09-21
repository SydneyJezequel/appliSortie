<?php

namespace App\Entity;

use App\Repository\ParticipantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ParticipantRepository::class)
 * @UniqueEntity(fields={"email"})
 * @UniqueEntity(fields={"pseudo"})
 */
class Participant implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\NotBlank()
     * @Assert\Length(max=180)
     */
    private $email;

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Assert\Length(min=4, max=100)
     */
    private $motPasse;

    /**
     * @ORM\Column(type="string", length=30)
     * @Assert\NotBlank()
     * @Assert\Length(max=30)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=30)
     * @Assert\NotBlank()
     * @Assert\Length(max=30)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=30)
     * @Assert\NotBlank()
     * @Assert\Length(max=30)
     */
    private $telephone;

    /**
     * @ORM\Column(type="boolean")
     * @Assert\Type("bool")
     */
    private $isAdministrateur;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActif;

    /**
     * @ORM\Column(type="string", length=30, unique=true)
     * @Assert\NotBlank()
     * @Assert\Length(max=30)
     */
    private $pseudo;

    /**
     * @ORM\ManyToOne(targetEntity=Campus::class)
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull()
     */
    private $campus;

    /**
     * @ORM\OneToMany(targetEntity=Sortie::class, mappedBy="organisateur", orphanRemoval=true)
     * @ORM\JoinColumn(nullable=false)
     */
    private $organisateurSorties;

    /**
     * @ORM\ManyToMany(targetEntity=Sortie::class, mappedBy="inscrits")
     */
    private $inscritSorties;

    public function __construct()
    {
        $this->organisateurSorties = new ArrayCollection();
        $this->inscritSorties = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        return ($this->isAdministrateur)?['ROLE_ADMIN']:['ROLE_USER'];
    }


    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->motPasse;
    }


    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function isIsAdministrateur(): ?bool
    {
        return $this->isAdministrateur;
    }

    public function setIsAdministrateur(bool $isAdministrateur): self
    {
        $this->isAdministrateur = $isAdministrateur;

        return $this;
    }

    public function isIsActif(): ?bool
    {
        return $this->isActif;
    }

    public function setIsActif(bool $isActif): self
    {
        $this->isActif = $isActif;

        return $this;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(?string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getCampus(): ?Campus
    {
        return $this->campus;
    }

    public function setCampus(?Campus $campus): self
    {
        $this->campus = $campus;

        return $this;
    }

    /**
     * @return Collection<int, Sortie>
     */
    public function getOrganisateurSorties(): Collection
    {
        return $this->organisateurSorties;
    }

    public function addOrganisateurSortie(Sortie $organisateurSortie): self
    {
        if (!$this->organisateurSorties->contains($organisateurSortie)) {
            $this->organisateurSorties[] = $organisateurSortie;
            $organisateurSortie->setOrganisateur($this);
        }

        return $this;
    }

    public function removeOrganisateurSortie(Sortie $organisateurSortie): self
    {
        if ($this->organisateurSorties->removeElement($organisateurSortie)) {
                $organisateurSortie->removeInscrit($this);
            // set the owning side to null (unless already changed)
            /*if ($organisateurSortie->getOrganisateur() === $this) {
                $organisateurSortie->setOrganisateur(!null); // Pas de null par défaut. + Une fois la sorties réalisée, organisateur non supprimable
            }*/
        }

        return $this;
    }

    /**
     * @return Collection<int, Sortie>
     */
    public function getInscritSorties(): Collection
    {
        return $this->inscritSorties;
    }

    public function addInscritSorty(Sortie $inscritSorty): self
    {
        if (!$this->inscritSorties->contains($inscritSorty)) {
            $this->inscritSorties[] = $inscritSorty;
            $inscritSorty->addInscrit($this);
        }

        return $this;
    }

    public function removeInscritSorty(Sortie $inscritSorty): self
    {
        if ($this->inscritSorties->removeElement($inscritSorty)) {
            $inscritSorty->removeInscrit($this);
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getMotPasse(): string
    {
        return $this->motPasse;
    }

    /**
     * @param string $motPasse
     */
    public function setMotPasse(string $motPasse): void
    {
        $this->motPasse = $motPasse;
    }

    public function __toString()
    {
        return $this->nom;
    }


}
