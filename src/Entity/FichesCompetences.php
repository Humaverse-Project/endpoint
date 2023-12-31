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

    /**
     * @ORM\OneToMany(targetEntity=BriquesCompetencesNiveau::class, mappedBy="fichescompetances")
     */
    private $briquesCompetencesNiveaux;

    /**
     * @ORM\ManyToOne(targetEntity=Emploi::class, inversedBy="fichesCompetences")
     */
    private $appelation;

    /**
     * @ORM\ManyToMany(targetEntity=Accreditation::class, cascade={"persist"})
     */
    private $accreditation;

    public function __construct()
    {
        $this->fic_comp_competences = new ArrayCollection();
        $this->briquesCompetencesNiveaux = new ArrayCollection();
        $this->accreditation = new ArrayCollection();
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
            "titre" =>$this->getFicCompTitreEmploi(),
            "version"=> $this->getFicCompVersion(),
            "briquelist" => $this->getFicCompCompetences()
        ];
    }

        /**
     * @return Collection<int, BriquesCompetencesNiveau>
     */
    public function getBriquesCompetencesNiveaux(): Collection
    {
        return $this->briquesCompetencesNiveaux;
    }

    public function addBriquesCompetencesNiveau(BriquesCompetencesNiveau $briquesCompetencesNiveau): self
    {
        if (!$this->briquesCompetencesNiveaux->contains($briquesCompetencesNiveau)) {
            $this->briquesCompetencesNiveaux[] = $briquesCompetencesNiveau;
            $briquesCompetencesNiveau->setFichescompetances($this);
        }

        return $this;
    }

    // public function removeBriquesCompetencesNiveau(BriquesCompetencesNiveau $briquesCompetencesNiveau): self
    // {
    //     if ($this->briquesCompetencesNiveaux->removeElement($briquesCompetencesNiveau)) {
    //         // set the owning side to null (unless already changed)
    //         if ($briquesCompetencesNiveau->getFichescompetances() === $this) {
    //             $briquesCompetencesNiveau->setFichescompetances(null);
    //         }
    //     }

    //     return $this;
    // }

    public function getAppelation(): ?Emploi
    {
        return $this->appelation;
    }

    public function setAppelation(?Emploi $appelation): self
    {
        $this->appelation = $appelation;

        return $this;
    }

    /**
     * @return Collection<int, Accreditation>
     */
    public function getAccreditation(): Collection
    {
        return $this->accreditation;
    }

    public function addAccreditation(Accreditation $accreditation): self
    {
        if (!$this->accreditation->contains($accreditation)) {
            $this->accreditation[] = $accreditation;
        }

        return $this;
    }

    public function removeAccreditation(Accreditation $accreditation): self
    {
        $this->accreditation->removeElement($accreditation);

        return $this;
    }
}
