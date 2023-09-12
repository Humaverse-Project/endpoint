<?php

namespace App\Entity;

use App\Repository\ExperienceRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ExperienceRepository::class)
 */
class Experience
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
    private $exp_titre;

    /**
     * @ORM\ManyToOne(targetEntity=Entreprise::class, inversedBy="experiences")
     */
    private $exp_entreprise;

    /**
     * @ORM\Column(type="date")
     */
    private $exp_date_debut;

    /**
     * @ORM\Column(type="date")
     */
    private $exp_date_fin;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $exp_description;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $exp_skills = [];

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

    public function getExpTitre(): ?string
    {
        return $this->exp_titre;
    }

    public function setExpTitre(string $exp_titre): self
    {
        $this->exp_titre = $exp_titre;

        return $this;
    }

    public function getExpEntreprise(): ?Entreprise
    {
        return $this->exp_entreprise;
    }

    public function setExpEntreprise(?Entreprise $exp_entreprise): self
    {
        $this->exp_entreprise = $exp_entreprise;

        return $this;
    }

    public function getExpDateDebut(): ?\DateTimeInterface
    {
        return $this->exp_date_debut;
    }

    public function setExpDateDebut(\DateTimeInterface $exp_date_debut): self
    {
        $this->exp_date_debut = $exp_date_debut;

        return $this;
    }

    public function getExpDateFin(): ?\DateTimeInterface
    {
        return $this->exp_date_fin;
    }

    public function setExpDateFin(\DateTimeInterface $exp_date_fin): self
    {
        $this->exp_date_fin = $exp_date_fin;

        return $this;
    }

    public function getExpDescription(): ?string
    {
        return $this->exp_description;
    }

    public function setExpDescription(?string $exp_description): self
    {
        $this->exp_description = $exp_description;

        return $this;
    }

    public function getExpSkills(): ?array
    {
        return $this->exp_skills;
    }

    public function setExpSkills(?array $exp_skills): self
    {
        $this->exp_skills = $exp_skills;

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
