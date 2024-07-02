<?php

namespace App\Entity;

use App\Repository\AnneeScolaireMensualiteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: AnneeScolaireMensualiteRepository::class)]
class AnneeScolaireMensualite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['list'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['list'])]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'anneeScolaireMensualites')]
    private ?AnneeScolaire $anneeScolaire = null;

    /**
     * @var Collection<int, PaiementNiveauEtudeAnneeScolaire>
     */
    #[ORM\OneToMany(targetEntity: PaiementNiveauEtudeAnneeScolaire::class, mappedBy: 'mensualite')]
    private Collection $paiementNiveauEtudeAnneeScolaires;

    public function __construct()
    {
        $this->paiementNiveauEtudeAnneeScolaires = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

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
            $paiementNiveauEtudeAnneeScolaire->setMensualite($this);
        }

        return $this;
    }

    public function removePaiementNiveauEtudeAnneeScolaire(PaiementNiveauEtudeAnneeScolaire $paiementNiveauEtudeAnneeScolaire): static
    {
        if ($this->paiementNiveauEtudeAnneeScolaires->removeElement($paiementNiveauEtudeAnneeScolaire)) {
            // set the owning side to null (unless already changed)
            if ($paiementNiveauEtudeAnneeScolaire->getMensualite() === $this) {
                $paiementNiveauEtudeAnneeScolaire->setMensualite(null);
            }
        }

        return $this;
    }
}
