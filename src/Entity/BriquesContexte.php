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
}
