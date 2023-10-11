<?php

namespace App\Entity;

use App\Repository\FichesPostesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FichesPostesRepository::class)
 */
class FichesPostes
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
    private $fiches_postes_titre;

    /**
     * @ORM\ManyToOne(targetEntity=FichesCompetences::class)
     */
    private $fiches_postes_fiche_competence;

    /**
     * @ORM\ManyToOne(targetEntity=Rome::class)
     */
    private $fiches_postes_fiche_rome;

    /**
     * @ORM\Column(type="date")
     */
    private $fiches_postes_validation_at;

    /**
     * @ORM\Column(type="date")
     */
    private $fiches_postes_visa_at;

    /**
     * @ORM\ManyToMany(targetEntity=FichesPostes::class)
     * @ORM\JoinTable(name="fiches_postes_liaison_hierarchique")
     */
    private $fiches_postes_liaison_hierarchique;

    /**
     * @ORM\ManyToOne(targetEntity=FichesPostes::class)
     */
    private $fiches_postes_nplus1;

    /**
     * @ORM\ManyToMany(targetEntity=FichesPostes::class)
     * @ORM\JoinTable(name="fiches_postes_liaison_fonctionnelle")
     */
    private $fiches_postes_liaison_fonctionnelle;

    /**
     * @ORM\ManyToMany(targetEntity=ConventionCollective::class)
     * @ORM\JoinTable(name="fiches_postes_convention_collective")
     */
    private $fiches_postes_convention_collective;

    /**
     * @ORM\ManyToOne(targetEntity=Entreprise::class, inversedBy="fichesPostes")
     */
    private $fiches_postes_entreprise;


    /**
     * @ORM\ManyToMany(targetEntity=Formation::class)
     * @ORM\JoinTable(name="fiches_postes_formations")
     */
    private $formations;

    /**
     * @ORM\ManyToMany(targetEntity=ParcoursProfessionnel::class)
     * @ORM\JoinTable(name="fiches_postes_parcours_professionnel")
     */
    private $fiches_postes_parcours_professionnel;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $updated_at;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $fiches_postes_version;

    /**
     * @ORM\OneToMany(targetEntity=BriquesContexteMetiers::class, mappedBy="fichesPostes", orphanRemoval=true)
     */
    private $briquesContexteMetiers;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $fiches_postes_convention;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $fiches_poste_definition;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $fiches_post_formations;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $fiches_postes_activite;

    /**
     * @ORM\ManyToOne(targetEntity=Emploi::class)
     */
    private $appelation;

    public function __construct()
    {
        $this->fiches_postes_liaison_hierarchique = new ArrayCollection();
        $this->fiches_postes_liaison_fonctionnelle = new ArrayCollection();
        $this->fiches_postes_convention_collective = new ArrayCollection();
        $this->formations = new ArrayCollection();
        $this->fiches_postes_parcours_professionnel = new ArrayCollection();
        $this->briquesContexteMetiers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFichesPostesTitre(): ?string
    {
        return $this->fiches_postes_titre;
    }

    public function setFichesPostesTitre(string $fiches_postes_titre): self
    {
        $this->fiches_postes_titre = $fiches_postes_titre;

        return $this;
    }

    public function getFichesPostesFicheCompetence(): ?FichesCompetences
    {
        return $this->fiches_postes_fiche_competence;
    }

    public function setFichesPostesFicheCompetence(?FichesCompetences $fiches_postes_fiche_competence): self
    {
        $this->fiches_postes_fiche_competence = $fiches_postes_fiche_competence;

        return $this;
    }

    public function getFichesPostesFicheRome(): ?Rome
    {
        return $this->fiches_postes_fiche_rome;
    }

    public function setFichesPostesFicheRome(?Rome $fiches_postes_fiche_rome): self
    {
        $this->fiches_postes_fiche_rome = $fiches_postes_fiche_rome;

        return $this;
    }

    public function getFichesPostesValidationAt(): ?\DateTimeInterface
    {
        return $this->fiches_postes_validation_at;
    }

    public function setFichesPostesValidationAt(\DateTimeInterface $fiches_postes_validation_at): self
    {
        $this->fiches_postes_validation_at = $fiches_postes_validation_at;

        return $this;
    }

    public function getFichesPostesVisaAt(): ?\DateTimeInterface
    {
        return $this->fiches_postes_visa_at;
    }

    public function setFichesPostesVisaAt(\DateTimeInterface $fiches_postes_visa_at): self
    {
        $this->fiches_postes_visa_at = $fiches_postes_visa_at;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getFichesPostesLiaisonHierarchique(): Collection
    {
        return $this->fiches_postes_liaison_hierarchique;
    }

    public function addFichesPostesLiaisonHierarchique(self $fichesPostesLiaisonHierarchique): self
    {
        if (!$this->fiches_postes_liaison_hierarchique->contains($fichesPostesLiaisonHierarchique)) {
            $this->fiches_postes_liaison_hierarchique[] = $fichesPostesLiaisonHierarchique;
        }

        return $this;
    }

    public function removeFichesPostesLiaisonHierarchique(self $fichesPostesLiaisonHierarchique): self
    {
        $this->fiches_postes_liaison_hierarchique->removeElement($fichesPostesLiaisonHierarchique);

        return $this;
    }

    public function getFichesPostesNplus1(): ?self
    {
        return $this->fiches_postes_nplus1;
    }

    public function setFichesPostesNplus1(?self $fiches_postes_nplus1): self
    {
        $this->fiches_postes_nplus1 = $fiches_postes_nplus1;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getFichesPostesLiaisonFonctionnelle(): Collection
    {
        return $this->fiches_postes_liaison_fonctionnelle;
    }

    public function addFichesPostesLiaisonFonctionnelle(self $fichesPostesLiaisonFonctionnelle): self
    {
        if (!$this->fiches_postes_liaison_fonctionnelle->contains($fichesPostesLiaisonFonctionnelle)) {
            $this->fiches_postes_liaison_fonctionnelle[] = $fichesPostesLiaisonFonctionnelle;
        }

        return $this;
    }

    public function removeFichesPostesLiaisonFonctionnelle(self $fichesPostesLiaisonFonctionnelle): self
    {
        $this->fiches_postes_liaison_fonctionnelle->removeElement($fichesPostesLiaisonFonctionnelle);

        return $this;
    }

    /**
     * @return Collection<int, ConventionCollective>
     */
    public function getFichesPostesConventionCollective(): Collection
    {
        return $this->fiches_postes_convention_collective;
    }

    public function addFichesPostesConventionCollective(ConventionCollective $fichesPostesConventionCollective): self
    {
        if (!$this->fiches_postes_convention_collective->contains($fichesPostesConventionCollective)) {
            $this->fiches_postes_convention_collective[] = $fichesPostesConventionCollective;
        }

        return $this;
    }

    public function removeFichesPostesConventionCollective(ConventionCollective $fichesPostesConventionCollective): self
    {
        $this->fiches_postes_convention_collective->removeElement($fichesPostesConventionCollective);

        return $this;
    }

    public function getFichesPostesEntreprise(): ?Entreprise
    {
        return $this->fiches_postes_entreprise;
    }

    public function setFichesPostesEntreprise(?Entreprise $fiches_postes_entreprise): self
    {
        $this->fiches_postes_entreprise = $fiches_postes_entreprise;

        return $this;
    }

    /**
     * @return Collection<int, Formation>
     */
    public function getFormations(): Collection
    {
        return $this->formations;
    }

    public function addFormation(Formation $formation): self
    {
        if (!$this->formations->contains($formation)) {
            $this->formations[] = $formation;
        }

        return $this;
    }

    public function removeFormation(Formation $formation): self
    {
        $this->formations->removeElement($formation);

        return $this;
    }


    /**
     * @return Collection<int, ParcoursProfessionnel>
     */
    public function getFichesPostesParcoursProfessionnel(): Collection
    {
        return $this->fiches_postes_parcours_professionnel;
    }

    public function addFichesPostesParcoursProfessionnel(ParcoursProfessionnel $fichesPostesParcoursProfessionnel): self
    {
        if (!$this->fiches_postes_parcours_professionnel->contains($fichesPostesParcoursProfessionnel)) {
            $this->fiches_postes_parcours_professionnel[] = $fichesPostesParcoursProfessionnel;
        }

        return $this;
    }

    public function removeFichesPostesParcoursProfessionnel(ParcoursProfessionnel $fichesPostesParcoursProfessionnel): self
    {
        $this->fiches_postes_parcours_professionnel->removeElement($fichesPostesParcoursProfessionnel);

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
    public function _getOrganigrammeData(): array
    {
        $data = [
            'id' => $this->getId(),
            'fiches_postes_titre' => $this->getFichesPostesTitre(),
            'fiches_postes_nplus1' => []
        ];

        if (!empty($this->getFichesPostesNplus1())) {
            $data['fiches_postes_nplus1'] = [
                'id' => $this->getFichesPostesNplus1()->getId(),
                'fiches_postes_titre' => $this->getFichesPostesNplus1()->getFichesPostesTitre()
            ];
        }
        return $data;
    }

    public function _getListPostData(): array
    {
        $data = [
            'label'=> "[".$this->getFichesPostesVersion()."] ".$this->getFichesPostesTitre(),
            'id' => $this->getId(),
            'titre' => $this->getFichesPostesTitre(),
            'createdAt'=> $this->getCreatedAt(),
            'version'=> $this->getFichesPostesVersion(),
            'fichecompetance' => [
                "id"=> $this->getFichesPostesFicheCompetence()->getId(),
                "titre" =>$this->getFichesPostesFicheCompetence()->getFicCompTitreEmploi(),
                "niveau"=>$this->getFichesPostesFicheCompetence()->getBriquesCompetencesNiveaux(),
                "version"=> $this->getFichesPostesFicheCompetence()->getFicCompVersion(),
                "briquelist" => $this->getFichesPostesFicheCompetence()->getFicCompCompetences()
            ],
            'convention' =>$this->getFichesPostesConvention(),
            'definition' =>$this->getFichesPosteDefinition(),
            'activite' =>$this->getFichesPostesActivite(),
            'formation'=> $this->getFichesPostFormations(),
            'briquecontextmetier' => [],
            'emplois'=> $this->getAppelation(),
            'validation'=> $this->getFichesPostesValidationAt(),
            'visa'=> $this->getFichesPostesVisaAt(),
            'rome' => [
                "id"=>$this->getFichesPostesFicheRome()->getId(),
                "codeRome"=> $this->getFichesPostesFicheRome()->getRomeCoderome(),
                "code"=> $this->getFichesPostesFicheRome()->getRomeCoderome(),
                "titre"=> $this->getFichesPostesFicheRome()->getRomeTitre()
            ],
            'fiches_postes_nplus1' => []
        ];

        if (!empty($this->getFichesPostesNplus1())) {
            $data['fiches_postes_nplus1'] = [
                'id' => $this->getFichesPostesNplus1()->getId(),
                'fiches_postes_titre' => $this->getFichesPostesNplus1()->getFichesPostesTitre()
            ];
        }
        $briquemetier = $this->getBriquesContexteMetiers();
        if (!empty($briquemetier)) {
            foreach ($briquemetier as $key) {
                $data["briquecontextmetier"][] = [
                    'id' => $key->getId(),
                    'name' => $key->getBrqctxmetiertitre(),
                    'contexttitre' => $key->getContexte()->getCtxTrvTitre(),
                    'contextid' => $key->getContexte()->getid()
                ];
            }
        }
        return $data;
    }

    public function getFichesPostesVersion(): ?float
    {
        return $this->fiches_postes_version;
    }

    public function setFichesPostesVersion(?float $fiches_postes_version): self
    {
        $this->fiches_postes_version = $fiches_postes_version;

        return $this;
    }

    /**
     * @return Collection<int, BriquesContexteMetiers>
     */
    public function getBriquesContexteMetiers(): Collection
    {
        return $this->briquesContexteMetiers;
    }

    public function addBriquesContexteMetier(BriquesContexteMetiers $briquesContexteMetier): self
    {
        if (!$this->briquesContexteMetiers->contains($briquesContexteMetier)) {
            $this->briquesContexteMetiers[] = $briquesContexteMetier;
            $briquesContexteMetier->setFichesPostes($this);
        }

        return $this;
    }

    public function removeBriquesContexteMetier(BriquesContexteMetiers $briquesContexteMetier): self
    {
        if ($this->briquesContexteMetiers->removeElement($briquesContexteMetier)) {
            // set the owning side to null (unless already changed)
            if ($briquesContexteMetier->getFichesPostes() === $this) {
                $briquesContexteMetier->setFichesPostes(null);
            }
        }

        return $this;
    }

    public function getFichesPostesConvention(): ?string
    {
        return $this->fiches_postes_convention;
    }

    public function setFichesPostesConvention(?string $fiches_postes_convention): self
    {
        $this->fiches_postes_convention = $fiches_postes_convention;

        return $this;
    }

    public function getFichesPosteDefinition(): ?string
    {
        return $this->fiches_poste_definition;
    }

    public function setFichesPosteDefinition(?string $fiches_poste_definition): self
    {
        $this->fiches_poste_definition = $fiches_poste_definition;

        return $this;
    }

    public function getFichesPostFormations(): ?string
    {
        return $this->fiches_post_formations;
    }

    public function setFichesPostFormations(?string $fiches_post_formations): self
    {
        $this->fiches_post_formations = $fiches_post_formations;

        return $this;
    }

    public function getFichesPostesActivite(): ?string
    {
        return $this->fiches_postes_activite;
    }

    public function setFichesPostesActivite(?string $fiches_postes_activite): self
    {
        $this->fiches_postes_activite = $fiches_postes_activite;

        return $this;
    }

    public function getAppelation(): ?Emploi
    {
        return $this->appelation;
    }

    public function setAppelation(?Emploi $appelation): self
    {
        $this->appelation = $appelation;

        return $this;
    }
}
