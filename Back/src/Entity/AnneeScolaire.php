<?php

namespace App\Entity;

use App\Repository\AnneeScolaireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: AnneeScolaireRepository::class)]
class AnneeScolaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['list','eleves'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['list','eleves'])]
    private ?string $moisStart = null;

    #[ORM\Column(length: 255)]
    #[Groups(['list','eleves'])]
    private ?string $moisEnd = null;

    #[ORM\Column]
    #[Groups(['list','eleves'])]
    private ?int $anneeStart = null;

    #[ORM\Column]
    #[Groups(['list','eleves'])]
    private ?int $anneeEnd = null;

    /**
     * @var Collection<int, AnneeScolaireMensualite>
     */
    #[ORM\OneToMany(targetEntity: AnneeScolaireMensualite::class, mappedBy: 'anneeScolaire')]
    #[Groups(['list','eleves'])]
    private Collection $anneeScolaireMensualites;

    /**
     * @var Collection<int, ElevesAnneScolaire>
     */
    #[ORM\OneToMany(targetEntity: ElevesAnneScolaire::class, mappedBy: 'anneeScolaire')]
    #[Groups(['list'])]
    private Collection $elevesAnneScolaires;


    /**
     * @var Collection<int, PaiementNiveauEtudeAnneeScolaire>
     */
    #[ORM\OneToMany(targetEntity: PaiementNiveauEtudeAnneeScolaire::class, mappedBy: 'anneeScolaire')]
    private Collection $paiementNiveauEtudeAnneeScolaires;

    public function __construct()
    {
        $this->anneeScolaireMensualites = new ArrayCollection();
        $this->elevesAnneScolaires = new ArrayCollection();
        $this->paiementNiveauEtudeAnneeScolaires = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMoisStart(): ?string
    {
        return $this->moisStart;
    }

    public function setMoisStart(string $moisStart): static
    {
        $this->moisStart = $moisStart;

        return $this;
    }

    public function getMoisEnd(): ?string
    {
        return $this->moisEnd;
    }

    public function setMoisEnd(string $moisEnd): static
    {
        $this->moisEnd = $moisEnd;

        return $this;
    }

    public function getAnneeStart(): ?int
    {
        return $this->anneeStart;
    }

    public function setAnneeStart(int $anneeStart): static
    {
        $this->anneeStart = $anneeStart;

        return $this;
    }

    public function getAnneeEnd(): ?int
    {
        return $this->anneeEnd;
    }

    public function setAnneeEnd(int $anneeEnd): static
    {
        $this->anneeEnd = $anneeEnd;

        return $this;
    }

    /**
     * @return Collection<int, AnneeScolaireMensualite>
     */
    public function getAnneeScolaireMensualites(): Collection
    {
        return $this->anneeScolaireMensualites;
    }

    public function addAnneeScolaireMensualite(AnneeScolaireMensualite $anneeScolaireMensualite): static
    {
        if (!$this->anneeScolaireMensualites->contains($anneeScolaireMensualite)) {
            $this->anneeScolaireMensualites->add($anneeScolaireMensualite);
            $anneeScolaireMensualite->setAnneeScolaire($this);
        }

        return $this;
    }

    public function removeAnneeScolaireMensualite(AnneeScolaireMensualite $anneeScolaireMensualite): static
    {
        if ($this->anneeScolaireMensualites->removeElement($anneeScolaireMensualite)) {
            // set the owning side to null (unless already changed)
            if ($anneeScolaireMensualite->getAnneeScolaire() === $this) {
                $anneeScolaireMensualite->setAnneeScolaire(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ElevesAnneScolaire>
     */
    public function getElevesAnneScolaires(): Collection
    {
        return $this->elevesAnneScolaires;
    }

    public function addElevesAnneScolaire(ElevesAnneScolaire $elevesAnneScolaire): static
    {
        if (!$this->elevesAnneScolaires->contains($elevesAnneScolaire)) {
            $this->elevesAnneScolaires->add($elevesAnneScolaire);
            $elevesAnneScolaire->setAnneeScolaire($this);
        }

        return $this;
    }

    public function removeElevesAnneScolaire(ElevesAnneScolaire $elevesAnneScolaire): static
    {
        if ($this->elevesAnneScolaires->removeElement($elevesAnneScolaire)) {
            // set the owning side to null (unless already changed)
            if ($elevesAnneScolaire->getAnneeScolaire() === $this) {
                $elevesAnneScolaire->setAnneeScolaire(null);
            }
        }

        return $this;
    }


    /**
     * @return Collection<int, PaiementNiveauEtudeAnneeScolaire>
     */
    public function getPaiementNiveauEtudeAnneeScolaires(): Collection
    {
        return $this->paiementNiveauEtudeAnneeScolaires;
    }

    public function addPaiementNiveauEtudeAnneeScolaire(PaiementNiveauEtudeAnneeScolaire $paiementNiveauEtudeAnneeScolaire): static
    {
        if (!$this->paiementNiveauEtudeAnneeScolaires->contains($paiementNiveauEtudeAnneeScolaire)) {
            $this->paiementNiveauEtudeAnneeScolaires->add($paiementNiveauEtudeAnneeScolaire);
            $paiementNiveauEtudeAnneeScolaire->setAnneeScolaire($this);
        }

        return $this;
    }

    public function removePaiementNiveauEtudeAnneeScolaire(PaiementNiveauEtudeAnneeScolaire $paiementNiveauEtudeAnneeScolaire): static
    {
        if ($this->paiementNiveauEtudeAnneeScolaires->removeElement($paiementNiveauEtudeAnneeScolaire)) {
            // set the owning side to null (unless already changed)
            if ($paiementNiveauEtudeAnneeScolaire->getAnneeScolaire() === $this) {
                $paiementNiveauEtudeAnneeScolaire->setAnneeScolaire(null);
            }
        }

        return $this;
    }
}
