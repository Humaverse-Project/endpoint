<?php

namespace App\Entity;

use App\Repository\CompetencesGlobalesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CompetencesGlobalesRepository::class)
 */
class CompetencesGlobales
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
    private $comp_gb_titre;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $comp_gb_categorie;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $updated_at;

    /**
     * @ORM\OneToMany(targetEntity=BriquesCompetences::class, mappedBy="comp_gb")
     */
    private $briquesCompetences;

    public function __construct()
    {
        $this->briquesCompetences = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompGbTitre(): ?string
    {
        return $this->comp_gb_titre;
    }

    public function setCompGbTitre(string $comp_gb_titre): self
    {
        $this->comp_gb_titre = $comp_gb_titre;

        return $this;
    }

    public function getCompGbCategorie(): ?string
    {
        return $this->comp_gb_categorie;
    }

    public function setCompGbCategorie(string $comp_gb_categorie): self
    {
        $this->comp_gb_categorie = $comp_gb_categorie;

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

    /**
     * @return Collection<int, BriquesCompetences>
     */
    public function getBriquesCompetences(): Collection
    {
        return $this->briquesCompetences;
    }

    public function addBriquesCompetence(BriquesCompetences $briquesCompetence): self
    {
        if (!$this->briquesCompetences->contains($briquesCompetence)) {
            $this->briquesCompetences[] = $briquesCompetence;
            $briquesCompetence->setCompGb($this);
        }

        return $this;
    }

    public function removeBriquesCompetence(BriquesCompetences $briquesCompetence): self
    {
        if ($this->briquesCompetences->removeElement($briquesCompetence)) {
            // set the owning side to null (unless already changed)
            if ($briquesCompetence->getCompGb() === $this) {
                $briquesCompetence->setCompGb(null);
            }
        }

        return $this;
    }
}
