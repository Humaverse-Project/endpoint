<?php

namespace App\Entity;

use App\Repository\BriquesContexteRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BriquesContexteRepository::class)
 */
class BriquesContexte
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
    private $brq_ctx_titre;

    /**
     * @ORM\ManyToOne(targetEntity=ContextesTravail::class, inversedBy="briquesContextes")
     */
    private $contexte;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $updated_at;

    /**
     * @ORM\ManyToOne(targetEntity=Rome::class)
     */
    private $rome;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBrqCtxTitre(): ?string
    {
        return $this->brq_ctx_titre;
    }

    public function setBrqCtxTitre(string $brq_ctx_titre): self
    {
        $this->brq_ctx_titre = $brq_ctx_titre;

        return $this;
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

    public function getRome(): ?Rome
    {
        return $this->rome;
    }

    public function setRome(?Rome $rome): self
    {
        $this->rome = $rome;

        return $this;
    }
}
