<?php

namespace App\Entity;

use App\Repository\EvaluationAnnuelElevesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: EvaluationAnnuelElevesRepository::class)]
class EvaluationAnnuelEleves
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['eleves'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'evaluationAnnuelEleves')]
    private ?Eleves $eleve = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['eleves'])]
    private ?string $htmlReport = null;

    #[ORM\ManyToOne(inversedBy: 'evaluationAnnuelEleves')]
    #[Groups(['eleves'])]
    private ?AnneeScolaire $anneeScolaire = null;

    /**
     * @var Collection<int, NotesEvaluationAnnuelEleves>
     */
    #[ORM\OneToMany(targetEntity: NotesEvaluationAnnuelEleves::class, mappedBy: 'evaluationAnnuelEleves')]
    #[Groups(['eleves'])]
    private Collection $notesEvaluationAnnuelEleves;

    public function __construct()
    {
        $this->notesEvaluationAnnuelEleves = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEleve(): ?Eleves
    {
        return $this->eleve;
    }

    public function setEleve(?Eleves $eleve): static
    {
        $this->eleve = $eleve;

        return $this;
    }

    public function getHtmlReport(): ?string
    {
        return $this->htmlReport;
    }

    public function setHtmlReport(?string $htmlReport): static
    {
        $this->htmlReport = $htmlReport;

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
     * @return Collection<int, NotesEvaluationAnnuelEleves>
     */
    public function getNotesEvaluationAnnuelEleves(): Collection
    {
        return $this->notesEvaluationAnnuelEleves;
    }

    public function addNotesEvaluationAnnuelElefe(NotesEvaluationAnnuelEleves $notesEvaluationAnnuelElefe): static
    {
        if (!$this->notesEvaluationAnnuelEleves->contains($notesEvaluationAnnuelElefe)) {
            $this->notesEvaluationAnnuelEleves->add($notesEvaluationAnnuelElefe);
            $notesEvaluationAnnuelElefe->setEvaluationAnnuelEleves($this);
        }

        return $this;
    }

    public function removeNotesEvaluationAnnuelElefe(NotesEvaluationAnnuelEleves $notesEvaluationAnnuelElefe): static
    {
        if ($this->notesEvaluationAnnuelEleves->removeElement($notesEvaluationAnnuelElefe)) {
            // set the owning side to null (unless already changed)
            if ($notesEvaluationAnnuelElefe->getEvaluationAnnuelEleves() === $this) {
                $notesEvaluationAnnuelElefe->setEvaluationAnnuelEleves(null);
            }
        }

        return $this;
    }
}
