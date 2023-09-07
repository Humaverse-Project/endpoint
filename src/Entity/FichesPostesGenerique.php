<?php

namespace App\Entity;

use App\Repository\FichesPostesGeneriqueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FichesPostesGeneriqueRepository::class)
 */
class FichesPostesGenerique
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
    private $fic_poste_gen_titre;

    /**
     * @ORM\ManyToOne(targetEntity=FichesCompetences::class)
     */
    private $fic_poste_gen_fiche_competence;

    /**
     * @ORM\ManyToOne(targetEntity=Rome::class)
     */
    private $fic_poste_gen_fiche_rome;

    /**
     * @ORM\Column(type="date")
     */
    private $fic_poste_gen_validation_at;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $fic_poste_gen_visa_at;

    /**
     * @ORM\ManyToMany(targetEntity=FichesPostes::class)
     * @ORM\JoinTable(name="fiches_poste_gen_liaison_hierarchique")
     */
    private $fic_poste_gen_liaison_hierarchique;

    /**
     * @ORM\ManyToOne(targetEntity=FichesPostes::class)
     */
    private $fic_poste_gen_nplus1;

    /**
     * @ORM\ManyToMany(targetEntity=FichesPostes::class)
     * @ORM\JoinTable(name="fiches_poste_gen_liaison_fonctionnelle")
     */
    private $fic_poste_gen_liaison_fonctionnelle;

    /**
     * @ORM\ManyToMany(targetEntity=ConventionCollective::class)
     * @ORM\JoinTable(name="fiches_poste_gen_convention_collective")
     */
    private $fic_poste_gen_convention_collective;

    /**
     * @ORM\ManyToOne(targetEntity=Entreprise::class)
     */
    private $fic_poste_gen_entreprise;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $fic_poste_gen_activite = [];

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $fic_poste_gen_definition = [];

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $fic_poste_gen_agrement;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $fic_poste_gen_conditions_generales;

    /**
     * @ORM\ManyToMany(targetEntity=Formation::class)
     * @ORM\JoinTable(name="fiches_poste_gen_formations")
     */
    private $fic_poste_gen_formations;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $fic_poste_gen_instructions = [];

    /**
     * @ORM\ManyToMany(targetEntity=ParcoursProfessionnel::class)
     * @ORM\JoinTable(name="fiches_poste_gen_fiches_postes_parcours_professionnel")
     */
    private $fic_poste_gen_fiches_postes_parcours_professionnel;

    /**
     * @ORM\Column(type="float")
     */
    private $fiches_postes_gen_version;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $updated_at;

    public function __construct()
    {
        $this->fic_poste_gen_liaison_hierarchique = new ArrayCollection();
        $this->fic_poste_gen_liaison_fonctionnelle = new ArrayCollection();
        $this->fic_poste_gen_convention_collective = new ArrayCollection();
        $this->fic_poste_gen_formations = new ArrayCollection();
        $this->fic_poste_gen_fiches_postes_parcours_professionnel = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFicPosteGenTitre(): ?string
    {
        return $this->fic_poste_gen_titre;
    }

    public function setFicPosteGenTitre(string $fic_poste_gen_titre): self
    {
        $this->fic_poste_gen_titre = $fic_poste_gen_titre;

        return $this;
    }

    public function getFicPosteGenFicheCompetence(): ?FichesCompetences
    {
        return $this->fic_poste_gen_fiche_competence;
    }

    public function setFicPosteGenFicheCompetence(?FichesCompetences $fic_poste_gen_fiche_competence): self
    {
        $this->fic_poste_gen_fiche_competence = $fic_poste_gen_fiche_competence;

        return $this;
    }

    public function getFicPosteGenFicheRome(): ?Rome
    {
        return $this->fic_poste_gen_fiche_rome;
    }

    public function setFicPosteGenFicheRome(?Rome $fic_poste_gen_fiche_rome): self
    {
        $this->fic_poste_gen_fiche_rome = $fic_poste_gen_fiche_rome;

        return $this;
    }

    public function getFicPosteGenValidationAt(): ?\DateTimeInterface
    {
        return $this->fic_poste_gen_validation_at;
    }

    public function setFicPosteGenValidationAt(\DateTimeInterface $fic_poste_gen_validation_at): self
    {
        $this->fic_poste_gen_validation_at = $fic_poste_gen_validation_at;

        return $this;
    }

    public function getFicPosteGenVisaAt(): ?\DateTimeInterface
    {
        return $this->fic_poste_gen_visa_at;
    }

    public function setFicPosteGenVisaAt(?\DateTimeInterface $fic_poste_gen_visa_at): self
    {
        $this->fic_poste_gen_visa_at = $fic_poste_gen_visa_at;

        return $this;
    }

    /**
     * @return Collection<int, FichesPostes>
     */
    public function getFicPosteGenLiaisonHierarchique(): Collection
    {
        return $this->fic_poste_gen_liaison_hierarchique;
    }

    public function addFicPosteGenLiaisonHierarchique(FichesPostes $ficPosteGenLiaisonHierarchique): self
    {
        if (!$this->fic_poste_gen_liaison_hierarchique->contains($ficPosteGenLiaisonHierarchique)) {
            $this->fic_poste_gen_liaison_hierarchique[] = $ficPosteGenLiaisonHierarchique;
        }

        return $this;
    }

    public function removeFicPosteGenLiaisonHierarchique(FichesPostes $ficPosteGenLiaisonHierarchique): self
    {
        $this->fic_poste_gen_liaison_hierarchique->removeElement($ficPosteGenLiaisonHierarchique);

        return $this;
    }

    public function getFicPosteGenNplus1(): ?FichesPostes
    {
        return $this->fic_poste_gen_nplus1;
    }

    public function setFicPosteGenNplus1(?FichesPostes $fic_poste_gen_nplus1): self
    {
        $this->fic_poste_gen_nplus1 = $fic_poste_gen_nplus1;

        return $this;
    }

    /**
     * @return Collection<int, FichesPostes>
     */
    public function getFicPosteGenLiaisonFonctionnelle(): Collection
    {
        return $this->fic_poste_gen_liaison_fonctionnelle;
    }

    public function addFicPosteGenLiaisonFonctionnelle(FichesPostes $ficPosteGenLiaisonFonctionnelle): self
    {
        if (!$this->fic_poste_gen_liaison_fonctionnelle->contains($ficPosteGenLiaisonFonctionnelle)) {
            $this->fic_poste_gen_liaison_fonctionnelle[] = $ficPosteGenLiaisonFonctionnelle;
        }

        return $this;
    }

    public function removeFicPosteGenLiaisonFonctionnelle(FichesPostes $ficPosteGenLiaisonFonctionnelle): self
    {
        $this->fic_poste_gen_liaison_fonctionnelle->removeElement($ficPosteGenLiaisonFonctionnelle);

        return $this;
    }

    /**
     * @return Collection<int, ConventionCollective>
     */
    public function getFicPosteGenConventionCollective(): Collection
    {
        return $this->fic_poste_gen_convention_collective;
    }

    public function addFicPosteGenConventionCollective(ConventionCollective $ficPosteGenConventionCollective): self
    {
        if (!$this->fic_poste_gen_convention_collective->contains($ficPosteGenConventionCollective)) {
            $this->fic_poste_gen_convention_collective[] = $ficPosteGenConventionCollective;
        }

        return $this;
    }

    public function removeFicPosteGenConventionCollective(ConventionCollective $ficPosteGenConventionCollective): self
    {
        $this->fic_poste_gen_convention_collective->removeElement($ficPosteGenConventionCollective);

        return $this;
    }

    public function getFicPosteGenEntreprise(): ?Entreprise
    {
        return $this->fic_poste_gen_entreprise;
    }

    public function setFicPosteGenEntreprise(?Entreprise $fic_poste_gen_entreprise): self
    {
        $this->fic_poste_gen_entreprise = $fic_poste_gen_entreprise;

        return $this;
    }

    public function getFicPosteGenActivite(): ?array
    {
        return $this->fic_poste_gen_activite;
    }

    public function setFicPosteGenActivite(?array $fic_poste_gen_activite): self
    {
        $this->fic_poste_gen_activite = $fic_poste_gen_activite;

        return $this;
    }

    public function getFicPosteGenDefinition(): ?array
    {
        return $this->fic_poste_gen_definition;
    }

    public function setFicPosteGenDefinition(?array $fic_poste_gen_definition): self
    {
        $this->fic_poste_gen_definition = $fic_poste_gen_definition;

        return $this;
    }

    public function getFicPosteGenAgrement(): ?string
    {
        return $this->fic_poste_gen_agrement;
    }

    public function setFicPosteGenAgrement(?string $fic_poste_gen_agrement): self
    {
        $this->fic_poste_gen_agrement = $fic_poste_gen_agrement;

        return $this;
    }

    public function getFicPosteGenConditionsGenerales(): ?string
    {
        return $this->fic_poste_gen_conditions_generales;
    }

    public function setFicPosteGenConditionsGenerales(?string $fic_poste_gen_conditions_generales): self
    {
        $this->fic_poste_gen_conditions_generales = $fic_poste_gen_conditions_generales;

        return $this;
    }

    /**
     * @return Collection<int, Formation>
     */
    public function getFicPosteGenFormations(): Collection
    {
        return $this->fic_poste_gen_formations;
    }

    public function addFicPosteGenFormation(Formation $ficPosteGenFormation): self
    {
        if (!$this->fic_poste_gen_formations->contains($ficPosteGenFormation)) {
            $this->fic_poste_gen_formations[] = $ficPosteGenFormation;
        }

        return $this;
    }

    public function removeFicPosteGenFormation(Formation $ficPosteGenFormation): self
    {
        $this->fic_poste_gen_formations->removeElement($ficPosteGenFormation);

        return $this;
    }

    public function getFicPosteGenInstructions(): ?array
    {
        return $this->fic_poste_gen_instructions;
    }

    public function setFicPosteGenInstructions(?array $fic_poste_gen_instructions): self
    {
        $this->fic_poste_gen_instructions = $fic_poste_gen_instructions;

        return $this;
    }

    /**
     * @return Collection<int, ParcoursProfessionnel>
     */
    public function getFicPosteGenFichesPostesParcoursProfessionnel(): Collection
    {
        return $this->fic_poste_gen_fiches_postes_parcours_professionnel;
    }

    public function addFicPosteGenFichesPostesParcoursProfessionnel(ParcoursProfessionnel $ficPosteGenFichesPostesParcoursProfessionnel): self
    {
        if (!$this->fic_poste_gen_fiches_postes_parcours_professionnel->contains($ficPosteGenFichesPostesParcoursProfessionnel)) {
            $this->fic_poste_gen_fiches_postes_parcours_professionnel[] = $ficPosteGenFichesPostesParcoursProfessionnel;
        }

        return $this;
    }

    public function removeFicPosteGenFichesPostesParcoursProfessionnel(ParcoursProfessionnel $ficPosteGenFichesPostesParcoursProfessionnel): self
    {
        $this->fic_poste_gen_fiches_postes_parcours_professionnel->removeElement($ficPosteGenFichesPostesParcoursProfessionnel);

        return $this;
    }

    public function getFichesPostesGenVersion(): ?float
    {
        return $this->fiches_postes_gen_version;
    }

    public function setFichesPostesGenVersion(float $fiches_postes_gen_version): self
    {
        $this->fiches_postes_gen_version = $fiches_postes_gen_version;

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
