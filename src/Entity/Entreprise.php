<?php

namespace App\Entity;

use App\Repository\EntrepriseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EntrepriseRepository::class)
 */
class Entreprise
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $entreprise_nom;

    /**
     * @ORM\Column(type="string", length=14)
     */
    private $entreprise_siret;

    /**
     * @ORM\Column(type="string", length=5, nullable=true)
     */
    private $entreprise_ape_naf;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $entreprise_url;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $entreprise_adresse;

    /**
     * @ORM\Column(type="string", length=5, nullable=true)
     */
    private $entreprise_code_postal;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $entreprise_ville;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $entreprise_pays;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $entreprise_telephone;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $entreprise_email;

    /**
     * @ORM\Column(type="integer")
     */
    private $entreprise_effectif;

    /**
     * @ORM\Column(type="integer")
     */
    private $entreprise_etablissement;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $updated_at;

    /**
     * @ORM\OneToMany(targetEntity=Compte::class, mappedBy="compte_entreprise_id")
     */
    private $comptes;

    /**
     * @ORM\OneToMany(targetEntity=Experience::class, mappedBy="exp_entreprise")
     */
    private $experiences;

    /**
     * @ORM\OneToMany(targetEntity=FichesPostes::class, mappedBy="fiches_postes_entreprise")
     */
    private $fichesPostes;

    /**
     * @ORM\OneToMany(targetEntity=Personne::class, mappedBy="entreprise")
     */
    private $personnes;

    /**
     * @ORM\OneToMany(targetEntity=Organigramme::class, mappedBy="entreprise", orphanRemoval=true)
     */
    private $organigrammes;

    public function __construct()
    {
        $this->comptes = new ArrayCollection();
        $this->experiences = new ArrayCollection();
        $this->fichesPostes = new ArrayCollection();
        $this->personnes = new ArrayCollection();
        $this->organigrammes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEntrepriseNom(): ?string
    {
        return $this->entreprise_nom;
    }

    public function setEntrepriseNom(?string $entreprise_nom): self
    {
        $this->entreprise_nom = $entreprise_nom;

        return $this;
    }

    public function getEntrepriseSiret(): ?string
    {
        return $this->entreprise_siret;
    }

    public function setEntrepriseSiret(string $entreprise_siret): self
    {
        $this->entreprise_siret = $entreprise_siret;

        return $this;
    }

    public function getEntrepriseApeNaf(): ?string
    {
        return $this->entreprise_ape_naf;
    }

    public function setEntrepriseApeNaf(?string $entreprise_ape_naf): self
    {
        $this->entreprise_ape_naf = $entreprise_ape_naf;

        return $this;
    }

    public function getEntrepriseUrl(): ?string
    {
        return $this->entreprise_url;
    }

    public function setEntrepriseUrl(?string $entreprise_url): self
    {
        $this->entreprise_url = $entreprise_url;

        return $this;
    }

    public function getEntrepriseAdresse(): ?string
    {
        return $this->entreprise_adresse;
    }

    public function setEntrepriseAdresse(?string $entreprise_adresse): self
    {
        $this->entreprise_adresse = $entreprise_adresse;

        return $this;
    }

    public function getEntrepriseCodePostal(): ?string
    {
        return $this->entreprise_code_postal;
    }

    public function setEntrepriseCodePostal(?string $entreprise_code_postal): self
    {
        $this->entreprise_code_postal = $entreprise_code_postal;

        return $this;
    }

    public function getEntrepriseVille(): ?string
    {
        return $this->entreprise_ville;
    }

    public function setEntrepriseVille(string $entreprise_ville): self
    {
        $this->entreprise_ville = $entreprise_ville;

        return $this;
    }

    public function getEntreprisePays(): ?string
    {
        return $this->entreprise_pays;
    }

    public function setEntreprisePays(string $entreprise_pays): self
    {
        $this->entreprise_pays = $entreprise_pays;

        return $this;
    }

    public function getEntrepriseTelephone(): ?string
    {
        return $this->entreprise_telephone;
    }

    public function setEntrepriseTelephone(string $entreprise_telephone): self
    {
        $this->entreprise_telephone = $entreprise_telephone;

        return $this;
    }

    public function getEntrepriseEmail(): ?string
    {
        return $this->entreprise_email;
    }

    public function setEntrepriseEmail(string $entreprise_email): self
    {
        $this->entreprise_email = $entreprise_email;

        return $this;
    }

    public function getEntrepriseEffectif(): ?int
    {
        return $this->entreprise_effectif;
    }

    public function setEntrepriseEffectif(int $entreprise_effectif): self
    {
        $this->entreprise_effectif = $entreprise_effectif;

        return $this;
    }

    public function getEntrepriseEtablissement(): ?int
    {
        return $this->entreprise_etablissement;
    }

    public function setEntrepriseEtablissement(int $entreprise_etablissement): self
    {
        $this->entreprise_etablissement = $entreprise_etablissement;

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

    public function addCompte(Compte $compte): self
    {
        if (!$this->comptes->contains($compte)) {
            $this->comptes[] = $compte;
            $compte->setCompteEntrepriseId($this);
        }

        return $this;
    }

    public function removeCompte(Compte $compte): self
    {
        if ($this->comptes->removeElement($compte)) {
            // set the owning side to null (unless already changed)
            if ($compte->getCompteEntrepriseId() === $this) {
                $compte->setCompteEntrepriseId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Experience>
     */
    public function getExperiences(): Collection
    {
        return $this->experiences;
    }

    public function addExperience(Experience $experience): self
    {
        if (!$this->experiences->contains($experience)) {
            $this->experiences[] = $experience;
            $experience->setExpEntreprise($this);
        }

        return $this;
    }

    public function removeExperience(Experience $experience): self
    {
        if ($this->experiences->removeElement($experience)) {
            // set the owning side to null (unless already changed)
            if ($experience->getExpEntreprise() === $this) {
                $experience->setExpEntreprise(null);
            }
        }

        return $this;
    }

    // /**
    //  * @return Collection<int, FichesPostes>
    //  */
    // public function getFichesPostes(): Collection
    // {
    //     return $this->fichesPostes;
    // }

    public function addFichesPoste(FichesPostes $fichesPoste): self
    {
        if (!$this->fichesPostes->contains($fichesPoste)) {
            $this->fichesPostes[] = $fichesPoste;
            $fichesPoste->setFichesPostesEntreprise($this);
        }

        return $this;
    }

    public function removeFichesPoste(FichesPostes $fichesPoste): self
    {
        if ($this->fichesPostes->removeElement($fichesPoste)) {
            // set the owning side to null (unless already changed)
            if ($fichesPoste->getFichesPostesEntreprise() === $this) {
                $fichesPoste->setFichesPostesEntreprise(null);
            }
        }

        return $this;
    }

    // /**
    //  * @return Collection<int, Personne>
    //  */
    // public function getPersonnes(): Collection
    // {
    //     return $this->personnes;
    // }

    public function addPersonne(Personne $personne): self
    {
        if (!$this->personnes->contains($personne)) {
            $this->personnes[] = $personne;
            $personne->setEntreprise($this);
        }

        return $this;
    }

    // public function removePersonne(Personne $personne): self
    // {
    //     if ($this->personnes->removeElement($personne)) {
    //         // set the owning side to null (unless already changed)
    //         if ($personne->getEntreprise() === $this) {
    //             $personne->setEntreprise(null);
    //         }
    //     }

    //     return $this;
    // }

    /**
     * @return Collection<int, Organigramme>
     */
    public function getOrganigrammes(): Collection
    {
        return $this->organigrammes;
    }

    public function addOrganigramme(Organigramme $organigramme): self
    {
        if (!$this->organigrammes->contains($organigramme)) {
            $this->organigrammes[] = $organigramme;
            $organigramme->setEntreprise($this);
        }

        return $this;
    }

    public function removeOrganigramme(Organigramme $organigramme): self
    {
        if ($this->organigrammes->removeElement($organigramme)) {
            // set the owning side to null (unless already changed)
            if ($organigramme->getEntreprise() === $this) {
                $organigramme->setEntreprise(null);
            }
        }

        return $this;
    }
}
