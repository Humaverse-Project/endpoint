<?php

namespace App\Entity;

use App\Repository\CompetanceRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CompetanceRepository::class)
 */
class Competance
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $code;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $class;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description_c;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description_l;

    /**
     * @ORM\Column(type="datetime")
     */
    private $creation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getClass(): ?string
    {
        return $this->class;
    }

    public function setClass(string $class): self
    {
        $this->class = $class;

        return $this;
    }

    public function getDescriptionC(): ?string
    {
        return $this->description_c;
    }

    public function setDescriptionC(?string $description_c): self
    {
        $this->description_c = $description_c;

        return $this;
    }

    public function getDescriptionL(): ?string
    {
        return $this->description_l;
    }

    public function setDescriptionL(?string $description_l): self
    {
        $this->description_l = $description_l;

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
}
