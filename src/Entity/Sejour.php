<?php

namespace App\Entity;

use App\Repository\SejourRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SejourRepository::class)
 */
class Sejour
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $DateEntree;

    /**
     * @ORM\Column(type="date")
     */
    private $DateSortie;

    /**
     * @ORM\ManyToOne(targetEntity=Patient::class, inversedBy="sejours")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Patient;

    /**
     * @ORM\ManyToOne(targetEntity=Service::class, inversedBy="sejours")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Service;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateEntree(): ?\DateTimeInterface
    {
        return $this->DateEntree;
    }

    public function setDateEntree(\DateTimeInterface $DateEntree): self
    {
        $this->DateEntree = $DateEntree;

        return $this;
    }

    public function getDateSortie(): ?\DateTimeInterface
    {
        return $this->DateSortie;
    }

    public function setDateSortie(\DateTimeInterface $DateSortie): self
    {
        $this->DateSortie = $DateSortie;

        return $this;
    }

    public function getPatient(): ?Patient
    {
        return $this->Patient;
    }

    public function setPatient(?Patient $Patient): self
    {
        $this->Patient = $Patient;

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
}
