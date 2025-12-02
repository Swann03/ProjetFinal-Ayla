<?php

namespace App\Entity;

use App\Repository\RencontreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RencontreRepository::class)]
class Rencontre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'datetime', nullable: false)]
    private ?\DateTime $date = null;

    #[ORM\Column(length: 255)]
    private ?string $resultat = null;

    #[ORM\Column(length: 255)]
    private ?string $jeu = null;

    /**
     * @var Collection<int, Equipe>
     */
    #[ORM\ManyToMany(targetEntity: Equipe::class, mappedBy: 'rencontres')]
    private Collection $equipes;

    /**
     * @var Collection<int, Vote>
     */
    #[ORM\OneToMany(targetEntity: Vote::class, mappedBy: 'rencontre', cascade: ['persist', 'remove'])]
    private Collection $votes;

    /**
     * @var Collection<int, Statistique>
     */
    #[ORM\OneToMany(targetEntity: Statistique::class, mappedBy: 'rencontre', cascade: ['persist', 'remove'])]
    private Collection $statistiques;

    public function __construct()
    {
        $this->equipes = new ArrayCollection();
        $this->votes = new ArrayCollection();
        $this->statistiques = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTime
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;
        return $this;
    }

    public function getResultat(): ?string
    {
        return $this->resultat;
    }

    public function setResultat(string $resultat): static
    {
        $this->resultat = $resultat;
        return $this;
    }

    public function getJeu(): ?string
    {
        return $this->jeu;
    }

    public function setJeu(string $jeu): static
    {
        $this->jeu = $jeu;
        return $this;
    }

    /**
     * @return Collection<int, Equipe>
     */
    public function getEquipes(): Collection
    {
        return $this->equipes;
    }

    public function addEquipe(Equipe $equipe): static
    {
        if (!$this->equipes->contains($equipe)) {
            $this->equipes->add($equipe);
            $equipe->addRencontre($this);
        }
        return $this;
    }

    public function removeEquipe(Equipe $equipe): static
    {
        if ($this->equipes->removeElement($equipe)) {
            $equipe->removeRencontre($this);
        }
        return $this;
    }

    /**
     * @return Collection<int, Vote>
     */
    public function getVotes(): Collection
    {
        return $this->votes;
    }

    public function addVote(Vote $vote): static
    {
        if (!$this->votes->contains($vote)) {
            $this->votes->add($vote);
            $vote->setRencontre($this);
        }
        return $this;
    }

    public function removeVote(Vote $vote): static
    {
        if ($this->votes->removeElement($vote) && $vote->getRencontre() === $this) {
            $vote->setRencontre(null);
        }
        return $this;
    }

    /**
     * @return Collection<int, Statistique>
     */
    public function getStatistiques(): Collection
    {
        return $this->statistiques;
    }

    public function addStatistique(Statistique $statistique): static
    {
        if (!$this->statistiques->contains($statistique)) {
            $this->statistiques->add($statistique);
            $statistique->setRencontre($this);
        }
        return $this;
    }

    public function removeStatistique(Statistique $statistique): static
    {
        if ($this->statistiques->removeElement($statistique) && $statistique->getRencontre() === $this) {
            $statistique->setRencontre(null);
        }
        return $this;
    }
    public function getEquipeGentlemates(): ?Equipe
    {
        foreach ($this->equipes as $equipe) {
            if ($equipe->getIsAdversaire() === false) {
                return $equipe;
            }
        }
        return null;
    }

    public function getEquipeAdversaire(): ?Equipe
    {
        foreach ($this->equipes as $equipe) {
            if ($equipe->getIsAdversaire() === true) {
                return $equipe;
            }
        }
        return null;
    }

}
