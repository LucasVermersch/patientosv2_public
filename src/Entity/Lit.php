<?php

namespace App\Entity;

use App\Repository\LitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LitRepository::class)
 */
class Lit
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
    private $EtatDuLit;

    /**
     * @ORM\ManyToOne(targetEntity=Chambre::class, inversedBy="lits")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Chambre;

    /**
     * @ORM\OneToMany(targetEntity=Patient::class, mappedBy="Lit")
     */
    private $patients;

    /**
     * @ORM\Column(type="boolean")
     */
    private $Occupation;

    public function __construct()
    {
        $this->patients = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEtatDuLit(): ?string
    {
        return $this->EtatDuLit;
    }

    public function setEtatDuLit(string $EtatDuLit): self
    {
        $this->EtatDuLit = $EtatDuLit;

        return $this;
    }


    public function getChambre(): ?Chambre
    {
        return $this->Chambre;
    }

    public function setChambre(Chambre $Chambre): self
    {
        $this->Chambre = $Chambre;

        return $this;
    }


    /**
     * @return Collection|Patient[]
     */
    public function getPatients(): Collection
    {
        return $this->patients;
    }

    public function addPatient(Patient $patient): self
    {
        if (!$this->patients->contains($patient)) {
            $this->patients[] = $patient;
            $patient->setLit($this);
        }

        return $this;
    }

    public function removePatient(Patient $patient): self
    {
        if ($this->patients->removeElement($patient)) {
            // set the owning side to null (unless already changed)
            if ($patient->getLit() === $this) {
                $patient->setLit(null);
            }
        }

        return $this;
    }

    public function getOccupation(): ?bool
    {
        return $this->Occupation;
    }

    public function setOccupation(bool $Occupation): self
    {
        $this->Occupation = $Occupation;

        return $this;
    }
}
