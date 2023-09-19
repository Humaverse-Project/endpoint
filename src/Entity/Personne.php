<?php

namespace App\Entity;

use App\Repository\PersonneRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PersonneRepository::class)
 */
class Personne
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $personne_nom;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $personne_prenom;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $personne_email;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $personne_telephone;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $personne_adresse;

    /**
     * @ORM\Column(type="string", length=1)
     */
    private $personne_genre;

    /**
     * @ORM\Column(type="date")
     */
    private $personne_date_naissance;

    /**
     * @ORM\ManyToOne(targetEntity=FichesPostes::class)
     */
    private $personne_poste;

    /**
     * @ORM\ManyToMany(targetEntity=Experience::class)
     * @ORM\JoinTable(name="personne_experiences")
     */
    private $personne_experiences;

    /**
     * @ORM\ManyToMany(targetEntity=Formation::class)
     * @ORM\JoinTable(name="personne_formations")
     */
    private $personne_formations;

    /**
     * @ORM\ManyToMany(targetEntity=Accreditation::class)
     * @ORM\JoinTable(name="personne_accreditations")
     */
    private $personne_accreditations;

    /**
     * @ORM\ManyToOne(targetEntity=Compte::class)
     */
    private $personne_compte;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $updated_at;

    /**
     * @ORM\ManyToOne(targetEntity=Entreprise::class, inversedBy="personnes")
     */
    private $entreprise;

    public function __construct()
    {
        $this->personne_experiences = new ArrayCollection();
        $this->personne_formations = new ArrayCollection();
        $this->personne_accreditations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPersonneNom(): ?string
    {
        return $this->personne_nom;
    }

    public function setPersonneNom(string $personne_nom): self
    {
        $this->personne_nom = $personne_nom;

        return $this;
    }

    public function getPersonnePrenom(): ?string
    {
        return $this->personne_prenom;
    }

    public function setPersonnePrenom(?string $personne_prenom): self
    {
        $this->personne_prenom = $personne_prenom;

        return $this;
    }

    public function getPersonneEmail(): ?string
    {
        return $this->personne_email;
    }

    public function setPersonneEmail(string $personne_email): self
    {
        $this->personne_email = $personne_email;

        return $this;
    }

    public function getPersonneTelephone(): ?string
    {
        return $this->personne_telephone;
    }

    public function setPersonneTelephone(string $personne_telephone): self
    {
        $this->personne_telephone = $personne_telephone;

        return $this;
    }

    public function getPersonneAdresse(): ?string
    {
        return $this->personne_adresse;
    }

    public function setPersonneAdresse(?string $personne_adresse): self
    {
        $this->personne_adresse = $personne_adresse;

        return $this;
    }

    public function getPersonneGenre(): ?string
    {
        return $this->personne_genre;
    }

    public function setPersonneGenre(string $personne_genre): self
    {
        $this->personne_genre = $personne_genre;

        return $this;
    }

    public function getPersonneDateNaissance(): ?\DateTimeInterface
    {
        return $this->personne_date_naissance;
    }

    public function setPersonneDateNaissance(\DateTimeInterface $personne_date_naissance): self
    {
        $this->personne_date_naissance = $personne_date_naissance;

        return $this;
    }

    public function getPersonnePoste(): ?FichesPostes
    {
        return $this->personne_poste;
    }

    public function setPersonnePoste(?FichesPostes $personne_poste): self
    {
        $this->personne_poste = $personne_poste;

        return $this;
    }

    /**
     * @return Collection<int, Experience>
     */
    public function getPersonneExperiences(): Collection
    {
        return $this->personne_experiences;
    }

    public function addPersonneExperience(Experience $personneExperience): self
    {
        if (!$this->personne_experiences->contains($personneExperience)) {
            $this->personne_experiences[] = $personneExperience;
        }

        return $this;
    }

    public function removePersonneExperience(Experience $personneExperience): self
    {
        $this->personne_experiences->removeElement($personneExperience);

        return $this;
    }

    /**
     * @return Collection<int, Formation>
     */
    public function getPersonneFormations(): Collection
    {
        return $this->personne_formations;
    }

    public function addPersonneFormation(Formation $personneFormation): self
    {
        if (!$this->personne_formations->contains($personneFormation)) {
            $this->personne_formations[] = $personneFormation;
        }

        return $this;
    }

    public function removePersonneFormation(Formation $personneFormation): self
    {
        $this->personne_formations->removeElement($personneFormation);

        return $this;
    }

    /**
     * @return Collection<int, Accreditation>
     */
    public function getPersonneAccreditations(): Collection
    {
        return $this->personne_accreditations;
    }

    public function addPersonneAccreditation(Accreditation $personneAccreditation): self
    {
        if (!$this->personne_accreditations->contains($personneAccreditation)) {
            $this->personne_accreditations[] = $personneAccreditation;
        }

        return $this;
    }

    public function removePersonneAccreditation(Accreditation $personneAccreditation): self
    {
        $this->personne_accreditations->removeElement($personneAccreditation);

        return $this;
    }

    public function getPersonneCompte(): ?Compte
    {
        return $this->personne_compte;
    }

    public function setPersonneCompte(?Compte $personne_compte): self
    {
        $this->personne_compte = $personne_compte;

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

    // public function getEntreprise(): ?Entreprise
    // {
    //     return $this->entreprise;
    // }

    public function setEntreprise(?Entreprise $entreprise): self
    {
        $this->entreprise = $entreprise;

        return $this;
    }
}
