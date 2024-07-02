<?php

namespace App\Entity;

use App\Repository\PaiementScolariteElevesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: PaiementScolariteElevesRepository::class)]
class PaiementScolariteEleves
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'paiementScolariteEleves')]
    private ?Eleves $eleves = null;

    #[ORM\ManyToOne(inversedBy: 'paiementScolariteEleves')]
    private ?PaiementNiveauEtudeAnneeScolaire $scolaritePaiement = null;

    #[ORM\Column(length: 255)]
    private ?string $montantPaier = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $commentaire = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $htmlFacture = null;

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

    public function getScolaritePaiement(): ?PaiementNiveauEtudeAnneeScolaire
    {
        return $this->scolaritePaiement;
    }

    public function setScolaritePaiement(?PaiementNiveauEtudeAnneeScolaire $scolaritePaiement): static
    {
        $this->scolaritePaiement = $scolaritePaiement;

        return $this;
    }

    public function getMontantPaier(): ?string
    {
        return $this->montantPaier;
    }

    public function setMontantPaier(string $montantPaier): static
    {
        $this->montantPaier = $montantPaier;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

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

    public function getHtmlFacture(): ?string
    {
        return $this->htmlFacture;
    }

    public function setHtmlFacture(?string $htmlFacture): static
    {
        $this->htmlFacture = $htmlFacture;

        return $this;
    }
}
