<?php

namespace App\Entity;

use App\Repository\ChambreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ChambreRepository::class)
 */
class Chambre
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $NombreLit;

    /**
     * @ORM\ManyToOne(targetEntity=Service::class, inversedBy="chambres")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Service;

    /**
     * @ORM\OneToMany(targetEntity=Lit::class, mappedBy="Chambre")
     */
    private $lits;

    public function __construct()
    {
        $this->lits = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombreLit(): ?int
    {
        return $this->NombreLit;
    }

    public function setNombreLit(int $NombreLit): self
    {
        $this->NombreLit = $NombreLit;

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

    /**
     * @return Collection|Lit[]
     */
    public function getLits(): Collection
    {
        return $this->lits;
    }

    public function addLit(Lit $lit): self
    {
        if (!$this->lits->contains($lit)) {
            $this->lits[] = $lit;
            $lit->setChambre($this);
        }

        return $this;
    }

    public function removeLit(Lit $lit): self
    {
        if ($this->lits->removeElement($lit)) {
            // set the owning side to null (unless already changed)
            if ($lit->getChambre() === $this) {
                $lit->setChambre(null);
            }
        }

        return $this;
    }
}
