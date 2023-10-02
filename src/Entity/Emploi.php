<?php

namespace App\Entity;

use App\Repository\EmploiRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    /**
     * @ORM\OneToMany(targetEntity=FichesCompetences::class, mappedBy="appelation")
     */
    private $fichesCompetences;

    public function __construct()
    {
        $this->fichesCompetences = new ArrayCollection();
    }

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
    //     return $this->rome->_toArray();
    // }

    public function getRomeData(): array
    {
        return $this->rome->_toArray();
    }

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

    // /**
    //  * @return Collection<int, FichesCompetences>
    //  */
    // public function getFichesCompetences(): Collection
    // {
    //     return $this->fichesCompetences;
    // }

    public function addFichesCompetence(FichesCompetences $fichesCompetence): self
    {
        if (!$this->fichesCompetences->contains($fichesCompetence)) {
            $this->fichesCompetences[] = $fichesCompetence;
            $fichesCompetence->setAppelation($this);
        }

        return $this;
    }

    public function removeFichesCompetence(FichesCompetences $fichesCompetence): self
    {
        if ($this->fichesCompetences->removeElement($fichesCompetence)) {
            // set the owning side to null (unless already changed)
            if ($fichesCompetence->getAppelation() === $this) {
                $fichesCompetence->setAppelation(null);
            }
        }

        return $this;
    }
}
