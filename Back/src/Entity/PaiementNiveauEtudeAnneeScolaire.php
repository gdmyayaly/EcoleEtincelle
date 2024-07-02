<?php

namespace App\Entity;

use App\Repository\PaiementNiveauEtudeAnneeScolaireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: PaiementNiveauEtudeAnneeScolaireRepository::class)]
class PaiementNiveauEtudeAnneeScolaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['eleves','list'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'paiementNiveauEtudeAnneeScolaires')]
    #[Groups(['eleves','list'])]
    private ?NiveauEtude $niveauEtude = null;

    #[ORM\ManyToOne(inversedBy: 'paiementNiveauEtudeAnneeScolaires')]
    #[Groups(['eleves','list'])]
    private ?AnneeScolaire $anneeScolaire = null;

    #[ORM\ManyToOne(inversedBy: 'paiementNiveauEtudeAnneeScolaires')]
    #[Groups(['eleves','list'])]
    private ?AnneeScolaireMensualite $mensualite = null;

    #[ORM\Column(length: 255)]
    #[Groups(['eleves','list'])]
    private ?string $montant = null;

    /**
     * @var Collection<int, PaiementScolariteEleves>
     */
    #[ORM\OneToMany(targetEntity: PaiementScolariteEleves::class, mappedBy: 'scolaritePaiement')]
    private Collection $paiementScolariteEleves;

    public function __construct()
    {
        $this->paiementScolariteEleves = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNiveauEtude(): ?NiveauEtude
    {
        return $this->niveauEtude;
    }

    public function setNiveauEtude(?NiveauEtude $niveauEtude): static
    {
        $this->niveauEtude = $niveauEtude;

        return $this;
    }

    public function getAnneeScolaire(): ?AnneeScolaire
    {
        return $this->anneeScolaire;
    }

    public function setAnneeScolaire(?AnneeScolaire $anneeScolaire): static
    {
        $this->anneeScolaire = $anneeScolaire;

        return $this;
    }

    public function getMensualite(): ?AnneeScolaireMensualite
    {
        return $this->mensualite;
    }

    public function setMensualite(?AnneeScolaireMensualite $mensualite): static
    {
        $this->mensualite = $mensualite;

        return $this;
    }

    public function getMontant(): ?string
    {
        return $this->montant;
    }

    public function setMontant(string $montant): static
    {
        $this->montant = $montant;

        return $this;
    }

    /**
     * @return Collection<int, PaiementScolariteEleves>
     */
    public function getPaiementScolariteEleves(): Collection
    {
        return $this->paiementScolariteEleves;
    }

    public function addPaiementScolariteElefe(PaiementScolariteEleves $paiementScolariteElefe): static
    {
        if (!$this->paiementScolariteEleves->contains($paiementScolariteElefe)) {
            $this->paiementScolariteEleves->add($paiementScolariteElefe);
            $paiementScolariteElefe->setScolaritePaiement($this);
        }

        return $this;
    }

    public function removePaiementScolariteElefe(PaiementScolariteEleves $paiementScolariteElefe): static
    {
        if ($this->paiementScolariteEleves->removeElement($paiementScolariteElefe)) {
            // set the owning side to null (unless already changed)
            if ($paiementScolariteElefe->getScolaritePaiement() === $this) {
                $paiementScolariteElefe->setScolaritePaiement(null);
            }
        }

        return $this;
    }
}
