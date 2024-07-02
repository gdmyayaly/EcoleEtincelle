<?php

namespace App\Entity;

use App\Repository\ElevesAnneScolaireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ElevesAnneScolaireRepository::class)]
class ElevesAnneScolaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['eleves','list'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'elevesAnneScolaires')]
    #[Groups(['list'])]
    private ?Eleves $eleves = null;

    #[ORM\ManyToOne(inversedBy: 'elevesAnneScolaires')]
    #[Groups(['eleves','list'])]
    private ?NiveauEtude $niveauEtude = null;

    #[ORM\ManyToOne(inversedBy: 'elevesAnneScolaires')]
    #[Groups(['eleves'])]
    private ?AnneeScolaire $anneeScolaire = null;
    public function __construct()
    {
    }

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

    public function getNiveauEtude(): ?NiveauEtude
    {
        return $this->niveauEtude;
    }

    public function setNiveauEtude(?NiveauEtude $niveauEtude): static
    {
        $this->niveauEtude = $niveauEtude;

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

}
