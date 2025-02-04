<?php

namespace App\Entity;

use App\Repository\ElevesRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ElevesRepository::class)]
class Eleves
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['eleves','list'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['eleves','list'])]
    private ?string $prenom = null;

    #[ORM\Column(length: 255)]
    #[Groups(['eleves','list'])]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    #[Groups(['eleves','list'])]
    private ?string $age = null;

    #[ORM\Column(length: 255)]
    #[Groups(['eleves','list'])]
    private ?string $sex = null;

    #[ORM\Column(length: 255)]
    #[Groups(['eleves','list'])]
    private ?string $dateDeNaissance = null;

    /**
     * @var Collection<int, ParentsElevesLink>
     */
    #[ORM\OneToMany(targetEntity: ParentsElevesLink::class, mappedBy: 'eleves')]
    #[Groups(['eleves'])]
    private Collection $parentsElevesLinks;

    #[ORM\Column]
    private ?bool $isDeleted = null;

    #[ORM\Column(length: 255)]
    #[Groups(['eleves'])]
    private ?string $image = null;

    #[ORM\Column(length: 255)]
    #[Groups(['eleves'])]
    private ?string $commentaire = null;

    /**
     * @var Collection<int, ElevesAnneScolaire>
     */
    #[ORM\OneToMany(targetEntity: ElevesAnneScolaire::class, mappedBy: 'eleves')]
    #[Groups(['eleves'])]
    private Collection $elevesAnneScolaires;


    /**
     * @var Collection<int, PaiementScolariteEleves>
     */
    #[ORM\OneToMany(targetEntity: PaiementScolariteEleves::class, mappedBy: 'eleves')]
    private Collection $paiementScolariteEleves;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    public function __construct()
    {
        $this->parentsElevesLinks = new ArrayCollection();
        $this->elevesAnneScolaires = new ArrayCollection();
        $this->paiementScolariteEleves = new ArrayCollection();
        $this->createdAt= new DateTimeImmutable('now');
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
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

    public function getAge(): ?string
    {
        return $this->age;
    }

    public function setAge(string $age): static
    {
        $this->age = $age;

        return $this;
    }

    public function getSex(): ?string
    {
        return $this->sex;
    }

    public function setSex(string $sex): static
    {
        $this->sex = $sex;

        return $this;
    }

    public function getDateDeNaissance(): ?string
    {
        return $this->dateDeNaissance;
    }

    public function setDateDeNaissance(string $dateDeNaissance): static
    {
        $this->dateDeNaissance = $dateDeNaissance;

        return $this;
    }

    /**
     * @return Collection<int, ParentsElevesLink>
     */
    public function getParentsElevesLinks(): Collection
    {
        return $this->parentsElevesLinks;
    }

    public function addParentsElevesLink(ParentsElevesLink $parentsElevesLink): static
    {
        if (!$this->parentsElevesLinks->contains($parentsElevesLink)) {
            $this->parentsElevesLinks->add($parentsElevesLink);
            $parentsElevesLink->setEleves($this);
        }

        return $this;
    }

    public function removeParentsElevesLink(ParentsElevesLink $parentsElevesLink): static
    {
        if ($this->parentsElevesLinks->removeElement($parentsElevesLink)) {
            // set the owning side to null (unless already changed)
            if ($parentsElevesLink->getEleves() === $this) {
                $parentsElevesLink->setEleves(null);
            }
        }

        return $this;
    }

    public function isDeleted(): ?bool
    {
        return $this->isDeleted;
    }

    public function setDeleted(bool $isDeleted): static
    {
        $this->isDeleted = $isDeleted;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(string $commentaire): static
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
            $elevesAnneScolaire->setEleves($this);
        }

        return $this;
    }

    public function removeElevesAnneScolaire(ElevesAnneScolaire $elevesAnneScolaire): static
    {
        if ($this->elevesAnneScolaires->removeElement($elevesAnneScolaire)) {
            // set the owning side to null (unless already changed)
            if ($elevesAnneScolaire->getEleves() === $this) {
                $elevesAnneScolaire->setEleves(null);
            }
        }

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
            $paiementScolariteElefe->setEleves($this);
        }

        return $this;
    }

    public function removePaiementScolariteElefe(PaiementScolariteEleves $paiementScolariteElefe): static
    {
        if ($this->paiementScolariteEleves->removeElement($paiementScolariteElefe)) {
            // set the owning side to null (unless already changed)
            if ($paiementScolariteElefe->getEleves() === $this) {
                $paiementScolariteElefe->setEleves(null);
            }
        }

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
