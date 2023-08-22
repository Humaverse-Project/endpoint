<?php

namespace App\Entity;

use App\Repository\PropositionPosteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PropositionPosteRepository::class)
 */
class PropositionPoste
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
     * @ORM\Column(type="datetime")
     */
    private $creation;

    /**
     * @ORM\Column(type="integer")
     */
    private $createdby;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity=Proposition::class, inversedBy="propositionPostes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $proposition;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $ex_id;

    /**
     * @ORM\Column(type="integer")
     */
    private $niveau_competance;

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

    public function getCreation(): ?\DateTimeInterface
    {
        return $this->creation;
    }

    public function setCreation(\DateTimeInterface $creation): self
    {
        $this->creation = $creation;

        return $this;
    }

    public function getCreatedby(): ?int
    {
        return $this->createdby;
    }

    public function setCreatedby(int $createdby): self
    {
        $this->createdby = $createdby;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function setProposition(?Proposition $proposition): self
    {
        $this->proposition = $proposition;

        return $this;
    }

    public function getExId(): ?int
    {
        return $this->ex_id;
    }

    public function setExId(?int $ex_id): self
    {
        $this->ex_id = $ex_id;

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
}
