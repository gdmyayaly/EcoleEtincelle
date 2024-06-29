<?php

namespace App\Entity;

use App\Repository\CritereEvaluationFamilyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CritereEvaluationFamilyRepository::class)]
class CritereEvaluationFamily
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['list'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['list'])]
    private ?string $nom = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['list'])]
    private ?string $commentaire = null;

    /**
     * @var Collection<int, CritereEvaluationGroup>
     */
    #[ORM\OneToMany(targetEntity: CritereEvaluationGroup::class, mappedBy: 'family')]
    #[Groups(['list'])]
    private Collection $critereEvaluationGroups;

    public function __construct()
    {
        $this->critereEvaluationGroups = new ArrayCollection();
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
     * @return Collection<int, CritereEvaluationGroup>
     */
    public function getCritereEvaluationGroups(): Collection
    {
        return $this->critereEvaluationGroups;
    }

    public function addCritereEvaluationGroup(CritereEvaluationGroup $critereEvaluationGroup): static
    {
        if (!$this->critereEvaluationGroups->contains($critereEvaluationGroup)) {
            $this->critereEvaluationGroups->add($critereEvaluationGroup);
            $critereEvaluationGroup->setFamily($this);
        }

        return $this;
    }

    public function removeCritereEvaluationGroup(CritereEvaluationGroup $critereEvaluationGroup): static
    {
        if ($this->critereEvaluationGroups->removeElement($critereEvaluationGroup)) {
            // set the owning side to null (unless already changed)
            if ($critereEvaluationGroup->getFamily() === $this) {
                $critereEvaluationGroup->setFamily(null);
            }
        }

        return $this;
    }
}
