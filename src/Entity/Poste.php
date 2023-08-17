<?php

namespace App\Entity;

use App\Repository\PosteRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PosteRepository::class)
 */
class Poste
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Metier::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $metier;

    /**
     * @ORM\ManyToOne(targetEntity=Competance::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $competance;

    /**
     * @ORM\Column(type="integer")
     */
    private $niveau_competance;

    /**
     * @ORM\Column(type="datetime")
     */
    private $creation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMetier(): ?Metier
    {
        return $this->metier;
    }

    public function setMetier(?Metier $metier): self
    {
        $this->metier = $metier;

        return $this;
    }

    public function getCompetance(): ?Competance
    {
        return $this->competance;
    }

    public function setCompetance(?Competance $competance): self
    {
        $this->competance = $competance;

        return $this;
    }

    public function getNiveauCompetance(): ?int
    {
        return $this->niveau_competance;
    }

    public function setNiveauCompetance(int $niveau_competance): self
    {
        $this->niveau_competance = $niveau_competance;

        return $this;
    }

    public function getCreation(): ?\DateTimeInterface
    {
        return $this->creation;
    }

    public function setCreation(\DateTimeInterface $creation): self
    {
        $this->creation = $creation;

        return $this;
    }
}
