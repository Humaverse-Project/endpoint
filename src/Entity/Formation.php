<?php

namespace App\Entity;

use App\Repository\FormationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FormationRepository::class)
 */
class Formation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $formation_titre;

    /**
     * @ORM\Column(type="integer")
     */
    private $formation_type;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $formation_prerequis = [];

    /**
     * @ORM\ManyToMany(targetEntity=BriquesCompetences::class)
     */
    private $formation_competences;

    /**
     * @ORM\Column(type="float")
     */
    private $formation_duree;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $formation_description;

    /**
     * @ORM\Column(type="integer")
     */
    private $formation_cout;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $updated_at;

    /**
     * @ORM\ManyToOne(targetEntity=Personne::class)
     */
    private $formation_formateur;

    public function __construct()
    {
        $this->formation_competences = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFormationTitre(): ?string
    {
        return $this->formation_titre;
    }

    public function setFormationTitre(string $formation_titre): self
    {
        $this->formation_titre = $formation_titre;

        return $this;
    }

    public function getFormationType(): ?int
    {
        return $this->formation_type;
    }

    public function setFormationType(int $formation_type): self
    {
        $this->formation_type = $formation_type;

        return $this;
    }

    public function getFormationPrerequis(): ?array
    {
        return $this->formation_prerequis;
    }

    public function setFormationPrerequis(?array $formation_prerequis): self
    {
        $this->formation_prerequis = $formation_prerequis;

        return $this;
    }

    /**
     * @return Collection<int, BriquesCompetences>
     */
    public function getFormationCompetences(): Collection
    {
        return $this->formation_competences;
    }

    public function addFormationCompetence(BriquesCompetences $formationCompetence): self
    {
        if (!$this->formation_competences->contains($formationCompetence)) {
            $this->formation_competences[] = $formationCompetence;
        }

        return $this;
    }

    public function removeFormationCompetence(BriquesCompetences $formationCompetence): self
    {
        $this->formation_competences->removeElement($formationCompetence);

        return $this;
    }

    public function getFormationDuree(): ?float
    {
        return $this->formation_duree;
    }

    public function setFormationDuree(float $formation_duree): self
    {
        $this->formation_duree = $formation_duree;

        return $this;
    }

    public function getFormationDescription(): ?string
    {
        return $this->formation_description;
    }

    public function setFormationDescription(?string $formation_description): self
    {
        $this->formation_description = $formation_description;

        return $this;
    }

    public function getFormationCout(): ?int
    {
        return $this->formation_cout;
    }

    public function setFormationCout(int $formation_cout): self
    {
        $this->formation_cout = $formation_cout;

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

    public function getFormationFormateur(): ?Personne
    {
        return $this->formation_formateur;
    }

    public function setFormationFormateur(?Personne $formation_formateur): self
    {
        $this->formation_formateur = $formation_formateur;

        return $this;
    }
}
