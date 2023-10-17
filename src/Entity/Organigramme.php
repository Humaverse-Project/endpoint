<?php

namespace App\Entity;

use App\Repository\OrganigrammeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrganigrammeRepository::class)
 */
class Organigramme
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
    private $org_intitule_poste;

    /**
     * @ORM\ManyToOne(targetEntity=FichesPostes::class, inversedBy="organigrammes")
     */
    private $fiches_postes;

    /**
     * @ORM\ManyToOne(targetEntity=Personne::class, inversedBy="organigrammes")
     */
    private $personnes;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $updated_at;

    /**
     * @ORM\ManyToOne(targetEntity=Entreprise::class, inversedBy="organigrammes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $entreprise;

    /**
     * @ORM\ManyToOne(targetEntity=Organigramme::class)
     * @ORM\JoinColumn(name="organigramme_nplus_1_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $organigramme_nplus_1;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrgIntitulePoste(): ?string
    {
        return $this->org_intitule_poste;
    }

    public function setOrgIntitulePoste(string $org_intitule_poste): self
    {
        $this->org_intitule_poste = $org_intitule_poste;

        return $this;
    }

    public function getFichesPostes(): ?array
    {
        
        if ($this->personnes) {
            return $this->fiches_postes->_getOrganigrammeData();
        }
        return null;
    }

    public function setFichesPostes(?FichesPostes $fiches_postes): self
    {
        $this->fiches_postes = $fiches_postes;

        return $this;
    }

    public function getPersonnes(): ?array
    {
        if ($this->personnes) {
            return $this->personnes->_getOrganigrammeData();
        }
        return null;
    }

    public function setPersonnes(?Personne $personnes): self
    {
        $this->personnes = $personnes;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(?\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function setEntreprise(?Entreprise $entreprise): self
    {
        $this->entreprise = $entreprise;

        return $this;
    }

    public function getOrganigrammeNplus1(): ?int
    {
        
        if ($this->organigramme_nplus_1) {
            return $this->organigramme_nplus_1->getId();
        }
        return null;
    }

    public function setOrganigrammeNplus1(?self $organigramme_nplus_1): self
    {
        $this->organigramme_nplus_1 = $organigramme_nplus_1;

        return $this;
    }
}
