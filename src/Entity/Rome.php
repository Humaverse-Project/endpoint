<?php

namespace App\Entity;

use App\Repository\RomeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity(repositoryClass=RomeRepository::class)
 */
class Rome
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
    private $rome_titre;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $rome_coderome;

    /**
     * @ORM\Column(type="text")
     */
    private $rome_definition;

    /**
     * @ORM\Column(type="text")
     */
    private $rome_acces_metier;

    /**
     * @ORM\ManyToMany(targetEntity=Rome::class)
     * @ORM\JoinTable(name="rome_proches")
     */
    private $fiches_rome_proches;

    /**
     * @ORM\ManyToMany(targetEntity=Rome::class)
     * @ORM\JoinTable(name="rome_evolution")
     */
    private $fiches_rome_evolution;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $updated_at;

    /**
     * @ORM\OneToMany(targetEntity=BriquesCompetences::class, mappedBy="rome")
     */
    private $briquesCompetences;

    /**
     * @ORM\OneToMany(targetEntity=Emploi::class, mappedBy="rome")
     */
    private $emplois;

    public function __construct()
    {
        $this->fiches_rome_proches = new ArrayCollection();
        $this->fiches_rome_evolution = new ArrayCollection();
        $this->briquesCompetences = new ArrayCollection();
        $this->emplois = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRomeTitre(): ?string
    {
        return $this->rome_titre;
    }

    public function setRomeTitre(string $rome_titre): self
    {
        $this->rome_titre = $rome_titre;

        return $this;
    }

    public function getRomeCoderome(): ?string
    {
        return $this->rome_coderome;
    }

    public function setRomeCoderome(string $rome_coderome): self
    {
        $this->rome_coderome = $rome_coderome;

        return $this;
    }

    public function getRomeDefinition(): ?string
    {
        return $this->rome_definition;
    }

    public function setRomeDefinition(string $rome_definition): self
    {
        $this->rome_definition = $rome_definition;

        return $this;
    }

    public function getRomeAccesMetier(): ?string
    {
        return $this->rome_acces_metier;
    }

    public function setRomeAccesMetier(string $rome_acces_metier): self
    {
        $this->rome_acces_metier = $rome_acces_metier;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getFichesRomeProches(): Collection
    {
        return $this->fiches_rome_proches;
    }

    public function addFichesRomeProch(self $fichesRomeProch): self
    {
        if (!$this->fiches_rome_proches->contains($fichesRomeProch)) {
            $this->fiches_rome_proches[] = $fichesRomeProch;
        }

        return $this;
    }

    public function removeFichesRomeProch(self $fichesRomeProch): self
    {
        $this->fiches_rome_proches->removeElement($fichesRomeProch);

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getFichesRomeEvolution(): Collection
    {
        return $this->fiches_rome_evolution;
    }

    public function addFichesRomeEvolution(self $fichesRomeEvolution): self
    {
        if (!$this->fiches_rome_evolution->contains($fichesRomeEvolution)) {
            $this->fiches_rome_evolution[] = $fichesRomeEvolution;
        }

        return $this;
    }

    public function removeFichesRomeEvolution(self $fichesRomeEvolution): self
    {
        $this->fiches_rome_evolution->removeElement($fichesRomeEvolution);

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
    //  * @return Collection<int, BriquesCompetences>
    //  */
    // public function getBriquesCompetences(): Collection
    // {
    //     return $this->briquesCompetences;
    // }

    public function addBriquesCompetence(BriquesCompetences $briquesCompetence): self
    {
        if (!$this->briquesCompetences->contains($briquesCompetence)) {
            $this->briquesCompetences[] = $briquesCompetence;
            $briquesCompetence->setRome($this);
        }

        return $this;
    }

    // public function removeBriquesCompetence(BriquesCompetences $briquesCompetence): self
    // {
    //     if ($this->briquesCompetences->removeElement($briquesCompetence)) {
    //         // set the owning side to null (unless already changed)
    //         if ($briquesCompetence->getRome() === $this) {
    //             $briquesCompetence->setRome(null);
    //         }
    //     }

    //     return $this;
    // }

    /**
     * @return Collection<int, Emploi>
     */
    public function getEmplois(): Collection
    {
        return $this->emplois;
    }

    public function addEmploi(Emploi $emploi): self
    {
        if (!$this->emplois->contains($emploi)) {
            $this->emplois[] = $emploi;
            $emploi->setRome($this);
        }

        return $this;
    }

    public function removeEmploi(Emploi $emploi): self
    {
        if ($this->emplois->removeElement($emploi)) {
            // set the owning side to null (unless already changed)
            if ($emploi->getRome() === $this) {
                $emploi->setRome(null);
            }
        }

        return $this;
    }
    public function _toArray(): array
    {
        $formattedData = [
            'id' => $this->getId(),
            'nom' => $this->getRomeTitre(),
            'rome_coderome' => $this->getRomeCoderome(),
            'rome_definition' => $this->getRomeDefinition(),
            'rome_acces_metier' => $this->getRomeAccesMetier(),
            'created_at' => $this->getCreatedAt(),
            'updated_at' => $this->getUpdatedAt(),
            'romeproche' => [],
            'romeevolution'=>[]
        ];

        foreach ($this->getFichesRomeProches() as $proche) {
            $formattedData['romeproche'][] = [
                'id' => $proche->getId(),
                'nom' => $proche->getRomeTitre(),
                'rome_coderome' => $proche->getRomeCoderome(),
                'rome_definition' => $proche->getRomeDefinition(),
                'rome_acces_metier' => $proche->getRomeAccesMetier(),
            ];
        }

        foreach ($this->getFichesRomeEvolution() as $evolution) {
            $formattedData['romeevolution'][] = [
                'id' => $evolution->getId(),
                'nom' => $evolution->getRomeTitre(),
                'rome_coderome' => $evolution->getRomeCoderome(),
                'rome_definition' => $evolution->getRomeDefinition(),
                'rome_acces_metier' => $evolution->getRomeAccesMetier(),
            ];
        }

        return $formattedData;
    }
}
