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
     * @ORM\OneToMany(targetEntity=VoteProposition::class, mappedBy="proposition")
     */
    private $votePropositions;

    public function __construct()
    {
        $this->votePropositions = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, VoteProposition>
     */
    public function getVotePropositions(): Collection
    {
        return $this->votePropositions;
    }

    public function addVoteProposition(VoteProposition $voteProposition): self
    {
        if (!$this->votePropositions->contains($voteProposition)) {
            $this->votePropositions[] = $voteProposition;
            $voteProposition->setProposition($this);
        }

        return $this;
    }

    public function removeVoteProposition(VoteProposition $voteProposition): self
    {
        if ($this->votePropositions->removeElement($voteProposition)) {
            // set the owning side to null (unless already changed)
            if ($voteProposition->getProposition() === $this) {
                $voteProposition->setProposition(null);
            }
        }

        return $this;
    }
}
