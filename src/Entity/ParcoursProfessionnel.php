<?php

namespace App\Entity;

use App\Repository\ParcoursProfessionnelRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ParcoursProfessionnelRepository::class)
 */
class ParcoursProfessionnel
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $par_pro_nom;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $par_pro_type;

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

    public function getParProNom(): ?string
    {
        return $this->par_pro_nom;
    }

    public function setParProNom(string $par_pro_nom): self
    {
        $this->par_pro_nom = $par_pro_nom;

        return $this;
    }

    public function getParProType(): ?string
    {
        return $this->par_pro_type;
    }

    public function setParProType(string $par_pro_type): self
    {
        $this->par_pro_type = $par_pro_type;

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
