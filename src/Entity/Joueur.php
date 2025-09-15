<?php

namespace App\Entity;

use App\Repository\JoueurRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: JoueurRepository::class)]
class Joueur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $bio = null;

    
    #[ORM\OneToOne(mappedBy: 'Joueur', cascade: ['persist', 'remove'])]
    private ?Statistique $statistique = null;

    #[ORM\ManyToOne(inversedBy: 'joueurs')]
    private ?Equipe $joueur = null;

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

    public function getBio(): ?string
    {
        return $this->bio;
    }

    public function setBio(string $bio): static
    {
        $this->bio = $bio;

        return $this;
    }

    
    public function getStatistique(): ?Statistique
    {
        return $this->statistique;
    }

    public function setStatistique(?Statistique $statistique): static
    {
        // unset the owning side of the relation if necessary
        if ($statistique === null && $this->statistique !== null) {
            $this->statistique->setJoueur(null);
        }

        // set the owning side of the relation if necessary
        if ($statistique !== null && $statistique->getJoueur() !== $this) {
            $statistique->setJoueur($this);
        }

        $this->statistique = $statistique;

        return $this;
    }

    public function getJoueur(): ?Equipe
    {
        return $this->joueur;
    }

    public function setJoueur(?Equipe $joueur): static
    {
        $this->joueur = $joueur;

        return $this;
    }
}
