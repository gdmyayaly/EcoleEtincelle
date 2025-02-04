<?php

namespace App\Entity;

use App\Repository\SessionsNiveauxRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: SessionsNiveauxRepository::class)]
class SessionsNiveaux
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'sessionsNiveauxes')]
    private ?SessionEvaluation $session = null;

    #[ORM\ManyToOne(inversedBy: 'sessionsNiveauxes')]
    #[Groups(['session:read'])]
    private ?NiveauEtude $niveauEtude = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSession(): ?SessionEvaluation
    {
        return $this->session;
    }

    public function setSession(?SessionEvaluation $session): static
    {
        $this->session = $session;

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
}
