<?php

namespace App\Entity;

use App\Repository\ParentElevesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ParentElevesRepository::class)]
class ParentEleves
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['list','eleves'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['list','eleves'])]
    private ?string $prenom = null;

    #[ORM\Column(length: 255)]
    #[Groups(['list','eleves'])]
    private ?string $nom = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['list','eleves'])]
    private ?string $telephone = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['list','eleves'])]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    #[Groups(['list','eleves'])]
    private ?string $adresse = null;

    #[ORM\Column(length: 255)]
    #[Groups(['list','eleves'])]
    private ?string $profession = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['list','eleves'])]
    private ?string $image = null;

    #[ORM\Column(length: 255)]
    #[Groups(['list','eleves'])]
    private ?string $sex = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['list','eleves'])]
    private ?string $commentaire = null;

    #[ORM\Column]
    private ?bool $isDeleted = null;

    /**
     * @var Collection<int, ParentsElevesLink>
     */
    #[ORM\OneToMany(targetEntity: ParentsElevesLink::class, mappedBy: 'parents')]
    private Collection $parentsElevesLinks;

    public function __construct()
    {
        $this->parentsElevesLinks = new ArrayCollection();
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

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): static
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getProfession(): ?string
    {
        return $this->profession;
    }

    public function setProfession(string $profession): static
    {
        $this->profession = $profession;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

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

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(?string $commentaire): static
    {
        $this->commentaire = $commentaire;

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
            $parentsElevesLink->setParents($this);
        }

        return $this;
    }

    public function removeParentsElevesLink(ParentsElevesLink $parentsElevesLink): static
    {
        if ($this->parentsElevesLinks->removeElement($parentsElevesLink)) {
            // set the owning side to null (unless already changed)
            if ($parentsElevesLink->getParents() === $this) {
                $parentsElevesLink->setParents(null);
            }
        }

        return $this;
    }
}
