<?php

namespace App\Entity;

use App\Repository\EquipeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EquipeRepository::class)]
class Equipe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $logo = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imageFond = null;

    #[ORM\Column(name: 'is_adversaire', type: 'boolean', options: ['default' => false])]
    private ?bool $isAdversaire = false;

    #[ORM\Column(type: 'boolean', options: ['default' => false])]
    private ?bool $isClubPrincipal = false;
    /**
     * @var Collection<int, Joueur>
     */
    #[ORM\OneToMany(targetEntity: Joueur::class, mappedBy: 'equipe')]
    private Collection $joueurs;

    /**
     * @var Collection<int, Media>
     */
    #[ORM\OneToMany(targetEntity: Media::class, mappedBy: 'equipe')]
    private Collection $media;

    /**
     * @var Collection<int, Rencontre>
     */
    #[ORM\ManyToMany(targetEntity: Rencontre::class, inversedBy: 'equipes')]
    #[ORM\JoinTable(name: 'equipe_rencontre')]
    private Collection $rencontres;

    /**
     * @var Collection<int, Vote>
     */
    #[ORM\OneToMany(targetEntity: Vote::class, mappedBy: 'equipe')]
    private Collection $votes;

    public function __construct()
    {
        $this->joueurs = new ArrayCollection();
        $this->media = new ArrayCollection();
        $this->rencontres = new ArrayCollection();
        $this->votes = new ArrayCollection();
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

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(?string $logo): static
    {
        $this->logo = $logo;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return Collection<int, Joueur>
     */
    public function getJoueurs(): Collection
    {
        return $this->joueurs;
    }

    public function addJoueur(Joueur $joueur): static
    {
        if (!$this->joueurs->contains($joueur)) {
            $this->joueurs->add($joueur);
            $joueur->setEquipe($this);
        }
        return $this;
    }

    public function removeJoueur(Joueur $joueur): static
    {
        if ($this->joueurs->removeElement($joueur) && $joueur->getEquipe() === $this) {
            $joueur->setEquipe(null);
        }
        return $this;
    }

    /**
     * @return Collection<int, Media>
     */
    public function getMedia(): Collection
    {
        return $this->media;
    }

    public function addMedium(Media $medium): static
    {
        if (!$this->media->contains($medium)) {
            $this->media->add($medium);
            $medium->setEquipe($this);
        }
        return $this;
    }

    public function removeMedium(Media $medium): static
    {
        if ($this->media->removeElement($medium) && $medium->getEquipe() === $this) {
            $medium->setEquipe(null);
        }
        return $this;
    }

    /**
     * @return Collection<int, Rencontre>
     */
    public function getRencontres(): Collection
    {
        return $this->rencontres;
    }

    public function addRencontre(Rencontre $rencontre): static
    {
        if (!$this->rencontres->contains($rencontre)) {
            $this->rencontres->add($rencontre);
            $rencontre->addEquipe($this);
        }
        return $this;
    }

    public function removeRencontre(Rencontre $rencontre): static
    {
        if ($this->rencontres->removeElement($rencontre)) {
            $rencontre->removeEquipe($this);
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
            $vote->setEquipe($this);
        }
        return $this;
    }

    public function removeVote(Vote $vote): static
    {
        if ($this->votes->removeElement($vote) && $vote->getEquipe() === $this) {
            $vote->setEquipe(null);
        }
        return $this;
    }

    public function getImageFond(): ?string
    {
        return $this->imageFond;
    }

    public function setImageFond(?string $imageFond): static
    {
        $this->imageFond = $imageFond;
        return $this;
    }

    public function getIsAdversaire(): ?bool 
    { 
        return $this->isAdversaire; 
    }

    public function setIsAdversaire(bool $isAdversaire): static
    {
        $this->isAdversaire = $isAdversaire;

        return $this;
    }

    public function getIsClubPrincipal(): ?bool
    {
        return $this->isClubPrincipal;
    }

    public function setIsClubPrincipal(bool $isClubPrincipal): static
    {
        $this->isClubPrincipal = $isClubPrincipal;

        return $this;
    }
  public function getNomAffichage(): string
{
    // Équipe du club (Gentlemates)
    if ($this->getIsAdversaire() === false) {
        return 'Gentlemates';
    }

    // Équipe adverse
    return $this->nom ?? 'Adversaire';
}

public function getLogoAffichage(): ?string
{
    // Logo Gentlemates pour les équipes du club
    if ($this->getIsAdversaire() === false) {
        return 'gentlemates.png'; // ⚠️ mets ici le VRAI nom de ton fichier logo Gentlemates
    }

    // Logo normal pour les adversaires
    return $this->logo ?? 'default_adversaire.png';
}


}
