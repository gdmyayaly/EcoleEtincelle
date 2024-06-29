<?php

namespace App\Entity;

use App\Repository\CriteresEvaluationsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CriteresEvaluationsRepository::class)]
class CriteresEvaluations
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['list'])]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['list'])]
    private ?string $question = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['list'])]
    private ?string $faitSeul = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['list'])]
    private ?string $neFaitPas = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['list'])]
    private ?string $faitAvecDeLAide = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['list'])]
    private ?string $nonEvaluer = null;

    #[ORM\ManyToOne(inversedBy: 'criteresEvaluations')]
    private ?CritereEvaluationGroup $familyGroup = null;

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

    public function getFaitSeul(): ?string
    {
        return $this->faitSeul;
    }

    public function setFaitSeul(string $faitSeul): static
    {
        $this->faitSeul = $faitSeul;

        return $this;
    }

    public function getNeFaitPas(): ?string
    {
        return $this->neFaitPas;
    }

    public function setNeFaitPas(string $neFaitPas): static
    {
        $this->neFaitPas = $neFaitPas;

        return $this;
    }

    public function getFaitAvecDeLAide(): ?string
    {
        return $this->faitAvecDeLAide;
    }

    public function setFaitAvecDeLAide(string $faitAvecDeLAide): static
    {
        $this->faitAvecDeLAide = $faitAvecDeLAide;

        return $this;
    }

    public function getNonEvaluer(): ?string
    {
        return $this->nonEvaluer;
    }

    public function setNonEvaluer(?string $nonEvaluer): static
    {
        $this->nonEvaluer = $nonEvaluer;

        return $this;
    }

    public function getFamilyGroup(): ?CritereEvaluationGroup
    {
        return $this->familyGroup;
    }

    public function setFamilyGroup(?CritereEvaluationGroup $familyGroup): static
    {
        $this->familyGroup = $familyGroup;

        return $this;
    }
}
