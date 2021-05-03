<?php

namespace App\Entity;

use App\Repository\PatientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass=PatientRepository::class)
 */
class Patient implements \Symfony\Component\Security\Core\User\UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Prenom;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $Age;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $Sexe;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $Adresse;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Ville;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $CodePostal;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $Telephone;

    /**
     * @ORM\ManyToOne(targetEntity=Lit::class, inversedBy="patients")
     * @ORM\JoinColumn(nullable=true)
     */
    private $Lit;

    /**
     * @ORM\OneToMany(targetEntity=Sejour::class, mappedBy="Patient")
     * @ORM\JoinColumn(nullable=true)
     */
    private $sejours;

    /**
     * @ORM\ManyToOne(targetEntity=Service::class, inversedBy="patients")
     * @ORM\JoinColumn(nullable=true)
     */
    private $Service;

    /**
     * @var string The hashed password
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $roles = [];

    /**
     * @ORM\Column(type="boolean")
     */
    private $isVerified = false;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $photoUrl;

    /**
     * @ORM\OneToMany(targetEntity=RendezVous::class, mappedBy="patient")
     */
    private $rendezVous;

    public function __construct()
    {
        $this->sejours = new ArrayCollection();
        $this->rendezVous = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    public function setId(int $id): self
    {
        $this->Id = $id;

        return $this;
    }

    public function getNom(): ?string
    {

        return $this->Nom;
    }

    public function setNom(string $Nom): self
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->Prenom;
    }

    public function setPrenom(string $Prenom): self
    {
        $this->Prenom = $Prenom;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->Age;
    }

    public function setAge(int $Age): self
    {
        $this->Age = $Age;

        return $this;
    }

    public function getSexe()
    {
        return $this->Sexe;
    }

    public function setSexe($Sexe): self
    {
        $this->Sexe = $Sexe;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->Adresse;
    }

    public function setAdresse(string $Adresse): self
    {
        $this->Adresse = $Adresse;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->Ville;
    }

    public function setVille(string $Ville): self
    {
        $this->Ville = $Ville;

        return $this;
    }

    public function getCodePostal(): ?int
    {
        return $this->CodePostal;
    }

    public function setCodePostal(int $CodePostal): self
    {
        $this->CodePostal = $CodePostal;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $Email): self
    {
        $this->email = $Email;

        return $this;
    }

    public function getTelephone(): ?int
    {
        return $this->Telephone;
    }

    public function setTelephone(int $Telephone): self
    {
        $this->Telephone = $Telephone;

        return $this;
    }

    public function getLit(): ?Lit
    {
        return $this->Lit;
    }

    public function setLit(?Lit $Lit): self
    {
        $this->Lit = $Lit;

        return $this;
    }

    /**
     * @return Collection|Sejour[]
     */
    public function getSejours(): Collection
    {
        return $this->sejours;
    }

    public function addSejour(Sejour $sejour): self
    {
        if (!$this->sejours->contains($sejour)) {
            $this->sejours[] = $sejour;
            $sejour->setPatient($this);
        }

        return $this;
    }

    public function removeSejour(Sejour $sejour): self
    {
        if ($this->sejours->removeElement($sejour)) {
            // set the owning side to null (unless already changed)
            if ($sejour->getPatient() === $this) {
                $sejour->setPatient(null);
            }
        }

        return $this;
    }

    public function getService(): ?Service
    {
        return $this->Service;
    }

    public function setService(?Service $Service): self
    {
        $this->Service = $Service;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getRoles(): ?array
    {
        return $this->roles;
    }

    public function setRoles(?array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getIsVerified(): ?bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getPhotoUrl(): ?string
    {
        return $this->photoUrl;
    }

    public function setPhotoUrl(?string $photoUrl): self
    {
        $this->photoUrl = $photoUrl;

        return $this;
    }

    /**
     * @return Collection|RendezVous[]
     */
    public function getRendezVous(): Collection
    {
        return $this->rendezVous;
    }

    public function addRendezVou(RendezVous $rendezVou): self
    {
        if (!$this->rendezVous->contains($rendezVou)) {
            $this->rendezVous[] = $rendezVou;
            $rendezVou->setPatient($this);
        }

        return $this;
    }

    public function removeRendezVou(RendezVous $rendezVou): self
    {
        if ($this->rendezVous->removeElement($rendezVou)) {
            // set the owning side to null (unless already changed)
            if ($rendezVou->getPatient() === $this) {
                $rendezVou->setPatient(null);
            }
        }

        return $this;
    }

}
