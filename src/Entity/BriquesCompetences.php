<?php

namespace App\Entity;

use App\Repository\BriquesCompetencesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BriquesCompetencesRepository::class)
 */
class BriquesCompetences
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $brq_comp_titre;

    /**
     * @ORM\ManyToOne(targetEntity=CompetencesGlobales::class, inversedBy="briquesCompetences")
     */
    private $comp_gb;

    /**
     * @ORM\ManyToOne(targetEntity=Rome::class, inversedBy="briquesCompetences")
     */
    private $rome;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $updated_at;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBrqCompTitre(): ?string
    {
        return $this->brq_comp_titre;
    }

    public function setBrqCompTitre(string $brq_comp_titre): self
    {
        $this->brq_comp_titre = $brq_comp_titre;

        return $this;
    }

    public function getCompGb(): ?CompetencesGlobales
    {
        return $this->comp_gb;
    }

    public function setCompGb(?CompetencesGlobales $comp_gb): self
    {
        $this->comp_gb = $comp_gb;

        return $this;
    }

    // public function getRome(): ?Rome
    // {
    //     return $this->rome;
    // }

    public function setRome(?Rome $rome): self
    {
        $this->rome = $rome;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeImmutable $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

}
