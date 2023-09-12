<?php

namespace App\Entity;

use App\Repository\ConventionCollectiveRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ConventionCollectiveRepository::class)
 */
class ConventionCollective
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
    private $con_coll_titre;

    /**
     * @ORM\Column(type="text")
     */
    private $con_coll_description;

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

    public function getConCollTitre(): ?string
    {
        return $this->con_coll_titre;
    }

    public function setConCollTitre(string $con_coll_titre): self
    {
        $this->con_coll_titre = $con_coll_titre;

        return $this;
    }

    public function getConCollDescription(): ?string
    {
        return $this->con_coll_description;
    }

    public function setConCollDescription(string $con_coll_description): self
    {
        $this->con_coll_description = $con_coll_description;

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
