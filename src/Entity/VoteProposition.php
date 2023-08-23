<?php

namespace App\Entity;

use App\Repository\VotePropositionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VotePropositionRepository::class)
 */
class VoteProposition
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $votepar;

    /**
     * @ORM\Column(type="datetime")
     */
    private $creation;

    /**
     * @ORM\Column(type="boolean")
     */
    private $value;

    /**
     * @ORM\ManyToOne(targetEntity=Proposition::class, inversedBy="votePropositions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $proposition;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVotepar(): ?int
    {
        return $this->votepar;
    }

    public function setVotepar(int $votepar): self
    {
        $this->votepar = $votepar;

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

    public function getValue(): ?bool
    {
        return $this->value;
    }

    public function setValue(bool $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function setProposition(?Proposition $proposition): self
    {
        $this->proposition = $proposition;

        return $this;
    }
}
