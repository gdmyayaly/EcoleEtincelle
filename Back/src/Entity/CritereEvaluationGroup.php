<?php

namespace App\Entity;

use App\Repository\CritereEvaluationGroupRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CritereEvaluationGroupRepository::class)]
class CritereEvaluationGroup
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

    #[ORM\ManyToOne(inversedBy: 'critereEvaluationGroups')]
    private ?CritereEvaluationFamily $family = null;

    /**
     * @var Collection<int, CriteresEvaluations>
     */
    #[ORM\OneToMany(targetEntity: CriteresEvaluations::class, mappedBy: 'familyGroup')]
    #[Groups(['list'])]
    private Collection $criteresEvaluations;

    public function __construct()
    {
        $this->criteresEvaluations = new ArrayCollection();
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

    public function getFamily(): ?CritereEvaluationFamily
    {
        return $this->family;
    }

    public function setFamily(?CritereEvaluationFamily $family): static
    {
        $this->family = $family;

        return $this;
    }

    /**
     * @return Collection<int, CriteresEvaluations>
     */
    public function getCriteresEvaluations(): Collection
    {
        return $this->criteresEvaluations;
    }

    public function addCriteresEvaluation(CriteresEvaluations $criteresEvaluation): static
    {
        if (!$this->criteresEvaluations->contains($criteresEvaluation)) {
            $this->criteresEvaluations->add($criteresEvaluation);
            $criteresEvaluation->setFamilyGroup($this);
        }

        return $this;
    }

    public function removeCriteresEvaluation(CriteresEvaluations $criteresEvaluation): static
    {
        if ($this->criteresEvaluations->removeElement($criteresEvaluation)) {
            // set the owning side to null (unless already changed)
            if ($criteresEvaluation->getFamilyGroup() === $this) {
                $criteresEvaluation->setFamilyGroup(null);
            }
        }

        return $this;
    }
}
