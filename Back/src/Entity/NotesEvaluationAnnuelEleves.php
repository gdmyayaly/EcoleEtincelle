<?php

namespace App\Entity;

use App\Repository\NotesEvaluationAnnuelElevesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NotesEvaluationAnnuelElevesRepository::class)]
class NotesEvaluationAnnuelEleves
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $question = null;

    #[ORM\Column(length: 255)]
    private ?string $tagReponse = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $reponse = null;

    #[ORM\ManyToOne(inversedBy: 'notesEvaluationAnnuelEleves')]
    private ?EvaluationAnnuelEleves $evaluationAnnuelEleves = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuestion(): ?string
    {
        return $this->question;
    }

    public function setQuestion(string $question): static
    {
        $this->question = $question;

        return $this;
    }

    public function getTagReponse(): ?string
    {
        return $this->tagReponse;
    }

    public function setTagReponse(string $tagReponse): static
    {
        $this->tagReponse = $tagReponse;

        return $this;
    }

    public function getReponse(): ?string
    {
        return $this->reponse;
    }

    public function setReponse(string $reponse): static
    {
        $this->reponse = $reponse;

        return $this;
    }

    public function getEvaluationAnnuelEleves(): ?EvaluationAnnuelEleves
    {
        return $this->evaluationAnnuelEleves;
    }

    public function setEvaluationAnnuelEleves(?EvaluationAnnuelEleves $evaluationAnnuelEleves): static
    {
        $this->evaluationAnnuelEleves = $evaluationAnnuelEleves;

        return $this;
    }
}
