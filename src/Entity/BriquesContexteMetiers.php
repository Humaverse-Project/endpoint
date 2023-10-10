<?php

namespace App\Entity;

use App\Repository\BriquesContexteMetiersRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BriquesContexteMetiersRepository::class)
 */
class BriquesContexteMetiers
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=ContextesTravail::class, inversedBy="briquesContexteMetiers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $contexte;

    /**
     * @ORM\ManyToOne(targetEntity=FichesPostes::class, inversedBy="briquesContexteMetiers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $fichesPostes;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $brqctxmetiertitre;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $updated_at;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContexte(): ?ContextesTravail
    {
        return $this->contexte;
    }

    public function setContexte(?ContextesTravail $contexte): self
    {
        $this->contexte = $contexte;

        return $this;
    }

    public function getFichesPostes(): ?FichesPostes
    {
        return $this->fichesPostes;
    }

    public function setFichesPostes(?FichesPostes $fichesPostes): self
    {
        $this->fichesPostes = $fichesPostes;

        return $this;
    }

    public function getBrqctxmetiertitre(): ?string
    {
        return $this->brqctxmetiertitre;
    }

    public function setBrqctxmetiertitre(?string $brqctxmetiertitre): self
    {
        $this->brqctxmetiertitre = $brqctxmetiertitre;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(?\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }
}
