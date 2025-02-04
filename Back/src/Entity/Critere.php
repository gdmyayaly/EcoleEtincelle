<?php

namespace App\Entity;

use App\Repository\CritereRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CritereRepository::class)]
class Critere
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['list'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['list'])]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    #[Groups(['list'])]
    private ?string $commentaire = null;

    /**
     * @var Collection<int, CritereQuestions>
     */
    #[ORM\OneToMany(targetEntity: CritereQuestions::class, mappedBy: 'critere')]
    #[Groups(['list'])]
    private Collection $critereQuestions;

    public function __construct()
    {
        $this->critereQuestions = new ArrayCollection();
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

    public function setCommentaire(string $commentaire): static
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    /**
     * @return Collection<int, CritereQuestions>
     */
    public function getCritereQuestions(): Collection
    {
        return $this->critereQuestions;
    }

    public function addCritereQuestion(CritereQuestions $critereQuestion): static
    {
        if (!$this->critereQuestions->contains($critereQuestion)) {
            $this->critereQuestions->add($critereQuestion);
            $critereQuestion->setCritere($this);
        }

        return $this;
    }

    public function removeCritereQuestion(CritereQuestions $critereQuestion): static
    {
        if ($this->critereQuestions->removeElement($critereQuestion)) {
            // set the owning side to null (unless already changed)
            if ($critereQuestion->getCritere() === $this) {
                $critereQuestion->setCritere(null);
            }
        }

        return $this;
    }
}
