<?php

namespace App\Entity;

use App\Repository\CompteRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CompteRepository::class)
 */
class Compte
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
    private $compte_nom;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $compte_prenom;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $compte_email;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $compte_nom_utilisateur;

    /**
     * @ORM\Column(type="text")
     */
    private $compte_mot_de_passe;

    /**
     * @ORM\ManyToOne(targetEntity=Entreprise::class, inversedBy="comptes")
     */
    private $compte_entreprise_id;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $compte_role;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $updated_at;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $compte_telephone;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $compte_service;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompteNom(): ?string
    {
        return $this->compte_nom;
    }

    public function setCompteNom(string $compte_nom): self
    {
        $this->compte_nom = $compte_nom;

        return $this;
    }

    public function getComptePrenom(): ?string
    {
        return $this->compte_prenom;
    }

    public function setComptePrenom(string $compte_prenom): self
    {
        $this->compte_prenom = $compte_prenom;

        return $this;
    }

    public function getCompteEmail(): ?string
    {
        return $this->compte_email;
    }

    public function setCompteEmail(string $compte_email): self
    {
        $this->compte_email = $compte_email;

        return $this;
    }

    public function getCompteNomUtilisateur(): ?string
    {
        return $this->compte_nom_utilisateur;
    }

    public function setCompteNomUtilisateur(string $compte_nom_utilisateur): self
    {
        $this->compte_nom_utilisateur = $compte_nom_utilisateur;

        return $this;
    }

    public function getCompteMotDePasse(): ?string
    {
        return $this->compte_mot_de_passe;
    }

    public function setCompteMotDePasse(string $compte_mot_de_passe): self
    {
        $this->compte_mot_de_passe = $compte_mot_de_passe;

        return $this;
    }

    public function getCompteEntrepriseId(): ?Entreprise
    {
        return $this->compte_entreprise_id;
    }

    public function setCompteEntrepriseId(?Entreprise $compte_entreprise_id): self
    {
        $this->compte_entreprise_id = $compte_entreprise_id;

        return $this;
    }

    public function getCompteRole(): ?string
    {
        return $this->compte_role;
    }

    public function setCompteRole(string $compte_role): self
    {
        $this->compte_role = $compte_role;

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

    public function getCompteTelephone(): ?string
    {
        return $this->compte_telephone;
    }

    public function setCompteTelephone(?string $compte_telephone): self
    {
        $this->compte_telephone = $compte_telephone;

        return $this;
    }

    public function getCompteService(): ?string
    {
        return $this->compte_service;
    }

    public function setCompteService(?string $compte_service): self
    {
        $this->compte_service = $compte_service;

        return $this;
    }
}
