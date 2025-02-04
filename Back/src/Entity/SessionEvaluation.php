<?php

namespace App\Entity;

use App\Repository\SessionEvaluationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: SessionEvaluationRepository::class)]
class SessionEvaluation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['session:read', 'niveau:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['session:read', 'niveau:read'])]
    private ?string $nom = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['session:read', 'niveau:read'])]
    private ?\DateTimeInterface $dateLimit = null;

    #[ORM\Column]
    #[Groups(['session:read', 'niveau:read'])]
    private ?bool $isActive = false;

    /**
     * @var Collection<int, SessionsNiveaux>
     */
    #[ORM\OneToMany(targetEntity: SessionsNiveaux::class, mappedBy: 'session',)]
    #[Groups(['session:read'])]
    private Collection $sessionsNiveauxes;

    public function __construct()
    {
        $this->sessionsNiveauxes = new ArrayCollection();
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

    public function getDateLimit(): ?\DateTimeInterface
    {
        return $this->dateLimit;
    }

    public function setDateLimit(\DateTimeInterface $date): static
    {
        $this->dateLimit = $date;

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->isActive;
    }

    public function setActive(bool $isActive): static
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * @return Collection<int, SessionsNiveaux>
     */
    public function getSessionsNiveauxes(): Collection
    {
        return $this->sessionsNiveauxes;
    }

    public function addSessionsNiveaux(SessionsNiveaux $sessionsNiveaux): static
    {
        if (!$this->sessionsNiveauxes->contains($sessionsNiveaux)) {
            $this->sessionsNiveauxes->add($sessionsNiveaux);
            $sessionsNiveaux->setSession($this);
        }

        return $this;
    }

    public function removeSessionsNiveaux(SessionsNiveaux $sessionsNiveaux): static
    {
        if ($this->sessionsNiveauxes->removeElement($sessionsNiveaux)) {
            // set the owning side to null (unless already changed)
            if ($sessionsNiveaux->getSession() === $this) {
                $sessionsNiveaux->setSession(null);
            }
        }

        return $this;
    }
}
