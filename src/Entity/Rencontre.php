<?php

namespace App\Entity;

use App\Repository\RencontreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;

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
    #[ORM\ManyToMany(targetEntity: Equipe::class, inversedBy: 'equipe')]
    private Collection $rencontre;

    /**
     * @var Collection<int, Vote>
     */
    #[ORM\OneToMany(targetEntity: Vote::class, mappedBy: 'rencontre', cascade: ['persist', 'remove'])]
    private Collection $rencontreVote;

    /**
     * @var Collection<int, Statistique>
     */
    #[ORM\OneToMany(targetEntity: Statistique::class, mappedBy: 'rencontre', cascade: ['persist', 'remove'])]
    private Collection $statistiques;

   


    public function __construct()
    {
        $this->rencontre = new ArrayCollection();
        $this->rencontreVote = new ArrayCollection();
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

    public function setDate(\DateTime $date): static
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
    public function getRencontre(): Collection
    {
        return $this->rencontre;
    }

    public function addRencontre(Equipe $rencontre): static
    {
        if (!$this->rencontre->contains($rencontre)) {
            $this->rencontre->add($rencontre);
        }
        return $this;
    }

    public function removeRencontre(Equipe $rencontre): static
    {
        $this->rencontre->removeElement($rencontre);
        return $this;
    }

    /**
     * @return Collection<int, Vote>
     */
    public function getRencontreVote(): Collection
    {
        return $this->rencontreVote;
    }

    public function addRencontreVote(Vote $rencontreVote): static
    {
        if (!$this->rencontreVote->contains($rencontreVote)) {
            $this->rencontreVote->add($rencontreVote);
            $rencontreVote->setRencontre($this);
        }
        return $this;
    }

    public function removeRencontreVote(Vote $rencontreVote): static
    {
        if ($this->rencontreVote->removeElement($rencontreVote)) {
            if ($rencontreVote->getRencontre() === $this) {
                $rencontreVote->setRencontre(null);
            }
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
        if ($this->statistiques->removeElement($statistique)) {
            if ($statistique->getRencontre() === $this) {
                $statistique->setRencontre(null);
            }
        }
        return $this;
    }
}
