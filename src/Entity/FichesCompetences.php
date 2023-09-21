<?php

namespace App\Entity;

use App\Repository\FichesCompetencesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FichesCompetencesRepository::class)
 */
class FichesCompetences
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
    private $fic_comp_titre_emploi;

    /**
     * @ORM\ManyToMany(targetEntity=BriquesCompetences::class)
     */
    private $fic_comp_competences;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $fic_comp_competences_niveau = [];

    /**
     * @ORM\ManyToOne(targetEntity=Accreditation::class)
     */
    private $fic_comp_accreditations;

    /**
     * @ORM\Column(type="float")
     */
    private $fic_comp_version;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $updated_at;

    /**
     * @ORM\ManyToOne(targetEntity=Entreprise::class)
     */
    private $entreprise;

    public function __construct()
    {
        $this->fic_comp_competences = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFicCompTitreEmploi(): ?string
    {
        return $this->fic_comp_titre_emploi;
    }

    public function setFicCompTitreEmploi(string $fic_comp_titre_emploi): self
    {
        $this->fic_comp_titre_emploi = $fic_comp_titre_emploi;

        return $this;
    }

    /**
     * @return Collection<int, BriquesCompetences>
     */
    public function getFicCompCompetences(): Collection
    {
        return $this->fic_comp_competences;
    }

    public function addFicCompCompetence(BriquesCompetences $ficCompCompetence): self
    {
        if (!$this->fic_comp_competences->contains($ficCompCompetence)) {
            $this->fic_comp_competences[] = $ficCompCompetence;
        }

        return $this;
    }

    public function removeFicCompCompetence(BriquesCompetences $ficCompCompetence): self
    {
        $this->fic_comp_competences->removeElement($ficCompCompetence);

        return $this;
    }

    public function getFicCompCompetencesNiveau(): ?array
    {
        return $this->fic_comp_competences_niveau;
    }

    public function setFicCompCompetencesNiveau(?array $fic_comp_competences_niveau): self
    {
        $this->fic_comp_competences_niveau = $fic_comp_competences_niveau;

        return $this;
    }

    public function getFicCompAccreditations(): ?Accreditation
    {
        return $this->fic_comp_accreditations;
    }

    public function setFicCompAccreditations(?Accreditation $fic_comp_accreditations): self
    {
        $this->fic_comp_accreditations = $fic_comp_accreditations;

        return $this;
    }

    public function getFicCompVersion(): ?float
    {
        return $this->fic_comp_version;
    }

    public function setFicCompVersion(float $fic_comp_version): self
    {
        $this->fic_comp_version = $fic_comp_version;

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

    public function getEntreprise(): ?Entreprise
    {
        return $this->entreprise;
    }

    public function setEntreprise(?Entreprise $entreprise): self
    {
        $this->entreprise = $entreprise;

        return $this;
    }

    public function _getListCompetance(): array
    {
        return [
            "id"=> $this->getId(),
            "ficCompVersion"=> $this->getFicCompVersion(),
            "ficCompTitreEmploi" => $this->getFicCompTitreEmploi(),
            "ficCompCompetencesNiveau"=> $this->getFicCompCompetencesNiveau()
        ];
    }
}
