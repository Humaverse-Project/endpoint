<?php

namespace App\Entity;

use App\Repository\ContextesTravailRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ContextesTravailRepository::class)
 */
class ContextesTravail
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
    private $ctx_trv_titre;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $updated_at;

    /**
     * @ORM\OneToMany(targetEntity=BriquesContexte::class, mappedBy="contexte")
     */
    private $briquesContextes;

    public function __construct()
    {
        $this->briquesContextes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCtxTrvTitre(): ?string
    {
        return $this->ctx_trv_titre;
    }

    public function setCtxTrvTitre(string $ctx_trv_titre): self
    {
        $this->ctx_trv_titre = $ctx_trv_titre;

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

    /**
     * @return Collection<int, BriquesContexte>
     */
    public function getBriquesContextes(): Collection
    {
        return $this->briquesContextes;
    }

    public function addBriquesContexte(BriquesContexte $briquesContexte): self
    {
        if (!$this->briquesContextes->contains($briquesContexte)) {
            $this->briquesContextes[] = $briquesContexte;
            $briquesContexte->setContexte($this);
        }

        return $this;
    }

    public function removeBriquesContexte(BriquesContexte $briquesContexte): self
    {
        if ($this->briquesContextes->removeElement($briquesContexte)) {
            // set the owning side to null (unless already changed)
            if ($briquesContexte->getContexte() === $this) {
                $briquesContexte->setContexte(null);
            }
        }

        return $this;
    }
}
