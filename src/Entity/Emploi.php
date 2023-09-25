<?php

namespace App\Entity;

use App\Repository\EmploiRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EmploiRepository::class)
 */
class Emploi
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
    private $emploi_titre;

    /**
     * @ORM\ManyToOne(targetEntity=Rome::class, inversedBy="emplois")
     */
    private $rome;

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

    public function getEmploiTitre(): ?string
    {
        return $this->emploi_titre;
    }

    public function setEmploiTitre(string $emploi_titre): self
    {
        $this->emploi_titre = $emploi_titre;

        return $this;
    }

    // public function getRome(): ?Rome
    // {
    //     return $this->rome;
    // }

    public function setRome(?Rome $rome): self
    {
        $this->rome = $rome;

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
