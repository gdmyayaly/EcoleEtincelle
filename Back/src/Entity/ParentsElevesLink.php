<?php

namespace App\Entity;

use App\Repository\ParentsElevesLinkRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ParentsElevesLinkRepository::class)]
class ParentsElevesLink
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['eleves'])]

    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'parentsElevesLinks')]
    private ?Eleves $eleves = null;

    #[ORM\ManyToOne(inversedBy: 'parentsElevesLinks')]
    #[Groups(['eleves'])]

    private ?ParentEleves $parents = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEleves(): ?Eleves
    {
        return $this->eleves;
    }

    public function setEleves(?Eleves $eleves): static
    {
        $this->eleves = $eleves;

        return $this;
    }

    public function getParents(): ?ParentEleves
    {
        return $this->parents;
    }

    public function setParents(?ParentEleves $parents): static
    {
        $this->parents = $parents;

        return $this;
    }
}
