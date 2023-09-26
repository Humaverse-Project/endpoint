<?php

namespace App\Entity;

use App\Repository\BriquesCompetencesNiveauRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BriquesCompetencesNiveauRepository::class)
 */
class BriquesCompetencesNiveau
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=BriquesCompetences::class, inversedBy="briquesCompetencesNiveaux")
     * @ORM\JoinColumn(nullable=false)
     */
    private $briquescompetances;

    /**
     * @ORM\ManyToOne(targetEntity=FichesCompetences::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $fichescompetances;

    /**
     * @ORM\Column(type="integer")
     */
    private $niveau;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBriquescompetances(): ?BriquesCompetences
    {
        return $this->briquescompetances;
    }

    public function setBriquescompetances(?BriquesCompetences $briquescompetances): self
    {
        $this->briquescompetances = $briquescompetances;

        return $this;
    }

    // public function getFichescompetances(): ?FichesCompetences
    // {
    //     return $this->fichescompetances;
    // }

    public function setFichescompetances(?FichesCompetences $fichescompetances): self
    {
        $this->fichescompetances = $fichescompetances;

        return $this;
    }

    public function getNiveau(): ?int
    {
        return $this->niveau;
    }

    public function setNiveau(int $niveau): self
    {
        $this->niveau = $niveau;

        return $this;
    }
}
