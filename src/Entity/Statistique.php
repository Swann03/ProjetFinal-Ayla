<?php

namespace App\Entity;

use App\Repository\StatistiqueRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StatistiqueRepository::class)]
class Statistique
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $killCount = null;

    #[ORM\Column]
    private ?int $deadCount = null;

    #[ORM\Column]
    private ?int $assistCount = null;

    #[ORM\OneToOne(mappedBy: 'statistique', cascade: ['persist', 'remove'])]
    private ?Joueur $joueur = null;

    #[ORM\ManyToOne(inversedBy: 'statistiques')]
    private ?Rencontre $statistique = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getKillCount(): ?int
    {
        return $this->killCount;
    }

    public function setKillCount(int $killCount): static
    {
        $this->killCount = $killCount;

        return $this;
    }

    public function getDeadCount(): ?int
    {
        return $this->deadCount;
    }

    public function setDeadCount(int $deadCount): static
    {
        $this->deadCount = $deadCount;

        return $this;
    }

    public function getAssistCount(): ?int
    {
        return $this->assistCount;
    }

    public function setAssistCount(int $assistCount): static
    {
        $this->assistCount = $assistCount;

        return $this;
    }

    public function getJoueur(): ?Joueur
    {
        return $this->joueur;
    }

    public function setJoueur(?Joueur $joueur): static
    {
        // unset the owning side of the relation if necessary
        if ($joueur === null && $this->joueur !== null) {
            $this->joueur->setStatistique(null);
        }

        // set the owning side of the relation if necessary
        if ($joueur !== null && $joueur->getStatistique() !== $this) {
            $joueur->setStatistique($this);
        }

        $this->joueur = $joueur;
        return $this;
    }

    public function getStatistique(): ?Rencontre
    {
        return $this->statistique;
    }

    public function setStatistique(?Rencontre $statistique): static
    {
        $this->statistique = $statistique;

        return $this;
    }
}
