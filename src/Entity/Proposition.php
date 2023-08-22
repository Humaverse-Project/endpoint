<?php

namespace App\Entity;

use App\Repository\PropositionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PropositionRepository::class)
 */
class Proposition
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $creation;

    /**
     * @ORM\Column(type="integer")
     */
    private $createdby;

    /**
     * @ORM\OneToMany(targetEntity=PropositionPoste::class, mappedBy="proposition")
     */
    private $propositionPostes;

    /**
     * @ORM\OneToMany(targetEntity=VoteProposition::class, mappedBy="proposition", orphanRemoval=true)
     */
    private $votePropositions;

    public function __construct()
    {
        $this->propositionPostes = new ArrayCollection();
        $this->votePropositions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection<int, PropositionPoste>
     */
    public function getPropositionPostes(): Collection
    {
        return $this->propositionPostes;
    }

    public function addPropositionPoste(PropositionPoste $propositionPoste): self
    {
        if (!$this->propositionPostes->contains($propositionPoste)) {
            $this->propositionPostes[] = $propositionPoste;
            $propositionPoste->setProposition($this);
        }

        return $this;
    }

    public function removePropositionPoste(PropositionPoste $propositionPoste): self
    {
        if ($this->propositionPostes->removeElement($propositionPoste)) {
            // set the owning side to null (unless already changed)
            if ($propositionPoste->getProposition() === $this) {
                $propositionPoste->setProposition(null);
            }
        }

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
