<?php

namespace App\Entity;

use App\Repository\NiveauEtudeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: NiveauEtudeRepository::class)]
class NiveauEtude
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['list','eleves','niveau:read', 'session:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['list','eleves','niveau:read', 'session:read'])]
    private ?string $nom = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['list','eleves','niveau:read', 'session:read'])]
    private ?string $commentaire = null;

    /**
     * @var Collection<int, ElevesAnneScolaire>
     */
    #[ORM\OneToMany(targetEntity: ElevesAnneScolaire::class, mappedBy: 'niveauEtude')]
    private Collection $elevesAnneScolaires;

    /**
     * @var Collection<int, PaiementNiveauEtudeAnneeScolaire>
     */
    #[ORM\OneToMany(targetEntity: PaiementNiveauEtudeAnneeScolaire::class, mappedBy: 'niveauEtude')]
    private Collection $paiementNiveauEtudeAnneeScolaires;

    /**
     * @var Collection<int, SessionsNiveaux>
     */
    #[ORM\OneToMany(targetEntity: SessionsNiveaux::class, mappedBy: 'niveauEtude')]
    #[Groups(['niveau:read'])]
    private Collection $sessionsNiveauxes;

    public function __construct()
    {
        $this->elevesAnneScolaires = new ArrayCollection();
        $this->paiementNiveauEtudeAnneeScolaires = new ArrayCollection();
        $this->sessionsNiveauxes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(?string $commentaire): static
    {
        $this->commentaire = $commentaire;

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
            $elevesAnneScolaire->setNiveauEtude($this);
        }

        return $this;
    }

    public function removeElevesAnneScolaire(ElevesAnneScolaire $elevesAnneScolaire): static
    {
        if ($this->elevesAnneScolaires->removeElement($elevesAnneScolaire)) {
            // set the owning side to null (unless already changed)
            if ($elevesAnneScolaire->getNiveauEtude() === $this) {
                $elevesAnneScolaire->setNiveauEtude(null);
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
            $paiementNiveauEtudeAnneeScolaire->setNiveauEtude($this);
        }

        return $this;
    }

    public function removePaiementNiveauEtudeAnneeScolaire(PaiementNiveauEtudeAnneeScolaire $paiementNiveauEtudeAnneeScolaire): static
    {
        if ($this->paiementNiveauEtudeAnneeScolaires->removeElement($paiementNiveauEtudeAnneeScolaire)) {
            // set the owning side to null (unless already changed)
            if ($paiementNiveauEtudeAnneeScolaire->getNiveauEtude() === $this) {
                $paiementNiveauEtudeAnneeScolaire->setNiveauEtude(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, SessionsNiveaux>
     */
    public function getSessionsNiveauxes(): Collection
    {
        return $this->sessionsNiveauxes;
    }

    public function addSessionsNiveaux(SessionsNiveaux $sessionsNiveaux): static
    {
        if (!$this->sessionsNiveauxes->contains($sessionsNiveaux)) {
            $this->sessionsNiveauxes->add($sessionsNiveaux);
            $sessionsNiveaux->setNiveauEtude($this);
        }

        return $this;
    }

    public function removeSessionsNiveaux(SessionsNiveaux $sessionsNiveaux): static
    {
        if ($this->sessionsNiveauxes->removeElement($sessionsNiveaux)) {
            // set the owning side to null (unless already changed)
            if ($sessionsNiveaux->getNiveauEtude() === $this) {
                $sessionsNiveaux->setNiveauEtude(null);
            }
        }

        return $this;
    }
}
